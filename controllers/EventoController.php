<?php

namespace app\controllers;

use Yii;
use app\models\Evento;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\ValidarBusqueda;
use yii\helpers\Html;
use yii\data\Pagination;
use app\models\Convocados;
use app\models\Deporte;
use yii\filters\AccessControl;
use app\models\User;

require 'Imprimir.php';

include_once '../models/Tipo_de_menu.php';

class EventoController extends Controller {

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear','buscar','eliminar','clista','agregar','quitar','conflista','verlista','modif_agregar','modificarlista','imprimir'],
                'rules' => [
                    [
                        'actions' => ['crear','buscar','eliminar','clista','agregar','quitar','conflista','verlista','modif_agregar','modificarlista','imprimir'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) 
                        {
                          return User::isUserAdmin(Yii::$app->user->identity->id);
                        }
                    ],
                            
                    [
                        'actions' => ['crear','buscar','eliminar','clista','agregar','quitar','conflista','verlista','modif_agregar','modificarlista','imprimir'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) 
                        {
                            return User::isUserProfe(Yii::$app->user->identity->id);
                        }

                    ],
                    [
                        'actions' => ['buscar'],
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

    public function actionCrear($msg = null) {
        $this->layout = menu();
        $model = new Evento;
        unset($_SESSION['dni']);
        unset($_SESSION['deporte']);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                if ($model->insert()) {
                    if ($model->convocados) {
                        $_SESSION['deporte'] = $model->id_deporte;
                        $_SESSION['id_evento'] = Yii::$app->db->getLastInsertID('evento');
                        $model->id_deporte = null;
                        $this->redirect(["evento/clista"]);
                        foreach ($model as $clave => $valor) {
                            $model->$clave = null;
                        }
                    }
                    foreach ($model as $clave => $valor) {
                        $model->$clave = null;
                    }
                } else {
                    $msg = "No se pudo registrar Clase";
                }
            } else {
                $model->getErrors();
            }
        }
        $profesor = ArrayHelper::map(Yii::$app->db->createCommand("select nombre,dni from vprof_per")->queryAll(), 'dni', 'nombre');

        return $this->render("formulario", ['titulo' => 'Crear Evento', 'model' => $model, 'msg' => $msg, "profesor" => $profesor, "deporte" => Deporte::getListadeporte()]);
    }

