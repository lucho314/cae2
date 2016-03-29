<?php

use yii\widgets\ActiveForm;
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title>SGD CAE: Recuperar</title>
        <link href='../web/imagenes/cae.ico' rel='shortcut icon' type='image/x-icon'>
        <link rel="stylesheet" type="text/css" href="../web/css/login.css">
    </head>
    <body>
        <div class="container">
            <header class="row col-xs-12">
                <img src="../web/imagenes/cae.png">
                <h1>Sistema de Gestión Deportica</h1>
            </header>
            <section class="row col-xs-12 col-md-6">
                <h3>Recuperar Cuenta: 1/2</h3>
                <h4 style="color:white;"><?= $msg ?></h4>
                <hr>
                <?php
                $form = ActiveForm::begin([
                            "method" => "post",
                            "enableClientValidation" => true,
                           
                        ])
                ?>
                <div class="row col-xs-12" >
                    <div class="form-group">
                        <label for="ingrese email">Email:</label>
                        <?=$form->field($model, 'email')->input('email',['class'=>'form-control','autofocus','placeholder'=>'Email'])->label(false)?>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Recuperar" class="btn btn-default">
                    </div>
                </div>
                <?php $form->end()?>
            </section>
        </div>
    </body>
</html>