<?php

use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'SGD CAE: Crear Administrador';
?>


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
            <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre", "class" => "form-control", "autofocus" => true])->label(false) ?>   
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
            <label for="ingresar domicilio">Domicilio:</label>
            <?= $form->field($model, "domicilio")->input("text", ["placeholder" => "Domicilio", "class" => "form-control"])->label(false) ?>   
        </div>

        <div class="form-group">
            <label for="ingresar telefono">Telefono:</label>
            <?= $form->field($model, "telefono")->input("number", ["placeholder" => "Telefono eje:3434678950", "class" => "form-control"])->label(false) ?>   
        </div>
    </div>
    <div class="col-xs-12 col-md-6">  
        <div class="form-group">
            <label for="ingresar nombre de usuario">Nombre de Usuario:</label>
            <?= $form->field($model, "nombre_usuario")->input("text", ["placeholder" => "Nombre de Usuario eje: pepito", "class" => "form-control"])->label(false) ?>   
        </div>

        <div class="form-group">
            <label for="ingresar correo">Email:</label>
            <?= $form->field($model, "email")->input("email", ["placeholder" => "Email", "class" => "form-control"])->label(false) ?>   
        </div>
        <div class="form-group">
            <label for="ingresar contraseña">Contraseña:</label>
            <?= $form->field($model, "contrasenia")->input("password", ["placeholder" => "Contraseña", "class" => "form-control"])->label(false) ?>
        </div>
        <div class="form-group">
            <label for="ingresar confirmacion de contraseña">Confirmar:</label>
            <?= $form->field($model, "conf_cont")->input("password", ["placeholder" => "Contraseña", "class" => "form-control"])->label(false) ?>
        </div>

        <div class="botones">
            <input type="submit" value="Crear" class="btn btn-success">
        </div>
    </div>
    <?php $form->end() ?>

