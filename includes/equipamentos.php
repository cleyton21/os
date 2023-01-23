<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Equipamentos.php";

$objEquipamento = new Model\Equipamentos();

?>

<div class="wrapper">
    <div id="result"></div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Equipamentos de TI</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Lista de computadores, impressoras e outros equipamentos das seções</h6> &nbsp &nbsp
                </div>
                <div class="col-md-3">
                    <a href="?p=equipamentos-cadastrar" class="btn btn-primary btn-sm" style="float:right;">
                        <i class="fas fa-plus" alt="cadastrar" title="cadastrar"></i> Cadastrar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>

                            <tr style="text-align: center;">
                                <th>Ord</th>
                                <th>Seção</th>
                                <th>Máquina</th>
                                <th>Cadastrado por:</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listar = $objEquipamento->listarEquipamentos();
                            $count = 1; //contador 
                            foreach ($listar as $linha) {
                            ?>
                                <tr>
                                    <td style="text-align: center; cursor: pointer" <?php if($linha->id_chamado != "") { ?> onclick="location.href='?p=chamados&equipamento=<?= $linha->id_equipamento; ?>'<?php } ?>"><?= $count; ?></td>
                                    <td style="text-align: center; cursor: pointer" <?php if($linha->id_chamado != "") { ?> onclick="location.href='?p=chamados&equipamento=<?= $linha->id_equipamento; ?>'<?php } ?>"><?= $linha->secao; ?></td>
                                    <td style="text-align: center; cursor: pointer" <?php if($linha->id_chamado != "") { ?> onclick="location.href='?p=chamados&equipamento=<?= $linha->id_equipamento; ?>'<?php } ?>">
                                        <?= $linha->nome; ?>
                                        <br>
                                        <small><i>
                                            <?= $linha->equipamento; ?>
                                        </i></small>
                                    </td>
                                    <td style="text-align: center; cursor: pointer" <?php if($linha->id_chamado != "") { ?> onclick="location.href='?p=chamados&equipamento=<?= $linha->id_equipamento; ?>'<?php } ?>">
                                        <?= $linha->created_by; ?> <span style="color: red;"><small><i><?= ($linha->updated_by == "" ? "" : '| Alterado por: ' . $linha->updated_by) ?></i></small></span>
                                        <br>
                                        <small><i><?= $objData->ExibirTempoDecorrido($linha->created_at); ?> <span style="color: red;"><?= ($linha->updated_at == "" ? "" : '| Em: ' . $objData->ExibirTempoDecorrido($linha->updated_at)); ?></i></small>
                                    </td>

                                    <td style="text-align: center">
                                        <a href="?p=equipamento-editar&cd=<?= $linha->id_equipamento; ?>" class="btn btn-primary btn-sm" style="border-radius: 50px;">
                                            <i class="far fa-edit" alt="editar" title="editar"></i>
                                        </a>                                       
                                                <input type="hidden" name="cd" value="<?= $linha->id_equipamento; ?>">
                                                <input type="hidden" name="acao" value="excluir">
                                            <a class="btn btn-danger btn-sm btnDelEquipamento" data-cd="<?= $linha->id_equipamento; ?>" data-acao="excluirEquipamento" style="border-radius: 50px;">
                                                <i class="far fa-trash-alt" alt="excluir" title="excluir"></i>
                                            </a>
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