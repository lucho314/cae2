<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = 'SGD CAE: Nueva Subcomisión';
?>

<article class="col-xs-12 col-md-10">
    <h3>Crear Usuario Subcomisión: 2/2</h3>
    <?= $msg ?>
    <hr>
    <?php
    $form = ActiveForm::begin([
                "id" => "nuevo",
                "enableClientValidation" => false,
                "enableAjaxValidation" => true,
                "method" => "post"
            ])
    ?>

    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="ingresar nombre:">Nombre:</label>
                <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre", "autofocus", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar apellido:">Apellido:</label>
                <?= $form->field($model, "apellido")->input("text", ["placeholder" => "Apellido", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar dni">DNI:</label>
                <?= $form->field($model, "dni")->input("number", ["placeholder" => "DNI", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar direccion">Domicilio:</label>
                <?= $form->field($model, "domicilio")->input("text", ["placeholder" => "Domicilio", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar telefono">Telefono:</label>
                <?= $form->field($model, "telefono")->input("number", ["placeholder" => "Telefono eje:3434678950", "class" => "form-control"])->label(false) ?>   
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="ingresar email">E-mail:</label>
                <?= $form->field($model, "email")->input("email", ["placeholder" => "Email", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar nombre de usuario">Nombre de Usuario:</label>
                <?= $form->field($model, "nombre_usuario")->input("text", ["placeholder" => "Nombre de Usuario eje: pepito", "class" => "form-control"])->label(false) ?>   
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
                <label for="seleccione un deporte">Deporte:</label>
                <?= $form->field($sub, 'id_deporte')->dropDownList($deporte, ['prompt' => 'Seleccione Deporte'])->label(false) ?>
            </div>

            <div class="botones">
                <input type="submit" value="Crear" class="btn btn-success">
                <a href="<?= Url::toRoute("usuario/nuevo") ?>" class="btn btn-default">Cancelar</a>
            </div>
        </div>
    </div>
    <?php $form->end() ?>
</article>


