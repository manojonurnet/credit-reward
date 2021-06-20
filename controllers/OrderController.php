<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\Customer;
use app\models\Currency;
use app\models\Reward;
use app\models\Claim;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Order::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        $customers = ArrayHelper::map(Customer::find()->all(), 'id', 'email');

        $currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'code');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'customers' => $customers,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $customers = ArrayHelper::map(Customer::find()->all(), 'id', 'email');

        $currencies = ArrayHelper::map(Currency::find()->all(), 'id', 'code');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'customers' => $customers,
            'currencies' => $currencies,
        ]);
    }

    public function actionPay($id, $reward = false)
    {
        $model = $this->findModel($id);

        if ($reward) {
            if ($model->customer->reward && ($model->customer->reward * 0.01 >= $model->sale_amount / $model->currency->value)) {
                $reward_to_deduct = 100 * $model->sale_amount / $model->currency->value;

                $claim = new Claim([
                    'order_id' => $model->id,
                    'points' => $reward_to_deduct
                ]);

                $claim->save();
            }
        }

        $model->status = 1;
        $model->save();

        $reward_count = Reward::find()->where(['order_id' => $model->id])->count();

        if (! $reward_count) {
            $this->createReward($model);
        }

        $this->updateReward($model);

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function createReward($model)
    {
        $sales_amount_in_usd = $model->currency->code == 'USD' ? $model->sale_amount : $model->sale_amount / $model->currency->value;

        $reward = new Reward([
            'points' => floor($sales_amount_in_usd),
            'amount' => floor($sales_amount_in_usd) * 0.01,
            'status' => 1,
            'expiry_date' => date('Y-m-d', strtotime('+1 year')),
            'order_id' => $model->id,
        ]);
        $reward->save();
    }

    protected function updateReward($model)
    {
        $rewards = 0;
        $claims = 0;
        foreach ($model->customer->rewards as $reward) {
            if ($reward->expiry_date <= date('Y-m-d')) {
                $reward->status = 0;
                $reward->save();
            } else {
                $rewards += $reward->points;
            }
        }

        foreach ($model->customer->claims as $claim) {
            $claims += $claim->points;
        }

        $model->customer->reward = $rewards - $claims;
        $model->customer->save();
    }
}
