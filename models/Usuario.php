<?php

namespace app\models;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $dni
 * @property string $nombre_usuario
 * @property string $contrasenia
 * @property string $privilegio
 * @property string $authKey
 * @property string $accessToken
 * @property string $verification_code
 * @property string $email
 *
 * @property NotifAdmin[] $notifAdmins
 * @property Persona $dni0
 */
class Usuario extends \app\models\Persona {

    public $conf_cont;
    public $nueva_cont;

    const SCENARIO_NUEVO = 'nuevo';
    const SCENARIO_MODIFICAR = 'modificado';
    const SCENARIO_DATOS = 'datos';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['nombre_usuario', 'contrasenia', 'nueva_cont'], 'required'],
            [['contrasenia', 'nueva_cont'], 'string'],
            ['nombre_usuario', 'match', 'pattern' => "/^[a-záéíóúñ\s]+$/i", 'message' => 'Sólo se aceptan letras.'],
            ['nombre_usuario', 'match', 'pattern' => "/^.{1,20}$/", 'message' => 'Ah superado el maximo de 20 caracteres.'],
            ['conf_cont', 'compare', 'compareAttribute' => 'contrasenia', 'message' => 'Las contraseñas no coinciden.', 'on' => self::SCENARIO_NUEVO],
            ['nombre_usuario', 'usuario_existe', 'on' => self::SCENARIO_NUEVO],
            ['nombre_usuario', 'usuario_existeM', 'on' => self::SCENARIO_MODIFICAR],
            ['email', 'email_modificado', 'on' => self::SCENARIO_DATOS],
          //  ['contrasenia', 'validar_usuario' ,'on' => self::SCENARIO_MODIFICAR],
            ['conf_cont', 'compare', 'compareAttribute' =>'nueva_cont', 'message' => 'Las contraseñas no coinciden.', 'on' => self::SCENARIO_MODIFICAR]
        ]);
    }

    public function scenarios() {
        $scenarios[self::SCENARIO_NUEVO] = ['nombre', 'apellido', 'dni', 'domicilio', 'telefono', 'email', 'nombre_usuario', 'conf_cont', 'contrasenia'];
        $scenarios[self::SCENARIO_MODIFICAR] = ['nueva_cont', 'conf_cont', 'contrasenia', 'nombre_usuario'];
        $scenarios[self::SCENARIO_DATOS] = ['nombre', 'apellido', 'dni', 'domicilio', 'telefono', 'email'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'dni' => 'DNI',
            'nombre_usuario' => 'Nombre Usuario',
            'contrasenia' => 'Contraseña',
            'nueva_cont' => 'Nueva Contraseña',
            'conf_cont' => 'Confirmar Contraseña',
            'privilegio' => 'Privilegio',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
            'verification_code' => 'Verification Code',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotifAdmins() {
        return $this->hasMany(NotifAdmin::className(), ['dni_generador' => 'dni']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDni0() {
        return $this->hasOne(Persona::className(), ['dni' => 'dni']);
    }

    public function usuario_existeM($attribute) {
        $usuario = $this->findOne($this->dni);
        if ($usuario->nombre_usuario != $this->nombre_usuario) {
            $table = $this->find()->where(['nombre_usuario' => $this->nombre_usuario]);

            if ($table->count() != 0) {
                $this->addError($attribute, "El nobre de usuario seleccionado existe");
                return true;
            }
        }
        return false;
    }

    public function usuario_existe($attribute) {
        $table = $this->find()->where(['nombre_usuario' => $this->nombre_usuario]);

        if ($table->count() != 0) {
            $this->addError($attribute, "El nombre de usuario seleccionado ya existe.");
            return true;
        }
        return false;
    }

    public function email_modificado($attribute) {
        $usuario = Persona::findOne($this->dni);
        if ($usuario->email != $this->email) {
            $table = Persona::find()->where(['email' => $this->email]);
            if ($table->count() != 0) {
                $this->addError($attribute, "El email seleccionado ya existe.");
                return true;
            }
        }
        return false;
    }

    public static function datos_usuario($id) {
        return Usuario::find()->select('persona.dni,nombre,apellido,domicilio,usuario.email,telefono')
                        ->from('persona,usuario')
                        ->where('persona.dni=usuario.dni')
                        ->andWhere(['usuario.dni' =>$id])->one();
    }
    
    public function validar_usuario($attribute){
        $cont_aux= crypt($this->contrasenia, \Yii::$app->params['salt']);
        $usuario = Usuario::find()->where(['dni'=> $this->dni])
                            ->andWhere(['contrasenia'=> $cont_aux])->one();
        if(count($usuario)!=1){
            $this->addError($attribute, "Contraseña no valida.");
            return true;
        }
        return false;        
    }
    
}
