<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deportista_categoria".
 *
 * @property integer $dni
 * @property integer $id_categoria
 * @property integer $id_deporte
 * @property integer $activo
 *
 * @property Deportista $dni0
 * @property Categoria $idCategoria
 * @property Deporte $idDeporte
 */
class DeportistaCategoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deportista_categoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dni', 'id_categoria', 'activo'], 'required'],
            [['dni', 'id_categoria', 'id_deporte', 'activo'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dni' => 'Dni',
            'id_categoria' => 'Id Categoria',
            'id_deporte' => 'Id Deporte',
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDni0()
    {
        return $this->hasOne(Deportista::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id_categoria' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDeporte()
    {
        return $this->hasOne(Deporte::className(), ['id_deporte' => 'id_deporte']);
    }
}
