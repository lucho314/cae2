<?php

namespace app\models;

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
            [['hora_inicio', 'hora_fin'],'match','pattern'=>"/^([0-1]+[0-9]|[2]+[0-4])+:+[0-5]+[0-9]$|^([0-1]+[0-9]|[2]+[0-4])+:+[0-5]+[0-9]+:[0][0]$/",'message'=>'Hora no valida.'],
            ['hora_fin','compare','compareAttribute' => 'hora_inicio','operator' => '>='],
            ['id_categoria','match', 'pattern' =>'/^[0-9]$|^[0-9]+[0-9]$/'],
            ['dia', 'match', 'pattern' => "/^[a-záéíóúñ\s]+$/i"],
            ['dia','match','pattern'=>"/^.{5,10}$/"],
            ['nombre_comision', 'match', 'pattern' => "/^[0-9a-záéíóúñ\s]+$/i",'message' => 'Sólo se aceptan letras y números.'],
            ['nombre_comision','match','pattern'=>"/^.{1,20}$/",'message'=>'Ah superado el maximo de 20 caracteres.'],
            [['hora_fin'],'validarcomision']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_comision' => 'Comisión',
            'dia' => 'Día',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'id_categoria' => 'Categoria',
            'nombre_comision' => 'Nombre Comisión',
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
    
    public function validarcomision($attribute){
        $tabla=  Comision::find()->where(['id_categoria'=>  $this->id_categoria])
                ->andWhere(['dia'=>  $this->dia])
                ->andWhere(['hora_inicio'=>  $this->hora_inicio])
                ->andWhere(['hora_fin'=>  $this->hora_fin]);
        if($tabla->count()!=0){
            $this->addError($attribute,'Ya existe una practica con estos datos.');
            return true;
        }
        return false;
    }
    
   

}
