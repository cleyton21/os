<?php

namespace Model;
include_once "../Model/DB.php";

class countResolvidosHoje extends DB{
    public function __construct()
    {
        $sql = "SELECT status FROM chamados WHERE status = 'Resolvido' AND DATE(updated_at) = CURDATE();
    ";

    $b = DB::conn()->query($sql);

    $c = count($b->fetchAll(\PDO::FETCH_OBJ));
    if($c >= 0){
        echo $c;
    }else{
        
    }
}
}

$objcountResolvidosHoje = new countResolvidosHoje();

?>