<?php

if($_SESSION['scd_perfil'] == 3){
    echo '<meta HTTP-EQUIV="Refresh" CONTENT="0; URL=?p=chamados-usuario">';
}

require_once "Model/Chamados.php";
require_once "Model/Usuarios.php";
$objChamados = new Model\Chamados();
$objUsuarios = new Model\Usuarios();

?>

<div class="container-fluid">
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4 row">
        <div class="col-md-10">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        
        <div class="col-md-2">
            <a href="?p=chamados"; class="d-none d-sm-inline-block btn btn-sm btn-success">
                    Chamados
            </a>
            <a href="?p=chamados-cadastrar" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                Abrir Ticket
            </a>
        </div>
</div>

<!-- Content Row -->
<div class="row">

   
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="?p=chamados&status=abertos-hoje" style="text-decoration: none;">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Chamados abertos hoje</div>
                        <div id="countChamadosAbertosHoje" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                    </div>
                    <div class="col-auto">
                        <!-- <i class="fas fa-calendar fa-2x text-gray-300"></i> -->
                    </div>
                </div>
            </div>
        </div>
    </a>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="?p=chamados&status=pendentes" style="text-decoration: none">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Chamados Pendentes</div>
                            <!-- contagem via ajax -->
                        <div id="countChamadosPendentes" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                    </div>
                    <div class="col-auto">
                        <!-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> -->
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="?p=chamados&status=aguardando-resposta-do-usuario" style="text-decoration: none">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Aguardando resposta do usuário
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <!-- via ajax -->
                                <div id="countAguardandoRespostaUsuario" class="h5 mb-0 mr-3 font-weight-bold text-gray-800"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <!-- <i class="fas fa-clipboard-list fa-2x text-gray-300"></i> -->
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <a href="?p=chamados&status=resolvidos-hoje" style="text-decoration: none">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="teste col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Chamados Resolvidos Hoje</div>
                        <div id="countResolvidosHoje" class="h5 mb-0 font-weight-bold text-gray-800"></div>
                    </div>
                    <div class="col-auto">
                        <!-- <i class="fas fa-comments fa-2x text-gray-300"></i> -->
                    </div>
                </div>
            </div>
        </div>
        </a>
    </div>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Chamados mensais
                <i class="fas fa-headset text-gray-500"></i>
                </h6>
                <!-- <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div> -->
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
                <!-- dados que irão alimentar os gráficos chart-area.demo.js -->
                <div style="display:none" id="chamadosJan"><?= $objChamados->countChamadosJaneiroAtual(); ?></div>
                <div style="display:none" id="chamadosFev"><?= $objChamados->countChamadosFevereiroAtual(); ?></div>
                <div style="display:none" id="chamadosMar"><?= $objChamados->countChamadosMarcoAtual(); ?></div>
                <div style="display:none" id="chamadosAbr"><?= $objChamados->countChamadosAbrilAtual(); ?></div>
                <div style="display:none" id="chamadosMai"><?= $objChamados->countChamadosMaioAtual(); ?></div>
                <div style="display:none" id="chamadosJun"><?= $objChamados->countChamadosJunhoAtual(); ?></div>
                <div style="display:none" id="chamadosJul"><?= $objChamados->countChamadosJulhoAtual(); ?></div>
                <div style="display:none" id="chamadosAgo"><?= $objChamados->countChamadosAgostoAtual(); ?></div>
                <div style="display:none" id="chamadosSet"><?= $objChamados->countChamadosSetembroAtual(); ?></div>
                <div style="display:none" id="chamadosOut"><?= $objChamados->countChamadosOutubroAtual(); ?></div>
                <div style="display:none" id="chamadosNov"><?= $objChamados->countChamadosNovembroAtual(); ?></div>
                <div style="display:none" id="chamadosDez"><?= $objChamados->countChamadosDezembroAtual(); ?></div>
                <script>
                    var chamadosJan = document.getElementById('chamadosJan').innerText;
                    var chamadosFev = document.getElementById('chamadosFev').innerText;
                    var chamadosMar = document.getElementById('chamadosMar').innerText;
                    var chamadosAbr = document.getElementById('chamadosAbr').innerText;
                    var chamadosMai = document.getElementById('chamadosMai').innerText;
                    var chamadosJun = document.getElementById('chamadosJun').innerText;
                    var chamadosJul = document.getElementById('chamadosJul').innerText;
                    var chamadosAgo = document.getElementById('chamadosAgo').innerText;
                    var chamadosSet = document.getElementById('chamadosSet').innerText;
                    var chamadosOut = document.getElementById('chamadosOut').innerText;
                    var chamadosNov = document.getElementById('chamadosNov').innerText;
                    var chamadosDez = document.getElementById('chamadosDez').innerText;
                </script>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Usuários / chamados mês corrente
                <i class="fas fa-user text-gray-500"></i>
                </h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <canvas id="myPieChart"></canvas>
                </div>

                <!-- array de cores com a qtd total do numero de clientes -->
                <?php
                    $colors = array("#1976D2", "#424242", "#82B1FF", "#FF5252", "#2196F3", "#4CAF50", "#FFC107", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2", "#1976D2")
                ?>
                </script>
                

                <!-- dados que alimentam o chart donuts -->
                <div style="visibility:hidden" id="chamadosUsuarios" data-chamadosUsuarios="<?= $objChamados->countChamadosUsuarios(); ?>"></div>
                <div style="display:none" id="chamadosQtdUser" data-qtdUser="<?= $objChamados->countQtdChamadosUsuarios(); ?>"></div>
                <script>
                    var chamadosUsuarios = document.getElementById('chamadosUsuarios');
                    var chamadosQtdUser = document.getElementById('chamadosQtdUser');

                    const userChamados = chamadosUsuarios.getAttribute("data-chamadosUsuarios");
                    const qtdChamados = chamadosQtdUser.getAttribute("data-qtdUser");

                    const user = userChamados.split(','); //transforma em array
                    const qtdUser = qtdChamados.split(','); //transforma em array
                    
                    user.splice(-1); // aqui remove o último elemento do array
                    qtdUser.splice(-1); // aqui remove o último elemento do array

                    // console.log(qtdUser);
                </script>

                <div class="mt-4 text-center small">
                    <span class="mr-2"></span>
                </div>
                <!-- fim do chart donuts -->
            </div>
        </div>
    </div>
</div>

<!-- div calendario -->
<div class="row">
    <div class="col-md-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Calendário
                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                </h6>
            </div>
            <div class="card-body">
                <?php include "fullcalendar.php"; ?>
            </div>
        </div>
    </div>
</div>
<!-- fim da div calendario -->

<div class="row">
    <div class="col-md-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Máquinas / Equipamentos
            <i class="fas fa-desktop text-gray-600"></i>
            </h6>
        </div>
        <div class="card-body">
            <div class="chart-bar">
                <canvas id="myBarChart"></canvas>
            </div>
            <hr>
            Ranking dos chamados por Máquinas / Equipamentos do corrente ano
            
            <!-- dados que irão alimentar os gráficos chart-bar.demo.js -->
            <div style="display:none" id="chamadosNomeMaquinas" data-chamados="<?= $objChamados->countChamadosNomeMaquinas(); ?>"></div>
            <div style="display:none" id="chamadosQtdMaquinas" data-qtdChamados="<?= $objChamados->countChamadosQtdMaquinas(); ?>"></div>
            <script>
                var chamadosNomeMaquinas = document.getElementById('chamadosNomeMaquinas');
                var chamadosQtdMaquinas = document.getElementById('chamadosQtdMaquinas');
                
                const nomeChamados = chamadosNomeMaquinas.getAttribute("data-chamados");
                const nomeQtdChamados = chamadosQtdMaquinas.getAttribute("data-qtdChamados");

                const nome = nomeChamados.split(','); //transforma em array
                const qtd = nomeQtdChamados.split(','); //transforma em array
                
                nome.splice(-1); // aqui remove o último elemento do array
                qtd.splice(-1); // aqui remove o último elemento do array

                //console.log(final); // retorna com o vazio o último elemento
                // console.log(nome); // aqui é o array final sem o último elemento
            </script>

        </div>
    </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Content Column -->
    <div class="col-lg-6 mb-4">

        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <?php
                $numero_mes = date('m')*1;
                $mes = array('', "Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro")
                ?>
                <h6 class="m-0 font-weight-bold text-primary">Porcentagem dos chamados de <?= $mes[$numero_mes].' de '. date('Y'); ?>
                <i class="fa fa-percent text-gray-500"></i>
                </h6>
            </div>
            <div class="card-body">
            <?php
                $listar = $objChamados->incidentesChamadosMensal(); //listar os 6 incidentes dos chamados hoje
                // $qtdTotal = count($listar); //conta os registros mensais
                
                $sum = 0;
                foreach($listar as $b){
                    $sum += $b->qtd;
                }
                // echo $sum;

                $bgs = array("primary", "success", "info", "warning", "secondary", "danger");
                $bg = "";
                $cor = "-1"; 
                foreach ($listar as $linha) {        

                    if($cor==count($bgs)){
                        }else{
                            $cor++; 
                        }   
                        if($cor > 5) { //usado para repetir as 6 cores se tiver mais de 6. indice começa em 0
                            $cor = 0;
                        }
                    $bg = $bgs[$cor];
                ?>
                      <h4 class="small font-weight-bold"><?= $linha->incidente; ?><span
                        class="float-right"><?= round(($linha->qtd/$sum)*100) ?>%</span></h4>
                        <div class="progress mb-4">
                        <div class="progress-bar bg-<?= $bg; ?>" role="progressbar" style="width: <?= ($linha->qtd/$sum)*100 ?>%"
                            aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                            <!-- <div class="progress-bar" role="progressbar" style="width: <?= ($linha->qtd/$sum)*100 ?>%; background-color: <?= $linha->cor; ?>" -->
                        </div>
                <?php } //fim do foreach ?>
                
            </div>
        </div>
    </div>


    <div class="col-lg-6 mb-2">
        <!-- Illustrations -->
        <div class="card shadow mb-2">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Incidentes de <?= $mes[$numero_mes].' de '. date('Y'); ?>
                    <i class="fas fa-ticket-alt text-gray-500"></i>
                </h6>
                <!-- <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Escolher mês / ano:</div>
                            <a class="dropdown-item" href="#">Mês: <?= date('m'); ?></a>
                            <a class="dropdown-item" href="#">Ano: <?= date('Y'); ?></a>
                             <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a> 
                        </div>
                </div> -->
            </div>

            <div class="card-body d-lg-flex flex-lg-wrap">
                <?php
                $listar = $objChamados->incidentesChamados(); //listar os incidentes dos chamados
                
                $bgs = array("primary", "success", "info", "warning", "secondary", "danger");
                $bg = "";
                $cor = "-1"; 
                foreach ($listar as $linha) {    
                                    
                    if($cor==count($bgs)){
                    }else{
                        $cor++; 
                    }   
                    if($cor > 5) { //usado para repetir as 6 cores se tiver mais de 6. indice começa em 0
                        $cor = 0;
                    } 
                    $bg = $bgs[$cor];
                    ?>
                    <div class="col-md-12 col-lg-6 mb-4">
                        <a href="?p=chamados&incidente=<?= $linha->id_incidente; ?>" style="text-decoration: none;">
                        <div style="height: 140px"; class="card bg-<?= $bg; ?> text-white shadow">
                        <!-- <div style="background-color: <?= $linha->cor; ?>" class=" card text-white shadow"> -->
                            <div class="card-body">
                            <?= $linha->incidente; ?>
                                <div class="text-white-50 small"><?= $linha->qtd; ?></div>
                                <!-- <br> -->
                                <?php 
                                if($linha->status == 'Resolvido'){ 
                                    $minutos = $linha->minutos;
                                    $sla_minutos = intdiv($minutos, $linha->qtd); //media em minutos

                                    // transformar em horas
                                    if($sla_minutos >= 60){
                                        $horas = intdiv($sla_minutos, 60); //pega o valor inteiro da divisão
                                        
                                        if($horas >= 24) { //transforma horas em dias se for maior que 24h
                                            $dias = intdiv($horas, 24); // dias
                                            $horas = $dias % 24; //horas

                                            $minutos = intdiv($horas, 24); //minutos inteiros
                                            $minutos = $minutos % 60;
                                            
                                            $dias = $dias . ' dias ';
                                            $horas = $horas . ' horas ';
                                            $minutos = $minutos . ' minutos ';

                                        } else { //se as horas forem menor que 24h
                                            $dias = "";
                                            $horas1 = $horas;
                                            $horas = $horas1 . ' horas e ';                                           
                                            $minutos = $horas1 % 60; //pega o resto da divisão                                            
                                            $minutos = $minutos. ' minutos';
                                        }

                                        
                                    } else { //se sla for menor que 60min
                                        $dias = "";
                                        $horas = "";
                                        $minutos = $sla_minutos. ' minutos'; //sla abaixo de 60min
                                    }
                                    
                                ?>
                                <small><i>Sla médio: <?php echo $dias, $horas, $minutos; ?></i></small>
                                <?php } ?>
                            </div>
                        </div>
                    </a>
                    </div>
                    <?php } //fim do foreach
                    ?>            
            </div>
        </div>    
    </div>
</div>