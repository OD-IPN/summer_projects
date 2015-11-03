<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include '../Model/conexion.php';
include '../Model/consultas.php';
//include 'header.php';

$rutaEnServidor='images/uploads';
$rutaTemporal=$_FILES['foto']['tmp_name'];
$nombreImagen=$_FILES['foto']['name'];
$rutaDestino= $rutaEnServidor.'/'.$nombreImagen;
$moved = move_uploaded_file($rutaTemporal,$rutaDestino);

$reg = registerPago($_POST, $rutaDestino, $conexion);
echo '<head>
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
</head>';
echo '<body><body>';
echo '<script language="javascript"> swal("Gracias", "Tu comprobante está siendo registrado.", "success"); </script>';

if($reg){
    if(isset($_POST['programa'])) {
      switch ($_POST['programa']) {
        case '1':
          $programe = 'SL';
          break;

        case '2':
          $programe = 'MLB';
          break;
        
        default:
          # code...
          break;
      }
      echo '<script language="javascript">swal("Tu comprobante se ha registrado correctamente!", "Este será validado en breve.", "success"); setTimeout("location.href=\"miHorario.php?v='.$programe.'\"", 2000); </script>';
    }
  }else{
      echo '<script language="javascript">swal("Ha habido un error registrando tu comprobante.", "Por favor intentalo nuevamente.", "error"); setTimeout("location.href=\"miHorario.php?v='.$programe.'\"", 2000); </script>';
    } ?>
