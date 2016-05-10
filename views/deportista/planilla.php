<?php
use yii\helpers\Url;
$this->title = 'SGD CAE: Planilla Deportista';
?>
<article class="col-xs-12 col-md-10">
    <h3>Planilla: 
        <a href="<?= Url::toRoute(["deportista/imprimir", "id" => $data['dni']]) ?>" style="color:white; font-size:16px; margin-left:50px;" target="_blank">
            <span class="glyphicon glyphicon-print"></span>
        </a>
    </h3>
    <hr>
    <div class="table-responsive" id="cuerpo_planilla">
        <table class="table table-bordered table-striped table-condensed">
            <thead Style="background-color:yellow; color:black;">
                <tr><th colspan="5" style="text-align: center;">Datos Personales</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2">Nombre y Apellido:<?=" ".$data['nombre']." ".$data["apellido"]?></td>
                    <td colspan="3">Domicilio:<?=" ".$data['domicilio']?></td>
                </tr>
                <tr>
                    <td>E-Mail:<?=" ".$data['email']?></td>
                    <td>Fecha de Nac.:<?=" ".$data['fecha_nac']?></td>
                    <td>DNI:<?=" ".$data['dni']?></td>
                    <td>Telefono:<?=" ".$data['telefono']?></td>
                    <td>Nº de Socio:<?=" ".$data['numero_socio']?></td>
                </tr>
            </tbody>
            <thead Style="background-color:yellow; color:black;">
                <tr><th colspan="5" style="text-align: center;">Antecedentes Medicos</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>Obra Social:<?=" ".$planilla['obra_social']?></td>
                    <td colspan="2">Medico de Cabecera:<?=" ".$planilla['medico_cabecera']?></td>
                    <td colspan="2">Grupo Sanguineo:<?=" ".$planilla['grupo_sanguineo']?></td>
                </tr>
                <tr>
                    <td>¿Toma medicamentos en forma regular?:<?=" ".$planilla['medicamento']?></th>
                    <td colspan="4">¿Cuales?:<?=" ".$planilla['desc_medicamento']?></th>
                    </td>
                <tr>
                    <td>¿Alergia?:<?=" ".$planilla['alergia']?></td>
                    <td colspan="4">¿Cuales?:<?=" ".$planilla['desc_alergia']?></td>
                </tr>
                <tr>
                    <td>¿Anemia?:<?=" ".$planilla['anemia']?></td>
                    <td colspan="2">¿Trastornos hemorragicos?:<?=" ".$planilla['trastornos_hemorragicos']?></td>
                    <td colspan="2">¿Presion?:<?=" ".$planilla['presion']?></td>
                </tr>
                <tr>
                    <td>¿Asma?:<?=" ".$planilla['asma']?></td>
                    <td colspan="4">Obs.:<?=" ".$planilla['desc_asma']?></td>
                </tr>
                <tr>
                    <td>¿Enfermedades cardiologicas?:<?=" ".$planilla['enf_cardiologica']?></td>
                    <td colspan="4">¿Cuales?:<?=" ".$planilla['desc_cardiologia']?></td>
                </tr>
                <tr>
                    <td>¿Fuma?:<?=" ".$planilla['fuma']?></td>
                    <td colspan="5">¿Cuantos diario?:<?=" ".$planilla['cuanto_fuma']?></td>
                </tr>
                <tr>
                    <td colspan="5">¿Tiene alguna enfermedad que requiere tratamineto medico?:<?=" ".$planilla['tratamiento']?></td>
                </tr>
                <tr>
                    <td colspan="5">¿Cual?:<?=" ".$planilla['desc_tratamiento']?></td>
                </tr>
                <tr>
                    <td colspan="2">¿Ha sufrido internaciones en los ultimos dos años?:<?=" ".$planilla['internaciones']?></td>
                    <td colspan="3">¿Por que?:<?=" ".$planilla['desc_internacion']?></td>
                </tr>
            </tbody>
            <thead Style="background-color:yellow; color:black;">
                <tr><th colspan="5" style="text-align: center;">Contactos de Emergencia</th></tr>
            </thead>
            <tbody>
                <tr><td colspan="5">Apellido y Nombre:<?=" ".$planilla['nombreyapellido1']?></td></tr>
                <tr>
                    <td colspan="3">Domicilio:<?=" ".$planilla['domicilio1']?></td>
                    <td colspan="2">Telefono:<?=" ".$planilla['telefono1']?></td>
                </tr>
                <tr><td colspan="5">Apellido y Nombre:<?=" ".$planilla['nombreyapellido2']?></td></tr>
                <tr>
                    <td colspan="3">Domicilio:<?=" ".$planilla['domicilio2']?></td>
                    <td colspan="3">Telefono:<?=" ".$planilla['telefono2']?></td>
                </tr>
            </tbody>
        </table>
    </div>
</article>

