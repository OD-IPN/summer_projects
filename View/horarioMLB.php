<title>HorarioMLB</title>
<?php 
include 'header.php';
if(!isset($_SESSION['user'])){
	echo '<script language="javascript">setTimeout("location.href=\"register.php\"", 10); </script>';
}
include '../Model/consultas.php';
$usar = $_SESSION['info']; 
$nombreSede = "";

if (isset($_GET['v'])) {
	$nombreSede = nombreSede($_GET['v'], $conexion);
	$nombreSede = json_decode($nombreSede);
	$nombreSede = $nombreSede[0]->nombre;
} ?>
<div class="[ container-js ]">
	<center><h2><?php echo $nombreSede; ?></h2></center>
	<h2>Instrucciones.</h2>
	Los pasos necesarios para realizar una inscripción son los siguientes:<br/>
	<li>1.- Selecciona el grupo en el que deseas inscribirte de la lista de horarios de grupo.</li>
	<li>2.- Si la lista se encuentra vacia, no hay cupos disponibles o simplemente no hay un horario de tu agrado; puedes proceder a crear un nuevo grupo en la sección de <b>Personaliza tu propio horario.</b></li>
	<li>3.- Verificar tu inscripción y los datos de la misma en la pestaña de <b>SCHEDULE/HORARIO.</b> (Posterior a la inscripción te redirecciona automáticamente) </li>
	<li>4.- Enviar tu comprobante de pago, así como los detalles solicitados del mismo.</li>
	<li>5.- Esperar a que sea validado el comprobante de pago. </li>
	<li>6.- En el caso de los grupos recién creados, requieren que sea validado el depósito para finalizar la inscripción del mismo.</li>
	<br/>
	<br/>
<?php
if(isset($_GET['id'])){ 
$grupoElegido = json_decode(infoGrupoMLB($_GET['id'], $conexion));
$sedex = json_decode(nombreSede($grupoElegido[0]->sede, $conexion));
$sedex = $sedex[0]->nombre;

$inscritos = json_decode(consultaRegistradosGrupoMLB($_GET['id'], $conexion));
//var_dump($inscritos);

$total=0;
	if($inscritos){
  		for ($conteo=0; $conteo < sizeof($inscritos); $conteo++) { 
  	 		$total+=$inscritos[$conteo]->integrantes;
  	 	}
  	}else{
  		$total=0;
  	}
 $temp=8-$total;

	?>
	Has seleccionado un grupo en específico de la lista mostrada previamente.
	<li>
		Puedes decidir continuar con la inscripción de este grupo o elegir otra de nuestras opciones disponibles.
	</li>
	<br/>	
	<h2>Horario Seleccionado</h2>
	<table class="[ horarios ][ cell ][ table table-striped ]">
		<tr>
			<td> SEDE </td>
			<td> NOMBRE </td>
			<td> IDIOMA </td>
			<td> </td>
			<td> DÍAS </td>
			<td> </td>
			<td> DISPONIBILIDAD </td>
			<td>  </td>
		</tr>
		<tr data-id="<?php echo $grupoElegido[0]->id; ?>">
			<td> <?php echo $sedex; ?> </td>
			<td> <?php echo $grupoElegido[0]->nombre; ?> </td>
			<td> <?php echo $grupoElegido[0]->idioma; ?> </td>
			<td> <?php echo $grupoElegido[0]->dia_1; ?><br> <?php echo $grupoElegido[0]->hr_1; ?><br>  </td>
			<td> <?php echo $grupoElegido[0]->dia_2; ?><br> <?php echo $grupoElegido[0]->hr_2; ?><br>  </td>
			<td> <?php echo $grupoElegido[0]->dia_3; ?><br> <?php echo $grupoElegido[0]->hr_3; ?><br>  </td>
			<td> <?php $vacant = $temp; echo $vacant; ?> </td>
			<td>
			<?php if($vacant>0) { ?>
				<!-- Dejar de inscribirse en grupos con cupo.
				<br/><button class="[ btn-primary ][ js_MLB_Inscripcion ]"> Inscribirse </button>	-->
			<?php } ?>
			</td>
		</tr>
	</table><br/><br/>
<?php
}

