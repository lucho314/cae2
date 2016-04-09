<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

$this->title = 'SGD CAE: Buscar Evento';
?>
<article class="col-xs-12 col-md-10"> 
    <div class="row" style="margin-top: 5px;">
        <?php
        $f = ActiveForm::begin([
                    "method" => "get",
                    "action" => Url::toRoute("evento/buscar"),
                    "enableClientValidation" => true,
        ]);
        ?>
        <div class="col-xs-12 col-md-4">
            <label>Buscar:</label>
            <?= $f->field($form, "q")->input("search", ['class' => "form-control", 'placeholder' => 'Nombre','autofocus'=>true])->label(false) ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <label>Desde:</label>
            <?= $f->field($form, "desde")->input("date", ['class' => "form-control"])->label(false) ?>
        </div>
        <div class="col-xs-12 col-md-3">
            <label>Hasta:</label>
            <?= $f->field($form, "hasta")->input("date", ['class' => "form-control"])->label(false) ?>
        </div>
        <div class="col-xs-6 col-md-2">
            <input type="submit" value="Buscar" class="btn btn-default" style ="margin-top:29px;">
            <a href="<?= Url::toRoute("evento/crear") ?>" class="btn btn-success" style="margin-top:29px; float: right;">Nuevo</a>
        </div>   
        
        <?php $f->end() ?>
    </div>
    <?= $msg ?>
    <hr style="margin-top: 0px;">
    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Eventos:</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Modificar</th>
                    <th>Eliminar</th>
                    <th>Ver lista</th>
                    </thead>
                    <tbody>
                        </tr>
                        <?php foreach ($model as $row): ?>
                            <tr>
                                <td><?= $row['nombre'] ?></td>
                                <td><?= $row['fecha_inicio'] ?></td>
                                <td><?= $row['fecha_fin'] ?></td>
                                <td><a href="<?= Url::toRoute(["evento/modificar", "id_evento" => $row['id_evento']]) ?>">Editar</a></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#id_evento<?= $row['id_evento'] ?>">Eliminar</a>
                                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_evento<?= $row["id_evento"] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Eliminar <?= $row["nombre"] ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Desea eliminar el evento <?= $row['nombre'] ?>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::beginForm(Url::toRoute("deporte/eliminar"), "POST") ?>
                                                    <input type="hidden" name="deporte" value="<?= $row['id_deporte'] ?>">
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <?= Html::endForm() ?>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </td>
                                <td><a href="<?= Url::toRoute(["evento/verlista", "id_evento" => $row['id_evento'], 'id_deporte' => $row['id_deporte']]) ?>">convocados</a></td>
                            </tr>                           
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?= LinkPager::widget(["pagination" => $pages,]); ?>
</article>

