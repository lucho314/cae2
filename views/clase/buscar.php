<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

$this->title = 'SGD CAE: Buscar Asistencia';
?>
<article class="col-xs-12 col-md-10">
    <div class="row" style="margin-top: 5px;">
        <?php
        $f = ActiveForm::begin([
                    "method" => "get",
                    "action" => Url::toRoute("clase/buscar"),
                    "enableClientValidation" => true,
        ]);
        ?>
        <div class="col-xs-10 col-md-5">
            <label for="buscar deporte">Buscar:</label>
            <div class="input-group">
                <?= $f->field($form, "x")->input("date", ['class' => "form-control", 'autofocus' => true, 'style' => "margin-top:-10px;"])->label(false) ?>
                <span class="input-group-btn">
                    <?= Html::submitButton("Buscar", ["class" => "btn btn-default"]) ?>
                </span>
            </div>
        </div>
        <?php $f->end() ?> 
        <div class="col-xs-2 col-md-5">
            <a href="<?= Url::toRoute("clase/crear")?>" class="btn btn-success" style="margin-top:29px;">Nueva</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Practicas:</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Fecha</th>
                    <th>Categoria</th>
                    <th>Asistencia</th>
                    <th>¿Modificar?</th>
                    <th>¿Eliminar?</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $row): ?>
                            <tr>
                                <td><?=$row['fecha']?></td>
                                <td><?=$row['nombre_categoria']?></td>
                                <td><a href="<?=Url::toRoute(["clase/verasistencia","id"=>$row['id_clase']])?>">Ver</a></td>
                                <td><a href="<?=Url::toRoute(["clase/modificar","id"=>$row['id_clase']])?>">Editar</a></td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#id_clase<?=$row['id_clase']?>">Eliminar</a>
                                    <div class="modal fade" role="dialog" aria-hidden="true" id="id_clase<?=$row['id_clase']?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4>Eliminar Clase</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Desea eliminar la clase de la categoria <?=$row['nombre_categoria']?> del <?=$row['fecha']?>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::beginForm(Url::toRoute("clase/eliminar"), "POST") ?>
                                                    <input type="hidden" name="id_clase" value="<?= $row['id_clase'] ?>">
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <?= Html::endForm() ?>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
             <?= LinkPager::widget(["pagination" => $page]); ?>
        </div>
    </div>
</article>
