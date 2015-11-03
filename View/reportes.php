<title>Reportes</title>
<?php 
include 'header.php';

if(!isset($_SESSION['user'])){
	echo '<script language="javascript">setTimeout("location.href=\"register.php\"", 10); </script>';
}

include '../Model/consultas.php';
$usar = $_SESSION['info'];

if(isset($_GET['v'])){
	if ($_GET['v']=='SL') {
		$programa = 1;
		$infoProyecto = nombrePrograma($programa, $conexion);
		
	}elseif ($_GET['v']=='MLB') {
		$programa = 2;
		$infoProyecto = nombrePrograma($programa, $conexion);
	}
}else{
	$infoProyecto = nombrePrograma($_GET['v'], $conexion);
}
	$infoProyecto = json_decode($infoProyecto);
?>
<table>
	<tbody>
		<tr>
			<td class="img-js"><img src="<?php echo $infoProyecto[0]->imagen; ?>" alt="" class="[ product_img_sede ]">
			</td>
			<td class="img-js"><h2><?php echo $infoProyecto[0]->nombre; ?></h2>
			</td>
		</tr>
		<tr><td></td></tr>
	</tbody>
</table>

<table class="[ indexTableText ]">
	<tr>
		<td><center><a href="reportesEspecializados.php?v=<?php echo $_GET['v'].'&'; ?>x=alumnos"><img src="images/page3_img4.gif"><br/>Inscritos</a></center></td>
		<td><center><a href="reportesEspecializados.php?v=<?php echo $_GET['v'].'&'; ?>x=mensajes"><img src="images/page3_img6.gif"><br/>Mensajes</a></center></td>
	</tr>
</table>

<?php 
$sedes=consultaSedesPrograma($programa, $conexion);
$locations = json_decode($sedes);
$proyecto = consultaInfoProyecto($programa, $conexion);
$infoProyecto = json_decode($proyecto);
?>

<h2>Reporte General de Grupos.</h2>
<?php 
$registrados = reporteInscritos('0', $conexion);
$pagados = reporteInscritos('1', $conexion);
$pendientes = reporteInscritos('2', $conexion);
$rechazados = reporteInscritos('3', $conexion);
$sinPagar = reporteInscritos('4', $conexion);

 ?>
<center>
	<table class="filtrosCssHorario">
		<tr class="cssReporte">
			<td><br/><b>Registrados: </b> <?php echo $registrados[0]; ?></td>
			<td><br/><b>Pagados: </b> <?php echo $pagados[0]; ?></td>
			<td><br/><b>Pendientes: </b> <?php echo $pendientes[0]; ?></td>
			<td><br/><b>Rechazados: </b> <?php echo $rechazados[0]; ?></td>
			<td><br/><b>Sin Pagar: </b> <?php echo $sinPagar[0]; ?></td>
		</tr>

	</table>
</center>
<br/>
	<table class="filtrosCssHorario">
		<tbody>
			<tr>
				<td>
					<span><b>SEDE: </b></span>
					<select name="sede" id="sede">
						<option value="0"> </option>
						<option value="1" <?php if(isset($_GET['s'])) if($_GET['s']=='1')echo "selected"; ?> >ESCOM</option>
						<option value="2" <?php if(isset($_GET['s'])) if($_GET['s']=='4')echo "selected"; ?> >ESE</option>
						<option value="3" <?php if(isset($_GET['s'])) if($_GET['s']=='5')echo "selected"; ?> >IMEJ</option>
					</select>
				</td>

					<?php if(isset($_GET['s'])) if($_GET['s']!='4') { ?>
				<td>
					<span><b>PROGRAMA:</b></span>
					<span>Sharing Languages</span>
				</td>
					<?php } else { ?>
				<td>
					<span><b>PROGRAMA:</b></span>
					<span>Liderazgo Global</span>
				</td>
					<?php } ?>
					<!--
					<select name="programa" id="programa">
						<option value="1">Sharing Languages</option>
					</select> -->
				
				<td>
					<span><b>  IDIOMA: </b></span>
					<select name="idioma" id="idioma">
						<option value="0"> </option>
						<option value="1">Inglés</option>
						<option value="2">Francés</option>
						<option value="3">Alemán</option>
						<option value="4">Chino</option>
						<option value="5">Italiano</option>
						<option value="6">Portugués</option>					
					</select>
				</td>
				<td>
					<span><b>MODALIDAD: </b></span>
					<select name="modalidad" id="modalidad">
						<option value="0">  </option>
						<option value="1">L-V</option>
						<option value="2">S</option>
					</select>
				</td>
			</tr>
		</tbody>
	</table>

