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
use app\models\Validar;

require 'Imprimir.php';

class EventoController extends Controller {

    private $msg = null;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear', 'buscar', 'eliminar', 'clista', 'agregar', 'quitar', 'conflista', 'verlista', 'modif_agregar', 'modificarlista', 'imprimir'],
                'rules' => [
                    ['actions' => ['crear', 'buscar', 'eliminar', 'clista', 'agregar', 'quitar', 'conflista', 'verlista', 'modif_agregar', 'modificarlista', 'imprimir'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['crear', 'buscar', 'eliminar', 'clista', 'agregar', 'quitar', 'conflista', 'verlista', 'modif_agregar', 'modificarlista', 'imprimir'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['crear','modificar','eliminar','buscar'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserSubcomision(Yii::$app->user->identity->id);
                }]
                ],
            ],
            'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post']]]
        ];
    }

    public function actionCrear($msg = null) {
        $this->layout = Validar::menu();
        $model = new Evento;
        unset($_SESSION['dni'], $_SESSION['id_evento'], $_SESSION['deporte']);
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
        $this->layout = Validar::menu();
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
        $model = $table->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("buscar", ['msg' => $msg, "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }

    public function actionModificar($id_evento) {
        $this->layout = Validar::menu();
        if (Validar::num_positivo($id_evento)) {
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
                        $this->msg = "Evento modificado con exito";
                        $this->redirect(['buscar', 'msg' => $msg]);
                    } else {
                        $$this->msg = "Error al modificar";
                    }
                } else {
                    $model->getErrors();
                }
            }
            $profesor = ArrayHelper::map(Yii::$app->db->createCommand("select nombre,dni from vprof_per")->queryAll(), 'dni', 'nombre');
            return $this->render("formulario", ['convocado' => $convocados, 'titulo' => 'Modificar Evento', 'model' => $model, 'msg' => $this->msg, "profesor" => $profesor, 'deporte' => $model->getListadeporte()]);
        } else {
            $this->redirect(['buscar']);
        }
    }

    public function actionEliminar() {
        if (Validar::num_positivo($_POST['id_evento'])) {
            if (Evento::deleteAll($_POST['id_evento'])) {
                //$msg="Evento eliminado con exito";
            }
        }
        $this->redirect(['evento/buscar']);
    }

    public function actionClista() {
        $this->layout = Validar::menu();
        $msg = null;
        $convocados = null;
        if (isset($_SESSION['deporte'])) {
            $deporte = $_SESSION['deporte'];
        } else {
            return $this->redirect(['evento/crear']);
        }
        $sql = "select nombre, dni,nombre_categoria from vdep_cat where id_deporte=$deporte";
        if (empty($_SESSION['dni'])) {
            $model = Yii::$app->db->createCommand($sql)->queryAll();
        } else {
            $dni = implode(",", $_SESSION['dni']);
            $sql1 = $sql . " and dni not in (" . $dni . ")";
            $model = \Yii::$app->db->createCommand($sql1)->queryAll();
            $sql2 = $sql . " and dni in (" . $dni . ")";
            $convocados = \Yii::$app->db->createCommand($sql2)->queryAll();
        }
        return $this->render('clista', ['model' => $model, 'msg' => $msg, 'convocados' => $convocados]);
    }

    public function actionAgregar() {
        $_SESSION['dni'][] = (int) $_REQUEST['id'];
    }

    public function actionQuitar() {
        if (is_numeric($_REQUEST['id'])) {
            $aux[] = $_REQUEST['id'];
            $array = array_diff($aux, $_SESSION['dni']);
            unset($_SESSION['dni']);
            foreach ($array as $val) {
                echo $val;
                $_SESSION['dni'][] = $val;
            }
        }
    }

    function actionConflista() {
        $dni = implode(",", $_SESSION['dni']);
        $evento = $_SESSION['id_evento'];
        $sql = "INSERT INTO convocados (id_evento, dni,nombre) SELECT $evento ,dni,nombre FROM persona WHERE dni in ($dni)";
        Yii::$app->db->createCommand($sql)->execute();
        $this->redirect(["crear"]);
    }

    public function actionVerlista($id_evento, $id_deporte) {
        $this->layout = Validar::menu();
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
        $this->layout = Validar::menu();
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
        $this->layout = Validar::menu();
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
        if ($evento->count() != 0) {
            $eventos = $evento->all();
            return true;
        }
        return false;
    }

}
