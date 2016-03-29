<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "convocados".
 *
 * @property integer $id_lista
 * @property integer $dni
 * @property string $nombre
 * @property integer $id_evento
 *
 * @property Deportista $dni0
 * @property Evento $idEvento
 */
class Convocados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'convocados';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dni', 'nombre', 'id_evento'], 'required'],
            [['dni', 'id_evento'], 'integer'],
            [['nombre'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_lista' => 'Id Lista',
            'dni' => 'Dni',
            'nombre' => 'Nombre',
            'id_evento' => 'Id Evento',
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
    public function getIdEvento()
    {
        return $this->hasOne(Evento::className(), ['id_evento' => 'id_evento']);
    }
}
