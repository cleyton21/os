<?php
namespace Model;
session_start();

include_once "../Model/DB.php";

include '../function/function.php';

class countChamadosAbertosHoje extends DB{
 public function __construct()
 {
     $sql = "SELECT created_at FROM chamados WHERE date(created_at) = CURDATE()
     ";
     
     $b = DB::conn()->query($sql);
     
     $c = count($b->fetchAll(\PDO::FETCH_OBJ));
     if($c >= 0){
         echo $c;
     }else{
         
     }
     
 }
}
$objcountChamadosAbertosHoje = new countChamadosAbertosHoje();

?>