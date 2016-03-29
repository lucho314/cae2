<?php

namespace app\controllers;

use Yii;
use app\models\Categoria;
use app\models\CategoriaB;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Profesor;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\ValidarBusqueda;
use yii\helpers\Html;
use yii\data\Pagination;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller {

    public $layout = 'mainadmin';

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Categoria models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CategoriaB();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Categoria model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = Categoria::findOne($id);
        $alumnos = $model->getDnis()
                ->select('nombre, persona.dni,telefono,email')
                ->innerJoin("persona", "persona.dni=deportista.dni")
                ->asArray()->all();
        return $this->render("view",['model'=>$model,'alumnos'=>$alumnos]);
    }

    /**
     * Creates a new Categoria model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Categoria();
        $model->scenario = Categoria::SCENARIO_NEW;
        $msg = null;

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->insert()) {
                    $msg = "<div class='alert alert-success' role='contentinfo'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
               Categoria registrada con exito </div>";
                } else {
                    $msg = "error";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render('ncategoria', [
                    'model' => $model,
                    'msg' => $msg,
                    'profesor' => $model->getProfesorLista(),
                    'deporte' => $model->getDeporteLista(),
                    'titulo' => 'Crear Categoria'
        ]);
    }

    /**
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionModificar($id_categoria, $op = null) {
        $msg = null;
        $model = Categoria::findOne($id_categoria);
        $dep = $model->id_deporte;
        $model->scenario = Categoria::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                $msg = "<div class='alert alert-success' role='contentinfo'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
               Categoria Modificada con exito </div>";
                if ($op == 1) {
                    $this->redirect(['deporte/infocategoria', 'id' => $dep]);
                } else {
                    $this->redirect(['buscar']);
                }
            }
        }
        return $this->render('ncategoria', [
                    'model' => $model,
                    'msg' => $msg,
                    'profesor' => $model->getProfesorLista(),
                    'deporte' => $model->getDeporteLista(),
                    'titulo' => 'Modificar Categoria'
        ]);
    }

    /**
     * Deletes an existing Categoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar() {
        if ((int) isset($_REQUEST["categoria"])) {
            $id = $_REQUEST["categoria"];
            $model = Categoria::findOne($id);
            if ($model->delete()) {
                $msg = "<div class='alert alert-success' role='contentinfo'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
               Categoria Eliminada con exito </div>";
            }
        }

        return $this->redirect(['buscar', 'msg' => $msg]);
    }

    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Categoria::findOne($id)) !== null) {
            $sub1 = Categoria::find()
                    ->select(["concat(nombre,' ',apellido)as Nyatitular, id_categoria"])
                    ->from('persona,categoria')
                    ->where("persona.nombre=categoria.nombre");
            $model = Categoria::find()->where(['IN', 'id_categoria', $sub1]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBuscar($msg = null) {
        $form = new ValidarBusqueda;
        $search = NULL;
        $tabla = Categoria::find()->select("categoria.id_categoria,vcat_titular.nya_titular,vcat_suplente.nya_suplente,nombre_categoria,nombre_deporte,edad_minima,edad_maxima")
                ->innerJoin("vcat_titular", 'categoria.id_categoria=vcat_titular.id_categoria')
                ->innerJoin("vcat_suplente", 'categoria.id_categoria=vcat_suplente.id_categoria')
                ->innerJoin("deporte", "categoria.id_deporte=deporte.id_deporte");
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $tabla->andWhere(['LIKE', 'nombre_categoria', $search])
                        ->orWhere(['LIKE', 'nya_titular', $search])
                        ->orWhere(['LIKE', 'nya_suplente', $search])
                        ->orWhere(['LIKE', 'nombre_deporte', $search])
                        ->orWhere(['edad_minima' => $search])
                        ->orWhere(['edad_maxima' => $search]);
            } else {
                $form->getErrors();
            }
        }
        $count = clone $tabla;
        $pages = new Pagination([
            "pageSize" => 10,
            "totalCount" => $count->count(),
        ]);
        $model = $tabla
                ->asArray()
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return $this->render("buscar", ['msg' => $msg, "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }

}
