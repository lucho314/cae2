<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'SGD CAE:' . $titulo;
?>

<article class="col-xs-12 col-md-10">
    <h3><?= $titulo ?>: </h3>
    <hr>
    <?php
    $form = ActiveForm::begin([
                "method" => "post",
                "id" => "formulario",
                "enableClientValidation" => false,
                "enableAjaxValidation" => true,
    ]);
    ?>
    <div class="row">
        <div class="col-xs-12 col-md-3">
            <div class="form-group">
                <label for="ingresar nombre">Nombre:</label>
                <?= $form->field($model, "nombre_comision")->input("text", ['placeholder' => "Nombre de la Comision", 'autofocus' => true])->label(false) ?>
            </div>
        </div>

        <div class="col-xs-12 col-md-3">
            <div class="form-group">
                <label for="seleccionar categoria:">Seleccione Categoria:</label>
                <?= $form->field($model, 'id_categoria')->dropDownList($opciones, ['class' => "form-control", 'prompt' => '----Categorias----'])->label(false) ?>
            </div>
        </div>

        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                <label for="seleccionar dia:">Seleccione Día:</label>
                <?php
                $a = ['Lunes' => 'Lunes', 'Martes' => 'Martes', 'Miercoles' => 'Miercoles', 'Jueves' => 'Jueves', 'Viernes' => 'Viernes']
                ?>
                <?= $form->field($model, 'dia')->dropDownList($a, ['class' => "form-control"])->label(false) ?>
            </div>
        </div>

        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                <label for="ingresar hora inicio">Hora de Inicio:</label>
                <?= $form->field($model, 'hora_inicio')->input("text", ['class' => "form-control"])->label(false) ?>
            </div>
        </div>

        <div class="col-xs-12 col-md-2">
            <div class="form-group">
                <label for="ingresar hora fin">Hora de Fin</label>
                <?= $form->field($model, 'hora_fin')->input("text", ['class' => "form-control"])->label(false) ?>
            </div>   
        </div>
        <div class="col-xs-12 col-md-3" style="float:right;">
            <div class="botones">
                <a href="<?= Url::toRoute("comision/buscar") ?>" class="btn btn-default" style='float:right; margin-left: 4px;'>Cancelar</a>
                <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'float:right;']) ?>
            </div>  
        </div>
    </div>
    <?php $form->end() ?>
</article>


