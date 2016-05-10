<?php

use yii\helpers\Url;

$this->title = 'SGD CAE: Informacion Deportista';
?>
<article class="col-xs-12 col-md-10">
    <h3>Información:</h3>
    <hr>
    <div class="row" style="color: white;">
        <div class="col-md-2">
            <img src="../web/archivos/<?= $informacion['dni'] ?>" class="img-rounded" id="perfil" style="float:left;">
        </div>
        <div class="col col-md-5 col-xs-12">
            <div class="form-group"><label>Nombre:</label><?= $informacion['nombre'] ?>.</div>
            <div class="form-group"><label>Apellido:</label><?= $informacion['apellido'] ?>.</div>
            <div class="form-group"><label>DNI:</label><?= $informacion['dni'] ?>.</div>
            <div class="form-group"><label>Edad:</label><?= $informacion['edad'] ?>  años.</div>
            <div class="form-group"><label>Numero de Socio: </label><?= $informacion['numero_socio'] ?>.</div>
            <div class="form-group"><label>Direccion:</label><?= $informacion['domicilio'] ?>.</div>
        </div>
        <div class="col col-md-5 col-xs-12">
            <div class="form-group"><label>Email:</label><?= $informacion['email'] ?>.</div>
            <div class="form-group"><label>Telefono:</label><?= $informacion['telefono'] ?>.</div>
            <?php
            $deportes = "";
            $categorias = "";
            foreach ($info_deporte as $valor) {
                $deportes.=$valor['nombre_deporte'] . " ";
                $categorias.=$valor['nombre_categoria'] . " ";
            }
            ?>
            <div class="form-group"><label>Deportes: </label><?= $deportes ?></div>
            <div class="form-group"><label>Categorias: </label><?= $categorias ?></div>
            <a href="<?= Url::toRoute(["deportista/planilla",'id'=> $informacion['dni']]) ?>" id="ver_planilla">
                <span class="glyphicon glyphicon-file"></span>Planilla Medica
            </a>
        </div>
    </div>
</article>
