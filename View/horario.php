<title>Horario</title>
<?php 
include 'header.php';

if(!isset($_SESSION['user'])){
	echo '<script language="javascript">setTimeout("location.href=\"register.php\"", 10); </script>';
}

include '../Model/consultas.php';
$usar = $_SESSION['info'];

if(isset($_GET['v']) && isset($_GET['s']) && $_GET['v']=='SL'){
	$horarios=consultaHorariosPrograma(1,$_GET['s'] ,$conexion);
}elseif(isset($_GET['v']) && isset($_GET['s']) && $_GET['v']=='MLB'){
	$horarios=consultaHorariosPrograma(2,$_GET['s'] ,$conexion);
}else{
	$horarios=consultaHorarios($conexion);	
}

$horarios = json_decode($horarios);

if(isset($_GET['id'])){ 
$grupoElegido = json_decode(infoGrupoSL($_GET['id'], $conexion));
$sedex = json_decode(nombreSede($grupoElegido[0]->sede, $conexion));
$sedex = $sedex[0]->nombre;

switch ($sedex) {
	case 'ESCOM':
		$valor = 100;
		break;
	
	case 'ESE':
		$valor = 38;
		break;
	
	case 'IMEJ Ecatepec':
		$valor = 62;
		break;
	
	default:
		# code...
		break;
}
	?>
	
<!--
	<p>El horario que habías seleccionado anteriormente se muestra de color azul. Puedes decidir seguir con tu inscripción o eligir entre los horarios de otros grupos. </p>
	
	<h2>Horario Seleccionado</h2>
	
	<table class="[ horarios ][ cell ][ table table-striped ]">
		<tr>
			<td> SEDE </td>
			<td> GRUPO </td>
			<td> IDIOMA </td>
			<td> NIVEL </td>
			<td> HORARIO </td>
			<td> DÍAS </td>
			<td>  </td>
		</tr>
		<tr data-id="<?php echo $grupoElegido[0]->id; ?>">
			<td> <?php echo $sedex; $valor=100;?> </td>
			<td> <?php echo $grupoElegido[0]->programa.'-'.($grupoElegido[0]->id)%$valor; ?> </td>
			<td> <?php echo $grupoElegido[0]->idioma; ?> </td>
			<td> <?php echo $grupoElegido[0]->nivel; ?> </td>
			<td> <?php echo $grupoElegido[0]->inicio.' - '.$grupoElegido[0]->fin; ?> </td>
			<td> <?php echo $grupoElegido[0]->modalidad; ?> </td>
			<td class="[ cell ]"> <img src="images/mas.png" id="" class="Add" onclick="sumar(this)" /> </td>
		</tr>
	</table>
	</br> -->
<?php
}

?>
<div class="[ container-js ]">
	<h2>Instrucciones:</h2>
	<p>	1) Selecciona los horarios que te interesen. (Recuerda que cada uno cuenta como un grupo diferente) <br/>
		2) Al final de la lista se encuentra la sección de "Tu Horario", donde se cargarán los grupos que hayas seleccionado. <br/>
		3) Por último... Confirma tu inscripción*. <br/>
	</p>

	<h2>Horario de Grupos</h2>
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
	<table class="[ horarios ][ cell ] table table-striped">
		<tbody>
			<tr>
				<td> SEDE </td>
				<td> GRUPO </td>
				<td> IDIOMA </td>
				<td> NIVEL </td>
				<td> HORARIO </td>
				<td> DÍAS </td>
				<td>  </td>
			</tr>
<?php 
	$clase = "";
	for ($i=0; $i < sizeof($horarios); $i++) { 
		if($horarios[$i]->sede==4) {
			$valor=38;
		} elseif($horarios[$i]->sede==5) {
			$valor=62;
		}else {
			$valor = 100;
		}
		$sede = json_decode((nombreSede($horarios[$i]->sede, $conexion)));
		if(isset($_GET['id']))
			if($_GET['id']==$horarios[$i]->id) $clase = "[ selectSL ]";
		else $clase='';
		echo '<tr id="'.$horarios[$i]->inicio.'/'.$horarios[$i]->modalidad.'" class="[ '.$sede[0]->nombre.' ][ '.$horarios[$i]->programa.' ][ '.$horarios[$i]->idioma.' ][ '.$horarios[$i]->modalidad.' ]" data-id="'.$horarios[$i]->id.'">
				<td class="[ cell ]'.$clase.'">'.$sede[0]->nombre.'</td>
				<td class="[ cell ]'.$clase.'">'.$horarios[$i]->programa.'-'.($horarios[$i]->id)%$valor.'</td>
				<td class="[ cell ]'.$clase.'">'.$horarios[$i]->idioma.'</td>
				<td class="[ cell ]'.$clase.'">'.$horarios[$i]->nivel.'</td>
				<td class="[ cell ][ hr ]'.$clase.'">'.$horarios[$i]->inicio.' - '.$horarios[$i]->fin.'</td>
				<td class="[ cell ]'.$clase.'">'.$horarios[$i]->modalidad.'</td>
				<td class="[ cell ]'.$clase.'"> <img src="images/mas.png" id="" class="Add" onclick="sumar(this)" /> </td>
			</tr>';
	}
 ?>		</tbody>
 	</table>
	
	<p><h3>Tu Horario</h3></p>
	<table class="[ misHorarios ][ cell ] table table-striped" id="misHorarios">
		<tr>
			<td> SEDE </td>
			<td> GRUPO </td>
			<td> IDIOMA </td>
			<td> NIVEL </td>
			<td> HORARIO </td>
			<td> MODALIDAD </td>
			<td> <input type="hidden" value="<?php echo $usar->get_id(); ?>" class="user_id"> </td>
		</tr>
	</table>
	<p>
		<br>
		<a href="#"><input type="button" value="Inscribirse" class="[ btn btn-primary ][ button ][ js-inscribir ]" /></a>
	</p>
</div>
<p>
	* Una vez confirmada tu inscripción, no es posible modificar el contenido de tu horario.
</p>
<?php include 'footer.php'; ?>