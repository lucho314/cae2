<?php
/* @var $this yii\web\View */
use yii\widgets\ActiveForm;
use yii\helpers\Url;
$this->title = 'SGD: Login';
 $form = ActiveForm::begin
         ([
             "method"=>"post",
            "enableClientValidation" => true,
         ]);
?>

<head>
    <link rel="stylesheet" type="text/css" href="../web/css/login.css">
</head>
<div class="container">
    <header class="row col-xs-12">
        <img src="../web/imagenes/cae.png">
        <h1>Sistema de Gestión Deportica</h1>	
    </header>
    <section class="row col-xs-12 col-md-6">
        <h3>Bienvenido</h3>
        <hr>
        <form class="row col-xs-12" >
            <div class="form-group">
                <label for="nombre">Nombre de Usuario</label>
                <?= $form->field($model,'usuario')->input("text",['class' => 'form-control','autofocus'=>true,'placeholder'=>'Nombre de Usuario'])->label(false)?>
            </div>

            <div class="form-group">
                <label for="contraseña">Contraseña</label>
                 <?= $form->field($model, 'contra')->input("password",['class'=>'form-control','placeholder'=>'Contraseña'])->label(false) ?>
            </div>
             <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
        ]) ?>
            <div class="form-group">
                <input type="submit" value="INCIAR SESION" class="btn btn-primary">
            </div>
            <?php $form->end()?>
            <div class="form-group">
                <a class="btn btn-default btn-xs" href="<?=Url::toRoute('usuario/recuperar_cuenta')?>">¿Olvido su Contraseña?</a>
            </div>
        </form>
    </section>
</div>