<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Deporte;

$this->title = 'SGD CAE: Nuevo Deportista';
$a = ['no' => 'NO', 'si' => 'SI'];
$factor = ArrayHelper::map(Yii::$app->db->createCommand("select codigo from factor order by codigo")->queryAll(), 'codigo', 'codigo');
$deporte = ArrayHelper::map(Deporte::find()->all(), 'id_deporte', 'nombre_deporte')
?>
<head>
    <style>
        .form-group {
            margin-bottom:5px;
        }
    </style>
    <script type="text/javascript" src="../web/js/menu.js"></script>
    <script type="text/javascript" src="../web/js/mostrar.js"></script>
    <script type="text/javascript" src="../web/js/bloqueardesbloquear.js"></script> 
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
            <h3>Crear Deportista: 1/4</h3>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="ingrese foto de perfil">Foto:</label>
                        <?= $form->field($model, "file[]", ['enableAjaxValidation' => false])->fileInput(['multiple' => true, 'class' => 'form-control', 'autofocus' => true])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar nombre del deportista">Nombre:</label>
                        <?= $form->field($model, "nombre")->input("text", ["placeholder" => "Nombre", "class" => "form-control"])->label(false) ?>
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

                    <div class="form-group">
                        <label for="ingresar fecha nacimiento">Fecha de Nacimiento:</label>
                        <?= $form->field($model, "fecha_nac")->input("text", ["placeholder" => "Fecha de Nacimiento eje: 01/01/1950", "class" => "form-control"])->label(false) ?>
                    </div>
                </div>	
                <div class="col-xs-12 col-md-6">

                    <div class="form-group">
                        <label for="ingresar telefono del deportista">Telefono:</label>
                        <?= $form->field($model, "telefono")->input("number", ["placeholder" => "Telefono eje: 3434678950", "class" => "form-control"])->label(false) ?>
                    </div>
                    <div class="form-group">
                        <label for="ingresar email del deportista">Email:</label>
                        <?= $form->field($model, "email")->input("text", ["placeholder" => "Email", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="ingresar grupo y factor sanguineo">Grupo y Factor Sanguineo:</label>
                        <?= $form->field($planilla, "grupo_sanguineo")->dropDownList($factor)->label(false) ?>
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
                        <?= $form->field($model, "numero_socio")->input("text", ["placeholder" => "Número de Socio", "class" => "form-control"])->label(false) ?>
                    </div>

                    <a href="javascript:cambiar(2)"  class="btn btn-default" style="float:right;" id="go_paso_b">Continuar<span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            </div>
        </div>
        <div id="form_paso_b">
            <h3>Crear Deportista: 2/4</h3>
            <hr>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="toma medicamento" >¿Toma Medicamento de Forma Regular?:</label>
                        <label>                       
                            <?= $form->field($planilla, "medicamento")->radioList($a, ['onclick' => 'activar_desactivar("desc_medicamento","Planilla[medicamento]")', 'style' => 'display:inline;', 'separator' => ' '])->label(false) ?> 
                        </label>                    
                        <?= $form->field($planilla, "desc_medicamento")->input("text", ['id' => 'desc_medicamento', "readOnly" => "true", "placeholder" => "¿Cuales?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="alergia">Alergia:</label>
                        <label>                       
                            <?= $form->field($planilla, "alergia")->radioList($a, ['onclick' => 'activar_desactivar("desc_alergia","Planilla[alergia]")', 'style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_alergia")->input("text", ['id' => 'desc_alergia', "readOnly" => "true", "placeholder" => "¿Cuales?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="enfermedades cardiologica">Enfermedades Cardiológicas:</label>
                        <label>                       
                            <?= $form->field($planilla, "enf_cardiologica")->radioList($a, ['onclick' => 'activar_desactivar("desc_cardiologica","Planilla[enf_cardiologica]")', 'style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_cardiologia")->input("text", ['id' => 'desc_cardiologica', "readOnly" => "true", "placeholder" => "¿Cuales?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="asma">Asma:</label>
                        <label>                       
                            <?= $form->field($planilla, "asma")->radioList($a, ['onclick' => 'activar_desactivar("desc_asma","Planilla[asma]")', 'style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_asma")->input("text", ['id' => 'desc_asma', "readOnly" => "true", "placeholder" => "¿Cuales?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="convulsiones">Convulsiones:</label>
                        <label>                       
                            <?= $form->field($planilla, "convulsiones")->radioList($a, ['onclick' => 'activar_desactivar("ultima_convulsion","Planilla[convulsiones]")', 'style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "ultima_convulsion")->input("text", ['id' => 'ultima_convulsion', "readOnly" => "true", "placeholder" => "¿Ultima vez?", "class" => "form-control"])->label(false) ?>
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
                            <?= $form->field($planilla, "diabetes")->radioList($a, ['onclick' => 'activar_desactivar("desc_diabetes","Planilla[diabetes]")', 'style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_diabetes")->input("text", ['id' => 'desc_diabetes', "readOnly" => "true", "placeholder" => "¿Cual?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="enfermedad que requiere atención medica">¿Tiene Alguna Enferm. que Req. Atención?:</label>
                        <label>                       
                            <?= $form->field($planilla, "tratamiento")->radioList($a, ['onclick' => 'activar_desactivar("desc_tratamiento","Planilla[tratamiento]")', 'style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_tratamiento")->input("text", ['id' => 'desc_tratamiento', "readOnly" => "true", "placeholder" => "¿Cual?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="internación">¿Sufrió Internaciones en los Ultimos 2 años?:</label>
                        <label>                       
                            <?= $form->field($planilla, "internaciones")->radioList($a, ['onclick' => 'activar_desactivar("desc_internacion","Planilla[internaciones]")', 'style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "desc_internacion")->input("text", ['id' => 'desc_internacion', "readOnly" => "true", "placeholder" => "¿Porque?", "class" => "form-control"])->label(false) ?>
                    </div>

                    <div class="form-group">
                        <label for="fuma">Fuma:</label>
                        <label>                       
                            <?= $form->field($planilla, "fuma")->radioList($a, ['onclick' => 'activar_desactivar("cuanto_fuma","Planilla[fuma]")', 'style' => 'display:inline', 'separator' => ' '])->label(false) ?> 
                        </label>
                        <?= $form->field($planilla, "cuanto_fuma")->input("text", ['id' => 'cuanto_fuma', "readOnly" => "true", "placeholder" => "¿Cuanto Fuma?", "class" => "form-control"])->label(false) ?>
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
            <h3>Crear Deportista: 3/4</h3>
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
            <h3>Crear Deportista: 4/4</h3>
            <hr>

            <div class="row">
                <div id="clone">

                </div>

            </div>
            <button class="btn btn-default" id="agregar"><span class="glyphicon glyphicon-plus"></span></button>

            <div class="col-xs-12">
                <input type="submit" id="submit" value="Guardar" class="btn btn-primary" style="float:right;">
                <a href="javascript:cambiar(3)"  class="btn btn-default" style="float:right;margin-right: 3px;"><span class="glyphicon glyphicon-chevron-left"></span>Atras</a>
            </div>
        </div>
    </div>
</div>

</article>

<?php

function disable($val) {
    if ($val == 'si') {
        return false;
    }

    return true;
}
?>

<script>
    var counter = 0;
    $("#agregar").click(function () {
        var y = 'select' + '1';
        var x = "$.post('index.php?r=deportista/opcion&id='+$(this).val(),function(data){$('#c" + counter + "').html(data);})"
        $('#clone').append("<div class='col-xs-6'><div class='form-group'><label>Deporte</label><select class='form-control deporte'name='deporte[]'  id=" + counter + " onchange=" + x + ";><option value=''>Seleccione Deporte</option><?php foreach ($deporte as $clave => $a): ?><option value='<?= $clave ?>'><?= $a ?></option><?php endforeach; ?></select><div id='error" + counter + "'style='display: none'>debe seleciconar deporte</div></div></div>");
        $('#clone').append("<div class='col-xs-6'><div class='form-group'><label>Categoria</label><select class='form-control'name='categoria[]'id='c" + counter + "'><option value=''> Seleccione Categoria</option></select></div></div>");
        counter++;
    });
    $('#submit').click(function () {
        validacion = true;
        $(".deporte").each(function () {
            if ($(this).val() === "")
            {
              $('#error'+$(this).attr('id')).show();
                validacion = false;
                return false;
            }
           if(validacion) return true;
           else return false;
        });
    });
   $('#clone').on("change", '.deporte' ,function(){
        ($(this).val()!=="") ? $('#error'+$(this).attr('id')).hide() : $('#error'+$(this).attr('id')).show();
   });
</script>

<?php $form->end() ?>