<?php
if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Secao.php";
$objSecao = new Model\Secao();
?>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cadastrar Seção</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=secao">Seçao</a></li>
                        <li class="breadcrumb-item active"><?= str_replace('-', ' ', ucfirst($_GET['p'])); ?></li>
                    </ol>
                </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        
        <!-- Main content -->
        <section class="content" style="margin-bottom:20px;">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Adicionar Seção</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" id="formCadSecao">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="secao">Nome da Seção <small style="color: red;">(*)</small></label>
                                        <input type="text" name="secao" class="form-control"
                                            placeholder="Ex.: Almoxarifado" requiblue="requiblue">
                                        <small style="color: blue;"> 
                                            Cadastrar seções da OM
                                        </small>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" name="acao" value="cadSecao">
                                    <button class="btn btn-primary btn-block" id="cadSecao">
                                    <i class="fas fa-save"></i> Gravar
                                    </button>
                                    <button style="display:none" id="gravandoSecao" class="btn btn-primary btn-md btn-block" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Aguarde...
                                    </button>
                                    <small style="color: red;">(*) Campos obrigatórios</small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</div>
