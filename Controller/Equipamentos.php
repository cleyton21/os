<?php

include_once dirname(__DIR__)."/Model/Equipamentos.php";

$objEquipamento = new Model\Equipamentos();

// cadastrar Equipamento
if (isset($_POST['acao']) && $_POST['acao'] == 'cadEquipamento') {

    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }   
   
    $secao = strip_tags(filter_input(INPUT_POST, 'secao'));
    $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
    $equipamento = strip_tags(filter_input(INPUT_POST, 'equipamento'));
    $created_at = date('Y-m-d H:i:s');
    $created_by = $_SESSION['scd_user'];
    
    if($secao == "" || $nome == "" || $equipamento == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!');</script>";
        return;
    }   

    $dados = array($secao, $nome, $equipamento, $created_at, $created_by);

    if ($objEquipamento->cadEquipamento($dados)) { //método cadastra

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));        
        echo "<script>alert('Equipamento cadastrado com sucesso');location.href='?p=equipamentos';</script>";
        return;

    } else {
           echo "<script>alert('Este equipamento já está cadastrado em nosso sistema..Tente novamente');</script>";
        return; 
    }
}
// =====================================================================
// editar equipamento
if (isset($_POST['acao']) && $_POST['acao'] == 'editEquipamento') {
    
    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $secao = strip_tags(filter_input(INPUT_POST, 'secao'));
    $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
    $equipamento = strip_tags(filter_input(INPUT_POST, 'equipamento'));
    $updated_at = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['scd_user'];
    
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));

    $dados = array($secao, $nome, $equipamento, $updated_at, $updated_by, $cd);
    // var_dump($dados[4]); exit;
    if($secao == "" || $nome == "" || $equipamento == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!);</script>";
        return;
    }   

    // if ($objEquipamento->verifyEquipamentoEdit($nome)) {
    //     echo "<script>alert('Este equipamento já está cadastrado em nosso sistema..Tente novamente');</script>";
    //     return;
    // }

    if ($objEquipamento->editEquipamento($dados)) { //método editar

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));

        echo "<script>alert('Equipamento editado com sucesso');location.href='?p=equipamentos';</script>";
        return;
    } else {
       echo "<script>alert('Este equipamento já está cadastrado em nosso sistema..Tente novamente');</script>";
    }
}
// ==============================================
// excluir equipamento
if (isset($_POST['acao']) && $_POST['acao'] == 'excluirEquipamento') {
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
    
    if ($objEquipamento->delEquipamento($cd)) {
        echo "<script>alert('Equipamento excluído com sucesso');location.href='?p=equipamentos';</script>";
    } else {
        echo "<script>alert('Erro ao excluir...Este equipamento está associado a um chamado...Impossível excluir');</script>";
    }
}
// =========================================================


