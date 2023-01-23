<?php
    include_once "Controller/Chamados.php";
    include_once "Model/Usuarios.php";
    include_once "Model/Chamados.php";
    include_once "Model/Equipamentos.php";
    include_once "Model/Estoque.php";

    $objChamados = new Model\Chamados();
    $objUsuarios = new Model\Usuarios();
    $objEquipamentos = new Model\Equipamentos();
    $objEstoque = new Model\Estoque();

    if (isset($_GET['cd']) && is_numeric($_GET['cd'])) {
        $cd = (int) $_GET['cd'];
      } else {
      echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=home">';
    }

    $listarUsuarios = $objUsuarios->pegarAdminSuporte();
    $dgr = $objChamados->pegarChamadoCd($cd);   
    $listarMsg = $objChamados->pegarMsgCd($cd);   
    $listarEquipamento = $objEquipamentos->pegarEquipamentos($cd);   
    $listarEstoque = $objEstoque->listarEstoqueChamado();   
?>
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ml-1">
                    <?php
                        if($dgr->status == 'Resolvido'){
                            $cor = 'success';
                        }elseif($dgr->status == 'Aguardando resposta do usuário'){
                            $cor = 'warning';
                        }elseif($dgr->status == 'Em andamento'){
                            $cor = 'info';
                        }elseif($dgr->status == 'Aberto'){
                            $cor = 'danger';
                        }
                    ?>
                    <div class="col-md-6 alert alert-<?= $cor; ?>" role="alert" style="padding: 10px">
                        <h4><?= ($dgr->incidente); ?></h4>
                    </div>

                    <?php if($_SESSION['scd_perfil'] == 3) { ?>
                    <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=chamados-usuario">Chamados</a></li>
                        <li class="breadcrumb-item active"><?= str_replace('-', ' ', ucfirst($_GET['p'])); ?></li>
                    </ol>
                    </div><!-- /.col -->
                    <?php } else { ?>
                        <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?p=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?p=chamados">Chamados</a></li>
                        <li class="breadcrumb-item active"><?= str_replace('-', ' ', ucfirst($_GET['p'])); ?></li>
                    </ol>
                    </div>
                    <?php } ?>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div id="result"></div>
        <!-- Main content -->
        <section class="content" style="margin-bottom:20px;">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                                <h6 class="m-0 font-weight-bold text-primary">Descrição do Incidente</h6>
                                <p class="m-0 font-weight text-black.50"><?= $dgr->dica; ?></p>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="formEditChamado" method="post" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row mensagens">
                                        <div class="col-md-12">
                                            <?= $dgr->descricao; ?>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row mensagens">
                                        <div>
                                        <div style="height: 60px; border-right: 4px solid blue; float:left;"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <b>Nome de guerra do solicitante: </b><?= $dgr->solicitante; ?>
                                            <br>
                                            <b>IP:</b> <?= $dgr->ip; ?>
                                            <br>
                                            <br>

                                            <?php if($dgr->foto != "" && $dgr->conteudo != "" && $dgr->tipo != "" && $dgr->tamanho != "" ) { ?>
                                                
                                                <!-- <div class="col-sm-6 col-md-4"> -->
                                                    <!-- <a href=""> -->
                                                    <div class="thumbnail">
                                                        <?php  echo '<img name="img1" onMouseOut="tamanhoNormal(img1)" onMouseOver="aumentaImagem(img1)" id="imagem" width="320" height="205" src="data:image/jpeg;base64,' . base64_encode( $dgr->conteudo ) . '" /> '; ?>

                                                        <div class="caption">
                                                            <strong>Nome:</strong> <?php echo $dgr->foto ?> <br/>
                                                            <strong>Tipo:</strong> <?php echo $dgr->tipo ?> <br/>
                                                            <strong>Tamanho:</strong> <?php  echo formatBytes( $dgr->tamanho ); ?>  <br/>
                                                        </div>
                                                    </div>
                                                    <!-- </a> -->
                                                <!-- </div> -->
                                                
                                                <?php } ?>
                                            </div>    
                                        </div>
                                </div>

                                <?php
                                foreach($listarMsg as $linha) {
                                ?>

                                <?php if($linha->privacidade == 0 && $_SESSION['scd_perfil'] == 3) { ?>
                                <div class="card-header">
                                    <h3 class="card-title"></h3>
                                    <h6 class="m-0 font-weight-bold text-primary">Respostas</h6>
                                </div>

                                <div class="row mensagens" style="min-height: 90px;">
                                        <div class="col-md-10" style="margin-left: 15px;">
                                            <div><?= $linha->mensagem; ?></div>
                                            <br>
                                            <br>
                                            <br>
                                            <i><b>Atualizado em:</b> </i><?= Data::ExibirTempoDecorrido($linha->updated_at); ?>
                                            <br>
                                            <i><b>Por:</b> </i><?= $linha->updated_by; ?>
                                        </div>
                                </div> <br>
                                <?php } ?>

                                <?php if($_SESSION['scd_perfil'] != 3) { ?>
                                <div class="card-header">
                                    <h3 class="card-title"></h3>
                                    <h6 class="m-0 font-weight-bold text-primary"><?= ($linha->privacidade == 1) ? '<div>Resposta <span class="badge badge-danger">Privado <i class="fas fa-eye-slash"></i></span></div>' : 'Respostas'?></h6>
                                </div>

                                <div class="row mensagens" style="min-height: 90px;">
                                        <div class="col-md-10" style="margin-left: 15px;">
                                            <?= $linha->mensagem; ?>
                                            <br>
                                            <br>
                                            <br>
                                            <i><b>Atualizado em:</b> </i><?= Data::ExibirTempoDecorrido($linha->updated_at); ?>
                                            <br>
                                            <i><b>Por:</b> </i><?= $linha->updated_by; ?>
                                            <br>
                                            <br>
                                            <?php if($linha->foto != "" && $linha->conteudo != "" && $linha->tipo != "" && $linha->tamanho != "" ) { ?>
                                                
                                                <div class="col-sm-6 col-md-4">
                                                    <!-- <a href=""> -->
                                                    <div class="thumbnail">
                                                        <?php  echo '<img id="imagem" name="img2" onMouseOut="tamanhoNormal(img2)" onMouseOver="aumentaImagem(img2)" width="320" height="205" src="data:image/jpeg;base64,' . base64_encode( $linha->conteudo ) . '" /> '; ?>

                                                        <div class="caption">
                                                            <strong>Nome:</strong> <?php echo $linha->foto ?> <br/>
                                                            <strong>Tipo:</strong> <?php echo $linha->tipo ?> <br/>
                                                            <strong>Tamanho:</strong> <?php  echo formatBytes( $linha->tamanho ); ?>  <br/>
                                                        </div>
                                                    </div>
                                                    <!-- </a> -->
                                                </div>

                                            <?php } ?>
                                        </div>

                                        
                                </div> <br>
                                <?php } ?>


                                <?php
                                 } //fim do foreach
                                ?>                                
                                
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"></h3>
                                        <h6 class="m-0 font-weight-bold text-primary">Respostas <small style="color: red;">(*)</small></h6> 
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">

                                            <nav>
                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"><i class="fas fa-eye"></i> Mensagem Pública</a>
                                                
                                                <?php if($_SESSION['scd_perfil'] != 3) { ?>
                                                <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false"><i class="fas fa-eye-slash"></i> Mensagem Privada</a>
                                                <?php } ?>
                                            </div>
                                            </nav>

                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                                    <div class="form-group"> <!-- msgn publica -->
                                                        <textarea name="mensagem" id="mensagem" requiblue class="form-control col-md-12" cols="30" rows="8"></textarea>
                                                    </div>
                                                </div>

                                                <?php if($_SESSION['scd_perfil'] != 3) { ?>
                                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                                    <div class="form-group"> <!-- msgn privada somente para admin/suporte-->
                                                        <textarea name="mensagem_privada" id="mensagem_privada" requiblue class="form-control col-md-12" cols="30" rows="8"></textarea>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                                <div class="form-group">
                                                    <input type="file" name="foto" id="foto"/>
                                                </div>
                                                <small>Tamanho Máximo: 5M</small><br>
                                                <small>Formatos suportados: (pjpeg|jpeg|png|gif|bmp)</small>
                                            </div>

                                            <?php if($_SESSION['scd_perfil'] != 3) { ?>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="status">Status <small style="color: red;">(*)</small></label>
                                                    <select class="form-control select2" name="status" id="status" <?= ($_SESSION['scd_perfil'] == 3 ? "" : 'requiblue'); ?> style="width: 100%;">
                                                        <option value="<?= $dgr->status; ?>"><?= $dgr->status; ?></option>
                                                        <option value="Aguardando resposta do usuário">Aguardando resposta do usuário</option>
                                                        <option value="Em andamento">Em andamento</option>
                                                        <option value="Resolvido">Resolvido</option>
                                                    </select>
                                                    <small style="color: blue;">Alterar o status do chamado</small>

                                                </div>

                                                <div class="form-group">
                                                    <label for="tecnico">Atribuir um técnico para suporte <small style="color: red;">(*)</small></label>
                                                    <select class="form-control select2" name="tecnico" id="tecnico" <?= ($_SESSION['scd_perfil'] == 3 ? "" : 'requiblue'); ?> style="width: 100%;">
                                                    <option value="<?= ($dgr->tecnico == "" ? "" : $dgr->tecnico); ?>" selected="selected"><?= ($dgr->tecnico == "" ? "Escolha um responsável pelo suporte" : $dgr->tecnico); ; ?></option>
                                                    <?php 
                                                    foreach ($listarUsuarios as $linha) { 
                                                    ?>
                                                    <option value="<?php echo $linha->postograd." ".$linha->user; ?>"><?php echo $linha->postograd." ".$linha->user; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <small style="color: blue;">Responsável pelo suporte</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                            <div class="form-group">
                                                    <label for="id_equipamento">Equipamento</label>
                                                    <select class="form-control select2" name="id_equipamento" id="id_equipamento" style="width: 100%;">
                                                    <option value="<?= ($dgr->nome == "" ? "" : $dgr->id_equipamento); ?>" selected="selected"><?= ($dgr->nome == "" ? "Atrelar um dispositivo ao chamado" : $dgr->nome); ?></option>
                                                    <?php 
                                                    foreach ($listarEquipamento as $linha) { 
                                                    ?>
                                                    <option value="<?php echo $linha->id_equipamento; ?>"><?php echo $linha->nome; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <small style="color: blue;">Atribuir um equipamento a este chamado</small>
                                                </div>

                                                <div class="form-group">
                                                    <label for="id_estoque">Material usado</label>
                                                    <select class="form-control select2" name="id_estoque" id="id_estoque" style="width: 100%;">
                                                    <option value="<?= ($dgr->material == "" ? "" : $dgr->id_estoque); ?>" selected="selected"><?= ($dgr->material == "" ? 'Inserir item de estoque no chamado' : $dgr->material.' - '.$dgr->descricaoestoque); ?></option>
                                                    <?php 
                                                    foreach ($listarEstoque as $linha) { 
                                                    ?>
                                                    <option value="<?php echo $linha->id_estoque; ?>"><?= $linha->material.' - '.$linha->descricao; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <small style="color: blue;">Alertar se foi usado algum material nesse chamado</small>
                                                </div>
                                                <div id="boxFields"></div>
                                                <!-- <button style="margin: 20px;padding: 10px;" id="add" class="badge badge-primary">Adicionar mais materiais</button> -->
                                            </div>
                                            <?php } ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" value="<?php echo $dgr->id_chamado; ?>" name="cd">
                                    <input type="hidden" value="<?php echo $dgr->equipamento; ?>" name="equipamento">
                                    <input type="hidden" name="acao" value="editChamado">

                                    <?php if($dgr->status != 'Resolvido') { ?>
                                    <button id="editChamado" class="btn btn-success btn-block">
                                        <i class="fas fa-pen" alt="editar" title="editar"></i>
                                            Adicionar Resposta
                                    </button>
                                    <button style="display:none" id="editandoChamado" class="btn btn-success btn-md btn-block" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Aguarde...
                                    </button>
                                    <small style="color: red;">(*) Campos obrigatórios</small>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- <a href="#" id="add">Adicionar</a>
<form action="" method="post">

<div id="boxFields">

</div>

<br />
<input type="submit" value="Enviar" />
</form> -->
        <!-- /.content -->
    </div>
</div>
