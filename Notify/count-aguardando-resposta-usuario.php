<?php
namespace Model;
session_start();

include_once "../Model/DB.php";

include '../function/function.php';

class countAguardandoRespostaUsuario extends DB{
    public function __construct()
    {
        $sql = "SELECT status FROM chamados WHERE status = 'Aguardando resposta do usuário'
        ";
        
        $b = DB::conn()->query($sql);
        
        $c = count($b->fetchAll(\PDO::FETCH_OBJ));
        if($c >= 0){
            echo $c;
        }else{
            
        }
        
    }
}
$objcountAguardandoRespostaUsuario = new countAguardandoRespostaUsuario();

?>