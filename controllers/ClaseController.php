<?php

namespace app\controllers;

use Yii;
use app\models\Clase;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Deportista;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\Asistencia;

/**
 * ClaseController implements the CRUD actions for Clase model.
 */
class ClaseController extends Controller {

    public $layout = "mainprofe";

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

    public function actionCrear() {
        $msg = null;
        $model = new Clase;
        session_start();
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
        return $this->render("nclase", ['model' => $model, 'msg' => $msg, 'categoria' => $model->getCategoriaLista()]);
    }

    public function actionAsistencia() {
        session_start();
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

}