$horarios=horariosStatus_by_Sede_MLB('1', $_GET['v'], $conexion);	
$horarios = json_decode($horarios);

$horariosReserv=horariosStatus_by_Sede_MLB('0', $_GET['v'], $conexion);	
$horariosReserv = json_decode($horariosReserv);
$nombreSede = "";
if (isset($_GET['v'])) {
	$nombreSede = nombreSede($_GET['v'], $conexion);
	$nombreSede = json_decode($nombreSede);
	$nombreSede = $nombreSede[0]->nombre;
}

//if(sizeof($horarios)>0) { 
if(1) { ?>
		A continuación se muestra la lista de grupos activos dentro de esta sede, puedes realizar tu inscripción en cualquiera de estos grupos siempre y cuando tengan disponibilidad de espacios. <br/><br/>
		<h3>Horario de Grupos</h3> Inscribete individualmente en alguno de nuestros grupos que ya están activos.

		<table class="[ horarios ][ cell ][ table table-striped ]">
		<tbody>
			<tr>
				<td> SEDE </td>
				<td> NOMBRE </td>
				<td> IDIOMA </td>
				<td> </td>
				<td> DÍAS </td>
				<td> </td>
				<td> DISPONIBILIDAD </td>
				<td>  </td>
			</tr>
<?php }
		for ($i=0; $i < sizeof($horarios); $i++) { 
		//var_dump($horarios);
			$sedex = json_decode(nombreSede($horarios[$i]->sede, $conexion));
			$sedex = $sedex[0]->nombre;
			$inscritos = json_decode(consultaRegistradosGrupoMLB($horarios[$i]->id, $conexion));
			//var_dump($inscritos);

			$total=0;
			if($inscritos){
					for ($conteo=0; $conteo < sizeof($inscritos); $conteo++) { 
				 		$total+=$inscritos[$conteo]->integrantes;
				 	}
				}else{
					$total=0;
				}
			$temp=8-$total;

			 ?>
			<tr data-id="<?php echo $horarios[$i]->id; ?>">
				<td> <?php echo $sedex; ?></td>
				<td> <?php echo $horarios[$i]->nombre; ?> </td>
				<td> <?php echo $horarios[$i]->idioma; ?> </td>
				<td> <?php echo $horarios[$i]->dia_1; ?><br/><?php echo $horarios[$i]->hr_1; ?></td>
				<td> <?php echo $horarios[$i]->dia_2; ?><br/><?php echo $horarios[$i]->hr_2; ?></td>
				<td> <?php echo $horarios[$i]->dia_3; ?><br/><?php echo $horarios[$i]->hr_3; ?></td>
				<td> <?php $vacantes = $temp; echo $vacantes; ?></td>
				<td>
				<?php if($vacantes>0) { ?>
				<!-- Dejar de inscribirse en grupos con cupo.
				<br/><button class="[ btn-primary ][ js_MLB_Inscripcion ]"> Inscribirse </button>	-->
				<?php } ?>
				 </td>
			</tr>
	<?php } ?>
 		</tbody>
 	</table>
	<br/>
	<br/>
	<br/>
	En caso de que así lo prefieras, puedes proceder a crear tu propio horario.
	<li>Posterior a haber sido aceptado el comprobante de pago, se reserva definitivamente el horario del grupo.</li>
	<li>En caso de que dos personas estén interesadas en el mismo horario y no se cuente con la disponibilidad suficiente, se dará la preferencia según el orden en que se reciban los comprobantes de pago.</li><br/>
	<h3>Personaliza tu propio horario.*</h3> 
	<?php 
	$horariosPagados = $horarios;
	//var_dump($horariosPagados);
	//echo "<br/>";
	//var_dump($horariosReserv);
	$claseHorario = "disp";
	$val = "";
	$hrs = "";

	$horarioColor = array();
	$horarioVacio = array('0', '0','0', '0');
	array_push($horarioColor, $horarioVacio);
	array_push($horarioColor, $horarioVacio);
	array_push($horarioColor, $horarioVacio);
	array_push($horarioColor, $horarioVacio);
	array_push($horarioColor, $horarioVacio);

	//var_dump($horariosPagados);
	for ($pagado=0; $pagado < sizeof($horariosPagados) ; $pagado++) { 
		$val = "";
		$val = dias($val, $horarios[$pagado]->dia_1);
		$val = dias($val, $horarios[$pagado]->dia_2);
		$val = dias($val, $horarios[$pagado]->dia_3);
	
		$hrs = "";
		$hrs = horas($hrs, $horarios[$pagado]->hr_1);
		$hrs = horas($hrs, $horarios[$pagado]->hr_2);
		$hrs = horas($hrs, $horarios[$pagado]->hr_3);

		//echo "<br/>->".$val;
		//echo "<br/>->".$hrs;
		if(isset($_GET['v']))
			if ($_GET['v']=='3') {
				$horarioColor = pintarMLB($horarioColor, $val, $hrs);
			}elseif ($_GET['v']=='1') {
				$horarioColor = pintarMLB_ESCOM($horarioColor, $val, $hrs);
			}
			
		//$val = $hrs = 0;
	}
	//var_dump($horariosReserv);
	for ($reserv=0; $reserv < sizeof($horariosReserv); $reserv++) { 
		$val = "";
		$val = dias($val, $horariosReserv[$reserv]->dia_1);
		$val = dias($val, $horariosReserv[$reserv]->dia_2);
		$val = dias($val, $horariosReserv[$reserv]->dia_3);
	
		$hrs = "";
		$hrs = horas($hrs, $horariosReserv[$reserv]->hr_1);
		$hrs = horas($hrs, $horariosReserv[$reserv]->hr_2);
		$hrs = horas($hrs, $horariosReserv[$reserv]->hr_3);

		if(isset($_GET['v']))
			if ($_GET['v']=='3') {
				$horarioColor = pintarMLB_SP($horarioColor, $val, $hrs);
			}elseif ($_GET['v']=='1') {
				$horarioColor = pintarMLB_SP_ESCOM($horarioColor, $val, $hrs);
			}
	}

	 ?>
	<table class="[ misHorarios ][ cell ][ table table-striped ]" id="misHorarios">
		<tr>
			<td> LUNES </td>
			<td> MARTES </td>
			<td> MIÉRCOLES </td>
			<td> JUEVES </td>
			<td> VIERNES </td>
		</tr>
		<tr>
			<td class="[ 1 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 0, 0)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 0, 0)); ?> ]">08:30 - 10:00</td>
			<td class="[ 2 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 1, 0)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 1, 0)); ?> ]">08:30 - 10:00</td>
			<td class="[ 3 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 2, 0)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 2, 0)); ?> ]">08:30 - 10:00</td>
			<td class="[ 4 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 3, 0)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 3, 0)); ?> ]">08:30 - 10:00</td>
			<td class="[ 5 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 4, 0)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 4, 0)); ?> ]">08:30 - 10:00</td>
		</tr>
		<tr>
			<td class="[ 1 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 0, 1)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 0, 1)); ?> ]">10:30 - 12:00</td>
			<td class="[ 2 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 1, 1)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 1, 1)); ?> ]">10:30 - 12:00</td>
			<td class="[ 3 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 2, 1)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 2, 1)); ?> ]">10:30 - 12:00</td>
			<td class="[ 4 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 3, 1)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 3, 1)); ?> ]">10:30 - 12:00</td>
			<td class="[ 5 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 4, 1)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 4, 1)); ?> ]">10:30 - 12:00</td>
		</tr>
		<tr>
			<td class="[ 1 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 0, 2)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 0, 2)); ?> ]">12:00 - 13:30</td>
			<td class="[ 2 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 1, 2)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 1, 2)); ?> ]">12:00 - 13:30</td>
			<td class="[ 3 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 2, 2)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 2, 2)); ?> ]">12:00 - 13:30</td>
			<td class="[ 4 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 3, 2)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 3, 2)); ?> ]">12:00 - 13:30</td>
			<td class="[ 5 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 4, 2)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 4, 2)); ?> ]">12:00 - 13:30</td>
		</tr>
		<tr>
			<td class="[ 1 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 0, 3)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 0, 3)); ?> ]">13:30 - 15:00</td>
			<td class="[ 2 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 1, 3)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 1, 3)); ?> ]">13:30 - 15:00</td>
			<td class="[ 3 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 2, 3)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 2, 3)); ?> ]">13:30 - 15:00</td>
			<td class="[ 4 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 3, 3)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 3, 3)); ?> ]">13:30 - 15:00</td>
			<td class="[ 5 ][ <?php if(isset($_GET['v'])) if($_GET['v']=='3') echo(pintarRegistados($horarioColor, 4, 3)); elseif($_GET['v']=='1') echo(pintarRegistados_ESCOM($horarioColor, 4, 3)); ?> ]">13:30 - 15:00</td>
		</tr>
	</table>
	<table class="[ misHorarios ][ cell ][ table ]" id="misHorarios">
		<tr>
			<td class="disp">Disponible</td>
			<?php 
			if(isset($_GET['v']))
				if ($_GET['v']=='1') {
					echo '<td class="con1">Último cupo.</td>';
				} ?>
			<td class="conI">Con Interesados</td>
			<td class="ND">No Disponible</td>
		</tr>
	</table>
	<table class="[ horarioCustom ][ cell ][ table table-striped ]">
		<tr>
			<td> SEDE </td>
			<td> NOMBRE </td>
			<td> IDIOMA </td>
			<td> PERSONAS </td>
			<td> </td>
			<td> DÍAS </td>
			<td> <input type="hidden" value="<?php echo $usar->get_id(); ?>" class="user_id"> </td>
		</tr>
		<tr>
			<td>
				<select name="sede" id="sede">
				<?php if(isset($_GET['v']))
						if($_GET['v']=='1')
							echo '<option value="1">ESCOM </option>';
						elseif($_GET['v']=='3')
							echo '<option value="3">Biblioteca Vasconcelos </option>'; ?>
				</select>
			</td>
			<td><input type="text" class="[ inputBorder ]" name="nombreGrupo" placeholder="Nombre Del Grupo" id="nombreGrupo" value="Nombre..."> </td>
			<td>
				<select name="idiomas" id="idiomas">
					<option value="Ingles" selected>Inglés</option>
				</select>
			</td>
			<td>
				<select name="integrantes" id="integrantes">
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
				</select>
			</td>
			<td id="data1"></td>
			<td id="data2"></td>
			<td id="data3"></td>
		</tr>
	</table>
	<p>
		<br/>
		<a href="#"><input type="button" value="Inscribirse" class="[ btn btn-primary ][ button ][ js-inscribir ]" id="submitBtn" disabled="true" /></a>
	</p>
	*Los grupos de MLB constan de <b>3 sesiones</b> de <b>1.5Hrs cada una.</b><br/>
	<li>Es necesario elegir hasta <b>3</b> difentes días y horas, una para cada sesión.</li>
	<li>Es posible registrar hasta <b>2</b> sesiones el mismo día.</li>
	<li>Personalizar el nombre del grupo. </li>
	<li>Para dar de alta un grupo son necesarias al menos 4 personas.</li>
	<br/>
	<br/>
	<br/>
</div>
<?php include 'footer.php'; ?>