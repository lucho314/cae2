<?php

namespace app\models;

/**
 * This is the model class for table "profesor".
 *
 * @property integer $dni
 *
 * @property Categoria[] $categorias
 * @property Categoria[] $categorias0
 * @property Evento[] $eventos
 * @property Evento[] $eventos0
 * @property Persona $dni0
 * @property ProfesorDeporte[] $profesorDeportes
 * @property Deporte[] $idDeportes
 */
class Profesor extends \app\models\Usuario
{
    /**
     * @inheritdoc
     */
    public $deportes;
    public static function tableName()
    {
        return 'profesor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ['deportes', 'required'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dni' => 'DNI',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::className(), ['id_profesor_titular' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategorias0()
    {
        return $this->hasMany(Categoria::className(), ['id_profesor_suplente' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventos()
    {
        return $this->hasMany(Evento::className(), ['id_profesor_titular' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEventos0()
    {
        return $this->hasMany(Evento::className(), ['id_profesor_suplente' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona()
    {
        return $this->hasOne(Persona::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorDeportes()
    {
        return $this->hasMany(ProfesorDeporte::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDeportes()
    {
        return $this->hasMany(Deporte::className(), ['id_deporte' => 'id_deporte'])->viaTable('profesor_deporte', ['dni' => 'dni']);
    }
}
