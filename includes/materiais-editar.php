<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}
include_once "Controller/Materiais.php";

$objMaterial = new Model\Materiais();

if (isset($_GET['cd']) && is_numeric($_GET['cd'])) {
    $cd = (int) $_GET['cd'];
  } else {
  echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
}

$dgr = $objMaterial->pegarMaterialCd($cd);
?>

<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar Materiais</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=materiais">Materiais</a></li>
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
                                <h3 class="card-title">Material</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="material">Material <small style="color: red;">(*)</small></label>
                                        <input type="text" name="material" id="material" value="<?= $dgr->material; ?>" class="form-control"
                                            placeholder="Ex.: Memória RAM" required="required"; ?> 
                                            <small style="color: red;"> 
                                            Descrição suscinta. Ex.: Memória RAM, HD, Placa mãe.
                                            </small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" value="<?php echo $dgr->id_material; ?>" name="cd">
                                    <input type="hidden" name="acao" value="editarMaterial">
                                    <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-pen" alt="editar" title="editar"></i>
                                        Editar
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
