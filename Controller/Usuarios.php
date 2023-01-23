<?php

include_once dirname(__DIR__)."/Model/Usuarios.php";

$objUsuarios = new Model\Usuarios();

// cadastrar usuarios
if (isset($_POST['acao']) && $_POST['acao'] == 'cadastrarUser') {
    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
    $postograd = strip_tags(filter_input(INPUT_POST, 'postograd'));
    $passwd = strip_tags(filter_input(INPUT_POST, 'passwd'));
    $passwd_r = strip_tags(filter_input(INPUT_POST, 'passwd_r'));
    $perfil = strip_tags(filter_input(INPUT_POST, 'perfil'));
    $id_secao = strip_tags(filter_input(INPUT_POST, 'id_secao'));
    $created_at = date('Y-m-d H:i:s');
    $created_by = $_SESSION['scd_user'];
    
    // verifica se existem dados vazios
    if($nome == "" || $passwd == "" || $perfil == "" || $passwd_r == "") {
        echo "<script>alert('Não pode existir dados vazios. Tente novamente...');</script>";
        return;
    }

    // proibe posto ou graduação para os clientes. o cadastro tem que ser por seção
    if($postograd == "" && $perfil != 3) {
     echo "<script>alert('O perfil Admin/Suporte necessita de Posto/Graduação. Tente novamente...');</script>";
     return;
    }
    // admin/suporte podem ter posto graduação
    if($postograd != "" && $perfil == 3) {
        echo "<script>alert('O cliente não pode ter posto ou graduação. Tente novamente...');</script>";
        return;
    }    

    if(strlen($passwd) < 6) {
        echo "<script>alert('A senha deve ter no mínimo 6 caracteres. Tente novamente......');</script>";
        return;
    }
    
    // confirma se as senhas são iguais
    if ($passwd != $passwd_r) {
        echo "<script>alert('As senhas não podem ser diferentes. Tente novamente...');</script>";
        return;
    }

    if($_SESSION['scd_perfil'] != 1) { //suporte não cadastra admin

        if($perfil == 1) {
            echo "<script>alert('Erro...Seu perfil não permite cadastrar administradores...');</script>";
            return;
        }
    }

    $passwd  = password_hash($passwd, PASSWORD_DEFAULT, ['cost' => 12]);
    $dados = array($nome, $postograd, $passwd, $perfil, $created_at, $created_by);
    
    if ($objUsuarios->cadUsuarios($dados, $id_secao)) { //método cadastra usuários

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));
        
        echo "<script>alert('Usuário cadastrado com sucesso');location.href='?p=usuarios';</script>";
        return;

    } else {

        // echo "<script>alert('Este usuário já está cadastrado em nosso sistema..Tente novamente');</script>";
        return; 
    }
}
// ==================================================================
// editar usuarios
if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    
    if ($_REQUEST['hash'] != $_SESSION['_token']) {
            die("Fail");
        }
        
    $nome = strip_tags(filter_input(INPUT_POST, 'nome'));
    $postograd = strip_tags(filter_input(INPUT_POST, 'postograd'));
    $perfil = strip_tags(filter_input(INPUT_POST, 'perfil'));
    $secao = strip_tags(filter_input(INPUT_POST, 'secao'));
    $id_secao = strip_tags(filter_input(INPUT_POST, 'id_secao'));
    $updated_at = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['scd_user'];
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
        
        // // verifica se existem dados vazios
        if($nome == "" || $perfil == "") {
            echo "<script>alert('Não pode existir dados vazios. Tente novamente...');</script>";
            return;
        }
        
        // // proibe posto ou graduação para os clientes. o cadastro tem que ser por seção
        if($postograd == "" && $perfil != 3) {
        echo "<script>alert('O perfil Admin/Suporte necessita de Posto/Graduação. Tente novamente...');</script>";
        return;
        }
        // cliente nao tem posto/graduacao
        if($postograd != "" && $perfil == 3) {
            echo "<script>alert('O cliente não pode ter posto ou graduação. Tente novamente...');</script>";
            return;
        }
                
        if($_SESSION['scd_perfil'] != 1) { //suporte não cadastra admin
            
        if($perfil == 1) {
                echo "<script>alert('Erro...Seu perfil não permite cadastrar administradores...');</script>";
                return;
            }
        }
        
    $dados = array($nome, $postograd, $perfil, $updated_at, $updated_by, $cd);
    // // var_dump($dados); exit;

    if ($objUsuarios->editUsuario($dados)) { //método edita usuários

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));

        echo "<script>alert('Usuário editado com sucesso');location.href='?p=usuarios';</script>";
        return;
    } else {
        echo "<script>alert('Este usuário já está cadastrado em nosso sistema...Tente novamente');</script>";
        return;
    }
}
// ==================================================================
// excluir usuario
// var_dump($_POST);
if (isset($_POST['acao']) && $_POST['acao'] == 'excluirUser') {
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
    var_dump($cd);
    if ($objUsuarios->delUsuario($cd)) {
        echo "<script>alert('Usuário excluído com sucesso');location.href='?p=usuarios';</script>";
        // echo "true";

    } else {
        echo "<script>alert('Erro ao excluir...Este usuário tem chamado cadastrado...impossível excluir...contacte o administrador');</script>";
    }
}
// ==========================================
//trocar senha
if (isset($_POST['acao']) && $_POST['acao'] == 'trocarSenha') {

    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $senha = strip_tags(filter_input(INPUT_POST, 'senha'));
    $r_senha = strip_tags(filter_input(INPUT_POST, 'r_senha'));
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));
    // var_dump($_POST); exit;
    if(strlen($senha) < 6) {
        echo "<div class='alert alert-danger' role='alert' style='text-align:center'>
                   A senha deve ter no mínimo 6 caracteres. Tente novamente...
              </div>";
        return;
    }

    if ($senha == "" || $r_senha == "") {
        echo "<div class='alert alert-danger' role='alert' style='text-align:center'>
                    As senhas não podem ser vazias
              </div>";
        return;
    }

    if ($senha != $r_senha) {
        echo "<div class='alert alert-danger' role='alert' style='text-align:center'>
                    Erro... As senhas devem ser iguais!!!
              </div>";
        return;
    }

    $senha  = password_hash($senha, PASSWORD_DEFAULT, ['cost' => 12]);
    $dados = array($senha, $cd);

    if ($objUsuarios->trocaSenha($dados)) { //método troca senha
        $_SESSION['_token'] = hash('sha512', rand(100, 1000));

        echo "<script>alert('Senha alterada com sucesso');location.href='?p=usuarios';</script>";
        return;
    } else {
        echo "<script>alert('Erro ao trocar senha...Tente novamente');</script>";
    }
}

