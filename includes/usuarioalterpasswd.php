<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Usuarios.php";
$objUsuarios = new Model\Usuarios;

if (isset($_GET['cd']) && is_numeric($_GET['cd'])) {
    $cd = (int) $_GET['cd'];
} else {
	echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
}
$dgr = $objUsuarios->pegarUsuarioCd($cd);

// var_dump($_SESSION);

?>

<div id="result"></div>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Trocar senha</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=dashboard">Home</a></li>
                        <li class="breadcrumb-item active"><a href="?p=usuarios">Usuários</a></li>
                        <li class="breadcrumb-item active"><?= ucfirst($_GET['p']); ?></li>
                    </ol>
                </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Área restrita</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" id="formTrocaSenha">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="senha">Nova Senha <small style="color: red;">(*)</small></label>
                                        <input type="password" name="senha" minlength='6' id="senha" class="form-control"
                                            placeholder="Nova senha..." required="required">
                                        <small style="color: red;">Mínimo de 6 caracteres</small>
                                    </div>
                                    
                                    <div class="form-group col-md-6">
                                        <label for="r_senha">Repita a nova senha <small style="color: red;">(*)</small></label>
                                        <input type="password" name="r_senha" minlength='6' id="r_senha" class="form-control"
                                            placeholder="Repita nova senha..." onblur="validarSenha('senha', 'r_senha');" required="required">
                                        <small style="color: red;">Mínimo de 6 caracteres</small>
                                    </div>
                                    </div>
                                    <script>
                                        function validarSenha(senha, r_senha){
                                            var senha = document.getElementById(senha).value();
                                            var r_senha = document.getElementById(r_senha).value();
                                            if(senha != r_senha){
                                                alert('As senhas não conferem..Tente novamente!!!');
                                            }
                                        }
                                    </script>
                                    
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" name="cd" value="<?php echo $dgr->id_user; ?>">
                                    <input type="hidden" name="acao" value="trocarSenha">
                                    <button type="submit" id="btnTrocaSenha" class="btn btn-info btn-block">Resetar</button>
                                    <small style="color: red;">(*) Campos obrigatórios</small>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="result"></div>
                   
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</div>
