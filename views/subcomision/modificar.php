<?php

use yii\widgets\ActiveForm;

$this->title = 'SGD CAE: Modificar Usuario';
?>

<article class="col-xs-12 col-md-10">
    <h3>Modificar Usuario: </h3>
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
                <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre", "class" => "form-control"])->label(false) ?>   
            </div>

            <div class="form-group">
                <label for="ingresar apellido:">Apellido:</label>
                <?= $form->field($model, "apellido")->input("text", ["placeholder" => "Apellido", "class" => "form-control"])->label(false) ?>   
            </div>


            <div class="form-group">
                <label for="ingresar direccion">Domicilio:</label>
                <?= $form->field($model, "domicilio")->input("text", ["placeholder" => "Domicilio", "class" => "form-control"])->label(false) ?>   
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="ingresar telefono">Telefono:</label>
                <?= $form->field($model, "telefono")->input("number", ["placeholder" => "Telefono eje:3434678950", "class" => "form-control"])->label(false) ?>   
            </div>
            <div class="form-group">
                <label for="ingresar email">E-mail:</label>
                <?= $form->field($model, "email")->input("email", ["placeholder" => "Email", "class" => "form-control"])->label(false) ?>   
            </div>
            <div class="form-group">
                <label for="seleccione un deporte">Deporte:</label>
                <?= $form->field($sub, 'id_deporte')->dropDownList($deporte, ['prompt' => 'Seleccione Deporte'])->label(false) ?>
            </div>
            <div class="botones">
                <input type="submit" value="Modificar" class="btn btn-primary">
            </div>
        </div>
    </div>
</article>

