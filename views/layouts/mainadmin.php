<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\models\Deporte;
use yii\bootstrap\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <?= Html::csrfMetaTags() ?>
        <link href='../web/imagenes/cae.ico' rel='shortcut icon' type='image/x-icon'>
        <script type="text/javascript" src="../web/js/jquery.js"></script>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
        <script type="text/javascript">
            $(document).ready(main);

            var contador = 1;
            var aux = 1;

            function main() {
                $('.menu_movil').click(function () {

                    if (contador == 1) {
                        $('aside').animate({
                            left: '0'
                        });
                        contador = 0;
                    } else {
                        contador = 1;
                        $('aside').animate({
                            left: '-100%'
                        });
                    }
                    ;
                });

                $('.cat').click(function () {
                    if (aux == 1) {
                        $('section').animate({
                            left: '0'
                        });
                        aux = 0;
                        
                    } else {
                        $('section').animate({
                            left: '-100%'
                        });
                        aux = 1;
                    }
                    ;
                });

                // Mostramos y ocultamos submenus
                $('.submenu').click(function () {
                    $(this).children('.children').slideToggle();
                });
            }
            ;
        </script>
    </head>
    <body>
        <?php $this->beginBody() ?>
        <?php
        NavBar::begin(['options' => ['class' => 'hidden',]]);
        NavBar::end();
        ?>
        <div class="container-fluid">
            <div class="row">
                <header class="col-xs-12 cabecera">
                    <img src="../web/imagenes/cae.png" class="logo">
                    <a href="<?= Url::toRoute("usuario/admin") ?>"><h1>C.A.E.: Club Atlético Estudiante</h1></a>
                </header>
                <header class="col-xs-12 menu_movil">
                    <div class="row">
                        <a href="javascript:void(0);" class="container-fluid bt-menu">Menu<span class="glyphicon glyphicon-tasks"></span></a>
                    </div>
                </header>
                <aside class="col-xs-12 col-md-2 menu">
                    <ul class="container-fluid">
                        <li class="row"><a href="<?= Url::toRoute("deporte/buscar") ?>"><span class="glyphicon glyphicon-globe"></span>Deportes</a></li>
                        <li class="row cat"><a href="javascript:void(0);"><span class="glyphicon glyphicon-folder-open"></span>Categorias<span class="glyphicon glyphicon-menu-right"></span></a></li>
                        <li class="row"><a href="<?= Url::toRoute("usuario/buscar") ?>"><span class="glyphicon glyphicon-user"></span>Usuarios</a></li>
                        <li class="row"><a href="<?= Url::toRoute("deportista/buscar") ?>"><span class="glyphicon glyphicon-user"></span>Deportistas</a></li>
                        <li class="row"><a href="<?= Url::toRoute("evento/buscar") ?>"><span class="glyphicon glyphicon-calendar"></span>Eventos</a></li>
                        <li class="row"><a href="<?= Url::toRoute("comision/buscar") ?>"><span class="glyphicon glyphicon-time"></span>Horarios</a></li>
                        <li class="row submenu"><a href="javascript:void(0);"><span class="glyphicon glyphicon-user"></span>Mi Cuenta<span class="glyphicon glyphicon-menu-down"></span></a>
                            <ul class="children">
                                <li><a href="<?= Url::toRoute("usuario/modificarcuenta") ?>" ><span class="glyphicon glyphicon-lock"></span>Contraseña</a></li>
                                <li><a href="<?= Url::toRoute("usuario/modificar") ?>"><span class="glyphicon glyphicon-folder-open"></span>Datos</a></li>
                            </ul>
                        </li>
                        <li class="row"><a href=""><span class="glyphicon glyphicon-bell"></span>Notificaciones</a></li>
                        <li class="row"><a href=""><span class="glyphicon glyphicon-cog"></span>Backup</a></li>
                        <li class="row"><a href=""><span class="glyphicon glyphicon-wrench"></span>Restauración</a></li>
                        <li class="row"><a href="<?= Url::toRoute("usuario/logout") ?>" data-method="post"><span class="glyphicon glyphicon-off"></span>Cerrar Sesion</a></li>
                    </ul>		
                </aside>
                
                <section>
                    <ul>
                        <li class="cat"><a href="javascript:void(0);"><span class="glyphicon glyphicon-remove"></span>Cerrar</a></li>
                        <?php
                           $deportes=Deporte::find()->asArray()->all();
                           foreach($deportes as $val):
                        ?>
                        <li ><a href="<?=Url::toRoute(['categoria/buscar','id'=>$val['id_deporte']])?>"><span class="glyphicon glyphicon-tag"></span><?=$val['nombre_deporte']?></a></li>
                        <?php endforeach;?>
                    </ul>
                </section>
                <?= $content ?>
            </div>
        </div>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>

