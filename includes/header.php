<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>OS 7º GAC</title>

    <!-- pace progress bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
    <!-- fim pace progress bar -->

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="css/select2-bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

    <!-- Custom fonts for this template-->
    <link href="css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Seus estilos -->
    <link rel="stylesheet" href="css/custom.css" rel="stylesheet">

    <!-- Sweet Alert CSS -->
    <link rel="stylesheet" href="sweetalert2.min.css">

    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <div class="modal"></div>
    <div id="result"></div>
    <?php
    session_start();

    session_regenerate_id(); //gera outro id de sessão para evitar sequestro

    $_SESSION['_token'] = (!isset($_SESSION['_token'])) ? hash('sha512', rand(100, 1000)) : $_SESSION['_token'];

    require_once 'Model/Login.php';
    require_once 'Model/Chamados.php';
    include 'function/function.php';

    $objData = new Data();

    $objLogin = new Model\Login();
    $objChamados = new Model\Chamados();

    //se nao estiver logado ou sessao expirada envia para a tela de login
    if (!$objLogin->isLogado()) {
        $objLogin->Sair($_SESSION['scd_user']);
        header('Location:index.php');
    }

    //funcao de logout
    if (isset($_GET['acao']) && ($_GET['acao'] == 'sair')) {
        $objLogin->Sair($_SESSION['scd_user']);
        header('Location: index.php');
    }

    if($_SESSION['scd_lem_senha'] == 'lem_senha'):

        $expira = time() + 60*60*24*30; 
        setCookie('lem_senha', $_SESSION['scd_lem_senha'], $expira);
        setCookie('user', $_SESSION['scd_user'], $expira);
        setCookie('passwd', $_SESSION['scd_passwd'], $expira);
        // var_dump($_COOKIE);

     else:

        setCookie('lem_senha');
        setCookie('user');
        setCookie('passwd');

     endif; 
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php if ($_SESSION['scd_perfil'] != 3) { ?>
            <!-- Sidebar -->
            <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center"">
                <div class=" sidebar-brand-icon">
                    <!-- <i class="fas fa-laugh-wink"></i> -->
                    <img src="img/gac.png" width="30px" height="40px" alt="logo" title="logo">
    </div>
    <div class="sidebar-brand-text mx-3">OS - 7º GAC</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="?p=home">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <li class="nav-item active">
        <a class="nav-link collapsed" href="?p=fullcalendar">
        <i class="fas fa-calendar text-gray-300"></i>
            <span>Calendário</span>
        </a>
    </li>
    
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSecao" aria-expanded="true" aria-controls="collapseSecao">
            <i class="fas fa-building"></i>
            <span>Seção</span>
        </a>
        <div id="collapseSecao" class="collapse <?= (in_array($_GET['p'], array('secao', 'secao-cadastrar', 'secao-editar', 'equipamentos', 'equipamentos-cadastrar', 'equipamento-editar')) ? 'show' : ''); ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo Seção:</h6>
                <a class="collapse-item <?= (in_array($_GET['p'], array('secao', 'secao-cadastrar', 'secao-editar')) ? 'active' : ''); ?>" href="?p=secao">Seção</a>
                <a class="collapse-item <?= (in_array($_GET['p'], array('equipamentos', 'equipamentos-cadastrar', 'equipamento-editar')) ? 'active' : ''); ?>" href="?p=equipamentos">Equipamentos</a>
            </div>
        </div>
    </li>
    
    <hr class="sidebar-divider">
    
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-user"></i>
            <span>Usuários</span>
        </a>
        <div id="collapseTwo" class="collapse <?= (in_array($_GET['p'], array('usuarios', 'usuarios-cadastrar', 'usuarios-editar', 'usuarioalterpasswd')) ? 'show' : ''); ?> aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo Usuários:</h6>
                <a class="collapse-item <?= (in_array($_GET['p'], array('usuarios', 'usuarios-cadastrar', 'usuarios-editar', 'usuarioalterpasswd')) ? 'active' : ''); ?>" href="?p=usuarios">Usuários</a>
                <!-- <a class="collapse-item" href="?p=clientes">Clientes</a> -->
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseIncidentes" aria-expanded="true" aria-controls="collapseIncidentes">
            <!-- <i class="fas fa-fw fa-wrench"></i> -->
            <i class="fas fa-desktop"></i>
            <span>Componentes</span>
        </a>
        <div id="collapseIncidentes" class="collapse <?= (in_array($_GET['p'], array('materiais', 'materiais-cadastrar', 'materiais-editar', 'estoque', 'estoque-cadastrar', 'estoque-editar', 'estoque-usado', 'estoque-disponivel')) ? 'show' : ''); ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo Estoque</h6>
                <a class="collapse-item <?= (in_array($_GET['p'], array('materiais', 'materiais-cadastrar', 'materiais-editar')) ? 'active' : ''); ?>" href="?p=materiais">Materiais de TI</a>
                <a class="collapse-item <?= (in_array($_GET['p'], array('estoque', 'estoque-cadastrar', 'estoque-editar', 'estoque-usado', 'estoque-disponivel')) ? 'active' : ''); ?>" href="?p=estoque">Estoque</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <li class="nav-item active">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <!-- <i class="fas fa-fw fa-wrench"></i> -->
            <i class="fas fa-headset"></i>
            <span>Chamados</span>
        </a>
        <div id="collapseUtilities" class="collapse <?= (in_array($_GET['p'], array('incidentes', 'incidente-cadastrar', 'incidente-editar', 'chamados', 'chamados-cadastrar', 'chamados-editar', 'chamados-abertos')) ? 'show' : ''); ?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Módulo Chamados:</h6>
                <a class="collapse-item <?= (in_array($_GET['p'], array('incidentes', 'incidente-cadastrar', 'incidente-editar')) ? 'active' : ''); ?>" href="?p=incidentes">Incidentes</a>
                <a class="collapse-item <?= (in_array($_GET['p'], array('chamados', 'chamados-cadastrar', 'chamados-editar', 'chamados-abertos')) ? 'active' : ''); ?>" href="?p=chamados">Chamados</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <a style="margin: 15px;padding: 5px;" class="badge badge-danger" href="?acao=sair">
    Sair
    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>

    </a>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        <p><strong>Níveis de Acesso</strong></p>
        <p style="color: #fff">Nível 1 - Admin</p>
        <p style="color: #fff">Nível 2 - Suporte</p>
        <p style="color: #fff">Nível 3 - Cliente</p>
        <!-- <img class="sidebar-card-illustration mb-2" src="img/undraw_rocket.svg" alt="...">
                <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
                <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a> -->
    </div>

    </ul>
    <!-- End of Sidebar -->
<?php } ?>


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- <div id="result"></div> -->
            <!-- Topbar Search -->
            <?php if($_SESSION['scd_perfil'] != 3) { ?>
            <form action="?p=search" method="post" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                <div class="input-group">
                    <input type="text" name="pesquisar" id="search" class="form-control bg-light border-0 small" placeholder="Procurar por..."
                        aria-label="Search" aria-describedby="basic-addon2">
                    <input type="hidden" name="search" value="teste">
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="button-search">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
            <?php } ?>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <!-- <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                     Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                        <form class="form-inline mr-auto w-100 navbar-search">
                            <div class="input-group">
                                <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li> 

                <!-- Nav Item - Alerts -->
                <?php if($_SESSION['scd_perfil'] != 3) { ?>
                
                <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                 <!-- Counter - Alerts -->
                            <!-- conta de forma dinamica com ajax -->
                            <span id="countChamadodNovos" class="badge badge-danger badge-counter"></span>
                            </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                   Novos Chamados
                                   <br>
                                   <small>Últimos 10 chamados</small>
                                </h6>
                                <!-- lista dos novos chamados vindo atraves do ajax  -->
                                <div id="listChamadosNovos"></div>
                        </div> 
                 </li>
                 <?php }  ?>

                <!-- Nav Item - Messages -->
                <li class="nav-item dropdown no-arrow mx-1">
                    <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-envelope fa-fw"></i>
                        <!-- Counter - Messages -->
                        <!-- contagem vindo via ajax -->
                        <span id="countNewMessages" class="badge badge-danger badge-counter"></span>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                        <h6 class="dropdown-header">
                            Central de Mensagens
                            <br>
                            <small>Últimas 10 mensagens</small>
                        </h6>
                        <!-- listagem vindo via ajax -->
                        <div id="listAllMessages"></div>
                    </div>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo ucfirst($_SESSION['scd_user']); ?></span>
                        <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> -->
                        <!-- <div class="dropdown-divider"></div> -->
                        <a class="dropdown-item" href="?acao=sair">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Sair
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->

        <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->