<title>Sede</title>
<?php 
include 'header.php';
include '../Model/consultas.php';

$infoSede=consultaInfoSede($_GET['v'], $conexion);
$infoSede = json_decode($infoSede);
//	var_dump($infoSede);

if ($_GET['x']=='SL') {
	$programasSede=consultaProgramasSede($_GET['v'], $conexion);
	if($_GET['v']=='4'){
	$valor = 38;
}elseif ($_GET['v']=='5') {
	$valor = 62;
}

}elseif ($_GET['x']=='MLB') {
	$programasSede=consultaProgramasSedeMLB($_GET['v'], $conexion);
}

$programasSede = json_decode($programasSede);
$valor = 100;

?>

<h2><?php echo $infoSede[1].' - '.$infoSede[2]; ?></h2>
<center>
	<table>
		<tbody>
			<tr>
				<td class="img-js_SL"><img src="<?php echo $infoSede[4]; ?>" alt=""> 
				</td>
				<td class="img-js"><?php echo $infoSede[3]; ?>
				</td>
			</tr>
		</tbody>
	</table>
</center>
<h3>Periodo de Clases:</h3>
<center>
	<table class="fechas">
	<tr>
		<?php  if (isset($_GET['v']) && isset($_GET['x'])) if($_GET['v'] == '4' && $_GET['x']=='SL') { ?>
		<td><center><img src="images/fechasSUAM2.png"></center></td>
		<?php } elseif ( $_GET['v'] == '1' && $_GET['x']=='SL' ) { ?>
		<td><img src="images/fechasESCOM.png"></td>
		<td><img src="images/fechasESCOM2.png"></td>
		<?php } elseif ( $_GET['v'] == '5' && $_GET['x']=='SL' ) { ?>
		<td><img src="images/fechasESCOM.png"></td>
		<td><img src="images/fechasESCOM2.png"></td>
		<?php }?>
	</tr>
	</table>
</center>
<div class="content">
	<?php 
	for ($i=0; $i <sizeof($programasSede) ; $i++) { 
		$infoProyecto = consultaInfoProyecto($i+1, $conexion);
		$infoProyecto = json_decode($infoProyecto); 
		$horarioSede = consultaHorariosSede($i+1 , $_GET['v'], $conexion);
		$horarioSede = json_decode($horarioSede);
		$idiomaActual ="";
		$idiomaNuevo ="";

	for ($k=0; $k < sizeof($horarioSede) ; $k++) { 
		$idiomaNuevo = $horarioSede[$k]->idioma;
		if($idiomaActual != $idiomaNuevo ) {
			$idiomaActual = $idiomaNuevo;
		?>
		<h2> <?php echo($idiomaNuevo) ?></h2>
		<table class="[ horarios ][ cell ][ table table-striped ]">
			<tbody>
				<tr>
					<td> PROGRAMA </td>
					<td> GRUPO </td>
					<td> IDIOMA </td>
					<td> NIVEL </td>
					<td> HORARIO </td>
					<td> DÍAS </td>
					<td></td>
				</tr>
		<?php } ?>
				<tr>
					<td class="cell"><img src="<?php echo $infoProyecto[4]; ?>" alt="" class="[ product_img_sede_location ]"></td>
					<td class="cell"><?php echo $horarioSede[$k]->programa.'-'.$horarioSede[$k]->id%$valor ; ?></td>
					<td class="cell"><?php echo $horarioSede[$k]->idioma; ?></td>
					<td class="[ cell][ SL-<?php echo substr($horarioSede[$k]->nivel, 0, 1); ?> ] "><?php echo $horarioSede[$k]->nivel; ?></td>
					<td class="cell"><?php echo $horarioSede[$k]->inicio." - ".$horarioSede[$k]->fin; ?></td>
					<td class="cell"><?php echo $horarioSede[$k]->modalidad; ?></td>
					<td>
					<?php
					if($_GET['v']!='2') $programa='SL';
					if($_GET['v']=='2') $programa='MLB';
					if(isset($_SESSION['user'])){
						echo '<a href="horario.php?v='.$programa.'&id='.$horarioSede[$k]->id.'&s='.$horarioSede[$k]->sede.'"><button class="[ btn-primary ]"> Inscribirse </button></a>';
						}
					else {
						echo '<a href="register.php?v='.$_GET['x'].'"><button class="[ btn-primary ]"> Inicia Sesión </button></a>';
						}
					 ?>
					</td>
				</tr>		
		<?php 
		if( ($k+1) < sizeof($horarioSede)){
			if($idiomaActual != $horarioSede[$k+1]->idioma ) { ?>
				<?php $idiomaActual = $idiomaNuevo; ?>
					</tbody>
				</table>
				<p><br/></p>
				<?php } }else{ ?>
				</tbody>
				</table>
				<?php } } } ?>
			</div>
	<?php include 'footer.php'; ?>


