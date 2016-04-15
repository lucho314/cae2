<?php

namespace app\controllers;

use Yii;
use app\models\Deportista;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\models\Categoria;
use yii\web\UploadedFile;
use app\models\ValidarBusqueda;
use yii\data\Pagination;
use yii\helpers\Html;
use app\models\Planilla;
use yii\filters\AccessControl;
use app\models\User;

include_once '../models/Tipo_de_menu.php';
require 'Imprimir.php';

/**
 * DeportistaController implements the CRUD actions for Deportista model.
 */
class DeportistaController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['sessioncategoria', 'agregar', 'imprimir', 'buscar', 'opcion', 'delete', 'update', 'crear'],
                'rules' => [
                    ['actions' => ['sessioncategoria', 'agregar', 'imprimir', 'buscar', 'opcion', 'delete', 'update', 'crear'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
                    return User::isUserAdmin(Yii::$app->user->identity->id);
                }],
                    ['actions' => ['buscar'], 'allow' => true, 'roles' => ['@'], 'matchCallback' => function () {
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
     * Lists all Deportista models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new Deportistab();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Deportista model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $this->layout = "mainadmin";
        $info = Deportista::find()
                ->select(['persona.dni,id_planilla,numero_socio,email,nombre,apellido,telefono,'
                    . 'domicilio,YEAR(CURDATE())-YEAR(fecha_nac)as edad'])
                ->innerJoin("persona", 'persona.dni=deportista.dni')
                ->where(['deportista.dni' => $id])
                ->one();
        if (empty($info)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $info_deporte = $info->getDeportistaCategorias()->select('nombre_deporte,nombre_categoria')
                ->innerJoin('categoria', 'categoria.id_categoria=deportista_categoria.id_categoria')
                ->innerJoin('deporte', 'deporte.id_deporte=deportista_categoria.id_deporte')
                ->asArray()->all();
        return $this->render('informacion', ['informacion' => $info,'info_deporte' => $info_deporte]);
    }

    /**
     * Creates a new Deportista model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear() {
        $msg = null;
        $this->layout = "mainadmin";
        $persona = new \app\models\Persona();
        $planilla = new \app\models\Planilla();
        $model = new Deportista();
        if ($model->load(Yii::$app->request->post()) && $planilla->load(Yii::$app->request->post())) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $model->file = UploadedFile::getInstances($model, 'file');
            if ($model->validate() && $planilla->validate()) {
                foreach ($model->file as $file) {
                    $file->name = $model->dni;
                    $file->saveAs('archivos/' . $file->baseName);
                }

                $categorias = [$model->deporte1 => $model->categoria1, $model->deporte2 => $model->categoria2, $model->deporte3 => $model->categoria3];
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                $sql1 = "insert into persona (dni,nombre,apellido,domicilio,telefono,email) value ('$model->dni','$model->nombre','$model->apellido','$model->domicilio','$model->telefono','$model->email')";
                $sql2 = "insert into planilla (medico_cabecera,grupo_sanguineo,obra_social,medicamento,desc_medicamento,alergia,
                 desc_alergia,anemia,enf_cardiologica,desc_cardiologia,asma,desc_asma,presion,convulsiones,ultima_convulsion,trastornos_hemorragicos,
                 fuma,cuanto_fuma,diabetes,desc_diabetes,tratamiento,desc_tratamiento,internaciones,desc_internacion,nombreyapellido1,domicilio1,telefono1,
                 nombreyapellido2,domicilio2,telefono2,observaciones) value ('$planilla->medico_cabecera','$planilla->grupo_sanguineo','$planilla->obra_social','$planilla->medicamento','$planilla->desc_medicamento','$planilla->alergia',
                 '$planilla->desc_alergia','$planilla->anemia','$planilla->enf_cardiologica','$planilla->desc_cardiologia','$planilla->asma','$planilla->desc_asma','$planilla->presion','$planilla->convulsiones','$planilla->ultima_convulsion','$planilla->trastornos_hemorragicos',
                 '$planilla->fuma','$planilla->cuanto_fuma','$planilla->diabetes','$planilla->desc_diabetes','$planilla->tratamiento','$planilla->desc_tratamiento','$planilla->internaciones','$planilla->desc_internacion','$planilla->nombreyapellido1','$planilla->domicilio1','$planilla->telefono1',
                 '$planilla->nombreyapellido2','$planilla->domicilio2','$planilla->telefono2','$planilla->observaciones')";
                try {
                    $connection->createCommand($sql1)->execute();
                    $connection->createCommand($sql2)->execute();
                    $id_planilla = Yii::$app->db->getLastInsertID('planilla');
                    $sql3 = "insert into deportista (dni,id_planilla,numero_socio) value ('$model->dni','$id_planilla','$model->numero_socio')";
                    $connection->createCommand($sql3)->execute();
                    foreach ($categorias as $deporte => $id_categoria) {
                        if ($id_categoria != "")
                            $connection->createCommand("insert into deportista_categoria (dni,id_categoria,id_deporte,activo) value('$model->dni','$id_categoria','$deporte',1)")->execute();
                    }
                    $transaction->commit();
                    $msg = "deportista guardado con exito";
                    foreach ($model as $clave => $val) {
                        $model->$clave = null;
                    }
                    foreach ($planilla as $clave => $val) {
                        $planilla->$clave = null;
                    }
                    foreach ($persona as $clave => $val) {
                        $model->$clave = null;
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
        return $this->render('formulario', ['model' => $model, 'planilla' => $planilla, 'msg' => $msg]);
    }

    public function actionModificar($dni) {
        $msg = null;
        $model = Deportista::find()->select("persona.*,deportista.*")->from("persona,deportista")->where('persona.dni=deportista.dni')->andWhere("deportista.dni=$dni")->one();
        $planilla = $model->getIdPlanilla()->one();
        $cant = $model->getDeportistaCategorias()->count();
        switch ($cant) {
            case 1:
                $table = $model->getDeportistaCategorias()->offset(0)->one();
                $model->deporte1 = $table->id_deporte;
                $model->categoria1 = $table->id_categoria;
                break;
            case 2;
                $table = $model->getDeportistaCategorias()->offset(0)->one();
                $model->deporte1 = $table->id_deporte;
                $model->categoria1 = $table->id_categoria;
                $table = $model->getDeportistaCategorias()->offset(1)->one();
                $model->deporte2 = $table->id_deporte;
                $model->categoria2 = $table->id_categoria;
                break;
            case 3:
                $table = $model->getDeportistaCategorias()->offset(0)->one();
                $model->deporte1 = $table->id_deporte;
                $model->categoria1 = $table->id_categoria;
                $table = $model->getDeportistaCategorias()->offset(1)->one();
                $model->deporte2 = $table->id_deporte;
                $model->categoria2 = $table->id_categoria;
                $table = $model->getDeportistaCategorias()->offset(2)->one();
                $model->deporte3 = $table->id_deporte;
                $model->categoria3 = $table->id_categoria;
                break;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->dni]);
        } else {
            return $this->render('modificar_deportista', ['model' => $model,'planilla' => $planilla,'msg' => $msg,'cant' => $cant]);
        }
    }

    /**
     * Deletes an existing Deportista model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Deportista model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Deportista the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Deportista::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionOpcion($id) {
        $categorias = Categoria::find()
                ->where(['id_deporte' => $id])
                ->count();

        $categori = Categoria::find()
                ->where(['id_deporte' => $id])
                ->all();

        if ($categorias > 0) {
            foreach ($categori as $categoria) {

                echo "<option value='" . $categoria->id_categoria . "'>" . $categoria->nombre_categoria . "</option>";
            }
        } else {
            echo "<option>-</option>";
        }
    }

    public function actionBuscar($opcion = null) {
        $this->layout = menu();
        $form = new ValidarBusqueda;
        $search = null;
        $table = $this->sql_buscar($opcion);
        if ($form->load(Yii::$app->request->get())) {
            if ($form->validate()) {
                $search = Html::encode($form->q);
                $table->andWhere(['persona.dni' => $search])
                        ->orWhere(['LIKE', 'persona.nombre', $search])
                        ->orWhere(['LIKE', 'persona.APELLIDO', $search]);
            } else {
                $form->getErrors();
            }
        }
        $count = clone $table;
        $pages = new Pagination([
            "pageSize" => 10,
            "totalCount" => $count->count(),
        ]);
        $model = $table
                ->offset($pages->offset)
                ->limit($pages->limit)
                ->asArray()
                ->all();
        if (!empty($opcion)) {
            return $this->render('agregar', [ "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
        }
        return $this->render(User::isUserAdmin(Yii::$app->user->identity->id) ? "buscar" : "buscar_restringido", [ "pages" => $pages, "model" => $model, "form" => $form, "search" => $search]);
    }

    /* Imprimir planilla con informacion del deportista pasado por parametro */

    public function actionImprimir($id = null) {
        $this->layout = "mainadmin";
        $pdf = new \Imprimirplanilla();
        $data = $this->findModel($id);
        $planilla = Planilla::findOne($data['id_planilla']);
        $pdf->AddPage();
        $pdf->BasicTable($data, $planilla);
        $pdf->Output();
    }

    /* funcion sql_buscar segun el tipo de usuario se formula la consulta sql para realizar una busquedas */

    private function sql_buscar($opcion = null) {
        $model = Deportista::find()->select(["concat(persona.apellido,', ' ,persona.nombre)as NyA, persona.dni"])
                ->innerJoin("persona", 'persona.dni=deportista.dni');
        if (User::isUserAdmin(Yii::$app->user->identity->id)) {
            $model->where("1=1");
        }
        if (User::isUserProfe(Yii::$app->user->identity->id)) {
            if (empty($opcion)) {
                $model->innerJoin("deportista_categoria", "deportista_categoria.dni=deportista.dni")
                        ->innerJoin("categoria", "categoria.id_categoria=deportista_categoria.id_categoria")
                        ->where(["id_profesor_titular" => Yii::$app->user->identity->id])
                        ->orWhere(["id_profesor_suplente" => Yii::$app->user->identity->id])
                        ->orWhere(['activo' => 1]);
            } else {
                if ($opcion != 'agregar') {
                    throw new NotFoundHttpException('The requested page does not exist.');
                }
                $model->where('deportista.dni not in (SELECT deportista_categoria.dni from deportista_categoria '
                        . 'INNER JOIN categoria on deportista_categoria.id_categoria=categoria.id_categoria WHERE id_profesor_titular=123456798)');
            }
        }
        if (User::isUserSubcomision(Yii::$app->user->identity->id)) {
            $model->innerJoin("sub_comision", "sub_comision.id_deporte=deportista.id_deporte");
        }
        return $model;
    }

    public function actionAgregar() {
        session_start();
        if (isset($_SESSION['categoria']) && is_numeric($_REQUEST['id'])) {
            $id_categoria = $_SESSION['categoria'];
            $id_deporte = Categoria::findOne($id_categoria);
            $dni = $_REQUEST['id'];
            Yii::$app->db->createCommand("insert into deportista_categoria (dni,id_categoria,id_deporte,activo) value('$dni','$id_categoria',$id_deporte->id_deporte,0)")->execute();
        }
    }

    public function actionSessioncategoria() {
        session_start();
        $_SESSION['categoria'] = $_REQUEST['categoria'];
    }

}
