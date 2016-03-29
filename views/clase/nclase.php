<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'SGD CAE: Nueva Clase';
?>
<head>
    <script type="text/javascript" src="../web/js/menu.js"></script>
</head>
<article class="col-xs-12 col-md-10">

    <?php
    $form = ActiveForm::begin([
                "method" => "post",
                "id" => "formulario",
                "enableClientValidation" => false,
                "enableAjaxValidation" => true,
            ])
    ?>
    <h3>Clase:</h3>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-3">
            <div class="form-group">
                <label for="ingresar fecha de la clase">Fecha:</label>
                <?= $form->field($model, "fecha")->input("date", ["placeholder" => "Nombre del Deporte", "class" => "form-control",'autofocus'=>true])->label(false) ?>
            </div>
        </div>
        <div class="col-xs-12 col-sm-3">
            <div class="form-group">
                <label for="seleccionar comision">Categoria:</label>
                <?= $form->field($model, 'id_categoria')->dropDownList($categoria)->label(false) ?>
            </div>
        </div>
        <div class="col-xs-12 col-xs-lg-6">
            <div class="form-group">
                <label for="ingresar observaciones">Observaciones:</label>
                <?= $form->field($model, 'observaciones')->textarea(['class' => "form-control", 'style' => "resize:none;", 'rows' => "4"])->label(false) ?>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-default botones">
        Continuar<span class="glyphicon glyphicon-chevron-right"></span>
    </button>
    <?php $form->end() ?>
</article>