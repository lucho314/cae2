<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

/**
 * DeporteController implements the CRUD actions for Deporte model.
 */
class NotificacionesController extends Controller {

    public static function Notificacion($tipo, &$cantidad) {
        if ($tipo == "admin") {
            $cantidad = Yii::$app->db->createCommand("select count(*)as cantidad from notif_admin")->queryOne();
            if ($cantidad['cantidad'] != 0) {
                return true;
            }
        } else {
            $cantidad = Yii::$app->db->createCommand("select count(*)as cantidad from notif_profe")->queryOne();
            if ($cantidad['cantidad'] != 0) {
                return true;
            }
        }
        return false;
    }

    public function actionNotificaciones() {
        $sql = 'SELECT id,concat(persona.nombre," ",persona.apellido)as nombre,categoria.nombre_categoria, deporte.nombre_deporte, persona.dni';
        if (User::isUserAdmin(Yii::$app->user->identity->id)) {
            $table = "notif_admin";
        } else {
            //$sql.=" ,aceptado ";
            $table = "notif_profe";
        }
        $model=Yii::$app->db->createCommand($sql. " FROM  ".$table
                . " INNER JOIN deporte on deporte.id_deporte=".$table.".id_deporte INNER JOIN categoria on categoria.id_categoria=".$table.".id_categoria "
                . "INNER JOIN persona on persona.dni=".$table.".dni")->queryAll();
        return $this->render("notificacion",['model'=>$model]);
    }
    
    public function actionAceptar()
    {
        if(is_numeric($_REQUEST['id']))
        {
            $id=$_REQUEST['id'];
            Yii::$app->db->createCommand("delete from notif_admin where id=$id")->execute();
            echo "hola";
        }
        echo "hola";
    }

}
