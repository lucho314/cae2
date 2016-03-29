<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<head>
    <script type="text/javascript" src="../web/js/jquery.js"></script>
</head>
<article class="col-xs-12 col-md-10">
    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Convocados</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre</th>
                    <th>Dni</th>
                    <th>Categoria</th>
                    <th>Eliminar</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $valor): ?>
                            <tr>
                                <td> <?= $valor['nombre'] ?></td>
                                <td><?= $valor['dni'] ?> </td>
                                <td><?= $valor['nombre_categoria'] ?> </td>
                                <td> <a href="#" onclick="Eliminar(this.parentNode.parentNode.rowIndex,<?= $valor['dni'] ?>)">Eliminar</a></td>
                            </tr>   
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div style="float:right;">
                <a href="<?= Url::toRoute(["evento/clista"]) ?>" class="btn btn-default">
                    <span class="glyphicon glyphicon-chevron-left"></span>Atras
                </a>
                <a href="<?= Url::toRoute(["evento/conflista", 'id' => 'confirmar']) ?>"  class="btn btn-primary">Guardar</a>
            </div>
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
            url: "<?= Url::toRoute(["evento/quitar"]) ?>",
            data: dataString
        });
    }
</script>