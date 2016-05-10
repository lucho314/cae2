<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Profesor;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\User;
use app\models\Usuario;

/**
 * ProfesorController implements the CRUD actions for Profesor model.
 */
class ProfesorController extends Controller {

    public $layout = 'mainadmin';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear', 'update', 'delete'],
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
            'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post']]]
        ];
    }

    /**
     * Creates a new Profesor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Usuario;
        $model->scenario = Usuario::SCENARIO_NUEVO;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->contrasenia = crypt($model->contrasenia, Yii::$app->params["salt"]);
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                $sql1 = "insert into persona (dni,nombre,apellido,domicilio,telefono,email) value ('$model->dni','$model->nombre','$model->apellido','$model->domicilio','$model->telefono','$model->email')";
                $sql2 = "insert into usuario (dni,nombre_usuario,contrasenia,privilegio) value ('$model->dni','$model->nombre_usuario','$model->contrasenia',3)";
                $sql3 = "insert into profesor (dni) value ('$model->dni')";
                try {
                    $connection->createCommand($sql1)->execute();
                    $connection->createCommand($sql2)->execute();
                    $connection->createCommand($sql3)->execute();
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
                return $this->redirect(['usuario/nuevo']);
            }
        }
        return $this->renderAjax('nuevo', ['model' => $model]);
    }



    /**
     * Finds the Profesor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profesor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Profesor::findOne($id)) !== null) {
            $model = Profesor::find()
                    ->select('persona.*')
                    ->from('persona,profesor,usuario')
                    ->where('persona.dni=profesor.dni')
                    ->andWhere(['profesor.dni' => $id])
                    ->andWhere('usuario.dni=profesor.dni')
                    ->one();
            return $model;
        } else {
            throw new NotFoundHttpException('La pagina requerida no existe.');
        }
    }
}
