<?php

use yii\helpers\Url;
$this->title = 'SGD CAE: Deportistas';
?>
<article class="col-xs-12 col-md-10" >
    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Deportistas</h3>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Dni</th>
                    <th>Domicilio</th>
                    <th>Email</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $val): ?>
                            <tr>
                                <td><?= $val['nombre'] ?></td>
                                <td><?= $val['apellido'] ?></td>
                                <td><?= $val['dni'] ?></td>
                                <td><?= $val['domicilio'] ?></td>
                                <td><?= $val['email'] ?></td>
                            </tr>

                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
            <a href="<?=Url::toRoute(["infodeporte","id"=>$id])?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-chevron-left"></span>Atras</a>
        </div>
    </div>
</article>

