<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;

$this->title = 'SGD CAE: Buscar Deportista';
?>
<article class="col-xs-12 col-md-10"> 
    <div class="row" style="margin-top: 5px;">
        <?php
        $f = ActiveForm::begin([
                    "method" => "get",
                    "action" => Url::toRoute("deportista/buscar"),
                    "enableClientValidation" => true,
        ]);
        ?>

        <div class="col-xs-12 col-md-5">
            <label>Buscar:</label>
            <div class="input-group">
                <?= $f->field($form, "q")->input("search", ['class' => "form-control", 'style' => "margin-top:-10px;",'placeholder'=>'DNI,Nombre o Apellido'])->label(false) ?>

                <span class="input-group-btn">
                    <?= Html::submitButton("Buscar",['class'=>'btn btn-default'])?>
                </span>
            </div>
        </div>

        <?php $f->end() ?> 
    </div>
    <hr>
    

    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Deportistas</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>Ver</th>
                    <th>¿Modificar?</th>
                    <th>¿Eliminar?</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $row): ?>
                            <tr>
                                <td><?= $row['dni'] ?></td>
                                <td><?= $row['NyA'] ?></td>
                                <td><a href="<?= Url::toRoute(["deportista/view",'id'=>$row['dni']])?>">Informacion</a>
                                <td>
                                    <a href="<?= Url::toRoute(["deportista/modificar", "dni" => $row['dni']]) ?>">Editar</a>
                                </td>
                                <td>
                                    <a href="#" data-toggle="modal" data-target="#dni<?= $row['dni'] ?>">Eliminar</a>
                                    <div class="modal fade" role="dialog" aria-hidden="true" id="dni<?= $row["dni"] ?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content panel-warning">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    <h4 class="modal-title">Eliminar Deportista</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Realmente deseas eliminar al deportista <?= $row['NyA'] ?>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <?= Html::beginForm(Url::toRoute("deportista/eliminar"), "POST") ?>
                                                        <input type="hidden" name="dni" value="<?= $row['dni'] ?>">
                                                        <button type="submit" class="btn btn-primary">Eliminar</button>
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