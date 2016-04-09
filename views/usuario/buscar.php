<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

$this->title = 'SGD CAE: Buscar usuario';
?>
<article class="col-xs-12 col-md-10"> 
    <div class="row" style="margin-top: 5px;">
        <?php
        $f = ActiveForm::begin([
                "method" => "post",
                "action" => Url::toRoute("usuario/buscar"),
                "enableClientValidation" => true]);
        ?>

        <div class="col-xs-10 col-md-5">
            <label>Buscar:</label>
            <div class="input-group">
                <?= $f->field($form, "q")->input("search", ['class' => 'form-control', 'placeholder' => 'DNI o Nombre de Usuario', 'style' => "margin-top:-10px;",'autofocus'=>true])->label(false) ?>
                <span class="input-group-btn">
                    <?= Html::submitButton("buscar", ["class" => "btn btn-default"]) ?>
                </span>
            </div>
        </div>
        <div class="col-xs-2">
            <a href="<?=Url::toRoute("usuario/nuevo")?>" class="btn btn-success" style="margin-top:29px;">Nuevo</a>
        </div>
        <?php $f->end() ?> 
    </div>
    <hr>

    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Usuarios:</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                        <th>DNI</th>
                        <th>Nombre de usuario</th>
                        <th>Privilegio</th>
                        <th>Información</th>
                        <th>¿Modificar?</th>
                        <th>¿Eliminar?</th>
                        <th>Resetear</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $row): ?>
                            <tr>
                                <td><?= $row->dni ?></td>
                                <td><?= $row['nombre_usuario'] ?></td>
                                <td><?= $row['privilegio'] ?> </td>
                                </td>
                                <td><a href="<?= Url::toRoute(["usuario/ver", "id" => $row['dni']]) ?>">Ver</a></td>                                
                                <td><a href="<?= Url::toRoute(["usuario/modifica", "id" => $row['dni']]) ?>">Editar</a></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#dni<?= $row['dni'] ?>">Eliminar</a>
                                    <div class="modal fade" role="dialog" aria-hidden="true" id="dni<?= $row["dni"] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content panel-warning">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Eliminar Usuario</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Realmente deseas eliminar al usuario <?= $row['nombre_usuario'] ?>  DNI: <?= $row['dni'] ?>? </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::beginForm(Url::toRoute("usuario/eliminar"), "POST") ?>
                                                    <input type="hidden" name="dni" value="<?= $row['dni'] ?>">
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <?= Html::endForm() ?>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </td>
                                <td><a href="<?= Url::toRoute(["usuario/reset", 'dni' => $row['dni']]) ?>">Resetear</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?= LinkPager::widget(["pagination" => $pages]); ?>
        </div>
    </div>
</article>

