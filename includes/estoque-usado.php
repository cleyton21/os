<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Estoque.php";

$objEstoque = new Model\Estoque();

?>

<div class="wrapper">
    <div id="result"></div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Estoque de Material</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?p=estoque">Estoque</a></li>
                            <li class="breadcrumb-item active"><?= ucfirst($_GET['p']); ?></li>
                        </ol>
                    </div><!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="card shadow mb-4 content">
            <div class="card-header py-3 row">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Materiais usados</h6>&nbsp &nbsp
                <!-- <a href="?p=estoque-cadastrar" class="btn btn-primary btn-sm" style="float:right;">
                    <i class="fas fa-plus" alt="cadastrar" title="cadastrar"></i> Cadastrar
                </a> -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>

                            <tr style="text-align: center;">
                                <th>Ord</th>
                                <th>Material</th>
                                <th>Qtd</th>
                                <th>Cadastrado por:</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listar = $objEstoque->listarEstoqueUsado();
                            $count = 1; //contador 
                            foreach ($listar as $linha) {
                            ?>
                                <tr <?php if($linha->usado == 1) { ?> onclick="location.href='?p=chamados&estoque=usado&cd=<?= $linha->id_estoque; ?>'" <?php } else {} ?> style="text-align: center;">
                                    <td><?= $count; ?></td>
                                    <td>
                                        <?= $linha->material; ?>
                                        <br>
                                        <small><i><?= $linha->descricao; ?></i></small>
                                    </td>
                                    <td><?= ($linha->usado == 1 ? '0' : $linha->qtd); ?></td>
                                    <td>
                                        <?= $linha->created_by; ?> <span style="color: red;"><small><i><?= ($linha->updated_by == "" ? "" : '| Alterado por: ' . $linha->updated_by) ?></i></small></span>
                                        <br>
                                        <small><i><?= Data::ExibirTempoDecorrido($linha->created_at); ?> <span style="color: red;"><?= ($linha->updated_at == "" ? "" : '| Em: ' . Data::ExibirTempoDecorrido($linha->updated_at)); ?></i></small>
                                    </td>

                                    <td>
                                        <?php if($linha->usado == 0) { ?>
                                        <a href="?p=estoque-editar&cd=<?= $linha->id_estoque; ?>" class="btn btn-primary btn-sm" style="border-radius: 50px;">
                                            <i class="far fa-edit" alt="editar" title="editar"></i>
                                        </a>                                       
                                                <input type="hidden" name="cd" value="<?= $linha->id_estoque; ?>">
                                                <input type="hidden" name="acao" value="excluir">
                                            <a class="btn btn-danger btn-sm btnDelEstoque" data-cd="<?= $linha->id_estoque; ?>" data-toggle="modal" data-target="#modalDelEstoque" href="#" style="border-radius: 50px;">
                                                <i class="far fa-trash-alt" alt="excluir" title="excluir"></i>
                                            </a>
                                        <?php }else { echo '<i>Usado</i>';} ?>
                                    </td>
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

<div id="result"></div>
<div class="modal fade" id="modalDelEstoque" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Deseja realmente excluir este item?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div> -->
            <form class="form">
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Não</button>
                    <input type="hidden" name="cd" class="hiddencd" >
                    <input type="hidden" name="acao" value="excluirEstoque">
                    <button class="btn btn-primary btn-submit">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>