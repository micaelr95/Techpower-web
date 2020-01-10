<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Sale;
/* @var $this yii\web\View */
/* @var $searchModel common\models\SaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sales';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'user.username',
            'sale_date',
            [
                'attribute' => 'Total',
                'value' => 'total',
            ],
            [
                'attribute' => 'Estado',
                'value' => 'SaleState',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
