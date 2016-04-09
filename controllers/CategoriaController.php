<?php

namespace app\controllers;

use Yii;
use app\models\Categoria;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\ValidarBusqueda;
use yii\helpers\Html;
use yii\data\Pagination;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Validar;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller {

    public $layout = 'mainadmin';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear', 'modificar', 'eliminar', 'buscar'],
                'rules' => [
                    ['actions' => ['crear', 'modificar', 'eliminar', 'buscar'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['buscar'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['buscar'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserSubcomision(Yii::$app->user->identity->id);
                }]]],
            'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post']]]
        ];
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
                    $msg = "Categoria registrada con exito.";
                } else {
                    $msg = "error";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render('formulario', ['model' => new Categoria, 'msg' => $msg, 'profesor' => $model->getProfesorLista(), 'deporte' => $model->getDeporteLista(), 'titulo' => 'Crear Categoria']);
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
                $msg = "Categoria Modificada con exito.";
                if ($op == 1) {
                    $this->redirect(['deporte/infocategoria', 'id' => $dep]);
                } else {
                    $this->redirect(['buscar','msg'=>$msg]);
                }
            }
        }
        return $this->render('formulario', ['model' => $model, 'msg' => $msg, 'profesor' => $model->getProfesorLista(), 'deporte' => $model->getDeporteLista(), 'titulo' => 'Modificar Categoria']);
    }

    /**
     * Deletes an existing Categoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
    */
    public function actionEliminar() {
        $msg=null;
        if (isset($_POST["categoria"])&&Validar::num_positivo($_POST['categoria'])) {
            $model = Categoria::findOne($_POST["categoria"]);
            if ($model->delete()) {
                $msg = "Categoria eliminada con exito.";
            }  else {
                $msg="Categoria no eliminada.";
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
    /*protected function findModel($id) {
        if (($model = Categoria::findOne($id)) !== null) {
            $sub1 = Categoria::find()
                    ->select(["concat(nombre,' ',apellido)as Nyatitular, id_categoria"])
                    ->from('persona,categoria')
                    ->where("persona.nombre=categoria.nombre");
            $model = Categoria::find()->where(['IN', 'id_categoria', $sub1]);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }*/

    public function actionBuscar($msg = null,$search = null) {
        $form = new ValidarBusqueda;
        $tabla = Categoria::find()->select("categoria.id_categoria,vcat_titular.nya_titular,nombre_categoria")
                ->innerJoin("vcat_titular", 'categoria.id_categoria=vcat_titular.id_categoria')
                ->innerJoin("deporte", "categoria.id_deporte=deporte.id_deporte");
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $tabla->andWhere(['LIKE', 'nombre_categoria', $search])
                        ->orWhere(['LIKE', 'nya_titular', $search]);
            } else {
                $form->getErrors();
            }
        }
        $count = clone $tabla;
        $pages = new Pagination(["pageSize" => 10,"totalCount" => $count->count()]);
        $model = $tabla->asArray()->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("buscar", ['msg' => $msg, "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }
    
}
