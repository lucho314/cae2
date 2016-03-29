<?php

use yii\helpers\Url;
$this->title = 'SGD CAE: Información';
?>
<head>
    <style>
        h4{
            color: #DCDCDC;
            font-style:italic;
            font-family: "arial", serif;
            font-size: 20px;
        }
        
        h4 >a{
             color: #DCDCDC;
            font-size: 12px;
            font-style:normal;
        }
    </style>
</head>

<article class="col-xs-12 col-md-10">
    <h3>Información Resumida:</h3>
    <hr>
    <h4>Nombre del deporte:  <?= $datos['nombre_deporte'] ?> </h4>
    <h4>Cantidad de Profesores:  <?= $datos['cantidad_profesor'] ?>       <a href="<?= Url::toRoute(["infoprofesores",'id'=>$datos['id_deporte']])?>"><span class="glyphicon glyphicon-plus"></span></a></h4>
    <h4>Cantidad de Categoria:  <?= $datos['cantidad_categoria'] ?>       <a href="<?= Url::toRoute(["infocategoria",'id'=>$datos['id_deporte']])?>"><span class="glyphicon glyphicon-plus"></span></a></h4>
    <h4> Cantidad de deportistas:  <?= $datos['cantidad_deportista'] ?>     <a href="<?= Url::toRoute(["infodeportista",'id'=>$datos['id_deporte']])?>"><span class="glyphicon glyphicon-plus"></span></a></h4>
</article>