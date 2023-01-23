<?php
namespace Model;
session_start();
include_once "../Model/DB.php";

include '../function/function.php';

class countNewMessages extends DB{
    public function __construct()
    {
    $sql = "SELECT user.user, suporte_chamados.* FROM suporte_chamados
    INNER JOIN chamados
    ON chamados.id_chamado = suporte_chamados.id_chamado
    INNER JOIN user
    ON user.id_user = chamados.id_user";

    ($_SESSION['scd_perfil'] != 3 ? $sql.= " WHERE alertsm = 1" : "");

    // condição para caso seja cliente, usar a session
    ($_SESSION['scd_perfil'] == 3 ? $sql.= " WHERE privacidade = 0 AND '{$_SESSION['scd_user']}' = user AND alertsm = 2" : "");

    $sql.= " ORDER BY updated_at DESC
    ";

    $b = DB::conn()->query($sql);

    $c = count($b->fetchAll(\PDO::FETCH_OBJ));
    if($c > 0){
        echo $c, '+';
    }else{
        
    }
        }
}
$objcountNewMessages = new countNewMessages();


?>