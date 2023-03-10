<?php
if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Secao.php";
include_once "Controller/Equipamentos.php";

if (isset($_GET['cd']) && is_numeric($_GET['cd'])) {
    $cd = (int) $_GET['cd'];
    } else {
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
}

$objSecao = new Model\Secao();
$objEquipamento = new Model\Equipamentos();

$listSecao = $objSecao->listarSecao();
$dgr = $objEquipamento->pegarEquipamentoCd($cd);    

?>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Editar dados do equipamento</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=equipamentos">Equipamento</a></li>
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
                                <h3 class="card-title">Editar Item</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post">
                            <div class="card-body">
                                    <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="secao">Se????o <small style="color: red;">(*)</small></label>
                                        <select class="form-control select2" name="secao" id="secao" requiblue="requiblue" style="width: 100%;">
                                            <option value="<?= $dgr->id_secao; ?>" selected="selected"><?= $dgr->secao; ?></option>
                                            <?php 
                                            $listSecao = $objSecao->listarSecao();
                                            foreach ($listSecao as $linha) { 
                                            ?>
                                            <option value="<?php echo $linha->id_secao; ?>"><?php echo $linha->secao; ?></option>
                                            <?php } ?>
                                        </select>
                                        <small style="color: blue;"> 
                                            Escolha a se????o a qual o equipamento pertence
                                        </small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="nome">Nome da m??quina <small style="color: red;">(*)</small></label>
                                        <input type="text" name="nome" value="<?= $dgr->nome; ?>" id="nome" class="form-control"
                                            placeholder="Ex.: STI-01" requiblue="requiblue">
                                        <small style="color: blue;"> 
                                            Cadastrar o nome do equipamento / n??o repetir nomes de m??quinas
                                        </small>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="form-group col-md-12">
                                    <label for="equipamento">Descri????o/Marca/Modelo <small style="color: red;">(*)</small></label>
                                        <textarea name="equipamento" placeholder="Ex.: Processadores Intel Socket 1200 para 10?? Gera????o Intel Core, Pentium Gold e Celeron
                                        " class="form-control col-md-12" name="" id="" cols="30" rows="8" requiblue><?= $dgr->equipamento; ?></textarea>
                                        <small style="color: blue;"> 
                                            Ex.: Detalhar caracter??sticas m??nimas do equipamento a ser inserido
                                        </small>
                                    </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" value="<?php echo $dgr->id_equipamento; ?>" name="cd">
                                    <input type="hidden" name="acao" value="editEquipamento">
                                    <button class="btn btn-primary btn-block">
                                        <i class="fas fa-pen" alt="editar" title="editar"></i>
                                            Editar
                                        </button>
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
