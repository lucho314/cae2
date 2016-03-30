<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'SGD CAE: Nuevo Usuario';
?>
<article class="col-xs-12 col-md-10">
    <div class="row">
        <div class="col-xs-2">
            <h3>Crear usuario:</h3>
        </div>
        <div class="col-xs-4">
            <select class="form-control" name="tipo" id="tipo" autofocus>
                <option value=""> Seleccione Usuario</option>
                <option value="1">Administrador</option>
                <option value="2">Subcomisión</option>
                <option value="3">Profesor</option>
            </select>
        </div>
    </div>
    <hr>

    <div id="administrador" style="display: none">
        <?php
        $form = ActiveForm::begin([
                    "method" => "post",
                    "id" => "formulario",
                    "enableClientValidation" => false,
                    "enableAjaxValidation" => true,
        ]);
        ?>

        <div class="col-xs-12 col-md-5">
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
    </div>
    <?php if (isset($sub)): ?>
        <div id="subcomision" style="display: none">

            <?php
            $form = ActiveForm::begin([
                        "id" => "nuevo",
                        "enableClientValidation" => false,
                        "enableAjaxValidation" => true,
                        "method" => "post"
                    ])
            ?>
            <div class="col-xs-12 col-md-5">
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
            <?php $form->end() ?>
        </div>
    <?php endif; ?>

</article>

<script>
    $('select#tipo').on('change', function () {
        var valor = $(this).val();
        var dataString = 'tipo=' + valor;
        switch (valor) {
            case '1':
                $.ajax({
                    type: "GET",
                    url: "<?= Url::toRoute(["usuario/create"]) ?>",
                    data: dataString
                });
                $('#administrador').show();
                break;
            case '2':
                $.ajax({
                    type: "GET",
                    url: "<?= Url::toRoute(["usuario/createsub"]) ?>",
                    data: dataString
                });
                $('#subcomision').show();
                break;
            case '3':
                $.ajax({
                    type: "GET",
                    url: "<?= Url::toRoute(["usuario/create"]) ?>",
                    data: dataString
                });
                $('#administrador').show();
                break;
            default:
                $('#administrador').hide();
                $('#subcomision').hide();
        }

    });

</script>