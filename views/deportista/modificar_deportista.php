<?php

use yii\widgets\ActiveForm;
use app\models\Deporte;
use yii\helpers\ArrayHelper;
use app\models\Categoria;

$this->title = 'SGD CAE: Nuevo Deportista';
$a = ['no' => 'NO', 'si' => 'SI'];
$deporte = ArrayHelper::map(Deporte::find()->all(), 'id_deporte', 'nombre_deporte');
$categoria = ArrayHelper::map(Categoria::find()->all(), 'id_categoria', 'nombre_categoria')
?>
<head>
    <style>
        .form-group {
            margin-bottom:5px;
        }
        <?php
        switch ($cant):
            case 2:
                echo "#deporte2,#categoria2{ display: block;}";
                echo '#boton1{ display: none}';
                break;
            case 3:
                echo "#deporte2,#deporte3,#categoria2,#categoria3{ display: block;}";
                echo '#boton1,#boton2{ display: none}';
                break;
        endswitch;
        ?>

    </style>
    <script type="text/javascript" src="../web/js/menu.js"></script>
    <script type="text/javascript" src="../web/js/mostrar.js"></script>
</head>
<article class="col-xs-12 col-md-10">
    <?php
    $form = ActiveForm::begin([
                "id" => "formulario",
                "enableClientValidation" => true,
                "enableAjaxValidation" => true,
                "method" => "post",
                "options" => ["enctype" => "multipart/form-data"],
            ])
    ?>
    <div class="row col-xs-12">
        <div id="form_paso_a">
            <h3 id="deportista">Crear Deportista: 1/4</h3>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="ingrese foto de perfil">Foto:</label>
                        <?= $form->field($model, "file[]", ['enableAjaxValidation' => false])->fileInput(['multiple' => true, "data-preview-file-type" => "any", "id" => "file-1", "class" => "file"])->label(false) ?>
                    </div>
                    <div class="form-group">
                        <label for="ingresar nombre del deportista">Nombre:</label>
                        <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre", "class" => "form-control", "autofocus" => true])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar apellido del deportista">Apellido:</label>
                        <?= $form->field($model, "apellido")->input("text", ["placeholder" => "Apellido", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar dni del deportista">DNI:</label>
                        <?= $form->field($model, "dni")->input("number", ["placeholder" => "DNI", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar domicilio del deportista">Domicilio:</label>
                        <?= $form->field($model, "domicilio")->input("text", ["placeholder" => "Domicilio", "class" => "form-control"])->label(false) ?>
                    </div>

                </div>	
                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="ingresar telefono del deportista">Telefono:</label>
                        <?= $form->field($model, "telefono")->input("number", ["placeholder" => "Telefono eje:3434678950", "class" => "form-control"])->label(false) ?>
                    </div>
                    <div class="form-group">
                        <label for="ingresar email del deportista">Email:</label>
                        <?= $form->field($model, "email")->input("text", ["placeholder" => "Email", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar grupo y factor sanguineo">Grupo y Factor Sanguineo:</label>
                        <?= $form->field($planilla, "grupo_sanguineo")->input("text", ["placeholder" => "Grupo y Factor Sanguineo", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar medico cabecera">Medico Cabecera:</label>
                        <?= $form->field($planilla, "medico_cabecera")->input("text", ["placeholder" => "Medico Cabecera", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar obra social">Obra Social:</label>
                        <?= $form->field($planilla, "obra_social")->input("text", ["placeholder" => "Obra Social", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar número de socio">Número de Socio:</label>
                        <?= $form->field($model, "numero_socio")->input("number", ["placeholder" => "Número de Socio", "class" => "form-control"])->label(false) ?>
                    </div>

                    <a href="javascript:cambiar(2)"  class="btn btn-default" style="float:right;" id="go_paso_b">Continuar<span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
        </div>
        <div id="form_paso_b">
            <h3 id="planilla">Crear Deportista: 2/4</h3>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="toma medicamento" >¿Toma Medicamento de Forma Regular?:</label>
                        <label>                       
                            <?= $form->field($planilla, "medicamento")->radioList($a, ['style' => 'display:inline;', 'separator' => ' '])->label(false) ?> 
                        </label>                    
                        <?= $form->field($planilla, "desc_medicamento")->input("text", ["placeholder" => "¿Cuales?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="alergia">Alergia:</label>
                        <label>                       
                            <?= $form->field($planilla, "alergia")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_alergia")->input("text", ["placeholder" => "¿Cuales?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="enfermedades cardiologica">Enfermedades Cardiológicas:</label>
                        <label>                       
                            <?= $form->field($planilla, "enf_cardiologica")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_cardiologia")->input("text", ["placeholder" => "¿Cuales?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="asma">Asma:</label>
                        <label>                       
                            <?= $form->field($planilla, "asma")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_asma")->input("text", ["placeholder" => "¿Cuales?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="convulsiones">Convulsiones:</label>
                        <label>                       
                            <?= $form->field($planilla, "convulsiones")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "ultima_convulsion")->input("text", ["placeholder" => "¿Ultima vez?", "class" => "form-control"])->label(false) ?>
                    </div>
                    <div class="form-group">
                        <label for="trastornos hemorragicos">Trastornos Hemorragicos:</label>
                        <label>                       
                            <?= $form->field($planilla, "trastornos_hemorragicos")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                    </div>

                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="diabetes">Diabetes:</label>
                        <label>                       
                            <?= $form->field($planilla, "diabetes")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_diabetes")->input("text", ["placeholder" => "¿Cual?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="enfermedad que requiere atención medica">¿Tiene Alguna Enferm. que Req. Atención?:</label>
                        <label>                       
                            <?= $form->field($planilla, "tratamiento")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_tratamiento")->input("text", ["placeholder" => "¿Cual?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="internación">¿Sufrió Internaciones en los Ultimos 2 años?:</label>
                        <label>                       
                            <?= $form->field($planilla, "internaciones")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_internacion")->input("text", ["placeholder" => "¿Porque?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="fuma">Fuma:</label>
                        <label>                       
                            <?= $form->field($planilla, "fuma")->radioList($a, ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "cuanto_fuma")->input("text", ["placeholder" => "¿Cuanto Fuma?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="presión">Presión:</label>
                        <label>                       
                            <?= $form->field($planilla, "presion")->radioList(['baja' => 'Baja', 'normal' => 'Normal', 'alta' => 'Alta'], ['style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="anemia">Anemia:</label>
                        <label>                       
                            <?= $form->field($planilla, "anemia")->radioList($a, ['style' => 'display:inline;', 'separator' => ' '])->label(false) ?> 
                        </label> 
                    </div>
                    <a href="javascript:cambiar(3)"  class="btn btn-default" style="float:right;">Continuar<span class="glyphicon glyphicon-chevron-right"></span></a>
                    <a href="javascript:cambiar(1)"  class="btn btn-default" style="float:right; margin-right:3px;"><span class="glyphicon glyphicon-chevron-left"></span>Atras</a>
                </div>
            </div>
        </div>
        <div id="form_paso_c">
            <h3 id="contacto">Crear Deportista: 3/4</h3>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="ingresar nombre y apellido 1">Nombre y Apellido:</label>
                        <?= $form->field($planilla, "nombreyapellido1")->input("text", ["placeholder" => "Nombre y Apellido de contacto 1", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar domicilio 1">Domicilio:</label>
                        <?= $form->field($planilla, "domicilio1")->input("text", ["placeholder" => "Domicilio de contacto 1", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar telefono 1">Telefono:</label>
                        <?= $form->field($planilla, "telefono1")->input("number", ["placeholder" => "Telefono 1 ej:3434678950", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar nombre y apellido 2">Nombre y Apellido:</label>
                        <?= $form->field($planilla, "nombreyapellido2")->input("text", ["placeholder" => "Nombre y Apellido de contacto 2", "class" => "form-control"])->label(false) ?>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="ingresar domicilio 2">Domicilio:</label>
                        <?= $form->field($planilla, "domicilio2")->input("text", ["placeholder" => "Domicilio de contacto 2", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar telefono 2">Telefono:</label>
                        <?= $form->field($planilla, "telefono2")->input("text", ["placeholder" => "Telefono 2 ej:3434678950", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar observaciones">Observaciones:</label>
                        <?= $form->field($planilla, 'observaciones')->textarea(['class' => "form-control", 'style' => "resize:none;", 'rows' => '5'])->label(false) ?>
                    </div>
                    <a href="javascript:cambiar(4)"  class="btn btn-default" style="float:right;">Continuar<span class="glyphicon glyphicon-chevron-right"></span></a>
                    <a href="javascript:cambiar(2)"  class="btn btn-default" style="float:right; margin-right:3px;"><span class="glyphicon glyphicon-chevron-left"></span>Atras</a>
                </div>
            </div>
        </div>
        <div id="form_paso_d">
            <h3 id="deportes">Crear Deportista: 4/4</h3>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="seleccionar deporte">Deporte:</label>
                        <?=
                        $form->field($model, 'deporte1')->dropDownList(
                                $deporte, [
                            'prompt' => 'Seleccione Deporte',
                            'onchange' => '
                                        $.post( "index.php?r=deportista/opcion&id=' . '"+$(this).val(), function( data ) {
                                            $( "select#deportista-categoria1" ).html( data ).prop( "disabled", false );
                                        });'
                        ])->label(false);
                        ?>
                        <a href="javascript:mostrar(2)" id="boton1" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span></a>
                    </div>

                    <div id="deporte2">
                        <div class="form-group">
                            <label for="seleccionar deporte">Deporte:</label>
                            <?=
                            $form->field($model, 'deporte2')->dropDownList(
                                    $deporte, [
                                'prompt' => 'Seleccione Deporte',
                                'onchange' => '
                                        $.post( "index.php?r=deportista/opcion&id=' . '"+$(this).val(), function( data ) {
                                            $( "select#deportista-categoria2" ).html( data ).prop( "disabled", false );;
                                        });'
                            ])->label(false);
                            ?>
                            <a href="javascript:mostrar(3)" id="boton2" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span></a>
                        </div>
                    </div>
                    <div id="deporte3">
                        <div class="form-group">
                            <label for="seleccionar deporte">Deporte:</label>
                            <?=
                            $form->field($model, 'deporte3')->dropDownList(
                                    $deporte, [
                                'prompt' => 'Seleccione Deporte',
                                'onchange' => '
                                        $.post( "index.php?r=deportista/opcion&id=' . '"+$(this).val(), function( data ) {
                                            $( "select#deportista-categoria3" ).html( data ).prop( "disabled", false );
                                        });'
                            ])->label(false);
                            ?>
                        </div> 
                    </div>
                </div> 
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="seleccionar categoria">categoria:</label>
                        <?=
                        $form->field($model, 'categoria1')->dropDownList(
                                $categoria, [
                            'prompt' => 'Selecione Categoria',
                            'disabled' => true,
                        ])->label(false);
                        ?>
                    </div>

                    <div id="categoria2">
                        <div class="form-group">
                            <label for="seleccionar deporte">categoria:</label>
                            <?=
                            $form->field($model, 'categoria2')->dropDownList(
                                    $categoria, [
                                'prompt' => 'Selecione Categoria',
                                'disabled' => true,
                            ])->label(false);
                            ?>

                        </div> 
                    </div>

                    <div id="categoria3">
                        <div class="form-group">
                            <label for="seleccionar deporte">categoria:</label>
                            <?=
                            $form->field($model, 'categoria3')->dropDownList(
                                    $categoria, [
                                'prompt' => 'Selecione Categoria',
                                'disabled' => true,
                            ])->label(false);
                            ?>
                        </div> 
                    </div>
                </div>
                <div class="col-xs-12">
                    <input type="submit" value="Guardar" class="btn btn-primary" style="float:right;">
                    <a href="javascript:cambiar(3)"  class="btn btn-default" style="float:right;margin-right: 3px;"><span class="glyphicon glyphicon-chevron-left"></span>Atras</a>
                </div>
            </div>
        </div>
    </div>
    <?php $form->end() ?>
</article>

<?php

function disable($val) {
    if ($val == 'si') {
        return false;
    }
    return true;
}
?>