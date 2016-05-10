<?php

use yii\widgets\LinkPager;

$this->title = 'SGD CAE: Lista de Profesores';
?>
<article class="col-xs-12 col-md-10"> 
    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Profesores:</h3>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre y Apellido</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    </thead>
                    <tbody>
                        <?php foreach ($profesores as $row): ?>
                            <tr>
                                <td><?= $row['nombre'].', '.$row['apellido'] ?></td>
                                <td><?= $row['telefono'] ?></td>
                                <td><?= $row['email'] ?> </td>                                
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?= LinkPager::widget(["pagination" => $pages]); ?>
        </div>
    </div>
</article>