<?php

use yii\helpers\Url;
$this->title = 'SGD CAE: Crear Lista';
?>
<head>
    <script type="text/javascript" src="../web/js/jquery.js"></script>
</head>
<article class="col-xs-12 col-md-10">
    <div class="row">
        <div class="col-xs-12">
            <h3>Crear Lista:</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre</th>
                    <th>Dni</th>
                    <th>Categoria</th>
                    <th>Convocar</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $valor): ?>
                            <tr>
                                <td> <?= $valor['nombre'] ?></td>
                                <td><?= $valor['dni'] ?> </td>
                                <td><?= $valor['nombre_categoria'] ?> </td>
                                <td><a href="#" onclick="Eliminar(this.parentNode.parentNode.rowIndex,<?= $valor['dni'] ?>)">Convocar</a></td>
                            </tr>   
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <a href="<?= Url::toRoute(["evento/conflista"]) ?>"  class="btn btn-default" style="float:right;" id="go_paso_b">Confirmar<span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
    </div>
</article>
<script type="text/javascript">
    function Eliminar(i, dni) {


        document.getElementsByTagName("table")[0].setAttribute("id", "tableid");
        document.getElementById("tableid").deleteRow(i);
        var dataString = 'id=' + dni;
        $.ajax({
            type: "POST",
            url: "<?= Url::toRoute(["evento/agregar"]) ?>",
            data: dataString
        });
    }
</script>