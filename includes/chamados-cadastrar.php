<?php
    include_once "Controller/Chamados.php";
    include_once "Model/Incidentes.php";
    include_once "Model/Usuarios.php";

    $objIncidentes = new Model\Incidentes();
    $objUsuarios = new Model\Usuarios();
?>

<div class="wrapper">
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ml-1">
                    <div class="col-md-6 alert alert-success" role="alert" style="padding: 10px">
                        <h4><u>Criar Ticket</u></h4>
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
        <!-- <div id="modal"></div> -->
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
                                <h6 class="m-0 font-weight-bold text-primary">Criar</h6>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form method="post" id="formCadChamado" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="id_incidente">Incidente: <small style="color: red;">(*)</small></label>
                                                <select class="form-control select2" name="id_incidente" id="id_incidente" style="width: 100%;">
                                                    <option value="" selected="selected">Selecione um incidente</option>
                                                    <?php
                                                    $listar = $objIncidentes->listarIncidente();
                                                    foreach($listar as $linha) {
                                                        ?>
                                                    <option data-ip="<?= $linha->ip; ?>" dica="<?= $linha->dica?>" value="<?= $linha->id_incidente; ?>"><?= $linha->incidente; ?></option>
                                                    <?php
                                                    }
                                                    ?>                                          
                                                </select>
                                        <small style="color: blue;">Selecione um incidente</small>
                                        </div>                                    
                                    </div>
                                
                                    <?php if($_SESSION['scd_perfil'] != 3) { ?>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="open_by">Abrir chamado como: </label>
                                        <select class="form-control select2" name="open_by" id="open_by" style="width: 100%;">
                                        <option value="" selected="selected">Selecione um cliente</option>
                                            <?php
                                            $listar = $objUsuarios->ListarusuariosClientes();
                                            foreach($listar as $linha) {
                                            ?>
                                            <option value="<?= $linha->id_user; ?>"><?= $linha->user; ?></option>
                                            <?php
                                            }
                                            ?>                                          
                                        </select>
                                        <small style="color: blue;">Abrir chamado como cliente</small>
                                    </div>                                    
                                    </div>
                                    <?php } ?>
                                </div>
                                    <div class="row">
                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="nome">Prioridade <small style="color: red;">(*)</small></label>
                                        <select class="form-control select2" name="prioridade" id="prioridade"  style="width: 100%;">
                                            <option value="Baixa" selected="selected">Baixa</option>
                                            <option value="Média">Média</option>
                                            <option value="Alta">Alta</option>
                                        </select>
                                        <small style="color: blue;">Selecione a prioridade do chamado</small>
                                    </div>
                                    </div>
                                    </div>                                    
                                </div>
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"></h3>
                                        <h6 class="m-0 font-weight-bold text-primary">Descrição</h6>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="descricao">Descrição <small style="color: red;">(*)</small></label>
                                                    <textarea id="descricao" name="descricao" placeholder="Ex.: Solicito senha de acesso a internet
                                        " class="form-control col-md-12" cols="30" rows="8" ></textarea>
                                                    <small style="color: blue;">Descrever o problema de forma detalhada</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                                    <input type="file" name="foto" id="foto"/>
                                        </div>
                                        <small>Tamanho Máximo: 5M</small><br>
                                        <small>Formatos suportados: (pjpeg|jpeg|png|gif|bmp)</small>
                                    </div>
                                </div>

                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"></h3>
                                        <h6 class="m-0 font-weight-bold text-primary">Identificação</h6>
                                    </div>
                                    <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="postograd">Posto/Grad do solicitante <small style="color: red;">(*)</small></label>
                                        <select class="form-control select2" name="postograd" id="postograd"  style="width: 100%;">
                                            <option value="" selected="selected">Selecione um Posto/Grad</option>
                                            <option value="Gen Ex">Gen Ex</option>
                                            <option value="Gen Div">Gen Div</option>
                                            <option value="Gen Bgda">Gen Bgda</option>
                                            <option value="Cel">Cel</option>
                                            <option value="Ten Cel">Ten Cel</option>
                                            <option value="Maj">Maj</option>
                                            <option value="Cap">Cap</option>
                                            <option value="1º Ten">1º Ten</option>
                                            <option value="2º Ten">2º Ten</option>
                                            <option value="Asp">Asp</option>
                                            <option value="ST">ST</option>
                                            <option value="1º Sgt">1º Sgt</option>
                                            <option value="2º Sgt">2º Sgt</option>
                                            <option value="3º Sgt">3º Sgt</option>
                                            <option value="Cb">Cb</option>
                                            <option value="Sd EP">Sd EP</option>
                                            <option value="Sd EV">Sd EV</option>
                                        </select>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nome_guerra">Nome de Guerra do Solicitante <small style="color: red;">(*)</small></label>
                                        <input type="text" name="nome_guerra" id="nome_guerra" class="form-control">
                                        <small style="color: blue;"></small>
                                    </div>
                                    </div>
                                    </div>

                                    <div class="row" id="row-ip">
                                    <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ip">IP do computador/Impressora <small style="color: red;">(*)</small></label>
                                        <input type="text" name="ip" value="<?= $_SESSION['scd_ip'] ?>" id="ip" class="form-control"
                                            placeholder="<?= $_SESSION['scd_ip'] ?>">
                                        <small style="color: blue;">Ex.: Se o chamado for para esse equipamento, seu IP já está salvo. Caso contrário, deixe em branco, ou pegue seu IP no link disponível na nossa intranet</small>
                                    </div>
                                    </div>
                                    </div>                                    
                                </div>
                                </div>

                                <div class="card-footer">
                                    <input type="hidden" value="<?php echo $_SESSION['_token'] ?>" name="hash">
                                    <input type="hidden" name="acao" value="cadChamados">
                                    <button type="submit" id="btnCadChamados" class="btn btn-primary btn-block">
                                        <i class="fas fa-save"></i> Gravar
                                    </button>
                                    <button style="display:none" id="gravandoChamado" class="btn btn-primary btn-md btn-block" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Aguarde...
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
