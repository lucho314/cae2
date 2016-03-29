<?php

namespace app\models;

use Yii;

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

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['grupo_sanguineo', 'medico_cabecera', 'obra_social',  'observaciones', 'medicamento', 'anemia', 'alergia', 'enf_cardiologica',
            'asma', 'convulsiones', 'fuma', 'trastornos_hemorragicos',
            'diabetes', 'presion', 'tratamiento'], 'required'],
            [['medico_cabecera', 'grupo_sanguineo', 'obra_social', 'desc_medicamento', 'desc_alergia', 'desc_cardiologia', 'desc_asma', 'ultima_convulsion', 'desc_diabetes', 'desc_tratamiento', 'desc_internacion', 'nombreyapellido1', 'domicilio1', 'nombreyapellido2', 'domicilio2', 'observaciones'], 'string'],
            [['medico_cabecera', 'grupo_sanguineo', 'obra_social', 'desc_medicamento', 'desc_alergia', 'desc_cardiologia', 'desc_asma', 'ultima_convulsion', 'desc_diabetes', 'desc_tratamiento', 'desc_internacion'], 'match', 'pattern' => "/^.{3,20}$/", 'message' => 'Mínimo 3 y máximo 30 caracteres'],
            [['cuanto_fuma'], 'integer'],
            [['medicamento', 'alergia', 'anemia', 'enf_cardiologica', 'asma', 'convulsiones', 'trastornos_hemorragicos', 'fuma', 'diabetes', 'tratamiento', 'internaciones'], 'string', 'max' => 2],
            [['presion'], 'string', 'max' => 6],
            [['telefono1', 'telefono2'], 'string', 'max' => 20],
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_planilla' => 'Id Planilla',
            'medico_cabecera' => 'Medico Cabecera',
            'grupo_sanguineo' => 'Grupo Sanguineo',
            'obra_social' => 'Obra Social',
            'medicamento' => 'Medicamento',
            'desc_medicamento' => 'Desc Medicamento',
            'alergia' => 'Alergia',
            'desc_alergia' => 'Desc Alergia',
            'anemia' => 'Anemia',
            'enf_cardiologica' => 'Enf Cardiologica',
            'desc_cardiologia' => 'Desc Cardiologia',
            'asma' => 'Asma',
            'desc_asma' => 'Desc Asma',
            'presion' => 'Presion',
            'convulsiones' => 'Convulsiones',
            'ultima_convulsion' => 'Ultima Convulsion',
            'trastornos_hemorragicos' => 'Trastornos Hemorragicos',
            'fuma' => 'Fuma',
            'cuanto_fuma' => 'Cuanto Fuma',
            'diabetes' => 'Diabetes',
            'desc_diabetes' => 'Desc Diabetes',
            'tratamiento' => 'Tratamiento',
            'desc_tratamiento' => 'Desc Tratamiento',
            'internaciones' => 'Internaciones',
            'desc_internacion' => 'Desc Internacion',
            'nombreyapellido1' => 'Nombreyapellido1',
            'domicilio1' => 'Domicilio1',
            'telefono1' => 'Telefono1',
            'nombreyapellido2' => 'Nombreyapellido2',
            'domicilio2' => 'Domicilio2',
            'telefono2' => 'Telefono2',
            'observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeportistas() {
        return $this->hasOne(Deportista::className(), ['id_planilla' => 'id_planilla']);
    }

}
