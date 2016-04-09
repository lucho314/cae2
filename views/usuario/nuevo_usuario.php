<?php

use yii\helpers\Url;

$this->title = 'SGD CAE: Nuevo Usuario';
?>
<head>
    <style>
        #cargar {
            position: relative; /* podría ser relative */
            width: 200px;
            height: 200px;
            left: 25%;
            top: 80px;
        }
    </style>
</head>
<article class="col-xs-12 col-md-10">
    <div class="row">
        <div class="col-xs-3">
            <h3>Crear usuario:</h3>
        </div>
        <div class="col-xs-9 col-md-4">
            <select class="form-control" name="tipo" id="tipo" autofocus style="margin-top:4px;">
                <option value=""> Seleccione Usuario</option>
                <option value="1">Administrador</option>
                <option value="2">Subcomisión</option>
                <option value="3">Profesor</option>
            </select>
        </div>
    </div>
    <hr>
    <div>
    </div>

    <div id="crear"></div>

</article>

<script>
    $('select#tipo').on('change', function () {
        var valor = $(this).val();
        $('#crear').html('<div id="cargar"><img src="../web/imagenes/reload.svg"/></div>');
        switch (valor) {
            case '1':
                url = '<?= Url::toRoute(['usuario/create']) ?>';
                break;
            case '2':
                url = '<?= Url::toRoute(['subcomision/create']) ?>';
                break
            case '3':
                url = '<?= Url::toRoute(['profesor/create']) ?>';
                break;
            default:
                $('#crear').empty();
        }
        if (valor !== "") {
            $.ajax({
                'url': url,
                'async': true
            }).done(function (html) {
                $('#crear').fadeIn(1000).html(html);
            });
        }
    });
</script>