<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'SGD CAE: Nuevo Deporte';
?>

<head>
    <style>
        .alert {
            display:inline-block;
        }
    </style>
    <script type="text/javascript" src="../web/js/desaparecer.js"></script>
</head>
<article class="col-xs-12 col-md-10">
    <h3>Crear Deporte:</h3>
    <div class="content">       
        <?= $msg ?>
    </div>
    <hr>
    <?php
    $form = ActiveForm::begin([
                "method" => "post",
                "id" => "formulario",
                "enableClientValidation" => false,
                "enableAjaxValidation" => true,
    ]);
    ?>
    <div class="row col-xs-12 col-md-5">
        <div class="form-group">
            <label for="ingresar nombre del deporte">Nombre: </label>
            <?= $form->field($model, "nombre_deporte")->input("text", ["placeholder" => "Nombre del Deporte", "class" => "form-control", "autofocus"])->label(false) ?>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => "float:right;"]) ?>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 content">

    </div>
    <?php $form->end() ?>
</article>

