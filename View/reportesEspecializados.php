<title>ReportesEspecializados</title>
<?php 
include 'header.php';
include '../Model/consultas.php';

$reporte = "";
$programa = "";
$programaID = 0;

if (isset($_GET['v'])) {
	if ($_GET['v']=='SL') {
		$programa = $_GET['v'];
		$programaID = '1';
	}
	else if ($_GET['v']=='MLB') {
		$programa = $_GET['v'];
		$programaID = '2';
	}
}

if (isset($_GET['x'])) {
	switch ($_GET['x']) {
		//Reporte de alumnos
		case 'alumnos':
			$reporte = 1;
			break;

		//Reporte de mensajes
		case 'mensajes':
			$reporte = 2;
			break;
		
		default:
			# code...
			break;
	}
}
//echo($reporte);
//echo($programa);
//echo($programaID);

$resul = reporteEsp($reporte, $programaID, $conexion);
//echo '<pre>';
//var_dump($resul);
//echo '</pre>';
if ($reporte=='1') { ?>
<h2>Usuarios Inscritos en <?php echo $programa; ?></h2>
<table class="[ horarios ][ cell ][ table table-striped ]">
	<tbody>
		<tr>
			<td>#</td>
			<td>NOMBRE</td>
			<td>EMAIL</td>
			<td>TELÉFONO</td>
		</tr>
	<?php for ($i=0; $i <sizeof($resul); $i++) { ?>
		<tr>
			<td><?php echo $i+1; ?></td>
			<td><?php echo $resul[$i]['apellido'].' '.$resul[$i]['nombre']; ?></td>
			<td><?php echo $resul[$i]['email']; ?></td>
			<td><?php echo $resul[$i]['telefono']; ?></td>
		</tr>
	<?php } ?>		
	</tbody>
</table>
<?php 
}elseif ($reporte=='2') { ?>
	<h2>Mensajes de <?php echo $programa; ?></h2>
	<?php
	if (sizeof($resul=='0')) {
		echo '<center>Por el momento no hay mensaje alguno.</center><br/><br/><br/>';
	}
	for ($i=0; $i < sizeof($resul) ; $i++) {  ?>
	<h3>Mensaje #<?php echo $i; ?></h3>
	Nombre: <?php echo $resul[$i]['nombre']; ?><br/>
	Email: <?php echo $resul[$i]['email']; ?><br/>
	Msj: <?php echo $resul[$i]['msj']; ?><br/><br/>
<?php } } ?>



<?php include 'footer.php'; ?>