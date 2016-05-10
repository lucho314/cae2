<?php

namespace app\models;
use Yii;
/**
 * This is the model class for table "sub_comision".
 *
 * @property integer $dni
 * @property integer $id_deporte
 *
 * @property Persona $dni0
 * @property Deporte $idDeporte
 */
class SubComision extends Usuario
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_comision';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id_deporte'], 'required'],
            [[ 'id_deporte'], 'integer']
        ]);
    }

    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDni0()
    {
        return $this->hasOne(Persona::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDeporte()
    {
        return $this->hasOne(Deporte::className(), ['id_deporte' => 'id_deporte']);
    }
    
    public static function mi_id_deporte(){
        /*return Subc->find()->select("select id_deporte")
                    ->from("sub_comision")
                    ->where(["dni"=>Yii::$app->user->identity->id]);*/
    }
    
}
