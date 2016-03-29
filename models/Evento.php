<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "evento".
 *
 * @property integer $id_evento
 * @property string $nombre
 * @property string $condicion
 * @property string $fecha_inicio
 * @property integer $id_profesor_titular
 * @property integer $id_profesor_suplente
 * @property integer $id_deporte
 * @property string $fecha_fin
 * @property string $observaciones
 *
 * @property Convocados[] $convocados
 * @property Deporte $idDeporte
 * @property Profesor $idProfesorTitular
 * @property Profesor $idProfesorSuplente
 */
class Evento extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'evento';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre', 'condicion', 'fecha_inicio', 'id_profesor_titular', 'id_deporte', 'fecha_fin'], 'required'],
            ['nombre', 'match', 'pattern' => "/^.{1,30}$/", 'message' => 'Ah superado el maximo de 30 caracteres'],
            [['nombre'], 'match', 'pattern' => "/^[a-záéíóúñ\s]+$/i", 'message' => 'Sólo se aceptan letras'],
            [['observaciones'], 'match', 'pattern' => "/^[a-záéíóúñ\s,.;()]+$/i", 'message' => 'Sólo se aceptan letras ,;.()'],
            [['condicion', 'id_profesor_titular', 'id_deporte',], 'match', 'pattern' => " /^\d*$/", "message" => 'Solo numeros enteros'],
            ['convocados', 'boolean'],
            ['fecha_fin', 'compare', 'compareAttribute' => 'fecha_inicio', 'operator' => '>='],
            [['condicion', 'observaciones'], 'string'],
            [['fecha_inicio', 'fecha_fin'], 'safe'],
            [['id_profesor_titular', 'id_profesor_suplente', 'id_deporte'], 'integer'],
            [['nombre'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_evento' => 'Id Evento',
            'nombre' => 'Nombre',
            'condicion' => 'Condicion',
            'fecha_inicio' => 'Fecha Inicio',
            'id_profesor_titular' => 'Id Profesor Titular',
            'id_profesor_suplente' => 'Id Profesor Suplente',
            'id_deporte' => 'Id Deporte',
            'fecha_fin' => 'Fecha Fin',
            'observaciones' => 'Observaciones',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConvocados() {
        return $this->hasMany(Convocados::className(), ['id_evento' => 'id_evento']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDeporte() {
        return $this->hasOne(Deporte::className(), ['id_deporte' => 'id_deporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesorTitular() {
        return $this->hasOne(Profesor::className(), ['dni' => 'id_profesor_titular']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesorSuplente() {
        return $this->hasOne(Profesor::className(), ['dni' => 'id_profesor_suplente']);
    }

    public function getListadeporte() {
        $dropciones = Deporte::find()->asArray()->all();
        return ArrayHelper::map($dropciones, "id_deporte", "nombre_deporte");
    }

}
