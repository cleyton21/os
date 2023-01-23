<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Model/Materiais.php";

$objMateriais = new Model\Materiais();

?>

<div class="wrapper">
    <div id="result"></div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Administrar Materiais</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                            <li class="breadcrumb-item active"><?= ucfirst($_GET['p']); ?></li>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="card shadow mb-4 content">
            <div class="card-header py-3 row">
                <div class="col-md-9">
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Materiais Presentes na Seção de Informática para Uso e Manutenção de computadores</h6> &nbsp &nbsp
                </div>

                <div class="col-md-3">
                <?php if($_SESSION['scd_perfil'] == 1) { ?>
                <a href="?p=materiais-cadastrar" class="btn btn-primary btn-sm" style="float:right;">
                    <i class="fas fa-plus" alt="cadastrar" title="cadastrar"></i> Cadastrar
                </a>
                <?php } ?>
                </div>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>

                            <tr style="text-align: center;">
                                <th>Ord</th>
                                <th>Material</th>
                                <?php if($_SESSION['scd_perfil'] == 1) { ?>
                                <th>Ação</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listar = $objMateriais->listarMateriais();
                            $count = 1; //contador 
                            foreach ($listar as $linha) {
                            ?>
                                <tr style="text-align: center;">
                                    <td><?= $count; ?></td>
                                    <td><?= $linha->material; ?></td>

                                    <?php if($_SESSION['scd_perfil'] == 1) { ?>
                                    <td>
                                        <a href="?p=materiais-editar&cd=<?= $linha->id_material; ?>" class="btn btn-primary btn-sm" style="border-radius: 50px;">
                                            <i class="far fa-edit" alt="editar" title="editar"></i>
                                        </a>                                       
                                        <input type="hidden" name="cd" value="<?= $linha->id_material; ?>">
                                        <input type="hidden" name="acao" value="excluir">
                                        <a class="btn btn-danger btn-sm btnDelMaterial" data-cd="<?= $linha->id_material; ?>" data-acao="excluirMaterial" style="border-radius: 50px;">
                                            <i class="far fa-trash-alt" alt="excluir" title="excluir"></i>
                                        </a>
                                    </td>
                                    <?php } ?>

                                </tr>
                            <?php
                                $count++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>