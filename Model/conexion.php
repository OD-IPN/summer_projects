<?php 
//$dbhost= "$OPENSHIFT_MYSQL_DB_HOST";
//$dbusuario="adminyZspehi";
//$dbpassword="8xth1Xr9L2Wl";
//$db="aiesec";


$dbhost= "localhost";
$dbusuario="root";
$dbpassword="root";
$db="leviathan";
$conexion = mysql_connect($dbhost,$dbusuario,$dbpassword)or die ('Ha fallado la conexión: '.mysql_error());
mysql_select_db($db, $conexion) or die ('Error al seleccionar la Base de Datos: '.mysql_error());
mysql_query("SET NAMES 'utf8'");
?>