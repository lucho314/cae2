<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "deporte".
 *
 * @property integer $id_deporte
 * @property string $nombre_deporte
 *
 * @property Categoria[] $categorias
 * @property DeportistaCategoria[] $deportistaCategorias
 * @property Evento[] $eventos
 * @property ProfesorDeporte[] $profesorDeportes
 * @property Profesor[] $dnis
 * @property SubComision[] $subComisions
 * @property Persona[] $dnis0
 */
class Deporte extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'deporte';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['nombre_deporte'], 'required'],
            ['nombre_deporte', 'match', 'pattern' => "/^[a-záéíóúñ\s]+$/i", 'message' => 'Sólo se aceptan letras'],
            ['nombre_deporte', 'match', 'pattern' => "/^.{3,10}$/", 'message' => 'Mínimo 3 y máximo 10 caracteres'],
            ['nombre_deporte', 'val_nombre']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_deporte' => 'Id Deporte',
            'nombre_deporte' => 'Nombre Deporte',
        ];
    }

    public function val_nombre($attribute, $params) {
        $table = $this->find()->where(['nombre_deporte' => $this->nombre_deporte])->count();
        if ($table != 0) {
            $this->addError($attribute, "el deporte ingresado ya existe");
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias() {
        return $this->hasMany(Categoria::className(), ['id_deporte' => 'id_deporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeportistaCategorias() {
        return $this->hasMany(DeportistaCategoria::className(), ['id_deporte' => 'id_deporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventos() {
        return $this->hasMany(Evento::className(), ['id_deporte' => 'id_deporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorDeportes() {
        return $this->hasMany(ProfesorDeporte::className(), ['id_deporte' => 'id_deporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDnis() {
        return $this->hasMany(Profesor::className(), ['dni' => 'dni'])->viaTable('profesor_deporte', ['id_deporte' => 'id_deporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubComisions() {
        return $this->hasMany(SubComision::className(), ['id_deporte' => 'id_deporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDnis0() {
        return $this->hasMany(Persona::className(), ['dni' => 'dni'])->viaTable('sub_comision', ['id_deporte' => 'id_deporte']);
    }

    public function getDatosprofesor() {


        return Persona::find()->where(['IN', 'dni', $this->getDnis()])->asArray()->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeportistas() {
        return $this->hasMany(Persona::className(), ['dni' => 'dni'])->viaTable('deportista_categoria', ['id_deporte' => 'id_deporte']);
    }

    public static function getListadeporte() {
        return ArrayHelper::map(Deporte::find()->all(), "id_deporte", "nombre_deporte");
    }

}
