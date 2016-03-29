<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\bootstrap\Modal;

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
        <div class="col-xs-12 col-sm-4 col-md-4">
            <label>Buscar:</label>
            <?= $f->field($form, "q")->input("search",['class' => "form-control",'placeholder'=>'Nombre'])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
            <label>Desde:</label>
            <?= $f->field($form, "desde")->input("date",['class' => "form-control"])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-3 col-md-3">
            <label>Hasta:</label>
            <?= $f->field($form, "hasta")->input("date",['class' => "form-control"])->label(false) ?>
        </div>
        <div class="col-xs-12 col-sm-2">
            <input type="submit" value="Buscar" class="btn btn-default" style ="margin-top:28px;">
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
                                <td><a href="<?= Url::toRoute(["evento/eliminar", "id_evento" => $row['id_evento']]) ?>">Eliminar</a></td>
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

