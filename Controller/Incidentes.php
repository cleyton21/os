<?php

include_once dirname(__DIR__)."/Model/Incidentes.php";

$objIncidente = new Model\Incidentes();

// cadastrar incidente
if (isset($_POST['acao']) && $_POST['acao'] == 'cadIncidente') {

    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }   
    // var_dump($_POST);
    $incidente = strip_tags(filter_input(INPUT_POST, 'incidente'));
    $dica = strip_tags(filter_input(INPUT_POST, 'dica'));
    $cor = strip_tags(filter_input(INPUT_POST, 'cor'));
    $created_at = date('Y-m-d H:i:s');
    $created_by = $_SESSION['scd_user'];

    $dados = array($incidente, $dica, $cor, $created_at, $created_by);
    // var_dump($dados);
    if($incidente == "" || $dica == "" || $cor == "") {
        echo "<script>alert('Preencha os dados obrigatórios...Tente novamente!!!');</script>";
        return;
    }   

    if ($objIncidente->cadIncidente($dados)) { //método cadastra

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));        
        echo "<script>alert('Incidente cadastrado com sucesso');location.href='?p=incidentes';</script>";
        return;

    } else {
        echo "<script>alert('Este incidente já está cadastrado em nosso sistema...Tente novamente');</script>";
        return; 
    }
}
// =====================================================================
// editar incidente
if (isset($_POST['acao']) && $_POST['acao'] == 'editIncidente') {
    
    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $incidente = strip_tags(filter_input(INPUT_POST, 'incidente'));
    $dica = strip_tags(filter_input(INPUT_POST, 'dica'));
    $cor = strip_tags(filter_input(INPUT_POST, 'cor'));
    $updated_at = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['scd_user'];
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));

    $dados = array($incidente, $dica, $cor, $updated_at, $updated_by, $cd);
    // var_dump($dados); exit;
    if($incidente == "" || $dica == "" || $cor == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!);</script>";
        return;
    }   

    if ($objIncidente->editIncidente($dados)) { //método editar

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));

        echo "<script>alert('Incidente editado com sucesso');location.href='?p=incidentes';</script>";
        return;
    } else {
        echo "<script>alert('Este incidente já está cadastrado em nosso sistema...Tente novamente');</script>";
    }
}
// ==============================================
// excluir incidente
if (isset($_POST['acao']) && $_POST['acao'] == 'excluirIncidente') {
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
    
    if ($objIncidente->delIncidente($cd)) {
        echo "<script>alert('Incidente excluído com sucesso');location.href='?p=incidentes';</script>";
    } else {
        echo "<script>alert('Erro ao excluir...Este incidente possui um chamado atrelado...Impossível excluir');</script>";
    }
}
// =========================================================
// ip required
if (isset($_POST['name']) && $_POST['name'] == 'ip-required') {

$value = strip_tags(filter_input(INPUT_POST, 'value'));
$cd = strip_tags(filter_input(INPUT_POST, 'cd'));

$dados = array($value, $cd);

if ($objIncidente->editIncidenteIpRequired($dados)) { 

    $_SESSION['_token'] = hash('sha512', rand(100, 1000));

    // echo "<script>alert('Seção editada com sucesso');location.href='?p=incidentes';</script>";
    return;
} else {
    echo "<script>alert('Erro ao alterar...Tente novamente');</script>";
}
}
// =========================================================
// equipamento required
if (isset($_POST['name']) && $_POST['name'] == 'equipamento-required') {

    $value = strip_tags(filter_input(INPUT_POST, 'value'));
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
    
    $dados = array($value, $cd);
    
    if ($objIncidente->editIncidenteEquipamentoRequired($dados)) { 
    
        $_SESSION['_token'] = hash('sha512', rand(100, 1000));
    
        // echo "<script>alert('Seção editada com sucesso');location.href='?p=incidentes';</script>";
        return;
    } else {
        echo "<script>alert('Erro ao alterar...Tente novamente');</script>";
    }
}
// ===========================================================
if (isset($_POST['incidente']) && $_POST['incidente'] == 'incidente') {

    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));

    $linha = $objIncidente->pegarIncidenteCd($cd);
    if($linha->ip == 1){
        return 'disabled';
    } else {
        return;
    }
}


