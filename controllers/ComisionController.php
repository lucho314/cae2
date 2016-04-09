<?php

namespace app\controllers;

use Yii;
use app\models\Comision;
use yii\web\Controller;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\ValidarBusqueda;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\filters\AccessControl;
use app\models\User;
use yii\filters\VerbFilter;
use app\models\Validar;

class ComisionController extends Controller {

    public $layout = 'mainadmin';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear', 'modificar', 'buscar'],
                'rules' => [
                    [
                        'actions' => ['crear', 'modificar', 'buscar'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }
                    ],
                    [
                        'actions' => ['crear', 'modificar', 'buscar'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }
                    ],
                    [
                        'actions' => ['buscar'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
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

    public function actionCrear() {
        $msg = null;
        $model = new Comision;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->insert()) {
                    $msg = "Horario de practica creada con exito";
                } else {
                    $msg = "Error al crear horario";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render("formulario", ['model' => new Comisionl, 'titulo' => "Crear Horario", 'opciones' => $model->getListaCategorias()]);
    }

    public function actionModificar($id_comision) {
        $msg = null;
        if (!Validar::num_positivo($id_comision)) {
            return $this->redirect(["buscar"]);
        } 
        $model = Comision::findOne($id_comision);
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->update()) {
                    $msg = "Horario de practica modificado con exito";
                    return $this->redirect(['buscar','msg'=>$msg]);
                } else {
                    $msg = "Error al modificar horario";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render("formulario", ['model' => $model,'opciones' => $model->getListaCategorias(), 'titulo' => 'Modificar Horario']);
    }

    public function actionBuscar() {
        $this->layout = "mainadmin";
        $form = new ValidarBusqueda;
        $msg = null;
        $search = null;
        $table = Comision::find()->select("comision.*,nombre_categoria")
                ->innerJoin("categoria", 'categoria.id_categoria=comision.id_categoria');
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $table->where(['LIKE', 'nombre_comision', $search])
                        ->orWhere(['LIKE', 'dia', $search])
                        ->orWhere(['LIKE', 'nombre_categoria', $search]);
            }
        }
        $count = clone $table;
        $pages = new Pagination([
            "pageSize" => 10,
            "totalCount" => $count->count(),
        ]);
        $model = $table
                ->asArray()
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return $this->render('buscar', ['model' => $model, 'msg' => $msg, 'pages' => $pages, 'form' => $form]);
    }

}
