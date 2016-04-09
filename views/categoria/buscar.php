<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;

$this->title = 'SGD CAE: Buscar Categoria';
?>

<article class="col-xs-12 col-md-10"> 
        <div class="row" style="margin-top: 5px;">
            <?php
            $f = ActiveForm::begin([
                        "method" => "get",
                        "action" => Url::toRoute("categoria/buscar"),
                        "enableClientValidation" => true,
            ]);
            ?>
            <div class="col-xs-10 col-md-5">
                <label for="buscar categoria">Buscar:</label>
                <div class="input-group">
                    <?= $f->field($form, "q")->input("search", ['class' => "form-control", 'style' => "margin-top:-10px;", "placeholder" => "Profesor o Nombre","autofocus"=>true])->label(false) ?>
                    <span class="input-group-btn">
                        <?= Html::submitButton("buscar", ["class" => "btn btn-default"]) ?>
                    </span>
                </div>
            </div>
            <div class="col-xs-2 col-md-5">
                <a href="<?=Url::toRoute("categoria/crear")?>" class="btn btn-success" style="margin-top:29px;">Nueva</a>
            </div>

            <?php $f->end() ?> 
        </div>
        <div class="content">
            <?php if ($msg != NULL) { ?>
                <div class='alert alert-success' role='contentinfo'>
                    <span class='glyphicon glyphicon-ok' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>
                    <?= $msg ?>
                </div>
            <?php } ?>
        </div>
        <hr>
        <div class="row">
            <div class="col-xs-12">
                <h3>Lista de Categorias:</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed">
                        <thead Style="background-color:#4682B4; color:white;">
                        <th>Nombre</th>
                        <th>Prof. Titular</th>
                        <th>¿Modificar?</th>
                        <th>¿Eliminar?</th>
                        <th>Información</th>
                        </thead>
                        <tbody>
                            <?php foreach ($model as $row): ?>
                                <tr>
                                    <td><?= $row['nombre_categoria'] ?></td>
                                    <td><?= $row['nya_titular'] ?></td>
                                    <td><a href="<?= Url::toRoute(["categoria/modificar", "id_categoria" => $row['id_categoria']]) ?>">Editar</a></td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-target="#id_categoria<?= $row['id_categoria'] ?>">Eliminar</a>
                                        <div class="modal fade" role="dialog" aria-hidden="true" id="id_categoria<?= $row["id_categoria"] ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                        <h4 class="modal-title">Eliminar <?= $row["nombre_categoria"] ?></h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Esta Operación Implica Eliminar Todos los Eventos y Practicas Asociados a la 
                                                            Categoria.</p>
                                                        <p>¿Desea Continuar?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <?= Html::beginForm(Url::toRoute("categoria/eliminar"), "POST") ?>
                                                        <input type="hidden" name="categoria" value="<?= $row['id_categoria'] ?>">
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <?= Html::endForm() ?>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                    </td>
                                    <td><a href="">Ver</a></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <?= LinkPager::widget(["pagination" => $pages,]); ?>
            </div>
        </div>
    </div>
</article>
