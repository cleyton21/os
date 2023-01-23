<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Model/Usuarios.php";

$objUsuarios = new Model\Usuarios();

?>

<div class="wrapper">
    <div id="result"></div>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Administrar Usuários</h1>
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
                    <h6 class="m-0 font-weight-bold text-primary">Lista de Usuários</h6> &nbsp &nbsp
                </div>
                <div class="col-md-3">
                    <a href="?p=usuarios-cadastrar" class="btn btn-primary btn-sm" style="float:right;">
                        <i class="fas fa-plus" alt="cadastrar" title="cadastrar"></i> Cadastrar usuários
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>

                            <tr style="text-align: center;">
                                <th>Ord</th>
                                <th>Usuário</th>
                                <th>Seção</th>
                                <th>Perfil</th>
                                <th>Cadastrado por:</th>
                                <th>Acessado em:</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listar = $objUsuarios->listarUsuarios();
                            $count = 1; //contador 
                            foreach ($listar as $linha) {
                            ?>
                                <tr style="text-align: center;">
                                    <td><?= $count; ?></td>
                                    
                                    <td><?= ($linha->postograd != "" ? $linha->postograd : ""). " " . $linha->user; ?></td>
                                    
                                    <td style="text-align: center;">
                                        <?php
                                        if($linha->secao != ""){
                                            echo $linha->secao;
                                        }elseif($linha->perfil != 3){
                                            echo '-';
                                        }elseif($linha->perfil == 3 && $linha->secao == ""){
                                            echo '<small><i><span style="color:red">Não informado</span></i></small>';
                                        }

                                        ?>
                                        <!-- <?= ($linha->secao == "" ? "<small><i><span style='color:red'>Não informado</span></i></small>" : $linha->secao); ?> -->
                                    </td>
                                    <td>
                                        <?= ($linha->perfil == 1 ? "<span style='color:blue'>Nível 1 - Admin</span>" :  ""); ?>
                                        <?= ($linha->perfil == 2 ? "<span style='color:green'>Nível 2 - Suporte</span>" :  ""); ?>
                                        <?= ($linha->perfil == 3 ? "<span style='color:orange'>Nível 3 - Cliente</span>" :  ""); ?>
                                    </td>
                                    
                                    <td>
                                        <?= $linha->created_by; ?>
                                        <br>
                                        <small><i><?= ($linha->created_at == "" ? "" : $objData->ExibirTempoDecorrido($linha->created_at)); ?></i></small>
                                    </td>
                                    <td>
                                        <?= ($linha->login_in == "" ? "<small><i><span style='color:red'>Nunca logou</span></i></small>" :  $objData->ExibirTempoDecorrido($linha->login_in)); ?>
                                    </td>

                                    <td>
                                        <?php if($linha->user != 'admin'){ ?>
                                        <a href="?p=usuarios-editar&cd=<?= $linha->id_user; ?>" class="btn btn-primary btn-sm" style="border-radius: 50px;">
                                            <i class="far fa-edit" alt="editar" title="editar"></i>
                                        </a>
                                        <?php } ?>

                                        <a href="?p=usuarioalterpasswd&cd=<?= $linha->id_user; ?>" class="btn btn-warning btn-sm" style="border-radius: 50px;">
                                            <i class="fas fa-key" alt="alterar senha" title="alterar senha"></i>
                                        </a>
                                        <?php
                                        if ($linha->user != 'admin') {
                                        ?>
                                            <input type="hidden" name="cd" value="<?= $linha->id_user; ?>">
                                            <input type="hidden" name="acao" value="excluir">
                                            <a class="btn btn-danger btn-sm btnDelUser" data-cd="<?= $linha->id_user; ?>" data-acao="excluirUser" style="border-radius: 50px;">
                                                <i class="far fa-trash-alt" alt="excluir" title="excluir"></i>
                                            </a>
                                        <?php
                                        }
                                        ?>
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