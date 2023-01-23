<?php
if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Materiais.php";
include_once "Controller/Estoque.php";

$objMateriais = new Model\Materiais();

$listMaterial = $objMateriais->listarMateriais();
?>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cadastrar Estoque</h1>
                    </div>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=estoque">Estoque</a></li>
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
                                <h3 class="card-title">Adicionar Item</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post">
                                <div class="card-body">
                                    <div class="row">
                                    <div class="form-group col-md-8">
                                        <label for="material">Material <small style="color: red;">(*)</small></label>
                                        <select class="form-control select2" name="material" id="cadmaterial" requiblue="requiblue" style="width: 100%;">
                                            <option value="" selected="selected">Selecione um item da lista</option>
                                            <?php foreach ($listMaterial as $linha) { ?>
                                            <option value="<?php echo $linha->id_material; ?>"><?php echo $linha->material; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="qtd">Quantidade <small style="color: red;">(*)</small></label>
                                        <input type="number" min="1" max="10" name="qtd" value="1" id="qtd" class="form-control"
                                            placeholder="" requiblue="requiblue">
                                        <small style="color: blue;"> 
                                            Somente números entre 1 e 10
                                        </small>
                                    </div>
                                    </div>
                                    <div class="row">
                                        <label for="material">Descrição/Marca/Modelo <small style="color: red;">(*)</small></label>
                                        <textarea name="descricao" placeholder="Ex.: Processadores Intel Socket 1200 para 10ª Geração Intel Core, Pentium Gold e Celeron
                                        " class="form-control col-md-12" name="" id="" cols="30" rows="8" requiblue></textarea>
                                        <small style="color: blue;"> 
                                            Ex.: Detalhar características do item a ser inserido
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" name="acao" value="cadEstoque">
                                    <button class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Gravar
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
