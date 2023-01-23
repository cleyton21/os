<?php
namespace Model;
include_once "../Model/DB.php";

include '../function/function.php';

class listChamadosNovos extends DB{

    public function __construct()
    { 
    $objData = new \Data();
    
    $sql = "SELECT user.user, incidentes.incidente, chamados.* FROM chamados
    INNER JOIN user
    ON user.id_user = chamados.id_user
    INNER JOIN incidentes
    ON incidentes.id_incidente = chamados.id_incidente
    WHERE alert = 1
    ORDER BY created_at DESC
    LIMIT 10
    ";

    $b = DB::conn()->query($sql);

    $c =  $b->fetchAll(\PDO::FETCH_OBJ);

    foreach ($c as $key => $value) {
        # code...
        echo "<a href='?p=chamados-editar&cd=".$value->id_chamado."' class='dropdown-item d-flex align-items-center'>
        <div>
            <div class='small text-gray-700'>".$value->user." - ".\Data::ExibirTempoDecorrido($value->created_at)."</div>
            <span class='font-weight-bold'>".$value->incidente."</span>
        </div>
        </a>";
        }
    }
}

$objlistChamadosNovos = new listChamadosNovos();
