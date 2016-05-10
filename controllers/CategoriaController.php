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
use app\models\Deporte;

/**
 * CategoriaController implements the CRUD actions for Categoria model.
 */
class CategoriaController extends Controller {

    public $layout = 'mainadmin';
    private $msg=null;

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
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if ($model->insert()) {
                    $$this->msg = "Categoria registrada con exito.";
                } else {
                    $this->msg = "error";
                }
            } else {
                $model->getErrors();
            }
        }
        return $this->render('formulario', ['model' => new Categoria, 'msg' => $this->msg, 'profesor' => $model->getProfesorLista(), 'deporte' =>Deporte::getListadeporte(), 'titulo' => 'Crear Categoria']);
    }

    /**
     * Updates an existing Categoria model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionModificar($id_categoria, $op = null) {
        $model = Categoria::findOne($id_categoria);
        $model->scenario = Categoria::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate() && $model->save()) {
                $this->msg = "Categoria Modificada con exito.";
                if ($op == 1) {
                    $this->redirect(['deporte/infocategoria', 'id' =>$model->id_deporte]);
                } else {
                    $this->redirect(['buscar', 'msg' => $this->msg,'id'=>$model->id_deporte]);
                }
            }
        }
        return $this->render('formulario', ['model' => $model, 'msg' => $this->msg, 'profesor' => $model->getProfesorLista(), 'deporte' =>Deporte::getListadeporte(), 'titulo' => 'Modificar Categoria']);
    }

    /**
     * Deletes an existing Categoria model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar() {
        if (isset($_POST["categoria"]) && Validar::num_positivo($_POST['categoria'])) {
            $model = Categoria::findOne($_POST["categoria"]);
            if ($model->delete()) {
                $this->msg = "Categoria eliminada con exito.";
            } else {
                $this->msg = "Categoria no eliminada.";
            }
        }
        return $this->redirect(['buscar', 'msg' => $this->msg]);
    }

    /**
     * Finds the Categoria model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Categoria the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* protected function findModel($id) {
      if (($model = Categoria::findOne($id)) !== null) {
      $sub1 = Categoria::find()
      ->select(["concat(nombre,' ',apellido)as Nyatitular, id_categoria"])
      ->from('persona,categoria')
      ->where("persona.nombre=categoria.nombre");
      $model = Categoria::find()->where(['IN', 'id_categoria', $sub1]);
      } else {
      throw new NotFoundHttpException('The requested page does not exist.');
      }
      } */

    public function actionBuscar($id, $search = null) {
        $form = new ValidarBusqueda;
        $tabla = $this->infocategoria($id);
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
        $pages = new Pagination(["pageSize" => 10, "totalCount" => $count->count()]);
        $model = $tabla->asArray()->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("buscar", ['id'=>$id,'msg' => $this->msg, "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }

    
    public static function infocategoria($id = null) {
        if (Validar::num_positivo($id)) {
            $model = Categoria::find()
                    ->select('nombre_categoria,edad_maxima,edad_minima,nya_titular,nya_suplente,categoria.id_categoria ')
                    ->distinct()
                    ->innerJoin('deporte', 'deporte.id_deporte=categoria.id_deporte')
                    ->innerJoin('vcat_titular', 'categoria.id_deporte=vcat_titular.id_deporte')
                    ->innerJoin('vcat_suplente', 'categoria.id_deporte=vcat_titular.id_deporte')
                    ->where(['deporte.id_deporte' => $id]);
            return $model;
        } else {
            
        }
    }

}
