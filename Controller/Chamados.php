<?php

include_once dirname(__DIR__)."/Model/Chamados.php";

$objChamados = new Model\Chamados();

// cadastrar tickets
if (isset($_POST['acao']) && $_POST['acao'] == 'cadChamados') {

    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    $numberTicket = date('Ymd');
    $soma = '01';
    // verifica se já existe numberTicket cadastrado para o dia atual
    if ($objChamados->gerarTicket($numberTicket) > 0) { 
        $numberTicket = $objChamados->gerarTicket($numberTicket)->ticket+1; //se ja existir, ele incrementa + 1
        // echo $numberTicket; exit;
    } else { //se nao tiver numberTicket, cria um no formato ano mes dia e numero de vezes no dia
        $numberTicket = $numberTicket.$soma;
    }

    $ticket = strval($numberTicket); //trocar int por string

    $id_user = $_SESSION['scd_iduser']; //usuario logado que abriu o chamado

    $id_incidente = strip_tags(filter_input(INPUT_POST, 'id_incidente'));

    $open_by = strip_tags(filter_input(INPUT_POST, 'open_by'));

    $prioridade = strip_tags(filter_input(INPUT_POST, 'prioridade'));
    $descricao = strip_tags(filter_input(INPUT_POST, 'descricao'));
    $alert = 1;
    $postograd = strip_tags(filter_input(INPUT_POST, 'postograd')); //usado para alimentar solicitante
    $nome_guerra = strip_tags(filter_input(INPUT_POST, 'nome_guerra')); // usado para alimentar solicitante
    $solicitante = $postograd." ".$nome_guerra;
    $status = "Aberto";
    $ip = strip_tags(filter_input(INPUT_POST, 'ip'));
    $created_at = date('Y-m-d H:i:s');
    $created_by = $_SESSION['scd_user'];

    if($open_by != ""){ //admin/suporte abrir chamado como cliente
        $id_user = $open_by;
        // $open_by = $_SESSION['scd_iduser'];
    }else{
        $id_user = $_SESSION['scd_iduser'];
        // $open_by = "";
    }


    if ($_FILES['foto'] != "") //se existir um arquivo para upload
    {
        define('TAMANHO_MAXIMO', (1024 * 1024 * 100)); //5Mb
    
        // Recupera os dados dos campos
        $foto = $_FILES['foto'];
        $nome = $foto['name'];
        $tipo = $foto['type'];
        $tamanho = $foto['size'];

        // Validações básicas
        // Formato
        if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $tipo))
        {
            echo "<script>alert('Isso não é uma imagem válida...');</script>";
            return;
        }
        // Tamanho
        if ($tamanho > TAMANHO_MAXIMO)
        {
            echo "<script>alert('A imagem deve possuir no máximo 5 MB...');</script>";
            return;
        }
        // Transformando foto em dados (binário)
        $conteudo = file_get_contents($foto['tmp_name']);

    } else {// fim da verificação da existencia de arquivos
        $nome = "";
        $conteudo = "";
        $tipo = "";
        $tamanho = null;
    } //fim do else

    // verifica se existem dados vazios
    if($ticket == "" || $id_user == "" || $id_incidente == "" || $prioridade == "" || $descricao == "" || $solicitante == "" || $ip == "" || $created_at == "" || $created_by == "") {
        echo "<script>alert('Não pode existir dados vazios. Tente novamente...');</script>";
        return;
    }

    if($open_by == "" && $_SESSION['scd_perfil'] != 3) { //admin/suporte so pode abrir chamado para uma seção
        echo "<script>alert('Não é possível abrir chamado como admin e/ou suporte. Tente com outro usuário...');</script>";
        return;
    }
    // var_dump($ip);exit;
    $dados = array($ticket, $id_user, $id_incidente, $prioridade, $descricao, $nome, $conteudo, $tipo, $tamanho, $alert, $solicitante, $status, $ip, $created_at, $created_by);
    
    if ($objChamados->cadChamados($dados)) { //método cadastra chamados

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));
        
        if($_SESSION['scd_perfil'] == 3){
            echo "<script>alert('Ticket cadastrado com sucesso');location.href='?p=chamados-usuario';</script>";
            return;
        }else{
            echo "<script>alert('Ticket cadastrado com sucesso');location.href='?p=chamados';</script>";
            return;
        }

    } else {
        echo "<script>alert('Erro ao cadastrar...Tente novamente');</script>";
        return; 
    }
}
//==============================================================================
// editar ticket
if (isset($_POST['acao']) && $_POST['acao'] == 'editChamado') {
    
    if ($_REQUEST['hash'] != $_SESSION['_token']) {
        die("Fail");
    }

    // var_dump($_POST); exit;
    $mensagem = strip_tags(filter_input(INPUT_POST, 'mensagem'));
    $mensagem_privada = strip_tags(filter_input(INPUT_POST, 'mensagem_privada'));
    $status = strip_tags(filter_input(INPUT_POST, 'status'));
    $tecnico = strip_tags(filter_input(INPUT_POST, 'tecnico'));
    $equipamento = strip_tags(filter_input(INPUT_POST, 'equipamento'));
    $id_equipamento = strip_tags(filter_input(INPUT_POST, 'id_equipamento'));
    ($id_equipamento == "" ? $id_equipamento = null : $id_equipamento);
    $id_estoque = strip_tags(filter_input(INPUT_POST, 'id_estoque'));
    ($id_estoque == "" ? $id_estoque = null : $id_estoque);
    $updated_at = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['scd_user'];
    $cd = strip_tags(filter_input(INPUT_POST, 'cd'));


    if ($_FILES['foto'] != "") //se existir um arquivo para upload
    {
        define('TAMANHO_MAXIMO', (1024 * 1024 * 100)); //5Mb
    
        // Recupera os dados dos campos
        $foto = $_FILES['foto'];
        $nome = $foto['name'];
        $tipo = $foto['type'];
        $tamanho = $foto['size'];

        // Validações básicas
        // Formato
        if(!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/', $tipo))
        {
            echo "<script>alert('Isso não é uma imagem válida...');</script>";
            return;
        }
        // Tamanho
        if ($tamanho > TAMANHO_MAXIMO)
        {
            echo "<script>alert('A imagem deve possuir no máximo 5 MB...');</script>";
            return;
        }
        // Transformando foto em dados (binário)
        $conteudo = file_get_contents($foto['tmp_name']);

    } else {// fim da verificação da existencia de arquivos
        $nome = "";
        $conteudo = "";
        $tipo = "";
        $tamanho = null;
    } //fim do else

     // verifica se foi digitados nos dois campos msgn
     if($mensagem != "" && $mensagem_privada != ""){ //impedir digitar nos dois campos de mensagem
        echo "<script>alert('Digite apenas na mensagem púbica ou privada...');</script>";
        return;
    }

    if($mensagem_privada != "") { 
        $mensagem = $mensagem_privada;
        $privacidade = 1;
    }else{
        $mensagem = $mensagem;
        $privacidade = 0;
    }

    if($_SESSION['scd_perfil'] != 3) { //condicao para admin/suporte
        if(($mensagem == "" && $mensagem_privada == "") || $status == "" || $tecnico == "") {
            echo "<script>alert('Preencha os dados obrigatórios...');</script>";
            return;
        }
    }else { //condição para cliente
        if($mensagem == "") {
            echo "<script>alert('Preencha os dados obrigatórios...');</script>";
            return;
        }
    }   

    if($status == "Aberto"){
        echo "<script>alert('Altere o status ...Aberto... do chamado');</script>";
        return;
    }

    if($id_estoque != "" && $id_equipamento == ""){ //obriga escolher um equipamento caso tenha uso de material do estoque
        echo "<script>alert('Escolha o equipamento onde o material será usado...');</script>";
        return;
    }

    if($equipamento == 1 && $id_equipamento == "" && $status == 'Resolvido'){
        echo "<script>alert('Para este incidente, é necessário atrelar um equipamento...');</script>";
        return;
    }

    if($status != "Resolvido" && $id_equipamento != ""){ 
        echo "<script>alert('Encerre o chamado para atrelar um equipamento......');</script>";
        return;
    }

    if($id_estoque != "" && $id_equipamento != "" && $status != 'Resolvido'){
        echo "<script>alert('Encerre o chamado para usar um item de estoque...');</script>";
        return;
    }   
  

    if($id_estoque != "" && $status != 'Resolvido'){
        echo "<script>alert('Para usar um material, você deve encerrar o chamado...');</script>";
        return;
    }

    $dadosChamado = array($status, $tecnico, $id_equipamento, $id_estoque, $updated_at, $updated_by, $cd);
    $dadosChamadoCliente = array($updated_at, $updated_by, $cd); //array de dados caso o cliente
  
    if($_SESSION['scd_perfil'] != 3){ //edição para admin/suporte
    $alertsm = 2; //indica que tem msgn para o cliente
    $dadosSuporte = array($cd, $alertsm, $mensagem, $nome, $conteudo, $tipo, $tamanho, $privacidade, $updated_at, $updated_by);
    if ($objChamados->editChamado($dadosChamado, $dadosSuporte)) { //método edita chamados para admin/suporte

        $_SESSION['_token'] = hash('sha512', rand(100, 1000));

        if($status == "Resolvido"){
            echo "<script>alert('Chamado encerrado com sucesso!!!');location.href='?p=chamados';</script>";
            return;
        }
        
        echo "<script>alert('Chamado editado com sucesso!!!');location.href='?p=chamados-editar&cd=".$cd."';</script>";

    } else {
        echo "<script>alert('Erro ao alterar...Tente novamente');</script>";
    }

    } else { //fim do if edição para admin/suporte
        $alertsm = 1; //indica que tem msgn para admin/suporte
        $dadosSuporte = array($cd, $alertsm, $mensagem, $privacidade, $updated_at, $updated_by);
        if ($objChamados->editChamadoUsuario($dadosChamadoCliente, $dadosSuporte)) { //método edita chamados para cliente
            
            $_SESSION['_token'] = hash('sha512', rand(100, 1000));
            echo "<script>alert('Mensagem gravada com sucesso!!!');location.href='?p=chamados-editar&cd=".$cd."';</script>";
            return;        

    } else {
        echo "<script>alert('Erro ao alterar...Tente novamente');</script>";
    }
    }



} //fim do botao editar
