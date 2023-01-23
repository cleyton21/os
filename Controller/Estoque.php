<?php

include_once dirname(__DIR__)."/Model/Estoque.php";

$objEstoque = new Model\Estoque();

// cadastrar Estoque
if (isset($_POST['acao']) && $_POST['acao'] == 'cadEstoque') {

    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }   

    $material = strip_tags(filter_input(INPUT_POST, 'material'));
    $descricao = strip_tags(filter_input(INPUT_POST, 'descricao'));
    $qtd = strip_tags(filter_input(INPUT_POST, 'qtd'));
    $created_at = date('Y-m-d H:i:s');
    $created_by = $_SESSION['scd_user'];

    $dados = array($material, $descricao, $qtd, $created_at, $created_by);
    
    if($material == "" || $qtd == "" || $descricao == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!);</script>";
        return;
    }   

    if($qtd < 1 || $qtd > 10) {
        echo "<script>alert('A quantidade tem que ser entre 1 e 10...Tente novamente!!!);</script>";
        return;
    }  

    if ($objEstoque->cadEstoque($dados, $qtdUnit = 1)) { //método cadastra

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));
        
        echo "<script>alert('Estoque cadastrado com sucesso');location.href='?p=estoque';</script>";
        return;

    } else {

        echo "<script>alert('Erro ao cadastrar');</script>";
        return; 
    }
}
// =====================================================================
// editar estoque
if (isset($_POST['acao']) && $_POST['acao'] == 'editEstoque') {
    
    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $material = strip_tags(filter_input(INPUT_POST, 'material'));
    $descricao = strip_tags(filter_input(INPUT_POST, 'descricao'));
    $updated_at = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['scd_user'];
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));

    $dados = array($material, $descricao, $updated_at, $updated_by, $cd);
    // var_dump($dados); exit;
    if($material == "" || $descricao == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!);</script>";
        return;
    }   

    if ($objEstoque->editEstoque($dados)) { //método editar

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));

        echo "<script>alert('Estoque editado com sucesso');location.href='?p=estoque';</script>";
        return;
    } else {
        echo "<script>alert('Erro ao editar');</script>";
    }
}
// ==============================================
// excluir estoque
if (isset($_POST['acao']) && $_POST['acao'] == 'excluirEstoque') {
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
    
    if ($objEstoque->delEstoque($cd)) {
        // echo "<script>alert('Usuário excluído com sucesso');location.href='?p=Materiais';</script>";
        echo "true";

    } else {
        echo "<script>alert('Erro ao excluir');</script>";
    }
}
// =========================================================


