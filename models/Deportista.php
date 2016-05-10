<?php

namespace app\models;

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
    public $edad;
    public $email;

    public static function tableName() {
        return 'deportista';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            ['file', 'file',
                'skipOnEmpty' => TRUE,
                'maxSize' => 1024 * 1024 * 1, //1 MB
                'tooBig' => 'El tamaño máximo permitido es 1MB', //Error
                'minSize' => 0, //10 Bytes
                'extensions' => 'JPG',
                'wrongExtension' => 'El archivo {file} no contiene una extensión permitida {extensions}', //Error
                'maxFiles' => 4,
                'tooMany' => 'El máximo de archivos permitidos son {limit}', //Error
            ],
            ['numero_socio', 'required'],
            ['numero_socio', 'match', 'pattern' => "/^[0-9a-záéíóúñ]+$/", 'message' => "Número de Socio no Valido."],
            ['numero_socio', 'match', 'pattern' => "/^.{1,7}$/", 'message' => "Ah superado el maximo de 6 caracteres."],
            ['fecha_nac', 'match', 'pattern'=>"/^([0]+[1-9]|[1-2]+[0-9]|[3]+[0-1])+\/+([0]+[1-9]|[1]+[0-2])+\/+([1]+[9]+[5-9]|[2-9]+[0-9]+[0-9])+[0-9]$/i",'message' => "Fecha de Nacimiento no valida."],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'dni' => 'DNI',
            'id_planilla' => '',
            'numero_socio' => 'Número Socio',
            'fecha_nac' => 'Fecha Nac.',
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

    public static function datos_deportista($id){
        return Deportista::find()->select("nombre,apellido,domicilio,telefono,email,persona.dni,numero_socio,fecha_nac,id_planilla")
                           ->from("persona,deportista")
                           ->where("persona.dni=deportista.dni")
                           ->andWhere(["deportista.dni"=>$id])->one();
    }
}
