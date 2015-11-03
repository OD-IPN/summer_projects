<title>Pagos</title>
<?php 
include 'header.php';
include '../Model/consultas.php';
if (isset($_GET['v'])) {
	if ($_GET['v']=='SL') {
		$pendientes = json_decode(consultaPagosEstado('1', $conexion));
		$aceptados = json_decode(consultaPagosEstado('2', $conexion));
		//echo("<pre>");
		//var_dump($pendientes);
		//echo("</pre>");
	}
	else if ($_GET['v']=='MLB') {
		$pendientes = json_decode(consultaPagosEstadoMLB('1', $conexion));
		$aceptados = json_decode(consultaPagosEstadoMLB('2', $conexion));

		////echo("<pre>");
		////var_dump($pendientes);
		////echo("</pre>");
		
		////echo("<pre>");
		////var_dump($aceptados);
		////echo("</pre>");


	}
} ?>

<form class="[ comprobantes_js ]">

<?php 
	if(sizeof($pendientes)>0)
		echo '<h2>Comprobantes de Pago Pendientes.</h2>';
	for ($pago=0; $pago < sizeof($pendientes); $pago++) { 
	$infoPago = json_decode(consultaPagoID($pendientes[$pago]->pago, $conexion));
	//echo("<pre>");
	//var_dump($infoPago);
	//echo("</pre>");

	?>
	
	<table class="[ table table-striped ][ cell ]">
		<tr>
			<td>NOMBRE</td>
			<td>EMAIL</td>
			<td>FECHA</td>
			<td>NO. AUTENTIFICACIÓN</td>
			<td>NO. SUCURSAL</td>
			<td>MONTO</td>
			<td> <input type="hidden" class="[ user_id ]" value="<?php echo($infoPago[0]->id); ?>"> </td>
		</tr>
		<tr>
			<?php 

			if (1) {
				$infoPago[0]->id; // Pago ID
				if (isset($_GET['v'])) if($_GET['v']=='MLB'){
					$pagoInfo = json_decode(consultaInfoPagoMLB($infoPago[0]->id, $conexion));
					
					$user_Pago = $pagoInfo[0]->id_usuario;
					$user_info = consultaUsuarioId($user_Pago, $conexion);
					//var_dump($user_info);

				}elseif ($_GET['v']=='SL') {
					$pagoInfo = json_decode(consultaInfoPago($infoPago[0]->id, $conexion));
					$user_Pago = $pagoInfo[0]->id_usuario;
					$user_info = consultaUsuarioId($user_Pago, $conexion);
					//var_dump($user_info);
				}

				$nombre = $user_info[3].' '.$user_info[4];
				$email = $user_info[6];
				//echo $nombre;
				//echo $email;
			}
			
			 ?>

			<td><?php echo $nombre; ?></td>
			<td><?php echo $email; ?></td>
			<td><?php echo $infoPago[0]->fecha; ?></td>
			<td><?php echo $infoPago[0]->autentificacion; ?></td>
			<td><?php echo $infoPago[0]->sucursal; ?></td>
			<td><?php echo $infoPago[0]->monto; ?></td>
			<td> <input type="hidden" value="<?php if (isset($_GET['v'])) { echo($_GET['v']); } ?>" name="programa" id="programa" />
			  <input type="submit" value="Aprobar" class="[ btn-success ][ pago_js_A ]">
			  <input type="submit" value="Rechazar" class="[ btn-danger ][ pago_js_R ]">
			</td>
		</tr>
	</table>
		<?php if ($infoPago[0]->foto!='images/uploads/') { ?>
	<center>
		<img src="<?php echo($infoPago[0]->foto); ?>" class="img_pago">
	</center>
		<?php } ?>
	
<?php } ?>
</form>
<br/>

<?php 
	if(sizeof($pendientes)>0)
		echo '<h2>Comprobantes Validados. </h2>';
	for ($pago=0; $pago < sizeof($aceptados); $pago++) { 
	$infoPago = json_decode(consultaPagoID($aceptados[$pago]->pago, $conexion)); ?>
	<table class="[ table table-striped ][ cell ]">
		<tr>
			<td>ID</td>
			<td>FECHA</td>
			<td>NO. AUTENTIFICACIÓN</td>
			<td>NO. SUCURSAL</td>
			<td>MONTO</td>
		</tr>
		<tr>
			<td><?php echo $infoPago[0]->id; ?></td>
			<td><?php echo $infoPago[0]->fecha; ?></td>
			<td><?php echo $infoPago[0]->autentificacion; ?></td>
			<td><?php echo $infoPago[0]->sucursal; ?></td>
			<td><?php echo $infoPago[0]->monto; ?></td>
		</tr>
	</table>

<?php } ?>

<?php include 'footer.php'; ?>