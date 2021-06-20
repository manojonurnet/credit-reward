<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Orders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Order', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'detail',
            [
                'label' => 'Customer',
                'value' => function($model) {
                    return $model->customer->email;
                }
            ],
            'sale_amount',
            [
                'label' => 'Currency',
                'value' => function($model) {
                    return $model->currency->code;
                }
            ],
            [
                'label' => 'Status',
                'value' => function($model) {
                    return $model->status ? 'Complete' : 'Pending';
                }
            ],
            'created_date',
            [
                'attribute' => 'default',
                'label' => 'Order action',
                'format' => 'html',
                'value' => function($model, $index, $dataColumn) {
                    return 
                    $model->status ?
                    'No action required'
                    :
                    ($model->customer->reward && ($model->customer->reward * 0.01 >= $model->sale_amount / $model->currency->value) ? 
                    Html::a(
                        'Pay with reward points',
                        Url::to(['order/pay', 'id' => $model->id, 'reward' => true]),
                        ['class' => 'badge badge-info']
                    ) 
                    . '&nbsp;&nbsp;' . 
                    Html::a(
                        'Pay',
                        Url::to(['order/pay', 'id' => $model->id]),
                        ['class' => 'badge badge-info']
                    ) : 
                    Html::a(
                        'Pay',
                        Url::to(['order/pay', 'id' => $model->id]),
                        ['class' => 'badge badge-info']
                    ));
                },
            ],
            //'modified_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
