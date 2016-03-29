<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfesorBuscar */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profesors';
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="col-xs-12 col-md-10"> 
<div class="profesor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Profesor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'dni',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
<article> 