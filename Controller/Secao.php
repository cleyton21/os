<?php

include_once dirname(__DIR__)."/Model/Secao.php";

$objSecao = new Model\Secao();

// cadastrar Seção
if (isset($_POST['acao']) && $_POST['acao'] == 'cadSecao') {

    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }   

    $secao = strip_tags(filter_input(INPUT_POST, 'secao'));
    $created_at = date('Y-m-d H:i:s');
    $created_by = $_SESSION['scd_user'];

    $dados = array($secao, $created_at, $created_by);
    if($secao == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!);</script>";
        return;
    }   

    if (!$objSecao->verifySecao($secao)) {
        echo "<script>alert('Esta Seção já está cadastrada em nosso sistema..Tente novamente');</script>";
        return;
    }

    if ($objSecao->cadSecao($dados)) { //método cadastra

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));        
        echo "<script>alert('Seção cadastrada com sucesso');location.href='?p=secao';</script>";
        return;

    } else {

        echo "<script>alert('Esta seção já está cadastrada em nosso sistema...Tente novamente');</script>";
        return; 
    }
}
// =====================================================================
// editar seção
if (isset($_POST['acao']) && $_POST['acao'] == 'editSecao') {
    
    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $secao = strip_tags(filter_input(INPUT_POST, 'secao'));
    $updated_at = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['scd_user'];
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));

    $dados = array($secao, $updated_at, $updated_by, $cd);
    // var_dump($dados); exit;
    if($secao == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!);</script>";
        return;
    }   

    // if (!$objSecao->verifySecaoEdit($secao)) {
    //     echo "<script>alert('Esta Seção já está cadastrada em nosso sistema..Tente novamente');</script>";
    //     return;
    // }

    if ($objSecao->editSecao($dados)) { //método editar

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));

        echo "<script>alert('Seção editada com sucesso');location.href='?p=secao';</script>";
        return;
    } else {
        echo "<script>alert('Esta seção já está cadastrada em nosso sistema...Tente novamente');</script>";
    }
}
// ==============================================
// excluir seção
if (isset($_POST['acao']) && $_POST['acao'] == 'excluirSecao') {
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
    
    if ($objSecao->delSecao($cd)) {
        // echo "<script>alert('Seção excluída com sucesso...');location.href='?p=secao';</script>";
    } else {
        echo "<script>alert('Erro ao excluir...Esta seção tem equipamentos atrelados...impossível excluir');</script>";
    }
}
// =========================================================


