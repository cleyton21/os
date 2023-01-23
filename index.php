<?php
session_start();

include_once "Model/Login.php";
$objLogin = new Model\Login();

// include_once "./Controller/Login.php";

// se estiver logado não pode ficar aqui
if ($objLogin->isLogado()) {
    // $objLogin->Sair($_SESSION['scd_user']);
    header('Location:admin.php');
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>7º GAC</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


    <!-- Custom fonts for this template-->
    <link href="css/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link rel="stylesheet" href="css/custom.css" rel="stylesheet">
    
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>    
      .olho {
            cursor: pointer;
            left: 360px;
            position: absolute;
            width: 30px;
            margin-top: -33px;
            }
    </style>
</head>
<div class="modal"></div>
<div id="result"></div>
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bem Vindo! OS 7º GAC</h1>
                                    </div>

                                    <form id="formLogin" method="post">
                                        <div class="form-group">
                                            <input type="text" name="user" value="<?php if(isset($_COOKIE['user'])){ echo $_COOKIE['user'];} ?>" class="form-control form-control-user"
                                                placeholder="Usuário">
                                        </div>
                                        <div class="form-group">
                                            <input id="pass" type="password" name="passwd" value="<?php if(isset($_COOKIE['passwd'])){ echo $_COOKIE['passwd'];} ?>" class="form-control form-control-user"
                                                placeholder="Senha">
                                                <img src="https://cdn0.iconfinder.com/data/icons/ui-icons-pack/100/ui-icon-pack-14-512.png" id="olho" class="olho">
                                        </div>
                                        <hr>

                                        <div class="form-group">
                                            <input type="checkbox" name="lem_senha" value="lem_senha" <?php if(isset($_COOKIE['lem_senha'])){ echo 'checked'; } ?>> Lembrar de mim
                                        </div>

                                        <input type="hidden" name="acao" value="logar"/>
                                        <button id="logar" class="btn btn-md btn-block btn-primary btn-color">Login</button>
                                        <button style="display:none" id="logando" class="btn btn-primary btn-md btn-block" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Logando...
                                        </button>

                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>     

 <!-- Bootstrap core JavaScript-->
 <script src="js/jquery/jquery.min.js"></script>
 <!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->

 <script src="css/bootstrap/js/bootstrap.bundle.min.js"></script>
 <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

 <!-- Core plugin JavaScript-->
 <!-- <script src="js/jquery-easing/jquery.easing.min.js"></script> -->

 <!-- Custom scripts for all pages-->
 <script src="js/sb-admin-2.min.js"></script>

 <script src="css/datatables/jquery.dataTables.min.js"></script>
 <script src="css/datatables/dataTables.bootstrap4.min.js"></script>

 <script src="js/demo/datatables-demo.js"></script>

 <script src="js/scripts.js"></script>

 <script>
     $( "#olho" ).mousedown(function() {
    $("#pass").attr("type", "text");
    });

    $( "#olho" ).mouseup(function() {
    $("#pass").attr("type", "password");
    });
 </script>


</body>

</html>