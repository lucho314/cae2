<?php

use yii\helpers\Url;

$this->title = 'SGD CAE: Crear Lista';
?>
<head>
    <script type="text/javascript" src="../web/js/jquery.js"></script>
</head>
<article class="col-xs-12 col-md-10">
    <div class="row"> <!-- tabla de deportista para convocar -->
        <div class="col-xs-12">
            <h3>Crear Lista:</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed" id="original">
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
                                <td><a href="#" class="agregar">Agregar</a></td>
                            </tr>   
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row"> <!-- aca empieza la tabla de convocados -->
        <div class="col-xs-12">
            <h3>Crear Lista:</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed" id="tabla">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>Nombre</th>
                    <th>Dni</th>
                    <th>Categoria</th>
                    <th>Convocar</th>
                    </thead>
                    <tbody>

                        <?php if (!empty($convocados)): foreach ($convocados as $valor):  var_dump( $_SESSION['dni']);?>
                                <tr>
                                    <td> <?= $valor['nombre'] ?></td>
                                    <td><?= $valor['dni'] ?> </td>
                                    <td><?= $valor['nombre_categoria'] ?> </td>
                                    <td><a href="#" class="quitar">quitar</a></td>
                                </tr>   
                            <?php endforeach;
                        endif; ?>
                    </tbody>
                </table>
            </div>
            <a href="<?= Url::toRoute(["evento/conflista"]) ?>"  class="btn btn-default" style="float:right;" id="go_paso_b">Confirmar<span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
    </div>

</article>


<script type="text/javascript">
    $('.agregar').click(function () {
        var nombre = $(this).parents("tr").find("td").eq(0).html();
        var dni = $(this).parents("tr").find("td").eq(1).html();
        var categoria = $(this).parents("tr").find("td").eq(2).html();
        var nuevaFila = "<tr><td>" + nombre + "</td>";
        nuevaFila += "<td>" + dni + "</td>";
        nuevaFila += "<td>" + categoria + "</td>";
        nuevaFila += "<td><a href='#' class='quitar'>quitar</a></td></tr>";
        var dataString = 'id=' + dni;
        $.ajax({
            type: "get",
            url: "<?= Url::toRoute(["evento/agregar"]) ?>",
            data: dataString
        });
        $(this).parent().parent().remove();
        $('#tabla').append(nuevaFila);
    })

    $('.quitar').click(function () {
        var nombre = $(this).parents("tr").find("td").eq(0).html();
        var dni = $(this).parents("tr").find("td").eq(1).html();
        var categoria = $(this).parents("tr").find("td").eq(2).html();
        var nuevaFila = "<tr><td>" + nombre + "</td>";
        nuevaFila += "<td>" + dni + "</td>";
        nuevaFila += "<td>" + categoria + "</td>";
        nuevaFila += "<td><a href='#' class='agregar'>agregar</a></td></tr>";
        var dataString = 'id=' + dni;
        $.ajax({
            type: "get",
            url: "<?= Url::toRoute(["evento/quitar"]) ?>",
            data: dataString
        });
        $(this).parent().parent().remove();
        $('#original').append(nuevaFila);
    })
</script>