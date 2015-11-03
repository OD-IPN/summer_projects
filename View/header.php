<?php 
include '../Controller/functions.php';
include '../Controller/Usuario.php';

session_start();

$title = get_title();
$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = ''; 
$mode = 0;
$index = 0;
if(isset($_SESSION['user'])){
  $logged = true;
}else{
  $logged = false;
}

switch ($title) {
  case 'index.php':
    if(!isset($_GET['v'])){
      $index = true;
    }else{
      $index = false;
      $mode = $_GET['v'];
    }
    $s1='class="active"';
    break;
  case 'products.php':
    //echo $title;
    $s2='class="active"';
    break;
  case 'locations.php':
    //echo $title;
    $s3='class="active"';
    break;
  case 'register.php':
    //echo $title;
    $s4='class="active"';
    break;
  case 'contact.php':
    //echo $title;
    $s5='class="active"';
    break;
  case 'login.php':
    //echo $title;
    $s6='class="active"';
    break;
  case 'miHorario.php':
    //echo $title;
    $s7='class="active"';
    break;
case 'reportes.php':
    //echo $title;
    $s8='class="active"';
    break;
case 'pagos.php':
    //echo $title;
    $s9='class="active"';
    break;
  
  default:
    # code...
    break;
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="recursos/lib-sweetalert-master/sweet-alert.css" type="text/css" media="all">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<link rel="stylesheet" href="recursos/bootstrap/css/bootstrap.min.css" type="text/css" media="all">
<link rel="stylesheet" href="recursos/bootstrap/css/bootstrap-theme.min.css" type="text/css" media="all">

<script type="text/javascript" src="js/jquery-1.6.js" ></script>
<script type="text/javascript" src="js/jquery.js" ></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cufon-replace.js"></script>
<script type="text/javascript" src="js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="js/tabs.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/tms-0.3.js"></script>
<script type="text/javascript" src="js/tms_presets.js"></script>
<script type="text/javascript" src="js/jcarousellite.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/validate.min.js"></script>
<script type="text/javascript" src="js/Zurols.js"></script>
<script type="text/javascript" src="recursos/lib-sweetalert-master/sweet-alert.min.js"></script>
<script type="text/javascript" src="recursos/bootstrap/js/bootstrap.min.js"></script>

<!--[if lt IE 9]>
<script type="text/javascript" src="js/html5.js"></script>
<style type="text/css">.bg{behavior:url("js/PIE.htc");}</style>
<![endif]-->
</head>';
if($title=='index.php'){
  echo '<body id="pageIndex">';    
}else{
  echo '<body id="page4">';  
}

echo '<div class="body1">
  <div class="body2">
    <div class="body5">
      <div class="main">
        <!-- header -->';
        if($title!='index.php'){
          echo '<header class="header">';    
        }else{
           echo '<header class="header">';    
        }
        if(!$index && isset($_GET['v'])){
            if( $_GET['v']=='SL' || $_GET['v']=='MLB' )
              $get = "?v=".$_GET['v'];
            else{
              if(isset($_GET['x']))
                $get = "?v=".$_GET['x'];
            }
        } 
        else
          $get = "";
          echo '<div class="wrapper">';
          if(isset($_GET['v']))
            if( $_GET['v']=='SL' || $_GET['v']=='MLB' )
              echo '<h1><a href="index.php'.$get.'" id="logo">Leviathan - Internal Operations</a></h1>';
            else 
              echo '<h1><a href="index.php'.$get.'" id="logo">Leviathan - Internal Operations</a></h1>';
            else
              echo '<h1><a href="#" id="logo">Leviathan - Internal Operations</a></h1>';
            echo '<nav>
              <ul id="menu">';
                if(0){
                  echo '<li id="nav1"'.$s1.' ><a href="index.php">Home<span>Inicio</span></a></li>';
                }
                if(0){
                  echo '<li id="nav4"'.$s2.' ><a href="products.php">Products<span>Productos</span></a></li>';
                }
                if(1){
                  echo '<li id="nav2"'.$s3.' ><a href="locations.php'.$get.'">Locations<span>Sedes</span></a></li>';
                }
                if(!$logged && !$index){
                  echo '<li id="nav3"'.$s4.' ><a href="register.php'.$get.'">Login/Register<span>Registro/Iniciar Sesión</span></a></li>';
                }
                //if(!$index && whoAmI()!=='3' ){
                if(!$index){
                  echo '<li id="nav5"'.$s5.' ><a href="contact.php'.$get.'">Contacts<span>Contacto</span></a></li>';
                }
                if(0){
                //if($logged){
                  echo '<li id="nav6"'.$s6.' ><a href="horario.php'.$get.'">Schedule<span>Horario</span></a></li>';
                }
                if($logged){
                //if($logged){
                  echo '<li id="nav6"'.$s7.' ><a href="miHorario.php'.$get.'">Schedule<span>Horario</span></a></li>';
                }
                if($logged && ( whoAmI()=='1' || whoAmI()=='3') ){
                  echo '<li id="nav7"'.$s8.' ><a href="reportes.php?v=SL">Reportes<span>SL</span></a></li>';
                  echo '<li id="nav9"'.$s9.' ><a href="pagos.php?v=SL">Pagos<span>SL</span></a></li>';
                }
                if($logged && ( whoAmI()=='2' || whoAmI()=='3') ){
                  echo '<li id="nav7"'.$s8.' ><a href="reportesMLB.php?v=MLB">Reportes<span>MLB</span></a></li>';
                  echo '<li id="nav9"'.$s9.' ><a href="pagos.php?v=MLB">Pagos<span>MLB</span></a></li>';
                }
                if($logged){
                  if(isset($_GET['v'])){
                    if ( $_GET['v'] == 'SL') {
                      echo '<li id="nav8"><a href="#" class="js-logoutSL">Logout<span>Cerrar Sesión</span></a></li>';
                    }else
                      echo '<li id="nav8"><a href="#" class="js-logout">Logout<span>Cerrar Sesión</span></a></li>';
                    }else{
                      echo '<li id="nav8"><a href="#" class="js-logout">Logout<span>Cerrar Sesión</span></a></li>';
                    }
                }
            echo '</ul>
            </nav>
          </div>';
if(0){
//if($title=='index.php'){
  echo '        <div class="[ slider_css ]">  <div class="wrapper">
            <div class="slider">
              <ul class="items">
                <li><img src="images/img1.jpg" alt=""></li>
                <li><img src="images/img2.jpg" alt=""></li>
                <li><img src="images/img3.jpg" alt=""></li>
                <li><img src="images/img4.jpg" alt=""></li>
              </ul>
            </div>
          </div>
        </div>';
}
echo '        </header>
        <!-- header end-->
      </div>
    </div>
  </div>
</div>
<div class="body3">
  <div class="main">
    <!-- content -->';
 ?>