<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'SGD CAE: Nuevo Profesor';
?>

<article class="col-xs-12 col-md-10">
    <h3>Modificar Usuario: </h3>
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
             <div class="row col-xs-12 col-md-5">
            <div class="form-group">
                <label for="ingresar nombre:">Nombre:</label>
                <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre de Usuario", "class" => "form-control"])->label(false) ?>   
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
              <div class="row col-xs-12 col-md-5">
            <div class="form-group">
                <label for="ingresar telefono">Telefono:</label>
                <?= $form->field($model, "telefono")->input("number", ["placeholder" => "Telefono eje:3434678950", "class" => "form-control"])->label(false) ?>   
            </div>
          
            <div class="form-group">
                <label for="ingresar email">E-mail:</label>
                <?= $form->field($model, "email")->input("email", ["placeholder" => "Email", "class" => "form-control"])->label(false) ?>   
            </div>
          
          <div class="botones">
                <input type="submit" value="Guardar" class="btn btn-primary">
                <a href="<?= Url::toRoute("usuario/modificar") ?>" class="btn btn-default">
                    <span class="glyphicon glyphicon-chevron-left"></span>Atras
                </a>
            </div>
        </div>
        
          
           
      
    <?php $form->end() ?>
</article>
