<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deportista".
 *
 * @property integer $dni
 * @property integer $id_planilla
 * @property integer $numero_socio
 * @property string $fecha_nac
 *
 * @property Asistencia[] $asistencias
 * @property Clase[] $idClases
 * @property Convocados[] $convocados
 * @property Planilla $idPlanilla
 * @property Persona $dni0
 * @property DeportistaCategoria[] $deportistaCategorias
 * @property Categoria[] $idCategorias
 */
class Deportista extends \app\models\Persona {

    /**
     * @inheritdoc
     */
    public $file;
    public $deporte;
    public $categoria;
    public $NyA;
    public $email;
    public $edad;

    public static function tableName() {
        return 'deportista';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            ['file', 'file',
                'skipOnEmpty' => false,
                'uploadRequired' => 'No has seleccionado ningún archivo', //Error
                'maxSize' => 1024 * 1024 * 1, //1 MB
                'tooBig' => 'El tamaño máximo permitido es 1MB', //Error
                'minSize' => 10, //10 Bytes
                'tooSmall' => 'El tamaño mínimo permitido son 10 BYTES', //Error
                'extensions' => 'JPG',
                'wrongExtension' => 'El archivo {file} no contiene una extensión permitida {extensions}', //Error
                'maxFiles' => 4,
                'tooMany' => 'El máximo de archivos permitidos son {limit}', //Error
            ],
            [['numero_socio'], 'required'],
            [['numero_socio'], 'integer'],
            [['fecha_nac'], 'safe']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'dni' => 'Dni',
            'id_planilla' => 'Id Planilla',
            'numero_socio' => 'Numero Socio',
            'fecha_nac' => 'Fecha Nac',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsistencias() {
        return $this->hasMany(Asistencia::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdClases() {
        return $this->hasMany(Clase::className(), ['id_clase' => 'id_clase'])->viaTable('asistencia', ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConvocados() {
        return $this->hasMany(Convocados::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPlanilla() {
        return $this->hasOne(Planilla::className(), ['id_planilla' => 'id_planilla']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona() {
        return $this->hasOne(Persona::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeportistaCategorias() {
        return $this->hasMany(DeportistaCategoria::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCategorias() {
        return $this->hasMany(Categoria::className(), ['id_categoria' => 'id_categoria'])->viaTable('deportista_categoria', ['dni' => 'dni']);
    }

}
