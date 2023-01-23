<?php

include_once dirname(__DIR__)."/Model/Materiais.php";

$objMateriais = new Model\Materiais();

// cadastrar Materiais
if (isset($_POST['acao']) && $_POST['acao'] == 'cadMat') {
    echo "<script>alert('teste!!!);</script>";

    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $material = strip_tags(filter_input(INPUT_POST, 'material'));
    $created_at = date('Y-m-d H:i:s');
    $created_by = $_SESSION['scd_user'];

    $dados = array($material, $created_at, $created_by);
    
    if ($material == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!);</script>";
        return;
    }

    // if (!$objMateriais->verifyMaterial($material)) {
    //     echo "<script>alert('Este material já está cadastrado em nosso sistema..Tente novamente');</script>";
    //     return;
    // }
    
    if ($objMateriais->cadMaterial($dados)) { //método cadastra

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));
        
        echo "<script>alert('Material cadastrado com sucesso');location.href='?p=materiais';</script>";
        return;

    } else {

        echo "<script>alert('Este material já está cadastrado em nosso sistema...Tente novamente');</script>";
        return; 
    }
}
// =====================================================================
// editar Materiais
if (isset($_POST['acao']) && $_POST['acao'] == 'editarMaterial') {
    
    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $material = strip_tags(filter_input(INPUT_POST, 'material'));
    $updated_at = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['scd_user'];
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));

    $dados = array($material, $updated_at, $updated_by, $cd);
    // var_dump($dados); exit;

    if ($material == "") {
        echo "<script>alert('Os dados não podem ser vazios...Tente novamente!!!);</script>";
        return;
    }

    // if (!$objMateriais->verifyMaterialEdit($material)) {
    //     echo "<script>alert('Este material já está cadastrado em nosso sistema..Tente novamente');</script>";
    //     return;
    // }

    if ($objMateriais->editMaterial($dados)) { //método editar

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));

        echo "<script>alert('Material editado com sucesso');location.href='?p=materiais';</script>";
        return;
    } else {
        echo "<script>alert('Este material já está cadastrado em nosso sistema...Tente novamente');</script>";
    }
}
// ==============================================
// excluir material
if (isset($_POST['acao']) && $_POST['acao'] == 'excluirMaterial') {
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
    
    if ($objMateriais->delMaterial($cd)) {
        echo "<script>alert('Material excluído com sucesso');location.href='?p=materiais';</script>";

    } else {
        echo "<script>alert('Erro ao excluir...Este material possui item de estoque atrelado...Impossível excluir');</script>";
    }
}
// =========================================================
// if (isset($_POST['acao']) && $_POST['acao'] == 'trocar') {

//     if ($_REQUEST['hash'] != $_SESSION['_token']) {
//         die("Fail");
//     }

//     $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
//     $senha = strip_tags(filter_input(INPUT_POST, 'senha'));
//     $r_senha = strip_tags(filter_input(INPUT_POST, 'r_senha'));


//     if ($senha == "" || $r_senha == "") {
//         echo "<div class='alert alert-danger' role='alert' style='text-align:center'>
//                     As senhas não podem ser vazias
//               </div>";
//         return;
//     }

//     if ($senha != $r_senha) {
//         echo "<div class='alert alert-danger' role='alert' style='text-align:center'>
//                     Erro... As senhas devem ser iguais!!!
//               </div>";
//         return;
//     }

//     $senha  = password_hash($senha, PASSWORD_DEFAULT, ['cost' => 12]);
//     $dados = array($senha, $cd);

//     if ($objMateriais->trocaSenha($dados)) { //método troca senha
//         $_SESSION['_token'] = hash('sha512', rand(100, 1000));

//         echo "<script>alert('Senha alterada com sucesso');location.href='?p=Materiais-total';</script>";
//         return;
//     } else {
//         echo "<script>alert('Erro ao trocar senha...Tente novamente');</script>";
//     }
// }

