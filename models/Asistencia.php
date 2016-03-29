<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asistencia".
 *
 * @property integer $id_clase
 * @property integer $dni
 * @property string $asistencia
 * @property string $nota
 *
 * @property Clase $idClase
 * @property Deportista $dni0
 */
class Asistencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asistencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_clase', 'dni', 'asistencia', 'nota'], 'required'],
            [['id_clase', 'dni'], 'integer'],
            [['asistencia'], 'string', 'max' => 9],
            [['nota'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_clase' => 'Id Clase',
            'dni' => 'Dni',
            'asistencia' => 'Asistencia',
            'nota' => 'Nota',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdClase()
    {
        return $this->hasOne(Clase::className(), ['id_clase' => 'id_clase']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDni0()
    {
        return $this->hasOne(Deportista::className(), ['dni' => 'dni']);
    }
}
