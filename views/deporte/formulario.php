<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'SGD CAE: ' . $titulo;
?>

<head>
    <script type="text/javascript" src="../web/js/desaparecer.js"></script>
</head>
<article class="col-xs-12 col-md-10">
    <h3><?= $titulo ?>:</h3>
    <div class="content">
        <?php if ($msg != NULL) { ?>
            <div class='alert alert-success' role='contentinfo'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
                <?= $msg ?>
            </div>
        <?php } ?>
    </div>
    <hr>
    <?php
    $form = ActiveForm::begin([
                "method" => "post",
                "id" => "formulario",
                "enableClientValidation" => false,
                "enableAjaxValidation" => true,
    ]);
    ?>
    <div class="row col-xs-12 col-md-5">
        <div class="form-group">
            <label for="ingresar nombre del deporte">Nombre: </label>
            <?= $form->field($model, "nombre_deporte")->input("text", ["placeholder" => "Nombre del Deporte", "class" => "form-control", "autofocus"=>true])->label(false) ?>
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Modificar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <a href="<?=Url::toRoute("deporte/buscar")?>" class="btn btn-default">Cancelar</a>
        </div>
    </div>
    <?php $form->end() ?>
</article>

