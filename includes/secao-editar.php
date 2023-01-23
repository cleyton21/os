<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Secao.php";

if (isset($_GET['cd']) && is_numeric($_GET['cd'])) {
    $cd = (int) $_GET['cd'];
    } else {
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
}

$objSecao = new Model\Secao();

$dgr = $objSecao->pegarSecaoCd($cd);    

?>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar Seção</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=secao">Seção</a></li>
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
                                <h3 class="card-title">Editar Seção</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" id="formEditSecao">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="secao">Seção <small style="color: red;">(*)</small></label>
                                        <input type="text" name="secao" value="<?= $dgr->secao; ?>" class="form-control"
                                            placeholder="" requiblue="requiblue">
                                        <small style="color: blue;"> 
                                            Editar seção da OM
                                        </small>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" value="<?php echo $dgr->id_secao; ?>" name="cd">
                                    <input type="hidden" name="acao" value="editSecao">
                                    <button class="btn btn-primary btn-block" id="editSecao">
                                        <i class="fas fa-pen" alt="editar" title="editar"></i>
                                            Editar
                                        </button>
                                    </button>
                                    <button style="display:none" id="editandoSecao" class="btn btn-primary btn-md btn-block" type="button" disabled>
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
