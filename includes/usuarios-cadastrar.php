<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Usuarios.php";
include_once "Model/Secao.php";

$objSecao = new Model\Secao();
?>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Adicionar usuários ao sistema</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=usuarios">Usuários</a></li>
                        <li class="breadcrumb-item active"><?= str_replace('-', ' ', ucfirst($_GET['p'])); ?></li>
                    </ol>
                </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div id="result"></div>
        <!-- Main content -->
        <section class="content" style="margin-bottom:20px;">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" id="formCadUsuarios">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-3">
                                        <label for="perfil">Perfil de Acesso <small style="color: red;">(*)</small></label>
                                        <div class="form-group">
                                        <select class="form-control select2" name="perfil" id="perfil" onchange="validarSelect();" required="required" style="width: 100%;">
                                            <option value="" selected="selected">Selecione um perfil de acesso</option>
                                            <option value="1">Nível 1 - Admin</option>
                                            <option value="2">Nível 2 - Suporte</option>
                                            <option value="3">Nível 3 - Cliente</option>
                                        </select>
                                        <small style="color: blue;"> Escolher nível de acesso</small>
                                    </div>
                                    </div>

                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nome">Nome <small style="color: red;">(*)</small></label>
                                        <input type="text" name="nome" id="nome" class="form-control"
                                            placeholder="Ex.: s1" required="required">
                                        <small style="color: blue;"> Cadastrar nome do usuário que será usado no login. Ex.: s1 ou s2 ou almox...</small>
                                    </div>
                                    </div>

                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="postograd">Posto/Grad</label>
                                        <select class="form-control" name="postograd" id="postograd" style="width: 100%;">
                                            <option value="" selected="selected">Selecione um Posto/Grad</option>
                                            <option value="Gen Ex">Gen Ex</option>
                                            <option value="Gen Div">Gen Div</option>
                                            <option value="Gen Bgda">Gen Bgda</option>
                                            <option value="Cel">Cel</option>
                                            <option value="Ten Cel">Ten Cel</option>
                                            <option value="Maj">Maj</option>
                                            <option value="Cap">Cap</option>
                                            <option value="1º Ten">1º Ten</option>
                                            <option value="2º Ten">2º Ten</option>
                                            <option value="Asp">Asp</option>
                                            <option value="ST">ST</option>
                                            <option value="1º Sgt">1º Sgt</option>
                                            <option value="2º Sgt">2º Sgt</option>
                                            <option value="3º Sgt">3º Sgt</option>
                                            <option value="Cb">Cb</option>
                                            <option value="Sd EP">Sd EP</option>
                                            <option value="Sd EV">Sd EV</option>
                                        </select>
                                        <small style="color: blue;"> Somente para admin/suporte</small>
                                    </div>
                                    </div>

                                    
                                    <div class="col-md-3">
                                    <div class="form-group">
                            
                                        <?php $listar = $objSecao->listarSecao(); ?>

                                        <label for="secao">Seção</label>
                                        <select class="form-control select2" name="id_secao" id="secao" style="width: 100%;">
                                            <option value="" selected="selected">Selecione a seção do usuário</option>
                                            <?php foreach ($listar as $linha) { ?>
                                            <option value="<?= $linha->id_secao;?>"><?= $linha->secao ?></option>
                                            <?php } ?>
                                        </select>
                                        <small style="color: blue;"> Somente para o perfil Nível 3 - Clientes</small>
                                    </div>
                                    </div>
                                    <script>
                                        function validarSelect(){
                                        var perfil = document.getElementById('perfil').value;
                                        var secao = document.getElementById('secao');
                                        var postograd = document.getElementById('postograd');
                                        if(perfil != 3){
                                            document.getElementById('secao').disabled = true;
                                            document.getElementById('postograd').disabled = false;
                                        }else {
                                            document.getElementById('secao').disabled = false;
                                            document.getElementById('postograd').disabled = true;
                                        }
                                        }
                                    </script>
                                    
                                    </div>
                                  
                                    <div class="row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password">Senha <small style="color: red;">(*)</small></label>
                                        <input type="password" id="passwd" name="passwd" class="form-control" placeholder="Senha" required="required">
                                        <small style="color: blue;"> Mínimo 6 caracteres</small>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_r">Confirmar Senha <small style="color: red;">(*)</small></label>
                                        <input type="password" id="passwd_r" name="passwd_r" class="form-control"
                                            placeholder="Repita a senha" required="required">
                                        <small style="color: blue;"> Mínimo 6 caracteres</small>
                                    </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" name="acao" value="cadastrarUser">
                                    <button id="btnCadUsuarios" class="btn btn-primary btn-block">
                                        <i class="fas fa-save"></i> Gravar
                                    </button>
                                    <button style="display:none" id="gravandoUser" class="btn btn-primary btn-md btn-block" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Aguarde...
                                    </button>
                                    <small style="color: red;">(*) Campos obrigatórios</small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>