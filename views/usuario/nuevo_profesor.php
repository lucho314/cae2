<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'SGD CAE: Nuevo Profesor';
?>

<article class="col-xs-12 col-md-10">
    <h3>Crear Usuario Profesor: 2/2</h3>
    <?=$msg?>
    <hr>
    <?php
    $form = ActiveForm::begin([
                "method"=>"post",
                "id"=>"formulario",
                "enableClientValidation" =>false,
                "enableAjaxValidation"=>true,
    ]);
    ?>

    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="ingresar nombre:">Nombre:</label>
                <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre de Usuario", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar apellido:">Apellido:</label>
                <?= $form->field($model, "apellido")->input("text", ["placeholder" => "Apellido", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar dni">DNI:</label>
                <?= $form->field($model, "dni")->input("text", ["placeholder" => "DNI", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar direccion">Domicilio:</label>
                <?= $form->field($model, "domicilio")->input("text", ["placeholder" => "Domicilio", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar telefono">Telefono:</label>
                <?= $form->field($model, "telefono")->input("number", ["placeholder" => "Telefono eje:3434678950", "class" => "form-control"])->label(false) ?>   
            </div>
            
            <div class="form-group">
                <label for="ingresar nombre de usuario">Nombre de Usuario:</label>
                <?= $form->field($model, "nombre_usuario")->input("text", ["placeholder" => "Nombre de Usuario eje: pepito", "class" => "form-control"])->label(false) ?>   
            </div>
        </div>
        <div class="col-xs-12 col-md-6">        
            <div class="form-group">
                <label for="ingresar email">E-mail:</label>
                <?= $form->field($model, "email")->input("email", ["placeholder" => "Email", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar contraseña">Contraseña:</label>
                <?= $form->field($model, "contrasenia")->input("password", ["placeholder" => "Contraseña", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar confirmacion contraseña">Confirmar:</label>
                <?= $form->field($model, "conf_cont")->input("password", ["placeholder" => "Contraseña", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">          
                <label for="seleccionar deporte">Deportes:</label>
                <?=$form->field($model,'deportes')->dropDownList($deporte,['multiple'=>true,'size'=>'6','class'=>"form-control"])->label(false)?>
            </div>
          
            <div class="botones">
                <input type="submit" value="Guardar" class="btn btn-primary">
                <a href="<?= Url::toRoute("usuario/nuevo") ?>" class="btn btn-default">Cancelar</a>               </a>
            </div>
        </div>
    </div>
    <?php $form->end() ?>
</article>
