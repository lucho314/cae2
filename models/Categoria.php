<?php

namespace app\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "categoria".
 *
 * @property integer $id_categoria
 * @property string $nombre_categoria
 * @property integer $id_deporte
 * @property integer $id_profesor_titular
 * @property integer $id_profesor_suplente
 * @property integer $edad_minima
 * @property integer $edad_maxima
 *
 * @property Deporte $idDeporte
 * @property Profesor $idProfesorTitular
 * @property Profesor $idProfesorSuplente
 * @property Comision[] $comisions
 * @property DeportistaCategoria[] $deportistaCategorias
 * @property Deportista[] $dnis
 */
class Categoria extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    const SCENARIO_NEW = 'new';
    const SCENARIO_UPDATE = 'update';

    public $nombre_deporte;
    public $nya_titular;
    public $nya_suplente;

    public static function tableName() {
        return 'categoria';
    }

    /**
     * @inheritdoc
     */
    public $Nyatitular;

    public function rules() {
        return [
            [['nombre_categoria', 'id_deporte'], 'required'],
            [['edad_minima', 'edad_maxima'], 'match', 'pattern' => '/^[0-9]$|^[0-9]+[0-9]$/', "message" => 'Edad no valida.'],
            ['nombre_categoria', 'match', 'pattern' => "/^.{1,21}$/", 'message' => 'Ah superado el maximo de 20 caracteres.'],
            [['nombre_categoria'], 'match', 'pattern' => "/^[0-9a-záéíóúñ\s]+$/i", 'message' => 'Sólo se aceptan letras y números.'],
            ['edad_maxima', 'compare', 'compareAttribute' => 'edad_minima', 'operator' => '>='],
            ['id_profesor_suplente', 'compare', 'compareValue' => 'id_profesor_titular', 'operator' => '=', 'message' => 'El profesor suplente deber ser diferente al Titular.'],
            ['nombre_categoria', 'val_nom', 'on' => self::SCENARIO_NEW],
            ['nombre_categoria', 'val_nommodif', 'on' => self::SCENARIO_UPDATE],
            [['id_deporte', 'id_profesor_titular', 'id_profesor_suplente'],'match', 'pattern'=>'/^[0-9]$|^[0-9]+[0-9]$/']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id_categoria' => 'Categoria',
            'nombre_categoria' => 'Nombre Categoria',
            'id_deporte' => 'Deporte',
            'id_profesor_titular' => 'Profesor Titular',
            'id_profesor_suplente' => 'Profesor Suplente',
            'edad_minima' => 'Edad Minima',
            'edad_maxima' => 'Edad Maxima',
        ];
    }

    public function val_nom($attribute) {
        $cant = $this->find()->where(['id_deporte' => $this->id_deporte])->andWhere(['nombre_categoria' => $this->nombre_categoria])->count();
        if ($cant != 0) {
            $this->addError($attribute, "El nobre de categoria seleccionado existe en ese deporte");
            return true;
        }
        return false;
    }

    public function val_nommodif($attribute) {
        $nombre = $this->findOne($this->id_categoria);
        if ($nombre->nombre_categoria != $this->nombre_categoria) {
            $cant = $this->find()->where(['id_deporte' => $this->id_deporte])->andWhere(['nombre_categoria' => $this->nombre_categoria])->count();
            if ($cant != 0) {
                $this->addError($attribute, "El nobre de categoria seleccionado existe en ese deporte");
                return true;
            }
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeporte() {
        return $this->hasOne(Deporte::className(), ['id_deporte' => 'id_deporte']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesorTitular() {
        return $this->hasOne(Profesor::className(), ['dni' => 'id_profesor_titular']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdProfesorSuplente() {
        return $this->hasOne(Profesor::className(), ['dni' => 'id_profesor_suplente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComisions() {
        return $this->hasMany(Comision::className(), ['id_categoria' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeportistaCategorias() {
        return $this->hasMany(DeportistaCategoria::className(), ['id_categoria' => 'id_categoria']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDnis() {
        return $this->hasMany(Deportista::className(), ['dni' => 'dni'])->viaTable('deportista_categoria', ['id_categoria' => 'id_categoria']);
    }

    public static function getCategoriasLista() {
        return ArrayHelper::map(Categoria::find()->all(), 'id_categoria', 'nombre_categoria');
    }

    /**
     * get lista de profesores para lista desplegable
     */
    public static function getProfesorLista() {
        return ArrayHelper::map(Profesor::find()->select(["profesor.dni,concat(persona.apellido,', ',persona.nombre) nombre"])
                                ->from('persona,profesor')
                                ->where("persona.dni=profesor.dni")->all(), 'dni', 'nombre');
    }

}
