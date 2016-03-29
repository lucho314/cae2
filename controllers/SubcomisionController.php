<?php

namespace app\controllers;

use Yii;
use app\models\SubComision;
use app\models\SubcomisionBuscar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use app\models\User;

/**
 * SubcomisionController implements the CRUD actions for SubComision model.
 */
class SubcomisionController extends Controller
{
public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create','update','delete'],
                'rules' => [
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) 
                        {
                          return User::isUserAdmin(Yii::$app->user->identity->id);
                        }
                    ],
                            
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) 
                        {
                            return User::isUserProfe(Yii::$app->user->identity->id);
                        }

                    ],
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) 
                        {
                            return User::isUserSubcomision(Yii::$app->user->identity->id);
                        }

                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SubComision models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubcomisionBuscar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SubComision model.
     * @param integer $dni
     * @param integer $id_deporte
     * @return mixed
     */
    public function actionView($dni, $id_deporte)
    {
        return $this->render('view', [
            'model' => $this->findModel($dni, $id_deporte),
        ]);
    }

    /**
     * Creates a new SubComision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       $this->layout = "mainadmin";
        $sub = new SubComision();
        $model = new \app\models\Usuario;
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
                    $dni=$model->dni;
                    $msg = "guardado";
                    foreach ($model as $clave => $val) {
                        $model->$clave = null;
                    }
                    return $this->redirect(['view', 'id' => $dni]);
                } catch (\Exception $e) {
                    $msg = "Registracion realizada con exito";
                    $transaction->rollBack();
                    throw $e;
                }
            } 
            //return $this->redirect(['view', 'id' => $model->dni]);
        }

        $deporte = ArrayHelper::map(\app\models\Deporte::find()->all(), 'id_deporte', 'nombre_deporte');
        return $this->render('nuevo', [
                    'model' => $model,
                    'sub' => $sub,
                    'deporte' => $deporte,
                    'msg' => $msg
        ]);
    }

    /**
     * Updates an existing Profesor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */


    /**
     * Updates an existing SubComision model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $dni
     * @param integer $id_deporte
     * @return mixed
     */
    public function actionUpdate($dni, $id_deporte)
    {
        $model = $this->findModel($dni, $id_deporte);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'dni' => $model->dni, 'id_deporte' => $model->id_deporte]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SubComision model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $dni
     * @param integer $id_deporte
     * @return mixed
     */
    public function actionDelete($dni, $id_deporte)
    {
        $this->findModel($dni, $id_deporte)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SubComision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $dni
     * @param integer $id_deporte
     * @return SubComision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($dni, $id_deporte)
    {
        if (($model = SubComision::findOne(['dni' => $dni, 'id_deporte' => $id_deporte])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
