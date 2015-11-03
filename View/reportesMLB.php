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

<h2>Reporte General de Grupos.</h2>

<?php 

//$sedes=consultaSedesProgramaMLB($conexion);
//$locations = $sedes;
//var_dump($locations);
?>

<!--

	<table class="filtrosCssHorario">
		<tbody>
			<tr>
				<td>
					<span><b>SEDE: </b></span>
					<select name="sede" id="sede">
						<option value="0"> </option>
						<option value="1" <?php if(isset($_GET['s'])) if($_GET['s']=='1')echo "selected"; ?> >ESCOM</option>
						<option value="2" <?php if(isset($_GET['s'])) if($_GET['s']=='4')echo "selected"; ?> >UAM</option>
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
	<!--			
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
			</tr>
		</tbody>
	</table>
-->
<table class="[ horarios ][ cell ][ table table-striped ]">
	<tbody>
		<tr>
			<td> SEDE </td>
			<td> GRUPO </td>
			<td> IDIOMA </td>
			<td> </td>
			<td> DÍAS </td>
			<td> </td>
			<td> ESTADO </td>
			<td> REGISTRADOS </td>
			<td> PAGADOS </td>
			<td> VALIDANDO </td>
			<td> SIN PAGO </td>
		</tr>	
	<?php 

	$locations = $sedes = array(
      0 => '1', 
      1 => '3',
      );

    for ($sede=0; $sede < sizeof($sedes) ; $sede++) { 
      $infoEspecifica = consultaHorariosSedeMLB($sedes[$sede], $conexion);
      $infoEspecifica = json_decode($infoEspecifica);
      for ($grupo=0; $grupo < sizeof($infoEspecifica); $grupo++) { 
	    
		$inscritos = json_decode(consultaRegistradosGrupoMLB($infoEspecifica[$grupo]->id, $conexion));
		$sinPagar = json_decode(consultaHorariosEstadoMLB('0', $infoEspecifica[$grupo]->id, $conexion));
		$validando = json_decode(consultaHorariosEstadoMLB('1', $infoEspecifica[$grupo]->id, $conexion));
		$pagado = json_decode(consultaHorariosEstadoMLB('2', $infoEspecifica[$grupo]->id, $conexion));
	      $total=0;
	      if($inscritos){
	      	for ($conteo=0; $conteo < sizeof($inscritos); $conteo++) { 
	      	 	$total+=$inscritos[$conteo]->integrantes;
	      	 }
	      }else{
	      	$total=0;
	      }

	      $nom = nombreSede($infoEspecifica[$grupo]->sede, $conexion);
	      $nom = json_decode($nom); ?>
	<tr class="" >
		<td><?php echo($nom[0]->nombre); ?></td>

		<?php if($inscritos[0] > '0') { ?>
		<td>
			<a href="infoGrupoMLB.php?v=MLB&id=<?php echo $infoEspecifica[$grupo]->id.'"'; ?> target='_blank'>
				<?php echo $infoEspecifica[$grupo]->nombre; ?>
			</a>
			<?php } else {
					echo $infoEspecifica[$grupo]->nombre;
				} ?>
		</td>
		<td><?php echo($infoEspecifica[$grupo]->idioma); ?></td>
		<td><?php echo($infoEspecifica[$grupo]->dia_1.'<br/>'.$infoEspecifica[$grupo]->hr_1); ?></td>
		<td><?php echo($infoEspecifica[$grupo]->dia_2.'<br/>'.$infoEspecifica[$grupo]->hr_2); ?></td>
		<td><?php echo($infoEspecifica[$grupo]->dia_3.'<br/>'.$infoEspecifica[$grupo]->hr_3); ?></td>
		<td><?php echo($infoEspecifica[$grupo]->status); ?></td>
		<td><?php echo($total); ?></td>
		<td><?php echo($pagado[0]); ?></td>
		<td><?php echo($validando[0]); ?></td>
		<td><?php echo($sinPagar[0]); ?></td>
	</tr>
  	<?php } }?>
		</tbody>
	</table>
<div class="[ reporteInfo ]">
</div>
<?php include 'footer.php'; ?>