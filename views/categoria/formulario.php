<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'SGD CAE: '.$titulo;
?>
<head>
    <script type="text/javascript" src="../web/js/desaparecer.js"></script>
</head>
<article class="col-xs-12 col-md-10">
    <h3><?= $titulo.':' ?></h3>
    <div class="content">
        <?php if ($msg != NULL) { ?>
            <div class='alert alert-success' role='contentinfo'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
                <?= $msg ?>
            </div>
        <?php } ?>
    </div>
    <hr>
    <?php
    $form = ActiveForm::begin([
                "id" => "formulario",
                "enableClientValidation" => false,
                "enableAjaxValidation" => true,
                "method" => "post"
            ])
    ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="ingresar nombre categoria:">Nombre:</label>
                <?= $form->field($model, "nombre_categoria")->input("text", ["placeholder" => "Nombre de la Categoria", "class" => "form-control", "autofocus"=>true])->label(false) ?>
            </div>
            <div class="form-group">
                <label for="ingresar edad minima">Edad Minima:</label>
                <?= $form->field($model, "edad_minima")->input("number", ["placeholder" => "Edad Minima", "class" => "form-control"])->label(false) ?>
            </div>
            <div class="form-group">
                <label for="ingresar edad maxima">Edad Maxima:</label>
                <?= $form->field($model, "edad_maxima")->input("number", ["placeholder" => "Edad Maxima", "class" => "form-control"])->label(false) ?>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="seleccione un profesor titular">Profesor Titular:</label>
                <?= $form->field($model, 'id_profesor_titular')->dropDownList($profesor,['prompt' => 'Seleccione Pofesor'])->label(false) ?>
            </div>
            <div class="form-group">
                <label for="seleccione un profesor suplente">Profesor Suplente:</label>
                <?= $form->field($model, 'id_profesor_suplente')->dropDownList($profesor, ['prompt' => 'Seleccione Pofesor'])->label(false) ?>
            </div>
            <div class="form-group">
                <label for="seleccione un deporte">Deporte:</label>
                <?= $form->field($model, 'id_deporte')->dropDownList($deporte, ['prompt' => 'Seleccione Deporte'])->label(false) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <?php $form->end() ?>
</article>
