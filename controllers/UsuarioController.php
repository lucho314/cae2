<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\models\ValidarBusqueda;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\filters\AccessControl;
use app\models\User;
use app\models\SubComision;

include_once '../models/Tipo_de_menu.php';

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller {

    public $layout;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'admin', 'profesor', 'subcomision', 'nuevo', 'view', 'createadmin', 'eliminar', 'modificar', 'modificarcuenta'],
                'rules' => [
                    [
                        'actions' => ['index', 'admin', 'profesor', 'subcomision', 'login', 'nuevo', 'view', 'createadmin', 'eliminar', 'modificar', 'logout', 'modificarcuenta'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }
                    ],
                    [
                        'actions' => ['profesor', 'modificar', 'modificarcuenta'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }
                    ],
                    [
                        'actions' => ['index', 'modificar', 'modificarcuenta'],
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

    public function actionIndex() {
        return $this->redirect(["usuario/login"]);
    }

    public function actionAdmin() {
        $this->layout = "mainadmin";
        $nombre = Yii::$app->user->identity->nombre_usuario;
        $notificacion = NULL;
        $notificacion = NotificacionesController::Notificacion('admin', $cantidad);
        return $this->render("inicio", ['nombre' => $nombre, 'noti' => $notificacion,
                    'notificacion' => $notificacion ? 'Usted posee ' . $cantidad['cantidad'] . ' notificaciones' : 'No posee notificaciones',
                    'eventos' => EventoController::evento($eventos) ? $eventos : null
        ]);
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
        $nombre = Yii::$app->user->identity->nombre_usuario;
        return $this->render("inicio", ['nombre' => $nombre]);
    }

    public function actionLogin() {
        $nombre = null;
        if (!\Yii::$app->user->isGuest) {
            $nombre = $nombre = Yii::$app->user->identity->nombre_usuario;
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
            $nombre = Yii::$app->user->identity->nombre_usuario;
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


        return $this->render('login', [
                    'model' => $model,
        ]);
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
        $this->layout = "mainadmin";
        return $this->render("nuevo_usuario");
    }

    /**
     * Displays a single Usuario model.
     * @param integer $id
     * @return mixed
     */
    public function actionVer($id) {
        $this->layout = "mainadmin";
        return $this->render('ver', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $msg = null;
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
            $dni = $model->dni;
            try {
                $connection->createCommand($sql1)->execute();
                $connection->createCommand($sql2)->execute();
                $transaction->commit();
                $msg = "Registracion realizada con exito";
                foreach ($model as $clave => $val) {
                    $model->$clave = null;
                }
                $model->nombre = null;
                $model->apellido = null;
                $model->telefono = null;
                $model->domicilio = null;
                $model->conf_cont = null;
            } catch (\Exception $e) {
                $msg = "Registracion realizada con exito";
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect(['nuevo']);
        } else {
            return $this->renderAjax('nuevo_admin', [
                        'model' => $model, 'msg' => $msg
            ]);
        }
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->dni]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar() {
        if ((int) isset($_POST["dni"])) {
            $id = $_POST["dni"];
            $model = Usuario::findOne($_POST["dni"]);
            if ($model->delete()) {
                $msg = "<div class='alert alert-success' role='contentinfo'>
                <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                <span class='sr-only'>Error:</span>
               Usuario Eliminada con exito </div>";
            }
        }
        return $this->redirect(['buscar', 'msg' => $msg]);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if ((Usuario::findOne($id)) !== null) {
            $model = Usuario::find()
                    ->select('persona.*,nombre_usuario,privilegio')
                    ->from('persona,usuario')
                    ->where('persona.dni=usuario.dni')
                    ->andWhere(['usuario.dni' => $id])
                    ->one();
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionBuscar() {
        $this->layout = "mainadmin";
        $form = new ValidarBusqueda;
        $search = null;
        if ($form->load(Yii::$app->request->post())) {
            if ($form->validate()) {

                $search = Html::encode($form->q);

                $table = Usuario::find()
                        ->Where(['like', 'nombre_usuario', $search])
                        ->orWhere(['like', 'privilegio', $search])
                        ->orWhere(['dni' => $search]);
                $count = clone $table;
                $pages = new Pagination([
                    "pageSize" => 10,
                    "totalCount" => $count->count()
                ]);
                $model = $table
                        ->offset($pages->offset)
                        ->limit($pages->limit)
                        ->all();
            } else {
                $form->getErrors();
            }
        } else {
            $table = Usuario::find();

            $count = clone $table;
            $pages = new Pagination([
                "pageSize" => 10,
                "totalCount" => $count->count(),
            ]);
            $model = $table
                    ->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
        }
        return $this->render("buscar", [ "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }

    public function actionModificar($id=null) {
        if(empty($id))
        {
            $id=Yii::$app->user->identity->id;
        }
        $this->layout = "mainadmin";
        $model = $this->findModel($id);
        $msg = null;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->db->createCommand("update persona set nombre='$model->nombre', apellido='$model->apellido',email='$model->email',telefono='$model->telefono',domicilio='$model->domicilio' where dni=$model->dni")->execute();
        }
        return $this->render("modificar_usuario", ['msg' => $msg, 'model' => $model]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        $this->redirect(['login']);
    }

    public function actionModificarcuenta() {
        $msg = null;
        $this->layout = menu();
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
        return $this->render("modificar_cuenta", ['model' => $model, 'msg' => $msg]);
    }
    
    

}
