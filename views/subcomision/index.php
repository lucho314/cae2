<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SubcomisionBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Comisions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-comision-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sub Comision', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dni',
            'id_deporte',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
