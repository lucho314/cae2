<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;

$this->title = 'SGD CAE: Buscar Deporte';
?>
<head>
    <style>
        .alert {
            display:inline-block;
        }
    </style>
    <script type="text/javascript" src="../web/js/desaparecer.js"></script>
</head>
<article class="col-xs-12 col-md-10"> 
    <div class="row" style="margin-top: 5px;">
        <?php
        $f = ActiveForm::begin([
                    "method" => "get",
                    "action" => Url::toRoute("deporte/buscar"),
                    "enableClientValidation" => true,
        ]);
        ?>

        <div class="col-xs-12 col-md-5">
            <label for="buscar deporte">Buscar:</label>
            <div class="input-group">

                <?= $f->field($form, "q")->input("search", ['placeholder' => 'Nombre del Deporte', 'class' => "form-control", 'autofocus' => true, 'style' => "margin-top:-10px;"])->label(false) ?>

                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Buscar</button>
                </span>
            </div>
        </div>

        <?php $f->end() ?> 
    </div>
    <div class="content">       
        <?= $msg ?>
    </div>
    <hr>


    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Deportes:</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre</th>
                    <th>¿Modificar?</th>
                    <th>¿Eliminar?</th>
                    <th>Información</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $row): ?>
                            <tr>
                                <td><?= $row['nombre_deporte'] ?></td>
                                <td><a href="<?= Url::toRoute(["deporte/modificar", "id" => $row['id_deporte']]) ?>">Editar</a></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#id_deporte<?= $row['id_deporte'] ?>">Eliminar</a>
                                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_deporte<?= $row["id_deporte"] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Eliminar <?= $row["nombre_deporte"] ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Esta Operacíon Implica Eliminar Todas las Categorias, Horarios y Eventos
                                                        Asociados a Esté Deporte.</p>
                                                    <p>¿Desea Continuar?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::beginForm(Url::toRoute("deporte/eliminar"), "POST") ?>
                                                    <input type="hidden" name="deporte" value="<?= $row['id_deporte'] ?>">
                                                    <button type="submit" class="btn btn-primary">Eliminar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <?= Html::endForm() ?>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </td>
                                <td><a href="<?= Url::toRoute(["deporte/infodeporte", "id" => $row['id_deporte']]) ?>">Ver</a></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?= LinkPager::widget(["pagination" => $pages,]); ?>
        </div>
    </div>
</article>