<table class="[ horarios ][ cell ][ table table-striped ]">
	<tbody>
		<tr>
			<td> SEDE </td>
			<td> GRUPO </td>
			<td> IDIOMA </td>
			<td> NIVEL </td>
			<td> HORARIO </td>
			<td> DÍAS </td>
			<td> REGISTRADOS </td>
			<td> PAGADOS </td>
			<td> VALIDANDO </td>
			<td> RECHAZADOS </td>
			<td> SIN PAGO </td>
		</tr>	
	<?php 
		for ($i=0; $i <sizeof($locations) ; $i++) { 
			$sede = consultaInfoSede($locations[$i]->sede, $conexion);
			$sede = json_decode($sede);
			$horarioSede = consultaHorariosSede($programa, $locations[$i]->sede, $conexion);
			$horarioSede = json_decode($horarioSede);

			switch ($i) {
				case '1':
					$mod=38;
					break;
				
				case '2':
					$mod=62;
					break;
				
				default:
					$mod=100;
					break;
			}
			for ($k=0; $k < sizeof($horarioSede) ; $k++) { 
				$inscritos = json_decode(consultaRegistradosGrupo($horarioSede[$k]->id, $conexion));
				$sinPagar = json_decode(consultaHorariosEstado('0', $horarioSede[$k]->id, $conexion));
				$validando = json_decode(consultaHorariosEstado('1', $horarioSede[$k]->id, $conexion));
				$pagado = json_decode(consultaHorariosEstado('2', $horarioSede[$k]->id, $conexion));
				$rechazados = json_decode(consultaHorariosEstado('3', $horarioSede[$k]->id, $conexion));
				?>
				<tr class="<?php echo '[ '.$sede[1].' ][ '.$horarioSede[$k]->idioma.' ][ '.$horarioSede[$k]->modalidad.' ]'; ?>">
					<td class="cell"><?php echo $sede[1]; ?></td>
					<td class="cell">

					<?php if($inscritos[0] > '0') { ?>
						<a href="infoGrupo.php?v=SL&id=<?php echo $horarioSede[$k]->id.'"'; ?> target='_blank'>
							<?php echo $horarioSede[$k]->programa.'-'.$horarioSede[$k]->id%$mod; ?>
						</a>
						<?php } else {
								echo $horarioSede[$k]->programa.'-'.$horarioSede[$k]->id%$mod;
							} ?>
					</td>
					<td class="cell"><?php echo $horarioSede[$k]->idioma; ?></td>
					<td class="cell"><?php echo $horarioSede[$k]->nivel; ?></td>
					<td class="cell"><?php echo $horarioSede[$k]->inicio." - ".$horarioSede[$k]->fin; ?></td>
					<td class="cell"><?php echo $horarioSede[$k]->modalidad; ?></td>
					<td class="cell"><?php echo $inscritos[0]; ?></td>
					<td class="cell"><?php echo $pagado[0]; ?></td>
					<td class="cell"><?php echo $validando[0]; ?></td>
					<td class="cell"><?php echo $rechazados[0]; ?></td>
					<td class="cell"><?php echo $sinPagar[0]; ?></td>
				</tr>		
			<?php } 
			}?>
	</tbody>
</table>
<div class="[ reporteInfo ]">
</div>
<?php include 'footer.php'; ?>