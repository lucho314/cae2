<?php
namespace app\models;
class Validar{
    public static function num_positivo($id){
        if(preg_match('/^[0-9]$|^[0-9]+[0-9]$/', $id)){
            return true;
        }
        return false;
    }
}
