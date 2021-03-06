<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Reward */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reward-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            [
                'label' => 'Customer',
                'value' => function($model) {
                    return $model->order->customer->name;
                }
            ],
            'points',
            'amount',
            [
                'label' => 'Status',
                'value' => function($model) {
                    return $model->status ? 'Active' : 'Expired';
                }
            ],
            'expiry_date',
            // 'order_id',
            'created_date',
            // 'modified_date',
        ],
    ]) ?>

</div>
