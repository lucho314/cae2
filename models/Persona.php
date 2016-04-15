<?php

namespace app\models;

/**
 * This is the model class for table "persona".
 *
 * @property integer $dni
 * @property string $nombre
 * @property string $apellido
 * @property string $domicilio
 * @property string $telefono
 * @property string $email
 *
 * @property Deportista $deportista
 * @property Profesor $profesor
 * @property SubComision[] $subComisions
 * @property Deporte[] $idDeportes
 * @property Usuario $usuario
 */
class Persona extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public $nombre, $apellido, $domicilio, $telefono;

    public static function tableName() {
        return 'persona';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['dni', 'telefono', 'email', 'nombre', 'apellido', 'domicilio'], 'required'],
            [['dni','telefono'], 'match','pattern' => "/^[0-9]$|^[0-9]+[0-9]$/" ,"message"=>'Solo números enteros'],
            ['telefono', 'match', 'pattern' => "/^.{10,10}$/", 'message' => 'Numero de telefono incorrecto'],
            [['nombre', 'apellido'], 'match', 'pattern' => "/^[a-záéíóúñ\s]+$/i", 'message' => 'Sólo se aceptan letras'],
            ['domicilio', 'match', 'pattern' => "/^.{1,50}$/", 'message' => 'Ah superado el maximo de 50 caracteres'],
            ['nombre', 'match', 'pattern' => "/^.{1,20}$/", 'message' => 'Ah superado el maximo de 20 caracteres'],
            ['apellido', 'match', 'pattern' => "/^.{1,30}$/", 'message' => 'Ah superado el maximo de 30 caracteres'],
            ['email', 'match', 'pattern' => "/^.{1,30}$/", 'message' => 'Ah superado el maximo de 30 caracteres'],
            ['domicilio', 'match', 'pattern' => "/^[0-9a-z\s]+$/i", 'message' => 'Sólo se aceptan letras y números'],
            ['dni', 'dni_existe'],['email', 'email_existe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'dni' => 'DNI',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'domicilio' => 'Domicilio',
            'telefono' => 'Telefono',
            'email' => 'Email',
        ];
    }

    public function email_existe($attribute) {

        //Buscar el email en la tabla
        $table = Persona::find()->where("email=:email", [":email" => $this->email]);

        //Si el email existe mostrar el error
        if ($table->count() != 0) {
            $this->addError($attribute, "El email seleccionado existe");
        }
        return true;
    }

    public function dni_existe($attribute) {
        $table = Persona::find()->where("dni=:dni", [":dni" => $this->dni]);

        if ($table->count() != 0) {
            $this->addError($attribute, "El DNI seleccionado existe");
        }
        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeportista() {
        return $this->hasOne(Deportista::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfesor() {
        return $this->hasOne(Profesor::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubComisions() {
        return $this->hasMany(SubComision::className(), ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdDeportes() {
        return $this->hasMany(Deporte::className(), ['id_deporte' => 'id_deporte'])->viaTable('sub_comision', ['dni' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario() {
        return $this->hasOne(Usuario::className(), ['dni' => 'dni']);
    }

}
