<?php

namespace app\models;

use app\models\User;
use yii;

class Validar {

    public static function num_positivo($id) {
        if (preg_match('/^[0-9]$|^[0-9]+[0-9]$/', $id)) {
            return true;
        }
        return false;
    }

    public static function menu() {
        
        if (User::isUserAdmin(Yii::$app->user->identity->id)) {
            return "mainadmin";
        } elseif (User::isUserProfe(Yii::$app->user->identity->id)) {
            return "mainprofe";
        } elseif (User::isUserSubcomision(Yii::$app->user->identity->id)) {
            return "mainsubcomision";
        }
        return "main";
    }

}
