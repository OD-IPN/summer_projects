<title>Reporte Grupal</title>
<?php 
//include 'header.php';

include '../Model/consultas.php';
//$usar = $_SESSION['info'];
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
  echo '<body id="page4">';  
  echo '<div class="body1">
  <div class="body2">
    
      <div class="main">
        <!-- header -->';

if(isset($_GET["v"]) && isset($_GET["id"])){
	if($_GET["v"]=="SL"){
		$infoSede = consultaCursoId($_GET['id'], $conexion);
		$infoSede = json_decode($infoSede);
	}
}

?>
<h2>Grupo <?php echo $infoSede[0]->programa.'-'.$infoSede[0]->id; ?></h2>
<table class="[ reporte ]"> 
	<tbody>
		<tr>
		<?php $nombreSede = nombreSede($infoSede[0]->sede, $conexion);
		$nombreSede = json_decode($nombreSede);
		$nombreSede = $nombreSede[0]->nombre;

		$inscritos = json_decode(consultaRegistradosGrupo($infoSede[0]->id, $conexion));
		$sinPagar = json_decode(consultaHorariosEstado('0', $infoSede[0]->id, $conexion));
		$validando = json_decode(consultaHorariosEstado('1', $infoSede[0]->id, $conexion));
		$pagado = json_decode(consultaHorariosEstado('2', $infoSede[0]->id, $conexion));
		$rechazados = json_decode(consultaHorariosEstado('3', $infoSede[0]->id, $conexion));
		
		?>
			<td> <b>Sede: </b> <?php echo($nombreSede); ?></td>
			<td> <b>Idioma: </b> <?php echo($infoSede[0]->idioma); ?></td>
			<td> <b>Nivel: </b> <?php echo($infoSede[0]->nivel); ?></td>
		</tr>
		<tr>
			<td><b>Horario: </b> <?php echo($infoSede[0]->inicio.'-'.$infoSede[0]->fin); ?></td>
			<td> <b>Modalidad: </b> <?php echo($infoSede[0]->modalidad); ?></td>
		</tr>
	</tbody>
</table>
<table class="[ table table-striped ]">
	<tbody>
		<tr>
			<td> <center> # Inscritos </center> </td>
			<td> <center> # Sin Pagar </center> </td>
			<td> <center> # En Revisión </center> </td>
			<td> <center> # Pagado </center> </td>
			<td> <center> # Rechazado </center> </td>
		</tr>
		<tr>
			<td> <center> <?php echo($inscritos[0]); ?> </center> </td>
			<td> <center> <?php echo($sinPagar[0]); ?> </center> </td>
			<td> <center> <?php echo($validando[0]); ?> </center> </td>
			<td> <center> <?php echo($pagado[0]); ?> </center> </td>
			<td> <center> <?php echo($rechazados[0]); ?> </center> </td>
		</tr>
	</tbody>
</table>

<h3>Lista de Alumnos</h3>
</table>
<table class="[ table table-striped ]">
	<tbody>
		<tr>
			<td> <center> ID </center> </td>
			<td> <center> Nombre </center> </td>
			<td> <center> Email </center> </td>
			<td> <center> Teléfono </center> </td>
			<td> <center> Estado </center> </td>
			<td>  </td>
		</tr>
		
		<?php 
		$infoXsede = json_decode(consultaInscripcionId($infoSede[0]->id, $conexion));
		//echo '<pre>';
		//var_dump($infoXsede);
		//echo '<pre>';
		if($infoXsede)
		for ($f=0; $f < sizeof($infoXsede); $f++) { 
			$infoUser = consultaUsuarioId($infoXsede[$f]->id_usuario, $conexion);
			?>
		<tr>
			<td> 
				<center>
					<?php echo($infoXsede[$f]->id_usuario); ?>
				</center>
			</td>
			<td> 
				<center>
					<?php echo($infoUser[4].' '.$infoUser[3]); ?>
				</center>
			</td>
			<td> 
				<center>
					<?php echo($infoUser[6]); ?>
				</center>
			</td>
			<td> 
				<center>
					<?php echo($infoUser[11]); ?>
				</center>
			</td>
			<?php if($infoXsede[$f]->estado!='0'){
			 $estadoPago = json_decode(consultaEstadoUserCurso($infoXsede[$f]->id_usuario, $_GET['id'], $conexion)); ?>
			<td class="<?php echo('[ pago'.$estadoPago[0].' ]') ?>"> 
				<center>
					<?php
						switch (($estadoPago[0])) {
							case '0':
								echo("Sin Pagar");
								break;

							case '1':
								echo("En Revisión");
								break;
							
							case '2':
								echo("Pagado");
								break;
							
							case '3':
								echo("Rechazado");
								break;
							
							default:
								# code...
								break;
						};
					 ?>
				</center>
			</td>
			<?php } else { ?>
			<td class="[ pago0 ]"><center>Sin Pagar</center></td>
			<?php } ?>
			<td><center><img src="images/delete.png" class="group_delete_js" /><input type="hidden" value="<?php echo($infoXsede[$f]->id_usuario); ?>" class="[ user_id ]" name="user_id" ><input type="hidden" value="<?php echo($_GET['id']); ?>" class="[ group_id ]" name="group_id"><input type="hidden" value="<?php echo($_GET['v']); ?>" class="[ program_id ]" name="program_id"><input type="hidden" value="<?php echo($infoXsede[$f]->id); ?>" class="[ user_id ]" name="user_id" ></center></td>
		</tr>
		<?php } ?>
	</tbody>
</table>

<script type="text/javascript">	  
	borrarAlumno();
</script>

<?php //include 'footer.php'; ?>
