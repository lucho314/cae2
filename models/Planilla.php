<?php

namespace app\models;

/**
 * This is the model class for table "planilla".
 *
 * @property integer $id_planilla
 * @property string $medico_cabecera
 * @property string $grupo_sanguineo
 * @property string $obra_social
 * @property string $medicamento
 * @property string $desc_medicamento
 * @property string $alergia
 * @property string $desc_alergia
 * @property string $anemia
 * @property string $enf_cardiologica
 * @property string $desc_cardiologia
 * @property string $asma
 * @property string $desc_asma
 * @property string $presion
 * @property string $convulsiones
 * @property string $ultima_convulsion
 * @property string $trastornos_hemorragicos
 * @property string $fuma
 * @property integer $cuanto_fuma
 * @property string $diabetes
 * @property string $desc_diabetes
 * @property string $tratamiento
 * @property string $desc_tratamiento
 * @property string $internaciones
 * @property string $desc_internacion
 * @property string $nombreyapellido1
 * @property string $domicilio1
 * @property string $telefono1
 * @property string $nombreyapellido2
 * @property string $domicilio2
 * @property string $telefono2
 * @property string $observaciones
 *
 * @property Deportista[] $deportistas
 */
class Planilla extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'planilla';
    }

    public $medicamento = 'no';
    public $alergia = 'no';
    public $anemia = 'no';
    public $enf_cardiologica = 'no';
    public $asma = 'no';
    public $presion = 'normal';
    public $convulsiones = 'no';
    public $trastornos_hemorragicos = 'no';
    public $fuma = 'no';
    public $diabetes = 'no';
    public $tratamiento = 'no';
    public $internaciones = 'no';

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombreyapellido1', 'telefono1', 'domicilio1', 'grupo_sanguineo'], 'required'],
            [['nombreyapellido1', 'nombreyapellido2'], 'match', 'pattern' => "/^[a-záéíóúñ\s]+$/i", 'message' => "Solo se aceptan letras."],
            [['nombreyapellido1', 'nombreyapellido2'], 'match', 'pattern' => "/^.{1,50}$/", 'message' => 'Ah superado el maximo de 50 caracteres.'],
            [['telefono1', 'telefono2', 'cuanto_fuma'], 'match', 'pattern' => "/^[0-9]$|^[0-9]+[0-9]$/", 'message' => 'Solo se aceptan números'],
            [['telefono1', 'telefono2'], 'match', 'pattern' => "/^.{10,10}$/", 'message' => 'Número de telefono incorrecto.'],
            [['domicilio1', 'domicilio1'], 'match', 'pattern' => "/^[0-9a-záéíóúñ\s]+$/i", 'message' => 'Solo se aceptan números y letras.'],
            [['domicilio1', 'domicilio1'], 'match', 'pattern' => "/^.{1,100}$/", 'message' => 'Ah superado el maximo de 100 caracteres.'],
            ['observaciones', 'match', 'pattern' => '/^[0-9a-záéí.;,óúñ\s]+$/i', 'message' => 'Solo se aceptan números, letras y (, ; .).'],
            ['observaciones', 'match', 'pattern' => '/^.{1,1000}$/', 'message' => 'Ah superado el maximo de 1000 caracteres.'],
            ['grupo_sanguineo','validar_grupoSanguineo'],
            [['medicamento','alergia','anemia','enf_cardiologica','asma','convulsiones','trastornos_hemorragicos','fuma','diabetes','tratamiento','internaciones'],'match','pattern' => '/^(no|si)$/'],
            [['desc_medicamento','desc_alergia','desc_cardiologia','desc_asma','ultima_convulsion','desc_diabetes','desc_tratamiento','desc_internacion'],'match','pattern' => "/^[0-9a-záéíóúñ\s]+$/i",'message'=>'Solo se aceptan números y letras.'],
            [['desc_medicamento','desc_alergia','desc_cardiologia','desc_asma','ultima_convulsion','desc_diabetes','desc_tratamiento','desc_internacion'],'match','pattern' => "/^.{1,50}/", 'message' => "Ah superado el maximo de 50 caracteres."],
            ['presion','match', 'pattern' => "/^(baja|normal|alta)$/"]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_planilla' => '',
            'medico_cabecera' => 'Medico Cabecera',
            'grupo_sanguineo' => 'Grupo Sanguineo',
            'obra_social' => 'Obra Social',
            'medicamento' => 'Medicamento',
            'desc_medicamento' => 'Descripción de Medicamento',
            'alergia' => 'Alergia',
            'desc_alergia' => 'Descripción de la Alergia',
            'anemia' => 'Anemia',
            'enf_cardiologica' => 'Enfermedad Cardiologica',
            'desc_cardiologia' => 'Descripcion de enfermedad Cardiologia',
            'asma' => 'Asma',
            'desc_asma' => 'Descripción del Asma',
            'presion' => 'Presion',
            'convulsiones' => 'Convulsiones',
            'ultima_convulsion' => 'Ultima Convulsion',
            'trastornos_hemorragicos' => 'Trastornos Hemorragicos',
            'fuma' => 'Fuma',
            'cuanto_fuma' => 'Cuanto Fuma',
            'diabetes' => 'Diabetes',
            'desc_diabetes' => 'Descripción de la Diabetes',
            'tratamiento' => 'Tratamiento',
            'desc_tratamiento' => 'Descripción del Tratamiento',
            'internaciones' => 'Internaciones',
            'desc_internacion' => 'Descripción de la Internación',
            'nombreyapellido1' => 'Contacto 1: Nombre y Apellido',
            'domicilio1' => 'Contacto 1: Domicilio',
            'telefono1' => 'Contacto 1: Telefono',
            'nombreyapellido2' => 'Contacto 2: Nombre y Apellido',
            'domicilio2' => 'Contacto 2: Domicilio',
            'telefono2' => 'Contacto 2: Telefono',
            'observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeportistas() {
        return $this->hasOne(Deportista::className(), ['id_planilla' => 'id_planilla']);
    }

    public function validar_grupoSanguineo($attribute) {
        $aux= Planilla::find()->select("codigo")->from("factor")
                              ->where(["codigo"=>$this->grupo_sanguineo])->one();
        if(count($aux)!=1){
            $this->getErrors($attribute,"Grupo Sanguineo no valido.");
            return false;
        }
        return true;
    }

}
