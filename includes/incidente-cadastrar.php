<?php
if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Incidentes.php";
$objIncidente = new Model\Incidentes();
?>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cadastrar Incidente</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=incidentes">Incidentes</a></li>
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
                                <h3 class="card-title">Adicionar Incidente</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" id="formCadIncidente">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="incidente">Incidente <small style="color: red;">(*)</small></label>
                                        <input type="text" name="incidente" id="incidente" class="form-control"
                                            placeholder="Ex.: Sped / Acesso a internet / Servidor de arquivos">
                                        <small style="color: blue;"> 
                                            Cadastrar incidentes para o chamado
                                        </small>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="dica">Dica <small style="color: red;">(*)</small></label>
                                        <input type="text" name="dica" id="dica" class="form-control"
                                            placeholder="Ex.: Para este incidente favor inserir nome completo" requiblue="requiblue">
                                        <small style="color: blue;"> 
                                            Inserir dica de preenchimento para um chamado que use este incidente
                                        </small>
                                    </div>
                                    </div>

                                    <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="cor">Cor <small style="color: red;">(*)</small></label>
                                        <input type="color" name="cor" id="cor" value="#0275d8" class="form-control"/>
                                            
                                        <small style="color: blue;"> 
                                            Cor de identifica????o do incidente no calend??rio
                                        </small>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" name="acao" value="cadIncidente">
                                    <button id="btnCadIncidente" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Gravar
                                    </button>

                                    <button style="display:none" id="gravandoIncidente" class="btn btn-primary btn-md btn-block" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Aguarde...
                                    </button>
                                    <small style="color: red;">(*) Campos obrigat??rios</small>
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
