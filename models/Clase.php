<?php

namespace app\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "clase".
 *
 * @property integer $id_clase
 * @property string $fecha
 * @property string $observaciones
 * @property integer $id_categoria
 *
 * @property Asistencia[] $asistencias
 * @property Deportista[] $dnis
 * @property Categoria $idCategoria
 */
class Clase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha', 'id_categoria'], 'required'],
            [['fecha'], 'safe'],
            [['observaciones'], 'string'],
            [['id_categoria'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_clase' => 'Id Clase',
            'fecha' => 'Fecha',
            'observaciones' => 'Observaciones',
            'id_categoria' => 'Id Categoria',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsistencias()
    {
        return $this->hasMany(Asistencia::className(), ['id_clase' => 'id_clase']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDnis()
    {
        return $this->hasMany(Deportista::className(), ['dni' => 'dni'])->viaTable('asistencia', ['id_clase' => 'id_clase']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria()
    {
        return $this->hasOne(Categoria::className(), ['id_categoria' => 'id_categoria']);
    }
    
       /**
     * get lista de categoria para lista desplegable
     */
    public static function getCategoriaLista() {
        $dni=Yii::$app->user->identity->id;
        $droptions = Categoria::find()->where(['id_profesor_titular'=>$dni])->orWhere(['id_profesor_titular'=>$dni])->asArray()->all();
        return ArrayHelper::map($droptions, 'id_categoria', 'nombre_categoria');
    }
   
}
