<?php
include_once dirname(__DIR__)."/Model/Login.php";

$log = new Model\Login();              

if (isset($_POST['acao']) && $_POST['acao'] == 'logar') {
    $user = strip_tags(filter_input(INPUT_POST, 'user'));
    $passwd = strip_tags(filter_input(INPUT_POST, 'passwd'));
    $lem_senha = strip_tags(filter_input(INPUT_POST, 'lem_senha'));
    
    if ($user == '' || $passwd == '') {                                            
        echo '<div style="text-align: center"; class="p-3 mb-2 bg-danger text-white">Usuário e/ou senha não podem ser vazios!</div>';
        return;
    }

    if ($log->logar($user, $passwd, $lem_senha)) {

    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=admin.php">';
    } else{
        echo '<div style="text-align: center"; class="p-3 mb-2 bg-danger text-white">Usuário e/ou senha incorretos...tente novamente</div>';
    }
}

?>