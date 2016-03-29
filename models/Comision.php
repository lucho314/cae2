<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "comision".
 *
 * @property integer $id_comision
 * @property string $dia
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property integer $id_categoria
 * @property string $nombre_comision
 *
 * @property Categoria $idCategoria
 */
class Comision extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'comision';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['dia', 'hora_inicio', 'hora_fin', 'id_categoria', 'nombre_comision'], 'required'],
            [['hora_inicio', 'hora_fin'], 'safe'],
            [['id_categoria'], 'integer'],
            [['dia'], 'string', 'max' => 15],
            [['nombre_comision'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_comision' => 'Id Comision',
            'dia' => 'Dia',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'id_categoria' => 'Categoria',
            'nombre_comision' => 'Nombre Comision',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategoria() {
        return $this->hasOne(Categoria::className(), ['id_categoria' => 'id_categoria']);
    }

    public function getListaCategorias() {
        $opciones = [];
        $parents = Deporte::find()->all();
        foreach ($parents as $id => $p) {
            $children = Categoria::find()->where("id_deporte=:id", [":id" => $p->id_deporte])->all();
            $child_options = [];
            foreach ($children as $child) {
                $child_options[$child->id_categoria] = $p->nombre_deporte . "-" . $child->nombre_categoria;
            }
            $opciones[$p->nombre_deporte] = $child_options;
        }
        return $opciones;
    }

}
