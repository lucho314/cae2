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
    const SCENARIO_DATOS= 'datos';
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
        return array_merge(parent::rules(),[
            [['nombre_usuario', 'contrasenia'], 'required'],
            ['nueva_cont', 'required'],
            [['contrasenia'], 'string'],
            [['nombre_usuario'], 'string', 'max' => 9],
            ['conf_cont', 'compare', 'compareAttribute' => 'contrasenia', 'message' => 'Las contraseñas no coinciden', 'on' => self::SCENARIO_NUEVO],
            ['nombre_usuario', 'usuario_existe', 'on' => self::SCENARIO_NUEVO],
            ['nombre_usuario', 'usuario_existeM', 'on' => self::SCENARIO_MODIFICAR],
        ]);
    }

        public function scenarios()
    {
       // $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_NUEVO] = ['nombre','apellido','dni','domicilio','telefono','email','nombre_usuario','conf_cont', 'contrasenia'];
        $scenarios[self::SCENARIO_MODIFICAR] = ['nueva_cont', 'conf_cont', 'contrasenia','nombre_usuario'];
         $scenarios[self::SCENARIO_DATOS] = ['nombre','apellido','dni','domicilio','telefono','email'];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'dni' => 'Dni',
            'nombre_usuario' => 'Nombre Usuario',
            'contrasenia' => 'Contrasenia',
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

    public function usuario_existeM($attribute, $params) {
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

    public function usuario_existe($attribute, $params) {
        $table = $this->find()->where(['nombre_usuario' => $this->nombre_usuario]);

        if ($table->count() != 0) {
            $this->addError($attribute, "El nobre de usuario seleccionado existe");
            return true;
        }
        return false;
    }
}

