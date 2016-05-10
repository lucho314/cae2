<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\ValidarBusqueda;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Validar;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller {

    public $layout;
    private $msg = null;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'admin', 'profesor', 'subcomision', 'nuevo', 'view', 'createadmin', 'eliminar', 'modificar', 'modifica', 'modificarcuenta'],
                'rules' => [
                    ['actions' => ['index', 'admin', 'modifica', 'profesor', 'subcomision', 'login', 'nuevo', 'view', 'createadmin', 'eliminar', 'modificar', 'logout', 'modificarcuenta'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['profesor', 'modificar', 'modificarcuenta'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['subcomision','index', 'modificar', 'modificarcuenta'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserSubcomision(Yii::$app->user->identity->id);
                }]
                ],
            ],
            'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post']]]
        ];
    }

    public function actionIndex() {
        return $this->redirect(["usuario/login"]);
    }

    public function actionAdmin() {
        $this->layout = "mainadmin";
        $nombre = Yii::$app->user->identity->nombre_usuario;
        $notificacion = NULL;
        //$notificacion = NotificacionesController::Notificacion('admin', $cantidad);
        return $this->render("inicio", ['nombre' => $nombre, 'noti' => $notificacion, 'notificacion' => $notificacion ? 'Usted posee ' . $cantidad['cantidad'] . ' notificaciones' : 'No posee notificaciones', 'eventos' => EventoController::evento($eventos) ? $eventos : null]);
    }

    public function actionProfesor() {
        $this->layout = "mainprofe";
        $nombre = Yii::$app->user->identity->nombre_usuario;
        // $notificacion = NotificacionesController::Notificacion('profesor', $cantidad);
        return $this->render("inicio", ['nombre' => $nombre, 'noti' => null, // $notificacion,
                    'notificacion' => null, //$notificacion ? 'Usted posee ' . $cantidad['cantidad'] . ' notificaciones' : 'No posee notificaciones',
                    'eventos' => EventoController::evento($eventos) ? $eventos : null
        ]);
    }

    public function actionSubcomision() {
        $this->layout = "mainsubcomision";
        return $this->render("inicio", ['nombre' => Yii::$app->user->identity->nombre_usuario]);
    }

    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            if (User::isUserAdmin(Yii::$app->user->identity->id)) {
                $this->redirect(['usuario/admin']);
            }
            if (User::isUserProfe(Yii::$app->user->identity->id)) {
                $this->redirect(['usuario/profesor']);
            }
            if (User::isUserSubcomision(Yii::$app->user->identity->id)) {
                $this->redirect(['usuario/subcomision']);
            }
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (User::isUserAdmin(Yii::$app->user->identity->id)) {
                $this->redirect(['usuario/admin']);
            }
            if (User::isUserProfe(Yii::$app->user->identity->id)) {
                $this->redirect(['usuario/profesor']);
            }
            if (User::isUserSubcomision(Yii::$app->user->identity->id)) {
                $this->redirect(['usuario/subcomision']);
            }
        }
        return $this->render('login', ['model' => $model]);
    }

    private function randKey($str = '', $long = 0) {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str) - 1;
        for ($x = 0; $x < $long; $x++) {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }

    public function actionNuevo() {
        $this->layout = 'mainadmin';
        return $this->render("nuevo_usuario");
    }

    public function actionVer($id) {
        $this->layout = 'mainadmin';
        return $this->render('ver', ['model' => Usuario::datos_usuario($id)]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $this->layout = 'mainadmin';
        $model = new Usuario();
        $model->scenario = Usuario::SCENARIO_NUEVO;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            $password = crypt($model->contrasenia, Yii::$app->params["salt"]);
            $authKey = $this->randKey("abcdef0123456789", 200);
            $accessToken = $this->randKey("abcdef0123456789", 200);
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $sql1 = "insert into persona (dni,nombre,apellido,domicilio,telefono,email) value ('$model->dni','$model->nombre','$model->apellido','$model->domicilio','$model->telefono','$model->email')";
            $sql2 = "insert into usuario (dni,nombre_usuario,contrasenia,privilegio,authKey,accessToken) value ('$model->dni','$model->nombre_usuario','$password',1,'$authKey','$accessToken')";
            try {
                $connection->createCommand($sql1)->execute();
                $connection->createCommand($sql2)->execute();
                $transaction->commit();
                $this->msg = "Registracion realizada con exito";
            } catch (\Exception $e) {
                $this->msg = "Registracion no realizada";
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['nuevo']);
        }
        return $this->renderAjax('nuevo_admin', ['model' => $model, 'msg' => $this->msg]);
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar() {
        //$this->msg='Usuario no eliminado';
        if (Validar::num_positivo($_POST['dni'])) {
            $model = Usuario::findOne($_POST['dni']);
            if ($model->delete()) {
                //$this->msg='Usuario eliminado con exito';
            }
        }
        $this->redirect('usuario/buscar');
    }

    public function actionBuscar() {
        $this->layout = 'mainadmin';
        $search = null;
        $form = new ValidarBusqueda;
        $table = Usuario::find();
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $table = $table->Where(['like', 'nombre_usuario', $search])
                        ->orWhere(['like', 'privilegio', $search])
                        ->orWhere(['dni' => $search]);
            } else {
                $form->getErrors();
            }
        }
        $count = clone $table;
        $pages = new Pagination(["pageSize" => 10, "totalCount" => $count->count()]);
        $model = $table->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render("buscar", [ "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }

    public function actionModificar() {
        $this->layout = Validar::menu();
        $model = Usuario::datos_usuario(Yii::$app->user->identity->id);
        $model->scenario = Usuario::SCENARIO_DATOS;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->db->createCommand("update persona set nombre='$model->nombre', apellido='$model->apellido', email='$model->email', telefono='$model->telefono', domicilio='$model->domicilio' where dni=$model->dni")->execute();
            Yii::$app->db->createCommand("update usuario set email='$model->email'  where dni=$model->dni")->execute();
            $model = Usuario::datos_usuario(Yii::$app->user->identity->id);
            $this->msg="Datos Modificados.";
        }
        return $this->render("modificar_usuario", ['msg' => $this->msg, 'model' => $model]);
    }

    public function actionModifica($id) {
        $this->layout = "mainadmin";
        if (Validar::num_positivo($id)) {
            $model = Usuario::datos_usuario($id);
            $model->scenario = Usuario::SCENARIO_DATOS;
            if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->db->createCommand("update persona set nombre='$model->nombre', apellido='$model->apellido',email='$model->email',telefono='$model->telefono',domicilio='$model->domicilio' where dni=$model->dni")->execute();
                Yii::$app->db->createCommand("update usuario set email='$model->email' where dni=$model->dni")->execute();
                $model = Usuario::datos_usuario($model->dni);
            } else {
                return $this->render("modificar_usuario", ['msg' => $this->msg, 'model' => $model]);
            }
        }
        return $this->redirect(['usuario/buscar']);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        $this->redirect(['login']);
    }

    public function actionModificarcuenta() {
        $this->layout = Validar::menu();
        $model = Usuario::findOne(Yii::$app->user->identity->id);
        $model->scenario = Usuario::SCENARIO_MODIFICAR;
        $model->contrasenia = null;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->contrasenia = crypt($model->nueva_cont, Yii::$app->params["salt"]);
                if ($model->update()) {
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render("modificar_cuenta", ['model' => $model, 'msg' => null]);
    }

}

        