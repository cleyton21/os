<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

include_once "Model/Search.php";

$objSearch = new Model\Search();

$pesquisar = strip_tags(filter_input(INPUT_POST, 'pesquisar'));

if(strlen($pesquisar) < 2) {
    echo "<script>alert('Digite no mínimo 2 caracteres....');</script>";
?>
<script>
history.go(-1);
</script>

<?php
}

?>

<div class="wrapper">
    <!-- <div id="result"></div> -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pesquisar "<?= $pesquisar; ?>"</h1>
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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-striped table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>

                            <tr style="text-align: center;">
                                <th>Módulo</th>
                                <th>Pesquisa</th>
                            </tr>
                        </thead>
                        <tbody>
                                <?php
                                // modulo usuario
                                $listar = $objSearch->listarUsuarios($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Usuários'; ?></td>
                                    
                                    <td>
                                    <a href="?p=usuarios-editar&cd=<?= $linha->id_user; ?>">
                                    Usuário: 
                                        <?= ($linha->postograd != "" ? $linha->postograd : ""). " " . $linha->user; ?>
                                    </a>
                                    </td>

                                </tr>
                            <?php } ?>

                            <?php
                                // modulo seção
                                $listar = $objSearch->listarSecao($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Seção'; ?></td>
                                    
                                    <td>
                                    <a href="?p=secao-editar&cd=<?= $linha->id_secao; ?>">
                                        Seção: <?= ($linha->secao); ?>
                                    </a>
                                    </td>

                                </tr>
                            <?php } ?>

                            <?php
                                // modulo equipamento
                                $listar = $objSearch->listarEquipamento($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <?php if(palavras_iguais([$linha->nome, $pesquisar])) { ?>
                                <tr style="text-align: center;">
                                    <td style="text-align: center;"><?= 'Equipamentos'; ?></td>
                                    
                                    <td style="text-align: center;">
                                        <a href="?p=equipamento-editar&cd=<?= $linha->id_equipamento; ?>">
                                        Nome: <?= ($linha->nome); ?>
                                        </a>
                                    </td>
                                <?php } ?>
                                </tr>

                                <?php if(palavras_iguais([$linha->equipamento, $pesquisar])) { ?>
                                <tr>
                                <td style="text-align: center;"><?= 'Equipamentos'; ?></td>
                                <td style="text-align: center;">
                                    <a href="?p=equipamento-editar&cd=<?= $linha->id_equipamento; ?>">
                                    Equipamento: <?= ($linha->equipamento); ?>
                                    </a>
                                </td>
                                <?php } ?>
                                </tr>
                            <?php } ?>


                            <?php
                                // modulo materiais
                                $listar = $objSearch->listarMaterial($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Material'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->material, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=materiais-editar&cd=<?= $linha->id_material; ?>">
                                        Material: <?= $linha->material; ?>
                                    </a>
                                    </td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>

                            <?php
                                // modulo estoque
                                $listar = $objSearch->listarEstoque($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Estoque'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->descricao, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=estoque-editar&cd=<?= $linha->id_estoque; ?>">
                                        Descrição: <?= $linha->descricao; ?>
                                    </a>
                                    </td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>

                            <?php
                                // modulo incidentes
                                $listar = $objSearch->listarIncidentes($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Incidentes'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->incidente, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=incidente-editar&cd=<?= $linha->id_incidente; ?>">
                                        Incidente: <?= $linha->incidente; ?>
                                    </a>
                                    </td>
                                    <?php } ?>

                                </tr>
                            <?php } ?>

                            <?php
                                // modulo chamados
                                $listar = $objSearch->listarChamadosPrioridade($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Chamados'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->prioridade, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>">
                                        Prioridade: <?= $linha->prioridade; ?> (Ticket: <?= $linha->ticket; ?>)
                                    </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

                            <?php
                                // modulo chamados
                                $listar = $objSearch->listarChamadosDescricao($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Chamados'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->descricao, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>">
                                        Descrição: <?= $linha->descricao; ?> (Ticket: <?= $linha->ticket; ?>)
                                    </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

                            <?php
                                // modulo chamados
                                $listar = $objSearch->listarChamadosSolicitante($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Chamados'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->solicitante, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>">
                                        Solicitante: <?= $linha->solicitante; ?> (Ticket: <?= $linha->ticket; ?>)
                                    </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

                            <?php
                                // modulo chamados
                                $listar = $objSearch->listarChamadosStatus($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Chamados'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->status, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>">
                                        Status: <?= $linha->status; ?> (Ticket: <?= $linha->ticket; ?>)
                                    </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

                            <?php
                                // modulo chamados
                                $listar = $objSearch->listarChamadosTecnico($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Chamados'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->tecnico, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>">
                                        Tecnico: <?= $linha->tecnico; ?> (Ticket: <?= $linha->ticket; ?>)
                                    </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

                            <?php
                                // modulo chamados
                                $listar = $objSearch->listarChamadosIp($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Chamados'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->ip, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>">
                                        IP: <?= $linha->ip; ?> (Ticket: <?= $linha->ticket; ?>)
                                    </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>

                            <?php
                                // modulo chamados
                                $listar = $objSearch->listarChamadosMsg($pesquisar);
                                foreach ($listar as $linha) {
                                ?>
                                <tr style="text-align: center;">
                                    <td><?= 'Chamados'; ?></td>
                                    
                                    <?php if(palavras_iguais([$linha->mensagem, $pesquisar])) { ?>
                                    <td>
                                    <a href="?p=chamados-editar&cd=<?= $linha->id_chamado; ?>">
                                        Mensagem: <?= $linha->mensagem; ?> (Ticket: <?= $linha->ticket; ?>)
                                    </a>
                                    </td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDelUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input type="hidden" name="acao" value="excluirUser">
                    <button class="btn btn-primary btn-submit">Sim</button>
                </div>
            </form>
        </div>
    </div>
</div>