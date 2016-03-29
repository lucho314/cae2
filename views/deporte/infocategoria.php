<?php

use yii\helpers\Url;
$this->title = 'SGD CAE: Categoria';
?>
<article class="col-xs-12 col-md-10" >
    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Categorias</h3>
                        <?= $msg?>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre</th>
                    <th>Edad minima</th>
                    <th>Edad maxima</th>
                    <th>Profesor titular</th>
                    <th>Profesor suplente</th>
                    <th>Modificar</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $val): ?>
                            <tr>
                                <td><?= $val['nombre_categoria'] ?></td>
                                <td><?= $val['edad_minima'] ?></td>
                                <td><?= $val['edad_maxima'] ?></td>
                                <td><?= $val['nya_titular'] ?></td>
                                <td><?= $val['nya_suplente'] ?></td>
                                <td><a href="<?= Url::toRoute(["categoria/modificar",'id_categoria'=>$val['id_categoria'],'op'=>1])?>"> Modificar</a></td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <a href="<?=Url::toRoute(["infodeporte","id"=>$id])?>"class="btn btn-default btn-sm"><span class="glyphicon glyphicon-chevron-left"></span>Atras</a>
        </div>
    </div>
</article>