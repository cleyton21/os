<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Controller/Incidentes.php";

$objIncidentes = new Model\Incidentes();

?>

<div class="wrapper">
    <div id="result"></div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Incidentes dos chamados</h1>
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
                <h6 class="m-0 font-weight-bold text-primary">Incidentes</h6>&nbsp
                </div>

                <div class="col-md-3">
                <?php if($_SESSION['scd_perfil'] == 1) { ?>
                <a href="?p=incidente-cadastrar" class="btn btn-primary btn-sm" style="float:right;">
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
                                <th>Incidente</th>
                                <th>Dica</th>
                                <th>
                                    IP
                                    <small>(Obrigatório)</small>
                                </th>
                                <th>
                                    Equipamento
                                    <small>(Obrigatório)</small>
                                </th>
                                <th>Cadastrado por:</th>
                                <?php if($_SESSION['scd_perfil'] == 1) { ?>
                                <th>Ação</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listar = $objIncidentes->listarIncidente();
                            $count = 1; //contador 
                            foreach ($listar as $linha) {
                            ?>
                                <tr style="text-align: center;">
                                    <td><?= $count; ?></td>
                                    <td><?= $linha->incidente; ?></td>
                                    <td><?= ($linha->dica == "" ? '<small style="color:red">Não possui</small>' : '<small style="color: blue">'.substr($linha->dica, 0, 30).'...</small>'); ?></td>
                                    <td>
                                        <!-- <div class="col-md-6 ip-required"> 
                                            <input type="checkbox" <?= ($_SESSION['scd_perfil'] != 1 ? 'disabled' : "") ?> data-name="ip-required" data-cd="<?= $linha->id_incidente?>" <?= ($linha->ip == 1 ? "checked" : ""); ?> data-toggle="toggle" data-on="Sim" data-off="Não" data-onstyle="success" data-offstyle="danger" data-size="xs">
                                        </div> -->

                                        <label class="switch">
                                            <input class="ip-required" type="checkbox" <?= ($_SESSION['scd_perfil'] != 1 ? 'disabled' : "") ?> <?= ($linha->ip == 1 ? "checked" : ""); ?>  data-name="ip-required" data-cd="<?= $linha->id_incidente?>">
                                            <span class="slider round"></span>
                                        </label>

                                    </td>
                                    <td>
                                        <!-- <div class="col-md-6 equipamento-required"> 
                                            <input type="checkbox" <?= ($_SESSION['scd_perfil'] != 1 ? 'disabled' : "") ?> data-name="equipamento-required" data-cd="<?= $linha->id_incidente?>" <?= ($linha->equipamento == 1 ? "checked" : ""); ?> data-toggle="toggle" data-on="Sim" data-off="Não" data-onstyle="success" data-offstyle="danger" data-size="xs">
                                        </div> -->

                                        <label class="switch">
                                            <input class="equipamento-required" type="checkbox" <?= ($_SESSION['scd_perfil'] != 1 ? 'disabled' : "") ?> <?= ($linha->equipamento == 1 ? "checked" : ""); ?>  data-name="equipamento-required" data-cd="<?= $linha->id_incidente?>">
                                            <span class="slider round"></span>
                                        </label>

                                    </td>
                                    <td>
                                        <?= $linha->created_by; ?> <span style="color: red;"><small><i><?= ($linha->updated_by == "" ? "" : '| Alterado por: ' . $linha->updated_by) ?></i></small></span>
                                        <br>
                                        <small><i><?= Data::ExibirTempoDecorrido($linha->created_at); ?> <span style="color: red;"><?= ($linha->updated_at == "" ? "" : '| Em: ' . Data::ExibirTempoDecorrido($linha->updated_at)); ?></i></small>
                                    </td>

                                    <?php if($_SESSION['scd_perfil'] == 1) { ?>
                                    <td>
                                        <a href="?p=incidente-editar&cd=<?= $linha->id_incidente; ?>" class="btn btn-primary btn-sm" style="border-radius: 50px;">
                                            <i class="far fa-edit" alt="editar" title="editar"></i>
                                        </a>                                       
                                        <input type="hidden" name="acao" value="excluir">
                                        <a class="btn btn-danger btn-sm btnDelIncidente" data-cd="<?= $linha->id_incidente; ?>" data-acao="excluirIncidente" style="border-radius: 50px;">
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