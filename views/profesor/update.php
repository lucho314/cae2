<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Profesor */

$this->title = 'Update Profesor: ' . ' ' . $model->dni;
$this->params['breadcrumbs'][] = ['label' => 'Profesors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->dni, 'url' => ['view', 'id' => $model->dni]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="profesor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
