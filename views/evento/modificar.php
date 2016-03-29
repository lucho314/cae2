<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'SGD CAE: Moficar Evento';
$condicion=['Local'=>'Local','Visitante'=>'Visitante'];
?>

<article class="col-xs-12 col-md-10">
    <h3>Modificar Evento 2/2</h3>
    <?= $msg ?>
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
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="ingresar nombre:">Nombre:</label>
                <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre del evento", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar condicion:">Condición:</label>
                <?= $form->field($model, "condicion")->dropDownList(['1' => 'Local', '2' => 'Visitante'], ['class' => "form-control"])->label(false) ?>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="fecha inicio evento">Desde:</label>
                        <?= $form->field($model, "fecha_inicio")->input("date", ["class" => "form-control"])->label(false) ?>   
                    </div>
                </div>
                <div class=" col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="fecha fin evento">Hasta:</label>
                        <?= $form->field($model, "fecha_fin")->input("date", ["class" => "form-control"])->label(false) ?>   
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="profesor_titular">Profesor Titular:</label>
                <?= $form->field($model, "id_profesor_titular")->dropDownList($profesor, ['class' => "form-control"])->label(false) ?>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">  

            <div class="form-group">
                <label for="profesor_suplente">Profesor Suplente:</label>
                <?= $form->field($model, "id_profesor_suplente")->dropDownList($profesor, ['class' => "form-control","prompt"=>'Seleccionar Profesor'])->label(false) ?>
            </div>

            <div class="form-group">
                <label for="seleccionar deporte">Deporte:</label>
                <?= $form->field($model, "id_deporte")->dropDownList($deporte, ['class' => "form-control"])->label(false) ?>
            </div>
            
            <div class="form-group">
                <label for="ingresar observaciones">Observaciones:</label>
                <?= $form->field($model, 'observaciones')->textarea(['class' => "form-control", 'style' => "resize:none;", 'rows' => '5'])->label(false) ?>
            </div>
            
            <div class="checkbox" style="float: left;">
                <?= $form->field($model, "convocados")->checkbox(['label' => "Crear lista"])->label(false); ?>
            </div>
            
            <div style="float: right;">
                <input type="submit" value="Guardar" class="btn btn-primary">
            </div>

        </div>
    </div>
<?php $form->end() ?>
</article>