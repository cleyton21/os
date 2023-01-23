<!--Arquivo controlador principal-->
<?php
    include_once 'includes/header.php';  
?>
    <?php
        if (isset($_GET['p']) && ($_GET['p']) != '') {
                $page = strip_tags($_GET['p']);
                $pagina = array('includes');
                foreach($pagina as $path) {
                $arq = $path.'/'.$page.'.php';
                }                
                if (file_exists($arq)){
                        include 'includes/'.$page.'.php';
                }else{
                        include 'includes/404.php';
                }                
        }else{
                if($_SESSION['scd_perfil'] == 3) {
                 include 'includes/chamados-usuario.php';
                }else {
                 include 'includes/home.php';
                }
        }
    ?>        
<?php
    include_once 'includes/footer.php';   
?>
