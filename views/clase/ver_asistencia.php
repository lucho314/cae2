<?php
$this->title = 'SGD: Asistencia';
?>
<article class="col-xs-12 col-md-10">
    <h3>Asistencia:</h3>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-condensed">
            <thead Style="background-color:#4682B4; color:white;">
            <th>Nombre y Apellido</th>
            <th>Asistencia</th>
            <th>Desempeño</th>
            </thead>
            <?php
            $i = 0;
            foreach ($datos as $row): 
                ?>
                <tr>
                    <td><?= $row['nya'] ?></td>
                    <td><?= $row['asistencia'] ?></td>
                    <td><?= $row['nota']?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</article>