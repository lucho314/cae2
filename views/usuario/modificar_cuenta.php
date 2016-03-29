<?php

use yii\widgets\ActiveForm;
$this->title = 'SGD: Cambiar Contraseña';
?>
<article class="col-xs-12 col-md-10">
    <h3>Cambiar Contraseña:</h3>
    <?=$msg?>
    <hr>
    <div class="row">
        <?php
        $form = ActiveForm::begin([
                    "method" => "post",
                    "id" => "formul",
                    "enableClientValidation" => false,
                    "enableAjaxValidation" => true,
        ]);
        ?>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="ingrese su nombre de usuario">Nombre de Usuario:</label>
                <?= $form->field($model,"nombre_usuario")->input("text", ['class' => 'form-control', 'placeholder' => 'Ingrese Nombre de Usuario'])->label(false)?>
            </div>
            <div class="form-group">
                <label for="ingrese su contraseña actual">Contraseña Actual:</label>
                <?= $form->field($model, "contrasenia")->input("password", ['class' => 'form-control', 'placeholder' => 'Ingrese su Contraseña Actual'])->label(false); ?>
            </div>            
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="form-group">
                <label for="ingrese su nueva contraseña">Contraseña Nueva:</label>
                <?= $form->field($model, "nueva_cont")->input("password", ['class' => 'form-control', 'placeholder' => 'Ingrese su Nueva Contraseña'])->label(false); ?>
            </div>
            <div class="form-group">
                <label>Confirme la Contraseña:</label>
                <?= $form->field($model, "conf_cont")->input("password", ['class' => 'form-control', 'placeholder' => 'Confirme su Nueva Contraseña'])->label(false); ?>
            </div>
            <div class="botones">
                <input type="submit" value="Modificar" class="btn btn-primary">
            </div>
        </div>
        <?php $form->end() ?>

    </div>
</article>



