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
                    </thead>
                    <tbody>
                        <?php foreach ($model as $row): ?>
                            <tr>
                                <td><?= $row['dni'] ?></td>
                                <td><?= $row['NyA'] ?></td>
                                <td><a href="<?= Url::toRoute(["deportista/view",'id'=>$row['dni']])?>">Informacion</a>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?= LinkPager::widget(["pagination" => $pages,]); ?>
        </div>
    </div>
</article>