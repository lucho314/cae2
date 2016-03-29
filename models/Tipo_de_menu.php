<?php

use app\models\User;

function menu() {
    if (User::isUserAdmin(Yii::$app->user->identity->id)) {
        return "mainadmin";
    }
    if (User::isUserProfe(Yii::$app->user->identity->id)) {
        return "mainprofe";
    }
    if (User::isUserSubcomision(Yii::$app->user->identity->id)) {
        return "mainsubcomision";
    }
    return "main";
}
