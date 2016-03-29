<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'SGD CAE: ' . $titulo;
?>

<article class="col-xs-12 col-md-10">
    <h3><?= $titulo ?></h3>
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
                <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre del evento", "class" => "form-control", 'autofocus' => true])->label(false) ?>   
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
                <?= $form->field($model, "id_profesor_suplente")->dropDownList($profesor, ['class' => "form-control", "prompt" => 'Seleccionar Profesor'])->label(false) ?>
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

            <div class="form-group">
                <?php if ($model->isNewRecord): ?>
                    <?= Html::submitButton('Crear', ['class' => 'btn btn-success', "style" => "float: right;"]) ?>
                <?php else: ?>
                    <?= Html::button('Modificar', ['class' => 'btn btn-primary', "style" => "float: right;", 'id' => 'boton']) ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <?php $form->end() ?>
</article>

<script>
    $("#boton").click(function () {
        if (<?= $model->convocados ?> === 1)
        {
            if (!$("#evento-convocados").prop('checked'))
            {
                if (confirm('¿Estas seguro de eliminar la lista de convocados?')) {
                    $("#formulario").submit();
                }
            }
            else{$("#formulario").submit();}
        }
        else{
            $("#formulario").submit();
        }


    });
    
    
</script>