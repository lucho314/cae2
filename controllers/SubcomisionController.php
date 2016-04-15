<?php

namespace app\controllers;

use Yii;
use app\models\SubComision;
use app\models\SubcomisionBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Deporte;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use app\models\User;

/**
 * SubcomisionController implements the CRUD actions for SubComision model.
 */
class SubcomisionController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    ['actions' => ['crear', 'update', 'delete'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }],
                    ['actions' => [''], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }],
                    ['actions' => [''], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserSubcomision(Yii::$app->user->identity->id);
                }]
                ],
            ],
            'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post']]],
        ];
    }
    
    public function actionCrear() {
        $sub = new SubComision();
        $model = new \app\models\Usuario;
        $model->scenario = \app\models\Usuario::SCENARIO_NUEVO;
        $msg = null;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $sub->load(Yii::$app->request->post())) {
            $msg = "paso";
            if ($model->validate() || $sub->validate()) {
                $password = crypt($model->contrasenia, Yii::$app->params["salt"]);
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                $sql1 = "insert into persona (dni,nombre,apellido,domicilio,telefono,email) value ('$model->dni','$model->nombre','$model->apellido','$model->domicilio','$model->telefono','$model->email')";
                $sql2 = "insert into usuario (dni,nombre_usuario,contrasenia,privilegio,email) value ('$model->dni','$model->nombre_usuario','$password',2,'$model->email')";
                $sql3 = "insert into sub_comision (dni,id_deporte) value ('$model->dni','$sub->id_deporte')";

                try {
                    $connection->createCommand($sql1)->execute();
                    $connection->createCommand($sql2)->execute();
                    $connection->createCommand($sql3)->execute();
                    $transaction->commit();
                    $dni = $model->dni;
                    $msg = "guardado";
                    return $this->redirect(['view', 'id' => $dni]);
                } catch (\Exception $e) {
                    $msg = "Registracion realizada con exito";
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
        return $this->renderAjax('nuevo', ['model' => $model,'sub' => $sub,'deporte' =>Deporte::getListadeporte(),'msg' => $msg]);
    }

}