    public function actionBuscar($msg = null) {
        $this->layout = menu();

        if (!isset($form)) {
            $form = new ValidarBusqueda;
        }
        $search = $search_desde = $search_hasta = null;

        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $search_desde = Html::encode($form->desde);
                $search_hasta = Html::encode($form->hasta);
                $table = Evento::find();
                if ($search == "" && $search_desde == "" && $search_hasta == "") {
                    
                } elseif ($search == "" && $search_desde == "") {
                    $table->where("fecha_inicio BETWEEN '0000-00-00' and '$search_hasta'");
                } elseif ($search == "" && $search_hasta == "") {
                    $table->where("fecha_inicio BETWEEN '$search_desde' and curdate()");
                } elseif ($search == "") {
                    $table->where("fecha_inicio BETWEEN '$search_desde' and '$search_hasta'");
                } elseif ($search != "" && $search_desde == "" && $search_hasta == "") {
                    $table->where(['like', 'nombre', $search]);
                } else {
                    $table->where(['like', 'nombre', $search])
                            ->andWhere("fecha_inicio BETWEEN '$search_desde' and '$search_hasta'");
                }
            } else {
                $form->getErrors();
            }
        } else {
            $table = Evento::find();
        }
        $count = clone $table;
        $pages = new Pagination(["pageSize" => 10, "totalCount" => $count->count()]);
        $model = $table
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        return $this->render("buscar", ['msg' => $msg, "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }

    public function actionModificar($id_evento = null) {
        $this->layout = menu();
        if (preg_match("/^[0-9]+$/", $id_evento)) {
            $model = Evento::findOne($id_evento);
            $convocados = $model->convocados;
            if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    if ($model->update()) {
                        if ($convocados != $model->convocados && $model->convocados) {
                            $this->render("convocados");
                        }
                        $msg = "Evento modificado con exito";
                        $this->redirect(['buscar', 'msg' => $msg]);
                    } else {
                        $msg = "Error al modificar";
                    }
                } else {
                    $model->getErrors();
                }
            }
            $msg = null;
            $profesor = ArrayHelper::map(Yii::$app->db->createCommand("select nombre,dni from vprof_per")->queryAll(), 'dni', 'nombre');
            return $this->render("formulario", ['convocado' => $convocados, 'titulo' => 'Modificar Evento', 'model' => $model, 'msg' => $msg, "profesor" => $profesor, 'deporte' => $model->getListadeporte()]);
        } else {
            $this->redirect(['buscar']);
        }
    }

    public function actionClista() {
        $this->layout = menu();
        $msg = null;
        if (isset($_SESSION['deporte'])) {
            $deporte = $_SESSION['deporte'];
        } else {
            $this->redirect(['evento/crear']);
        }
        $sql = "select nombre, dni,nombre_categoria from vdep_cat where id_deporte=$deporte";
        if (!isset($_SESSION['dni'])) {
            $model = Yii::$app->db->createCommand($sql)->queryAll();
        } else {

            $datos = \Yii::$app->db->createCommand($sql)->queryAll();
            foreach ($datos as $val) {

                if (!in_array($val['dni'], $_SESSION['dni'])) {
                    $model[] = array('nombre' => $val['nombre'], 'dni' => $val['dni'], 'nombre_categoria' => $val['nombre_categoria']);
                }
            }
        }
        return $this->render('clista', ['model' => $model, 'msg' => $msg]);
    }

    public function actionAgregar() {
        session_start();
        $_SESSION['dni'][] = $_POST['id'];
    }

    public function actionQuitar() {
        session_start();
        if (is_numeric($_POST['id'])) {
            $aux[] = $_POST['id'];
            $array = array_diff($_SESSION['dni'], $aux);
            unset($_SESSION['dni']);
            foreach ($array as $val) {
                $_SESSION['dni'] = $val;
            }
        }
    }

    function actionConflista($id = null) {
        $this->layout = menu();
        $connection = \Yii::$app->db;
        $deporte = $_SESSION['deporte'];
        $dnis = implode(" ", $_SESSION['dni']);
        $dnis = str_replace(" ", ',', $dnis);
        $sql = "select * from vdep_cat where id_deporte=$deporte and dni in ($dnis) ";
        if ($id == 'confirmar') {
            $id_evento = $_SESSION['id_evento'];
            $tabla = $connection->createCommand($sql)->queryAll();
            $convocados = new Convocados();
            $transaction = $connection->beginTransaction();
            foreach ($tabla as $valor) {
                $dni = $valor['dni'];
                $nombre = $valor['nombre'];
                $connection->createCommand("insert into convocados (dni,nombre,id_evento) VALUES ('$dni','$nombre','$id_evento')")->execute();
            }
            $transaction->commit();
            unset($_SESSION['dni']);
            unset($_SESSION['id_evento']);
            unset($_SESSION['deporte']);
            $this->redirect(['evento/crear']);
        } else {
            $model = $connection->createCommand($sql)->queryAll();
            return $this->render('confirmar', ['model' => $model]);
        }
    }

    public function actionVerlista($id_evento, $id_deporte) {
        $this->layout = menu();
        if (isset($_SESSION['dni'])) {
            unset($_SESSION['dni']);
        }
        $_SESSION['id_deporte'] = $id_deporte;
        $_SESSION['id_evento'] = $id_evento;
        $evento = Evento::findOne($id_evento);
        $model = $evento->getConvocados()->select('vdep_cat.nombre,convocados.dni,nombre_categoria')
                        ->innerJoin('vdep_cat', 'vdep_cat.dni=convocados.dni')->where(['id_deporte' => $id_deporte])
                        ->andWhere(['id_evento' => $id_evento])->asArray()->all();
        foreach ($model as $val) {
            $_SESSION['dni'][] = $val['dni'];
        }
        return $this->render("lista_convocados", ['model' => $model]);
    }

    public function actionModif_agregar() {
        $this->layout = menu();
        $deporte = $_SESSION['id_deporte'];
        $sql = "select nombre, dni,nombre_categoria from vdep_cat where id_deporte=$deporte";
        if (!isset($_SESSION['dni'])) {
            $model = Yii::$app->db->createCommand($sql)->queryAll();
        } else {
            $dnis = implode(" ", $_SESSION['dni']);
            $dnis = str_replace(" ", ',', $dnis);
            $model = Yii::$app->db->createCommand($sql . " and dni not in ($dnis)")->queryAll();
        }
        return $this->render("m_agregar", ["model" => $model]);
    }

    public function actionModificarlista($sacar = null) {
        $this->layout = menu();
        $msg = null;
        $id_evento = $_SESSION['id_evento'];
        $id_deporte = $_SESSION['id_deporte'];
        $connection = \Yii::$app->db;
        if ($sacar == "si") {
            $msg = "Evento modificado con exito";
            if (isset($_SESSION['dni'])) {
                $datos = Convocados::find()->where(['id_evento' => $_SESSION['id_evento']])->andwhere(['not in', 'dni', $_SESSION['dni']])->all();
                foreach ($datos as $dni) {
                    $d = $dni['dni'];
                    $connection->createCommand("delete from convocados where dni=$d")->execute();
                }
            } else {
                $connection->createCommand("delete from convocados where id_evento=$id_evento")->execute();
            }
        } else {
            $d = implode(" ", $_SESSION['dni']);
            $dnis = str_replace(" ", ',', $d);
            $tabla = $connection->createCommand("select dni,nombre from vdep_cat where id_deporte=$id_deporte and dni in ($dnis) ")->queryAll();
            foreach ($tabla as $valor) {
                $dni = $valor['dni'];
                $nombre = $valor['nombre'];
                $connection->createCommand("insert IGNORE into convocados (dni,nombre,id_evento) VALUES ('$dni','$nombre','$id_evento')")->execute();
            }
        }
        unset($_SESSION['dni']);
        unset($_SESSION['id_evento']);
        unset($_SESSION['deporte']);
        $this->redirect(['evento/buscar', 'msg' => $msg]);
    }

    public function actionImprimir() {
        $this->layout = "mainadmin";
        $pdf = new \Imprimireventos();

        $convocados = Convocados::find()->select(["concat(persona.nombre,'',apellido) as nya,persona.dni,telefono"])
                ->innerJoin("persona", "persona.dni=convocados.dni");
        $tabla = Yii::$app->db->createCommand("SELECT evento.*, sub1.titular,nombre_deporte,persona.nombre as 'suplente' FROM evento left JOIN persona on persona.dni=evento.id_profesor_suplente
            INNER JOIN  (SELECT id_evento, persona.nombre as 'titular' from evento INNER JOIN persona on persona.dni=evento.id_profesor_titular) as sub1 ON sub1.id_evento=evento.id_evento
            inner join deporte on deporte.id_deporte=evento.id_deporte");
        $evento = Evento::find();
        if ($evento->count() != 0) {
            foreach ($tabla->queryAll() as $dato) {
                $pdf->AddPage();
                $pdf->BasicTable($dato);
                if ($dato['convocados']) {
                    $pdf->Convocados($convocados->where(['id_evento' => $dato['id_evento']])->asArray()->all());
                }
            }
        }

        $pdf->Output();
    }

    public static function evento(&$eventos) {
        $evento = Evento::find()->where("fecha_inicio>=CURDATE()");
        if ($ev = $evento->count() != 0) {
            $eventos = $evento->all();
            return true;
        }
        return false;
    }

}
