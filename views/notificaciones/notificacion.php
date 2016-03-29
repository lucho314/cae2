<?php

use yii\helpers\Url;
?>
<article>
    <?php
    if (!empty($model)):
        foreach ($model as $dato):
            ?>
            <div id="<?= $dato['id'] ?>">
                Los profesores del deporte <?= $dato['nombre_deporte'] ?> requieren el alta del deportista <?= $dato['nombre'] ?> dni <?= $dato['dni'] ?> <a href="#" onclick="aceptar(<?= $dato['id'] ?>)"> <span class="glyphicon glyphicon-ok"></span></a>
            </div>
        <?php
        endforeach;
    else:
        ?>
        No posee notificaciones para mostrar.
<?php endif; ?>
</article>

<script>
    function aceptar(id)
    {
        $('#' + id).remove();
        var dataString = 'id=' + id;
        $.ajax({
            type: "GET",
            url: "<?= Url::toRoute(["notificaciones/aceptar"]) ?>",
            data: dataString
        });
    }
</script>