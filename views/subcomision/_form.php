<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubComision */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-comision-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'dni')->textInput() ?>

    <?= $form->field($model, 'id_deporte')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
