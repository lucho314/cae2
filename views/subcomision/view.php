<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubComision */

$this->title = $model->dni;
$this->params['breadcrumbs'][] = ['label' => 'Sub Comisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-comision-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'dni' => $model->dni, 'id_deporte' => $model->id_deporte], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'dni' => $model->dni, 'id_deporte' => $model->id_deporte], [
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
            'dni',
            'id_deporte',
        ],
    ]) ?>

</div>
