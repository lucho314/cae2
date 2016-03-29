<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubComision */

$this->title = 'Update Sub Comision: ' . ' ' . $model->dni;
$this->params['breadcrumbs'][] = ['label' => 'Sub Comisions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dni, 'url' => ['view', 'dni' => $model->dni, 'id_deporte' => $model->id_deporte]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sub-comision-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
