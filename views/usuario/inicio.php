<?php $this->title = 'SGD: Inicio'; 
use yii\helpers\Url;
?>
<article class="row col-xs-12 col-md-8">
    <div class="col-xs-12">
        <h1>Bienvenido  <?= $nombre ?></h1>
        <h3> Sistema de administracion deportiva CAE</h3>
    </div>

</article>
<aside class="col-md-2" style="float: right;">
    <div class=" col-xs-12 notif">
        <p>Eventos Proximos</p>
        <hr style="margin-top: 5px; margin-bottom: 10px;">
        <?php if (!empty($eventos)): ?>
            <ul>
                <?php foreach ($eventos as $dato): ?>
                <li><a href="<?= Url::toRoute(["evento/modificar",'id_evento'=>$dato['id_evento']]) ?>"> <?= $dato['nombre'] ?></a></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
        <a href="">Más Eventos</a>
    </div>
    <div class="col-xs-12 notif">
        <p>Novedades</p>
        <hr style="margin-top: 5px; margin-bottom: 10px;">
        <p> <?= $notificacion ?></p>
        <a href="">Ir a notificaciones</a>
    </div>
</aside>