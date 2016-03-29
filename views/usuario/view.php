<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="col-xs-12 col-md-10">
    <div class="usuario-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <?= Html::a('Modificar', ['modificar', 'id' => $model->dni], ['class' => 'btn btn-primary']) ?>
            <?=
            Html::a('Eliminar', ['eliminar', 'id' => $model->dni], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ])
            ?>
        </p>

        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                'dni',
                'nombre_usuario',
                'privilegio',
                'nombre',
                'apellido',
                'email',
                'telefono',
                'domicilio'
            ],
        ])
        ?>

    </div>
</article>