<?php

namespace app\models;
use app\models\User;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    
    public $dni;
    public $nombre_usuario;
    public $email;
    public $contrasenia;
    public $authKey;
    public $accessToken;
    public $privilegio;
    public $verification_code;

    /**
     * @inheritdoc
     */
    
    /* busca la identidad del usuario a través de su $id */

    public static function findIdentity($id)
    {
        
        $user = Usuario::find()
                ->Where("dni=:dni", ["dni" => $id])
                ->one();
        
        return isset($user) ? new static($user) : null;
    }

    /**
     * @inheritdoc
     */
    
    /* Busca la identidad del usuario a través de su token de acceso */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        
        $users = Usuario::find()
                ->Where("accessToken=:accessToken", [":accessToken" => $token])
                ->all();
        
        foreach ($users as $user) {
            if ($user->accessToken === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    
    /* Busca la identidad del usuario a través del username */
    public static function findByUsername($username)
    {
        $users = Usuario::find()
                ->Where("nombre_usuario=:nombre_usuario", [":nombre_usuario" => $username])
                ->all();
        
        foreach ($users as $user) {
            if (strcasecmp($user->nombre_usuario, $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    
    /* Regresa el id del usuario */
    public function getId()
    {
        return $this->dni;
    }

    /**
     * @inheritdoc
     */
    
    /* Regresa la clave de autenticación */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    
    /* Valida la clave de autenticación */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        /* Valida el password */
        if (crypt($password, $this->contrasenia) == $this->contrasenia)
        {
        return $password === $password;
        }
    }
    
    public static function isUserAdmin($id)
    {
        if (Usuario::findOne(['dni' => $id, 'privilegio' => 1])) {
            return true;
        } else {
            return false;
        }
    }

    public static function isUserProfe($id)
    {
        if (Usuario::findOne(['dni' => $id, 'privilegio' => 3])) {
            return true;
        } else {
            return false;
        }
    }

    public static function isUserSubcomision($id)
    {
        if (Usuario::findOne(['dni' => $id, 'privilegio' => 2])) {
            return true;
        } else {
            return false;
        }
    }
}