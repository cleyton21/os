<?php
if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Secao.php";
include_once "Controller/Equipamentos.php";

$objSecao = new Model\Secao();
?>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cadastrar Equipamentos de TI</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=equipamentos">Equipamentos</a></li>
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
                                <h3 class="card-title">Adicionar Equipamentos das seções</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" id="formCadEquipamento">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="secao">Seção <small style="color: red;">(*)</small></label>
                                        <select class="form-control select2" name="secao" id="secao" requiblue="requiblue" style="width: 100%;">
                                            <option value="" selected="selected">Selecione uma seção da lista</option>
                                            <?php 
                                            $listSecao = $objSecao->listarSecao();
                                            foreach ($listSecao as $linha) { 
                                            ?>
                                            <option value="<?php echo $linha->id_secao; ?>"><?php echo $linha->secao; ?></option>
                                            <?php } ?>
                                        </select>
                                        <small style="color: blue;"> 
                                            Escolha a seção a qual o equipamento pertence
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nome">Nome da máquina <small style="color: red;">(*)</small></label>
                                        <input type="text" name="nome" id="nome" class="form-control"
                                            placeholder="Ex.: STI-01" requiblue="requiblue">
                                        <small style="color: blue;"> 
                                            Cadastrar o nome do equipamento / não repetir nomes de máquinas
                                        </small>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-md-12">
                                    <label for="equipamento">Descrição/Marca/Modelo <small style="color: red;">(*)</small></label>
                                        <textarea name="equipamento" placeholder="Ex.: Processadores Intel Socket 1200 para 10ª Geração Intel Core, Pentium Gold e Celeron
                                        " class="form-control col-md-12" name="" id="" cols="30" rows="8"></textarea>
                                        <small style="color: blue;"> 
                                            Ex.: Detalhar características mínimas do equipamento a ser inserido
                                        </small>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" name="acao" value="cadEquipamento">
                                    <button type="submit" id="btnCadEquipamento" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Gravar
                                    </button>
                                    <button style="display:none" id="gravandoEquipamento" class="btn btn-primary btn-md btn-block" type="button" disabled>
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
