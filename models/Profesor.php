<?php

namespace app\models;

/**
 * This is the model class for table "profesor".
 *
 * @property integer $dni
 *
 * @property Categoria[] $categorias
 * @property Categoria[] $categorias0
 * @property Evento[] $eventos
 * @property Evento[] $eventos0
 * @property Persona $dni0
 * @property ProfesorDeporte[] $profesorDeportes
 * @property Deporte[] $idDeportes
 */
class Profesor extends \app\models\Usuario {

    /**
     * @inheritdoc
     */
    public $deportes;
    public $email;

    public static function tableName() {
        return 'profesor';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return ['deportes', 'required'];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'dni' => 'DNI',
        ];
    }

    public static function lista_prof_por_deporte() {
        if (($id = SubComision::mi_id_deporte()) != null) {
            return Profesor::find()->select("nombre,apellido,telefono,email")
                            ->from("persona,profesor_deporte")
                            ->where("persona.dni=profesor_deporte.dni")
                            ->andWhere(["profesor_deporte.id_deporte" => $id]);
        }
        return null;
    }

}
