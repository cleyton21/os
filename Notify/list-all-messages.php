<?php
namespace Model;
session_start();

include_once "../Model/DB.php";

include '../function/function.php';

class listAllMessages extends DB{
    public function __construct()
    {
        $objData = new \Data();
        
        $sql = "SELECT user.user, suporte_chamados.* FROM suporte_chamados
        INNER JOIN chamados
        ON chamados.id_chamado = suporte_chamados.id_chamado
        INNER JOIN user
        ON user.id_user = chamados.id_user";

        ($_SESSION['scd_perfil'] != 3 ? $sql.= " WHERE alertsm = 1 OR alertsm = 'lido1'" : "");

        // condição para caso seja cliente, usar a session
        ($_SESSION['scd_perfil'] == 3 ? $sql.= " WHERE privacidade = 0 AND '{$_SESSION['scd_user']}' = user AND (alertsm = 2 OR alertsm = 'lido2')" : "");

        $sql.= " ORDER BY updated_at DESC
        LIMIT 10
        ";

        $b = DB::conn()->query($sql);

        $c =  $b->fetchAll(\PDO::FETCH_OBJ);

        foreach ($c as $key => $value) {
            # code...
            echo "<a href='?p=chamados-editar&cd=".$value->id_chamado."' class='dropdown-item d-flex align-items-center'>
            <div class='".(($value->alertsm == 1 || $value->alertsm == 2) ? 'font-weight-bold' : '')."' >
                <div class='text-truncate'>
                    ".$value->mensagem."
                </div>
                <div class='small text-gray-700'>".$value->updated_by." - " .\Data::ExibirTempoDecorrido($value->updated_at). " </div>
            </div>
        </a>";
        }
// echo "<a class='dropdown-item text-center small text-gray-900' href='#'>Ver todas as mensagens</a>";
    }
}

$objListAllMessages = new listAllMessages();

?>