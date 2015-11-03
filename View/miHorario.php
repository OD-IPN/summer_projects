<title>MiHorario</title>
<?php 
include 'header.php';
if(!isset($_SESSION['user'])){
	echo '<script language="javascript">setTimeout("location.href=\"register.php\"", 10); </script>';
}

include '../Model/consultas.php';

$info = consultaUsuarioId($_SESSION['user'], $conexion);
//var_dump($info); ?>

<h2><center><?php echo $info[3].' '.$info[4]; ?></center></h2>

<?php if(isset($_GET['v']))
	if($_GET['v']=='MLB'){
		$inscrito =estaInscritoMLB(myID(), $conexion);
		if($inscrito){
			$horarioPersonal = consultaHorariosUsuarioMLB($_SESSION['user'], $conexion);
			$horarioPersonal = json_decode($horarioPersonal); 		
			if(sizeof($horarioPersonal)>0){ ?>
		<br/>
		<h2>Datos de pago.</h2>
		<center>
		<img src="images/LC_accMLB.png" class= "[ img-pagoMLB ]"\>
		</center>
				<h2>Mi Horario</h2> <?php
				for ($y=0; $y < sizeof($horarioPersonal) ; $y++) { 
					$id_curso = $horarioPersonal[$y]->id_curso;
					$infoEspecifica = infoGrupoMLB($id_curso, $conexion);
					$infoEspecifica = json_decode($infoEspecifica);	?>
					<table class="[ horarios ][ cell ][ table table-striped ]">
					<tbody>
						<tr>
							<td> SEDE </td>
							<td> NOMBRE </td>
							<td> IDIOMA </td>
							<td> </td>
							<td> DÍAS </td>
							<td> </td>
							<td> INTEGRANTES </td>
						</tr>
						<tr data-id="<?php echo $infoEspecifica[$y]->id; ?>">
							<td> <?php $nom= json_decode(nombreSede($infoEspecifica[0]->sede, $conexion)); echo($nom[0]->nombre); ?> </td>
							<td> <?php echo $infoEspecifica[0]->nombre; ?> </td>
							<td> <?php echo $infoEspecifica[0]->idioma; ?> </td>
							<td> <?php echo $infoEspecifica[0]->dia_1.'<br/>'.$infoEspecifica[0]->hr_1; ?> </td>
							<td> <?php echo $infoEspecifica[0]->dia_2.'<br/>'.$infoEspecifica[0]->hr_2; ?> </td>
							<td> <?php echo $infoEspecifica[0]->dia_3.'<br/>'.$infoEspecifica[0]->hr_3; ?> </td>
							<td> <?php echo $infoEspecifica[0]->registrados; ?> </td>
						</tr>
					</tbody>
				</table>
				<center>
					<form class="[ comprobantePago ]" name="comprobantePago" id="comprobantePago<?php echo($y); ?>"  action="recibir.php" method="post" enctype="multipart/form-data" >
						<table class="[ horarios ][ cell ][ table table-striped ]">
							<tbody>
								<tr>
									<td> COMPROBANTE </td>
									<td> ESTADO </td>
								</tr>
								<tr>
									<td> <?php if($horarioPersonal[$y]->estado != '2') { ?>
										<input type="hidden" value="<?php echo $horarioPersonal[$y]->id; ?>" name="id" class="[ inpH ]">
										<input type="hidden" value="<?php echo myID(); ?>" name="user_id" class="[ inpH ]">
										<input type="file" name="foto" class="[  ]"/>(Máximo 2000KB) <br/>
										<span>Fecha:</span> <input type="text" name="fecha" placeholder="aaaa/mm/dd" class="[  ][ inputBorder ]" /> <br/><br/>
										<span>No. Autorización:</span> <input type="text" name="aut" placeholder="00000" class="[  ][ inputBorder ]" /> <br/><br/>
										<span>No. Sucursal:</span> <input type="text" name="suc" placeholder="0000" class="[  ][ inputBorder ]" /> <br/><br/>
										<span>Monto:</span> <input type="text" name="monto" placeholder="$0.00" class="[  ][ inputBorder ]" /> <br/><br/>
										<input type="submit" class="[ button ][ btn-primary ][ js_uploadImage ]" value="Enviar"/>
										<input type="hidden" value="2" name="programa" class="[ - ]" />
										<input type="hidden" value="uploadImage" name="action" class="[ - ]" />
									</td>
									<td> <label class="<?php echo ' pago'.$horarioPersonal[$y]->estado; ?>"> <br/><br/><br/><?php echo estadoPago($horarioPersonal[$y]->estado); ?><br/></td>
										<?php }  else { ?>
										</td>
									<td> <label class="<?php echo ' pago'.$horarioPersonal[$y]->estado; ?>"><?php echo estadoPago($horarioPersonal[$y]->estado); ?><br/></td>
										<?php } ?>	
								</tr>
								
							</tbody>
						</table>
					</form>
					</center>
					<br>
					<br>
				<?php } } } 
				else {
					echo '<center>Parece que no tienes registro de tu grupo aún...<br/>¿Por que no inscribirte?<br/><br/><a href="register.php?v='.$_GET['v'].'"><button class="[ btn-primary ]"> Inscribirse </button></a></center><br/><br/>';
				}
			}else if($_GET['v']=='SL'){
		$inscrito =estaInscrito(myID(), $conexion);
		if($inscrito){
		$horarioPersonal = consultaHorariosUsuario($_SESSION['user'], $conexion);
		$horarioPersonal = json_decode($horarioPersonal); 		
		//var_dump($horarioPersonal);
		if(sizeof($horarioPersonal)>0){
		?>
		<br/>
		<h2>Datos de pago.</h2>
		<center>
			<img src="images/LC_accMLB.png" class= "[ img-pagoMLB ]"\>
		</center>
		<!--
		<h2>Datos de pago por sede.</h2>

		<center>
			<table class="css_pagos">
				<tr>
					<td>
						<img src="images/LC_acc.png" class= "[ img-pago ]"\>
					</td>
					<td>
						<img src="images/UAM_acc.png" class= "[ img-pago ]"\>
					</td>
				</tr>
			</table>
			<br/>
		</center>-->
		<h2>Horario</h2>
				<?php
					for ($y=0; $y < sizeof($horarioPersonal) ; $y++) { 
						$id_curso = $horarioPersonal[$y]->id_curso;
						$infoEspecifica = infoGrupoSL2($id_curso, $conexion);
						$infoEspecifica = json_decode($infoEspecifica); 
						//var_dump($infoEspecifica);
						?>
				<table class="[ horarios ][ cell ][ table table-striped ]">
					<tbody>
						<tr>
							<td> SEDE </td>
							<td> IDIOMA </td>
							<td> HORARIO </td>
							<td> DÍAS </td>
						</tr>
						<tr data-id="<?php echo $infoEspecifica[$y]->id; ?>">
							<td> <?php $nom= json_decode(nombreSede($infoEspecifica[0]->sede, $conexion)); echo($nom[0]->nombre); ?> </td>
							<td> <?php echo $infoEspecifica[0]->idioma; ?> </td>
							<td> <?php echo $infoEspecifica[0]->inicio.' - '.$infoEspecifica[0]->fin; ?></td>
							<td> <?php echo $infoEspecifica[0]->modalidad; ?> </td>
							
						</tr>
					</tbody>
				</table>
				<center>
					<form class="[ comprobantePago ]" name="comprobantePago" id="comprobantePago<?php echo($y); ?>"  action="recibir.php" method="post" enctype="multipart/form-data" >
						<table class="[ horarios ][ cell ][ table table-striped ]">
							<tbody>
								<tr>
									<td> COMPROBANTE </td>
									<td> ESTADO </td>
								</tr>
								<tr>
									<td> <?php if($horarioPersonal[$y]->estado != '2') { ?>
										<input type="hidden" value="<?php echo $horarioPersonal[$y]->id; ?>" name="id" class="[ inpH ]">
										<input type="file" name="foto" class="[  ]"/>(Máximo 2000KB) <br/>
										<span>Fecha:</span> <input type="text" name="fecha" placeholder="aaaa/mm/dd" class="[  ][ inputBorder ]" /> <br/><br/>
										<span>No. Autorización:</span> <input type="text" name="aut" placeholder="00000" class="[  ][ inputBorder ]" /> <br/><br/>
										<span>No. Sucursal:</span> <input type="text" name="suc" placeholder="0000" class="[  ][ inputBorder ]" /> <br/><br/>
										<span>Monto:</span> <input type="text" name="monto" placeholder="$0.00" class="[  ][ inputBorder ]" /> <br/><br/>
										<input type="submit" class="[ button ][ btn-primary ][ js_uploadImage ]" value="Enviar"/>
										<input type="hidden" value="1" name="programa" class="[ - ]" />
										<input type="hidden" value="uploadImage" name="action" class="[ - ]" />

									</td>
									<td> <label class="<?php echo ' pago'.$horarioPersonal[$y]->estado; ?>"> <br/><br/><br/><?php echo estadoPago($horarioPersonal[$y]->estado); ?><br/></td>
										<?php }  else { ?>
										</td>
									<td> <label class="<?php echo ' pago'.$horarioPersonal[$y]->estado; ?>"><?php echo estadoPago($horarioPersonal[$y]->estado); ?><br/></td>
										<?php } ?>
								</tr>
								
							</tbody>
						</table>
					</form>
				</center>
				<?php } }else {echo "Sin inscr"; } 
			}else { 
				echo "<center>Parece que aún no estás registrado en algún idioma... Te invitamos a registrarte!</center>";
				echo '<center><br/><a href="register.php?v='.$_GET['v'].'"><button class="[ btn-primary ]"> Inscribirse </button></a></center><br/><br/>';
			}
		 }  include 'footer.php'; ?>