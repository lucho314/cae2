<?php

namespace app\controllers;

use Yii;
use app\models\Deporte;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\ValidarBusqueda;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Validar;

/**
 * DeporteController implements the CRUD actions for Deporte model.
 */
class DeporteController extends Controller {

    public $layout = 'mainadmin';
    private $msg = null;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['infodeportista', 'infocategoria', 'infoprofesores', 'buscar', 'infodeporte', 'eliminar', 'modificar', 'crear'],
                'rules' => [
                    ['actions' => ['infodeportista', 'infocategoria', 'infoprofesores', 'buscar', 'infodeporte', 'eliminar', 'modificar', 'crear'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }],
                    ['actions' => [''], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['buscar'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserSubcomision(Yii::$app->user->identity->id);
                }]
                ],
            ],
            'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post']]]
        ];
    }

    /**
     * Creates a new Deporte model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $model = new Deporte();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $this->msg = "<div class='alert alert-info' role='contentinfo'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
               Deporte registrado con exito </div>";
        }
        return $this->render('formulario', ['model' => new Deporte(), 'msg' => $this->msg, 'titulo' => 'Crear Deporte']);
    }

    /**
     * Updates an existing Deporte model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionModificar($id) {
        if (!Validar::num_positivo($id)) {
            return $this->redirect("deporte/buscar");
        }
        $model = Deporte::findOne($id);
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->update()) {
                    $msg = "Deporte modificado con exito.";
                } else {
                    $msg = "no se pudo modificar el deporte";
                }
                $this->redirect(["buscar", "msg" => $this->msg]);
            } else {
                $model->getErrors();
            }
        }
        return $this->render("formulario", ["model" => $model, "msg" => $this->msg, 'titulo' => 'Modificar Deporte']);
    }

    /**
     * Deletes an existing Deporte model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar() {
        $this->msg = "Deporte no eliminado.";
        if (isset($_POST['deporte']) && Validar::num_positivo($_POST['deporte'])) {
            $model = Deporte::findOne($_POST['deporte']);
            if ($model->delete()) {
                $this->msg = "Deporte Eliminado con exito.";
            }
        }
        return $this->redirect(['buscar', 'msg' => $this->msg]);
    }

    public function actionInfodeporte($id) {
        if (!Validar::num_positivo($id)) {
            $this->redirect(["deporte/buscar"]);
        }
        $sql = "select id_deporte ,cantidad_deportista,cantidad_categoria,"
                . "cantidad_profesor,nombre_deporte from vinfo_deporte where id_deporte=$id";
        $datos = Yii::$app->db->createCommand($sql)->queryOne();
        return $this->render("info", ['datos' => $datos]);
    }

    public function actionBuscar() {
        $form = new ValidarBusqueda;
        $search = null;
        $table = Deporte::find();
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $model = $table->where(['like', 'nombre_deporte', $search]);
            } else {
                $form->getErrors();
            }
        }
        $count = clone $table;
        $pages = new Pagination(["pageSize" => 10, "totalCount" => $count->count()]);
        $model = $table->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("buscar", [ "pages" => $pages, "model" => $model, "form" => $form, "search" => $search, 'msg' => $this->msg]);
    }

    public function actionInfoprofesores($id) {
        if (Validar::num_positivo($id)) {
            $deporte = Deporte::findOne($id);
            $model = $deporte->getDatosprofesor();
            return $this->render("infoprofesor", ['model' => $model, 'id' => $id]);
        }
        $this->redirect(["deporte/buscar"]);
    }

    public function actionInfocategoria($id) {
        return $this->render("infocategoria", ['model' => CategoriaController::infocategoria($id)->all(), 'id' => $id]);
    }

    public function actionInfodeportista($id) {
        if (!Validar::num_positivo($id)) {
            return $this->redirect("deporte/buscar");
        }
        $deporte = Deporte::findOne($id);
        $model = $deporte->getDeportistas()->asArray()->all();
        return $this->render("infodeportista", ['model' => $model, 'id' => $id]);
    }

}
