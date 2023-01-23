<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Model/Chamados.php";

$objChamados = new Model\Chamados();

?>

<div class="wrapper">
    <div id="result"></div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lista de Chamados Abertos</h1>
                    </div>
                    <?php if($_SESSION['scd_perfil'] != 3) { ?>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                            <li class="breadcrumb-item"><a href="?p=chamados">Chamados</a></li>
                            <li class="breadcrumb-item active"><?= ucfirst($_GET['p']); ?></li>
                        </ol>
                    </div><!-- /.col -->
                    <?php } ?>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="card shadow mb-4 content">
            <div class="card-header py-3 row">
                <div class="col-md-9"></div>
                <!-- <h6 class="m-0 font-weight-bold text-primary">Lista de Tickets</h6> -->
                <div class="md-col-3">
                    <a href="?p=chamados" class="btn btn-success btn-sm">
                        Todos os Chamados
                    </a>
                <a href="?p=chamados-cadastrar" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus" alt="cadastrar" title="cadastrar"></i> <u>Ciar Ticket</u>
                </a> 

                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>

                            <tr style="text-align:center">
                                <th>Ord</th>
                                <th>Ticket</th>
                                <th>Criado</th>
                                <th>Status</th>
                                <th>Assunto</th>
                                <th>Prioridade</th>
                                <th>Cliente</th>
                                <th>Atribuído a</th>
                                <th>Atualizado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listar = $objChamados->listarChamadosAbertos();
                            $count = 1; //contador 
                            foreach ($listar as $linha) {
                            ?>
                                <tr style="text-align: center;">
                                    <td><?= $count; ?></td>
                                   
                                    <td><a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>"><?= '#'.$linha->ticket; ?></a></td>
                                   
                                    <td><?= Data::ExibirTempoDecorrido($linha->created_at); ?></td>

                                    <?php if($linha->status == "Em andamento") { ?>
                                    <td class="alert alert-primary"><?= $linha->status; ?></td>
                                    <?php } ?>

                                    <?php if($linha->status == "Aberto") { ?>
                                    <td style="color:white" class="bg-gradient-danger"><?= $linha->status; ?></td>
                                    <?php } ?>

                                    <?php if($linha->status == "Resolvido") { ?>
                                    <td style="color:white" class="bg-gradient-success"><?= $linha->status; ?></td>
                                    <?php } ?>

                                    <?php if($linha->status == "Aguardando resposta do usuário") { ?>
                                    <td class="alert alert-warning"><?= $linha->status; ?></td>
                                    <?php } ?>

                                    <td><a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>"><?= $linha->incidente; ?></a></td>

                                    <?php if($linha->prioridade == "Alta"){ ?>
                                    <td style="color: white;" class="bg-gray-800">
                                        <?= $linha->prioridade; ?>
                                    </td>
                                    <?php } ?>

                                    <?php if($linha->prioridade == "Média"){ ?>
                                    <td style="color: white;" class="bg-gray-600">
                                        <?= $linha->prioridade; ?>
                                    </td>
                                    <?php } ?>

                                    <?php if($linha->prioridade == "Baixa"){ ?>
                                    <td style="color: white;" class="bg-gray-400">
                                        <?= $linha->prioridade; ?>
                                    </td>
                                    <?php } ?>

                                    <td>
                                        <?= $linha->created_by; ?>
                                        <br>
                                        <?= $linha->solicitante; ?>
                                    </td>

                                    <td><?= $linha->tecnico ?></td>

                                    <td><?= ($linha->updated_at == "" ? "" : Data::ExibirTempoDecorrido($linha->updated_at)); ?></td>

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
