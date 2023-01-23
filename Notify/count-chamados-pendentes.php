<?php
namespace Model;
session_start();

include_once "../Model/DB.php";

include '../function/function.php';

class countChamadosPendentes extends DB{
    public function __construct()
    {
        $sql = "SELECT status FROM chamados WHERE status != 'Resolvido'
    ";

    $b = DB::conn()->query($sql);

    $c = count($b->fetchAll(\PDO::FETCH_OBJ));
    if($c >= 0){
        echo $c;
    }else{
        
    }
}
}
$objcountChamadosPendentes = new countChamadosPendentes();

?>