<?php

namespace app\controllers;

use Yii;
use app\models\Clase;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Deportista;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
use app\models\User;
use app\models\ValidarBusqueda;
use yii\data\Pagination;
use yii\helpers\Html;

/**
 * ClaseController implements the CRUD actions for Clase model.
 */
class ClaseController extends Controller {

    public $layout = "mainprofe";

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear', 'asistencia'],
                'rules' => [

                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }
                    ],
                    [
                        'actions' => ['crear', 'asistencia'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }
                    ],
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
        $model = new Clase;
        unset($_SESSION['fecha']);
        unset($_SESSION['categoria']);
        unset($_SESSION['observacion']);
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $_SESSION['fecha'] = $model->fecha;
                $_SESSION['categoria'] = $model->id_categoria;
                $_SESSION['observacion'] = $model->observaciones;
                $this->redirect(['asistencia']);
            } else {
                $model->getErrors();
            }
        }
        return $this->render("formulario", ['model' => $model, 'msg' => $msg, 'categoria' => $model->getCategoriaLista()]);
    }

    public function actionAsistencia() {
        if (!isset($_SESSION['categoria'])) {
            $this->redirect(["clase/crear"]);
        }
        $fecha = $_SESSION['fecha'];
        $observacion = $_SESSION['observacion'];
        $id = $_SESSION['categoria'];
        $table = Deportista::find()->select('nombre,deportista.dni')->innerJoin("persona", 'persona.dni=deportista.dni')
                        ->innerJoin("deportista_categoria", 'deportista_categoria.dni=deportista.dni')
                        ->where("deportista_categoria.activo=1")->andWhere(["deportista_categoria.id_categoria" => $_SESSION['categoria']]);
        $asistieron = Yii::$app->request->post('asistencia');
        if (is_array($asistieron)) {
            $noasistiero = $table->andWhere(['NOT IN', 'deportista.dni', $asistieron])->all();
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $connection->createCommand("insert into clase (fecha,observaciones,id_categoria) value ('$fecha','$observacion','$id')")->execute();
                $id = Yii::$app->db->getLastInsertID('clase');
                foreach ($asistieron as $valor) {
                    $nota = Yii::$app->request->post($valor);
                    $connection->createCommand("insert into asistencia (id_clase,dni,asistencia,nota) value ('$id','$valor',1,'$nota')")->execute();
                }
                foreach ($noasistiero as $valor) {
                    $dni = $valor['dni'];
                    $connection->createCommand("insert into asistencia (id_clase,dni,asistencia,nota) value ('$id','$dni',0,'0')")->execute();
                }
                $transaction->commit();
                $this->redirect(["clase/crear"]);
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        $msg = null;
        if ($table->count() != 0) {
            return $this->render("asistencia", ['model' => $table->asArray()->all(), 'msg' => $msg]);
        } else {
            
        }
    }
    
    public function actionBuscar(){
        $this->layout = "mainprofe";
        $table=Clase::find()
                ->select('id_clase,fecha,nombre_categoria')
                ->innerJoin('categoria','categoria.id_categoria=clase.id_categoria');
        $form = new ValidarBusqueda;
        $search = null;
        if($form->load(Yii::$app->request->get())){
            if ($form->validate()) {

                $search = Html::encode($form->x);

                $table = $table->where(['like', 'fecha', $search]);
               
            } else {
                $form->getErrors();
            }
        }
        
         $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 10,
                    "totalCount" => $count->count()
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->asArray()
                        ->all();
        return $this->render("buscar", [ "page" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }

    public function actionVerasistencia($id){
        if(!preg_match("/^[0-9]+$/",$id)){ return $this->redirect('buscar');}
        $sql="select concat(persona.nombre,', ',persona.apellido)as nya,asistencia,nota from asistencia"
                . " inner join persona on persona.dni=asistencia.dni"
                . " where id_clase=$id";
        $datos=Yii::$app->db->createCommand($sql)->queryAll();
        return $this->render("ver_asistencia",['datos'=>$datos]);
    }
}
