<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\helpers\ArrayHelper;
use app\models\Categoria;

$categoria = Categoria::find()->where(['id_profesor_titular' => Yii::$app->user->id])
        ->orWhere(['id_profesor_suplente' => Yii::$app->user->id])
        ->all();

$this->title = 'SGD CAE: Buscar Deportista';
?>
<head>
    <script type="text/javascript" src="../web/js/jquery.js"></script>
    <script type="text/javascript" src="../web/js/jquery.session.js"></script>
</head>
<article class="col-xs-12 col-md-10"> 
    <div class="row" style="margin-top: 5px;">
        <?php
        $f = ActiveForm::begin([
                    "method" => "get",
                    "action" => Url::toRoute(['deportista/buscar', 'opcion' => 'agregar']),
                    "enableClientValidation" => true,
        ]);
        ?>

        <div class="col-xs-12 col-md-5">
            <label>Buscar:</label>
            <div class="input-group">
                <?= $f->field($form, "q")->input("search", ['class' => "form-control", 'style' => "margin-top:-10px;", 'placeholder' => 'DNI,Nombre o Apellido'])->label(false) ?>

                <span class="input-group-btn">
                    <?= Html::submitButton("buscar", ["class" => "btn btn-default"]) ?>
                </span>
            </div>
        </div>

        <?php $f->end() ?> 

        <div class="row col-xs-12 col-md-5">

            <form action="">
                <label>Agregar a la categoria:</label>
                <?= Html::dropDownList("categorias", null, ArrayHelper::map($categoria, 'id_categoria', 'nombre_categoria'), ['prompt' => 'seleccione categoria', 'id' => "categorias", "class" => "form-control"]) ?>
                <div class="form-group  has-error">
                    <div class="help-block" style="display: none" id="error">Debe seleccionar una categoria</div>
                </div>
        </div>
        </form>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <h3>Lista de Deportistas</h3>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-condensed">
                    <thead Style="background-color:#4682B4; color:white;">
                    <th>DNI</th>
                    <th>Nombre</th>
                    <th>¿Agregar?</th>
                    </thead>
                    <tbody>
                        <?php foreach ($model as $row): ?>
                            <tr>
                                <td><?= $row['dni'] ?></td>
                                <td><?= $row['NyA'] ?></td>
                                <td>
                                    <input id="<?= $row['dni'] ?>" style="display: none" type="submit" value="enviar" onclick = "location = '<?= Url::toRoute(["deportista/agregar", 'dni' => $row['dni']]) ?>'"/>

                                    <button type="button" class="btn btn-success btn-xs" onclick="Eliminar(this.parentNode.parentNode.rowIndex,<?= $row['dni'] ?>)">Agregar</button>
                                </td>
 
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <?= LinkPager::widget(["pagination" => $pages,]); ?>
        </div>
    </div>
</article>
<script>
    $('select#categorias').on('change', function () {
        var valor = $(this).val();
        if (valor !== '')
        {
            $('#error').hide();
            $.post("<?= Url::toRoute(["deportista/sessioncategoria"]) ?>", {"categoria": valor});
        } else
        {
            $('#error').show();
        }

    });

    function Eliminar(i, dni) {

        document.getElementsByTagName("table")[0].setAttribute("id", "tableid");
        if ($('#categorias').val().trim() === '') {
            $('#error').show();
        } else {
            if (confirm('¿Estas seguro de Agregar el deportista: ' + dni+ '?')) {
                var dataString = 'id=' + dni;
                $.ajax({
                    type: "GET",
                    url: "<?= Url::toRoute(["deportista/agregar"]) ?>",
                    data: dataString
                });
                document.getElementById("tableid").deleteRow(i);
            }
        }
    }


</script>