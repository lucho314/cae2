<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'SGD CAE: Buscar Practica';
?>
<article class="col-xs-12 col-md-10"> 
    <div class="row" style="margin-top: 5px;">
        <?php
        $f = ActiveForm::begin([
                    "method" => "get",
                    "action" => Url::toRoute("comision/buscar"),
                    "enableClientValidation" => true,
        ]);
        ?>

        <div class="col-xs-10 col-md-5">
            <label>Buscar:</label>
            <div class="input-group">
                <?= $f->field($form, "q")->input("search", ['placeholder' => 'Nombre, Día o Categoria', 'class' => "form-control", 'autofocus' => true, 'style' => "margin-top:-10px;"])->label(false) ?>
                <span class="input-group-btn">
                    <?= Html::submitButton("Buscar", ["class" => "btn btn-default"]) ?>
                </span>
            </div>
        </div>
        <div class="col-xs-2 col-md-5">
            <a href="<?= Url::toRoute("comision/crear") ?>" class="btn btn-success" style="margin-top:29px;">Nueva</a>
        </div>
        <?php $f->end() ?> 
    </div>
    <hr>
    <?= $msg ?>

    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Practicas:</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre</th>
                    <th>Día</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Categoria</th>
                    <th>¿Modificar?</th>
                    <th>¿Eliminar?</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $row): ?>
                            <tr>
                                <td><?= $row['nombre_comision'] ?></td>
                                <td><?= $row['dia'] ?></td>
                                <td><?= $row['hora_inicio'] ?></td>
                                <td><?= $row['hora_fin'] ?></td>
                                <td><?= $row['nombre_categoria'] ?></td>
                                <td><a href="<?= Url::toRoute(["comision/modificar", "id_comision" => $row['id_comision']]) ?>">Editar</a></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#id_comision<?= $row['id_comision'] ?>">Eliminar</a>
                                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_comision<?= $row["id_comision"] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Eliminar Practica</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Realmente deseas eliminar la practica <?= $row["nombre_comision"] ?>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::beginForm(Url::toRoute("comision/eliminar"), "POST") ?>
                                                    <input type="hidden" name="id_comision" value="<?= $row['id_comision'] ?>">
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <?= Html::endForm() ?>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?= LinkPager::widget(["pagination" => $pages,]); ?>
        </div>
    </div>
</article>