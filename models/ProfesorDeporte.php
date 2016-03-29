<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profesor_deporte".
 *
 * @property integer $dni
 * @property integer $id_deporte
 *
 * @property Profesor $dni0
 * @property Deporte $idDeporte
 */
class ProfesorDeporte extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profesor_deporte';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dni', 'id_deporte'], 'required'],
            [['dni', 'id_deporte'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'dni' => 'Dni',
            'id_deporte' => 'Id Deporte',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDni0()
    {
        return $this->hasOne(Profesor::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDeporte()
    {
        return $this->hasOne(Deporte::className(), ['id_deporte' => 'id_deporte']);
    }
}
