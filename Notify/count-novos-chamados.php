<?php

namespace Model;
include_once "../Model/DB.php";

include '../function/function.php';

class countNovosChamados extends DB{
    public function __construct()
    {
        $sql = "SELECT user.user, incidentes.incidente, chamados.* FROM chamados
    INNER JOIN user
    ON user.id_user = chamados.id_user
    INNER JOIN incidentes
    ON incidentes.id_incidente = chamados.id_incidente
    WHERE alert = 1
    ORDER BY created_at DESC
    ";

    $b = DB::conn()->query($sql);

    $c = count($b->fetchAll(\PDO::FETCH_OBJ));
    if($c > 0){
        echo $c, '+';
    }else{
        
    }
        }
    }
$objcountNovosChamados = new countNovosChamados();

?>