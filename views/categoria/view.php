<?php
$this->title = 'SGD CAE: Ver Categoria';
?>

<article class="col-xs-12 col-md-10"> 
    <h3>Deportista categoria: <?= $model->nombre_categoria ?></h3>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-condensed">
            <thead Style="background-color:#4682B4; color:white;">
            <th>Dni</th>
            <th>Nombre y Apellido</th>
            <th>Telefono</th>
            <th>email</th>
            </thead>
            <tbody>
                <?php foreach ($alumnos as $row): ?>
                    <tr>
                        <td><?= $row['nombre'] ?></td>
                        <td><?= $row['dni'] ?></td>
                        <td><?= $row['telefono'] ?></td>
                        <td><?= $row['email'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</article>
