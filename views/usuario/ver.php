<?php
/* @var $this yii\web\View */
/* @var $model app\models\Usuario */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'SGD CAE: Ver Usuario';
?>
<article class="col-xs-12 col-md-10">
    <h3>Ver Usuario:<?= ' ' . $model->nombre ?></h3>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <tbody>
                        <tr>
                            <th>DNI:</th>
                            <td><?= $model->dni ?></td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td><?= $model->nombre ?></td>
                        </tr>
                        <tr>
                            <th>Apellido:</th>
                            <td><?= $model->apellido ?></td>
                        </tr>
                        <tr>
                            <th>Dirección:</th>
                            <td><?= $model->domicilio ?></td>
                        </tr>
                        <tr>
                            <th>Telefono:</th>
                            <td><?= $model->telefono ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?= $model->email ?></td>
                        </tr>
                        <tr>
                            <th>Nombre de Usuario:</th>
                            <td><?= $model->nombre_usuario ?></td>
                        </tr>
                        <tr>
                            <th>Privilegio:</th>
                            <td><?= $model->privilegio ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="botones">
        <a href="<?=Url::toRoute(['modifica', 'id' => $model->dni])?>" class="btn btn-primary">Modificar</a>
        <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#dni<?= $model->dni ?>">Eliminar</a>
    </div>
    <div class="modal fade" role="dialog" aria-hidden="true" id="dni<?= $model->dni ?>">
        <div class="modal-dialog">
            <div class="modal-content panel-warning">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Eliminar Usuario</h4>
                </div>
                <div class="modal-body">
                    <p>¿Realmente deseas eliminar al usuario: <?= $model->nombre_usuario ?> con DNI: <?= $model->dni ?>? </p>
                </div>
                <div class="modal-footer">
                    <?= Html::beginForm(Url::toRoute("usuario/eliminar"), "POST") ?>
                    <input type="hidden" name="dni" value="<?= $model->dni ?>">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <?= Html::endForm() ?>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</article>

