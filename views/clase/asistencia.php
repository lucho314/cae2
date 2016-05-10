<?php

use yii\helpers\Html;
use yii\helpers\Url;

$nota = ['4' => 'Muy Bueno', '3' => 'Bueno', '2' => 'Regular', '1' => 'Malo'];
$this->title = 'SGD: Nueva Asistencia';
?>


<?=
Html::beginForm(
        Url::toRoute("clase/asistencia"), //action
        "post",//method
        ['id'=>'formulario']
);
?>
<article class="col-xs-12 col-md-10">
    <h3>Asistencia:</h3>
    <?= $msg ?>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-condensed">
            <thead Style="background-color:#4682B4; color:white;">
            <th>Nombre</th>
            <th>DNI</th>
            <th>Asistencia</th>
            <th>Desempeño</th>
            </thead>
            <?php
            $i = 0;
            foreach ($model as $row): $dni[] = $row['dni'];
                ?>
                <tr>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['dni'] ?></td>
                    <td>     
                        <input id="<?= $row['dni'] ?>" onchange="habilitar(this.checked, <?= $row['dni'] ?>);" type="checkbox" name="asistencia[]" value="<?= $row['dni'] ?>">
                    </td>
                    <td>
                        
                        <?= Html::dropDownList($row['dni'], $row['dni'], $nota, [ 'id' => 'list' . $row['dni'], 'disabled' => 'false', 'prompt' => 'Selecione desempeño']) ?>
                        <div style="display:none" id="div<?= $row['dni'] ?>">Debe poner una nota </div>
                    </td>
                </tr>
                <?php
                $i++;
            endforeach;
            ?>
            </tbody>
        </table>
        <div style="float:right">
            <button type="button" id="guardar" class="btn btn-success">Agregar</button>
            
        </div>
        <?= Html::endForm() ?>
    </div>
</article>

<script>
    function habilitar(value, dni)
    {
        if (value == true)
        {
            // habilitamos
            document.getElementById("list" + dni).disabled = false;
            document.getElementById("list" + dni).focus();
        } else if (value == false) {
            // deshabilitamos
            document.getElementById("list" + dni).disabled = true;
            $("#list" + dni).prop('selectedIndex', 0);
            $('#div' + dni).hide();
        }
    };

    $("#guardar").click(function () {
        var dnis = <?= json_encode($dni) ?>;
        var aux=0;
        for (x = 0; x < dnis.length; x++) {
            if ($('#' + dnis[x]).prop('checked')) {
                if ($("#list" + dnis[x]).val().trim() === '') {
                    $('#div' + dnis[x]).show();
                    aux++;
                }
                else
                {
                    $('#div' + dnis[x]).hide();
                }
            }
        }
        if(aux === 0)
        {
           $('#formulario').submit();
        }
    });
    

    
    
</script>

