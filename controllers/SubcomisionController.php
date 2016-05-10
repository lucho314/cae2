<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\Profesor;
use yii\web\NotFoundHttpException;

/**
 * SubcomisionController implements the CRUD actions for SubComision model.
 */
class SubcomisionController extends Controller {

    public $layout = "mainadmin";
    private $msg = null;

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear', 'modificar', 'mostrarprof'],
                'rules' => [
                    ['actions' => ['crear', 'modificar'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }],
                    ['actions' => [''], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserProfe(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['mostrarprof'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserSubcomision(Yii::$app->user->identity->id);
                }]
                ],
            ],
            'verbs' => ['class' => VerbFilter::className(), 'actions' => ['logout' => ['post']]],
        ];
    }

    public function actionMostrarprof() {
        $this->layout = "mainsubcomision";
        if (($table = Profesor::lista_prof_por_deporte()) != null) {
            $count = clone $table;
            $pages = new Pagination(["pageSize" => 10, "totalCount" => $count->count()]);
            $profesores = $table->offset($pages->offset)->limit($pages->limit)->all();
            return $this->render("lista_profesores", ["profesores" => $profesores, 'pages' => $pages]);
        }
        throw new NotFoundHttpException("La pagina requerida no existe o no tiene profesores acargo.");
    }

}
