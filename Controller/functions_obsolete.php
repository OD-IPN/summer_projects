<?php 
if(isset($_POST['action'])){
	$action = $_POST['action'];

	switch ($action) {
		case 'login':
			login();
			break;

		case 'logout':
			logout();
			break;

		case 'register':
			register();
			break;

		case 'verificarDisponibilidad':
			verificarDisponibilidad();
			break;

		case 'registrar_grupo_SL':
			inscribir_SL();
			break;

		case 'registrar_grupo_MLB':
			inscribir_MLB();
			break;

		case 'reportes':
			reportes();
			break;

		case 'registrar_individual_MLB':
			inscribir_individual_MLB();
			break;

		default:
			# code...
			break;
	}
}

//**********************
//Función para saber el tipo de sesión de usuario.
//@Return void.
//**********************
function whoAmI(){
	return $_SESSION['info']->get_roll();
}

//**********************
//Función para saber el tipo de sesión de usuario.
//@Return void.
//**********************
function estadoPago($valor){
	$status="";
	switch ($valor) {
		case '0':
			$status = "Pago no realizado.";
			break;
		
		case '1':
			$status = "Pago en revisión.";
			break;
		
		case '2':
			$status = "Pago validado.";
			break;
		
		default:
			# code...
			break;
	}
	return $status;
}

//**********************
//Función para saber el tipo de sesión de usuario.
//@Return void.
//**********************
function reportes(){
	include '../Model/consultas.php'; 
	switch ($_POST['tipo']) {
		case '0':
			reporteGeneralGrupos($_POST['programa'], $conexion);
			break;
		
		default:
			# code...
			break;
	}
}


//**********************
//Función para consultar la información de todos los grupos activos.
//@Return void.

//**********************

//
function reporteGeneralGrupos($programa, $conexion){
	$info = array();
	
	$sedes = json_decode(consultaSedesPrograma($programa, $conexion));
	
	for ($z=0; $z < sizeof($sedes) ; $z++) { 
		$sedeA = json_decode(nombreSede($z+1, $conexion));
		$nombreSede = $sedeA[0]->nombre;
		$info[$z][0]=$sedeA[0]->nombre;
		//var_dump($info);
		$grupos = json_decode(consultaHorariosPrograma($programa, $sedes[$z]->sede, $conexion));
		for ($y=0; $y < sizeof($grupos) ; $y++) { 
			//var_dump($grupos[$y]);
			$info[$z][1+$y]=$grupos[$y];
		}
	}
	
	//var_dump($info);
	for ($x=0; $x < sizeof($info) ; $x++) { 
		?> 
		<h2><?php echo $info[$x][0]; ?></h2>
		<table class="[ horarios ][ cell ][ table table-striped ]">
			<tbody>
				<tr>
					<td> PROGRAMA </td>
					<td> CÓDIGO </td>
					<td> IDIOMA </td>
					<td> HORARIO </td>
					<td> DÍAS </td>
					<td> REGISTRADOS </td>
					<td> SIN PAGO </td>
					<td> PAGO EN VALIDACIÓN </td>
					<td> PAGO ACEPTADO </td>
				</tr> 
				<?php 
					for ($w=1; $w < sizeof($info[$x]) ; $w++) { ?>

					<?php 
					var_dump(infoPagoGrupo($info[$x][$w]->id, '0', $conexion));

					 ?>

						<tr>
							<td><?php echo $info[$x][$w]->programa; ?></td>
							<td><?php echo $info[$x][$w]->programa.' - '.$info[$x][$w]->id; ?></td>
							<td><?php echo $info[$x][$w]->idioma; ?></td>
							<td><?php echo $info[$x][$w]->inicio.' - '.$info[$x][$w]->fin; ?></td>
							<td><?php echo $info[$x][$w]->modalidad; ?></td>
							<td><?php echo $info[$x][$w]->registrados; ?></td>
							<td><?php echo $info[$x][$w]->registrados; ?></td>
							<td><?php echo $info[$x][$w]->registrados; ?></td>
							<td><?php echo $info[$x][$w]->registrados; ?></td>
						</tr>
				<?php
					}
				 ?>
				<tr>
					
				</tr>
		</table>
	<?php
	}
}

//**********************
//Función para iniciar sesión de usuario.
//@Return void.
//**********************
function login(){
	include '../Model/consultas.php'; 
	include 'Usuario.php';
	session_start();

	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$result = consultaUsuario($_POST['email'], $conexion);

		if($result!=''){
			if($result[6]!='' && $_POST['password']!=''){
				if($result[6]==$_POST['password']){
					$_SESSION['user']=$result[7].' '.$result[8];
					$current_user = new Usuario($result[0],$result[1],$result[2],$result[3],$result[4],$result[5],$result[6],$result[7],$result[8],$result[9],$result[10],$result[11]);
					$_SESSION['info']=$current_user;
					echo "1";
				}else{
					echo "0";
				}
			}
		}else{
			echo "2";
		}
	}else{
		echo "3";
	}
}


//**********************
//Función para registro de usuarios.
//@Return void.
//**********************

function register(){
	include '../Model/consultas.php'; 
	include 'Usuario.php';

	registrarUsuario($_POST, $conexion);
}

//**********************
//Función para registro de clases de un usuario.
//@Return void.
//**********************

function inscribir_SL(){
	include '../Model/consultas.php'; 
	include 'Usuario.php';
	//consultarCupo($conexion);
	registrarInscripcion($_POST, $conexion);
}

//**********************
//Función para registro de clases de un usuario.
//@Return void.
//**********************

function verificarDisponibilidad(){
	include '../Model/consultas.php'; 
	//echo $_POST['mail'];
	$res = consultaUsuario($_POST['mail'], $conexion);
	if($res!=0)
		var_dump($res);

}


//**********************
//Función para registro de clases de un usuario.
//@Return void.
//**********************

function inscribir_MLB(){
	include '../Model/consultas.php'; 
	include 'Usuario.php';
	//consultarCupo($conexion);
	registrarInscripcionMLB($_POST, $conexion);
}

//**********************
//Función para registro de clases de un usuario.
//@Return void.
//**********************

function inscribir_individual_MLB(){
	include '../Model/consultas.php'; 
	include 'Usuario.php';
	//consultarCupo($conexion);
	var_dump($_POST);
	registrar_individual_MLB($_POST, $conexion);
}



//**********************
//Función para cerrar sesión de usuario.
//@Return void.
//**********************
function logout(){
	session_start();
	session_destroy();
	echo "0";
}

//**********************
//Función para generar el contenido en index.php.
//@Return void.
//**********************
function contentProgram($id_programa){
include '../Model/consultas.php';
$sedes=consultaSedesPrograma($id_programa, $conexion);
$locations = json_decode($sedes);
$proyecto = consultaInfoProyecto($id_programa, $conexion);
$infoProyecto = json_decode($proyecto);

echo   '<h2>INFORMACIÓN SOBRE: <br/></h2>
	<table>
		<tbody>
			<tr>
				<td><img src="'.$infoProyecto[4].'" class="[ product_img_sede ]"></td>
				<td><h2>'.$infoProyecto[1]." - ".$infoProyecto[2].'</h2></td>
			</tr>
			<tr><td></td></tr>
		</tbody>
	</table>
	<p class="info_css">
		<br/><b>Fecha de Inicio: </b>'.$infoProyecto[7].'
		<br/><b>Fecha de Término: </b>'.$infoProyecto[8].'
		<br/><b>Duración: </b>'.$infoProyecto[6].'
		<br/><b>Costo: </b>'.$infoProyecto[5].'
		<br/>
		<br/><b>Informes/contacto: </b><br/>carlos1.duran@aiesec.net
	</p>
	<h2>SEDES DEL PROYECTO: <br/></h2>';

	for ($i=0; $i <sizeof($locations) ; $i++) { 
		$sede = consultaInfoSede($locations[$i]->sede, $conexion);
		$sede = json_decode($sede);
		echo '
	<table class="sedes_proyecto">
		<tbody>
			<tr><h3 class="titulos_proyecto">'.$sede[1]." - ".$sede[2].'</h3></tr>
			<tr>
				
				<td class="img-js">
					<a href="infoSede.php?v='.$sede[0].'">
						<img src="'.$sede[4].'" alt=""></td>
					</a>
				<td class="img-js">'.$sede[3].'</td>
			</tr>
		</tbody>	
	</table>
	<p> </p>
	<table class="[ horarios ][ cell ][ table table-striped ]">
		<tbody>
			<tr>
				<td> GRUPO </td>
				<td> IDIOMA </td>
				<td> NIVEL </td>
				<td> HORARIO </td>
				<td> DÍAS </td>

			</tr>';

			$horarioSede = consultaHorariosSede($id_programa, $locations[$i]->sede, $conexion);
			$horarioSede = json_decode($horarioSede);

			for ($k=0; $k < sizeof($horarioSede) ; $k++) {
				echo '
				<tr>';
				if($i=='1') {
					echo '<td class="cell">'.$horarioSede[$k]->programa.' - '.($horarioSede[$k]->id)%37 .'</td>';
				} elseif($i=='2'){
					echo '<td class="cell">'.$horarioSede[$k]->programa.' - '.($horarioSede[$k]->id)%58 .'</td>';
				} else
				echo '<td class="cell">'.$horarioSede[$k]->programa.' - '.($horarioSede[$k]->id) .'</td>';

				echo '<td class="cell">'.$horarioSede[$k]->idioma.'</td>
					<td class="[ cell ][ SL-'.substr($horarioSede[$k]->nivel, 0, 1).' ]" >'.$horarioSede[$k]->nivel.'</td>
					<td class="cell">'.$horarioSede[$k]->inicio." - ".$horarioSede[$k]->fin.'</td>
					<td class="cell">'.$horarioSede[$k]->modalidad.'</td>
				</tr>';		
			}
		echo '</tbody>
	</table>
	<p><br></p>';
	}
	if(isset($_SESSION['user'])){
	echo '<p><a href="horario.php?v='.$_GET['v'].'"><input type="button" value="Inscribirse" class="[ btn btn-primary ][ button ]" /></a></p>';
	}
	else {
		echo '<p><a href="register.php"><input type="button" value="Inicia Sesión" class="[ btn btn-primary ][ button ]" /></a></p>';
	}
}

//**********************
//Función para generar el contenido en index.php.
//@Return void.
//**********************
function contentProgramMLB($id_programa){
include '../Model/consultas.php';
$sedes=consultaSedesProgramaMLB($conexion);	
$locations = json_decode($sedes);
$proyecto = consultaInfoProyecto($id_programa, $conexion);
$infoProyecto = json_decode($proyecto);
echo   '<h2>INFORMACIÓN SOBRE: <br/></h2>
	<table>
		<tbody>
			<tr>
				<td><img src="'.$infoProyecto[4].'" class="[ product_img_sede ]"></td>
				<td><h2>'.$infoProyecto[1]." - ".$infoProyecto[2].'</h2></td>
			</tr>
			<tr><td></td></tr>
		</tbody>
	</table>
	<p class="info_css">
		<table>
			<tr>
				<td>
					<br/><b>Fecha de Inicio: </b>'.$infoProyecto[7].'
					<br/><b>Duración: </b>'.$infoProyecto[6].'
					<br/><b>Costo Individual: </b>'.$infoProyecto[5].'
				</td>
				<td>
					<br/><b>Informes/Contacto: </b> 
					<br/>juan.estrada@aiesec.net
				</td>
			</tr>
		</table>	
		<br/>
		<br/>
		<h3>Descuentos por grupo.</h3>
		<table class="[ cell ][ table table-striped ]">
			<tr>
				<td><b> Integrantes por Grupo </b></td>
				<td><b> Costo Individual </b></td>
				<td><b> Costo Total </b></td>
			</tr>
			<tr>
				<td> 4 Integrantes</td>
				<td> $550.00 </td>
				<td> $2,200.00 </td>
			</tr>
			<tr>
				<td> 5 Integrantes</td>
				<td> $525.00 </td>
				<td> $2,625.00 </td>
			</tr>
			<tr>
				<td> 6 Integrantes</td>
				<td> $500.00 </td>
				<td> $3,000.00 </td>
			</tr>
			<tr>
				<td> 7 Integrantes</td>
				<td> $475.00 </td>
				<td> $3,325.00 </td>
			</tr>
			<tr>
				<td> 8 Integrantes</td>
				<td> $450.00 </td>
				<td> $3,600.00 </td>
			</tr>
			</tr>
		</table>
		<br/>
	</p>
	<h2>SEDES DEL PROYECTO: <br/></h2>';

	for ($i=0; $i <sizeof($locations) ; $i++) { 
		$sede = consultaInfoSede($locations[$i]->sede, $conexion);
		$sede = json_decode($sede);
		echo '
	<table class="sedes_proyecto">
		<tbody>
			<tr><h3 class="titulos_proyecto">'.$sede[1]." - ".$sede[2].'</h3></tr>
			<tr>
				<td class="img-js"><img src="'.$sede[4].'" alt=""></td>
				<td class="img-js">'.$sede[3].'</td>
			</tr>
		</tbody>	
	</table>
	<p> </p>
	<table class="[ horarios ][ cell ][ table table-striped ]">
		<tbody>
			<tr>
				<td> NOMBRE </td>
				<td> IDIOMA </td>
				<td> </td>
				<td> DÍAS </td>
				<td> </td>
				<td> DISPONIBILIDAD </td>
				<td> </td>
			</tr>';

			$horarioSede = consultaHorariosSedeMLB($locations[$i]->sede, $conexion);
			$horarioSede = json_decode($horarioSede);
			for ($k=0; $k < sizeof($horarioSede) ; $k++) {
				$temp = 8 - intval($horarioSede[$k]->registrados);				
				echo '
				<tr data-id="'.$horarioSede[$k]->id.'">
					<td class="cell">'.$horarioSede[$k]->nombre.'</td>
					<td class="cell">'.$horarioSede[$k]->idioma.'</td>
					<td class="cell">'.$horarioSede[$k]->dia_1." <br/> ".$horarioSede[$k]->hr_1.'</td>
					<td class="cell">'.$horarioSede[$k]->dia_2." <br/> ".$horarioSede[$k]->hr_2.'</td>
					<td class="cell">'.$horarioSede[$k]->dia_3." <br/> ".$horarioSede[$k]->hr_3.'</td>
					<td class="cell">'.$temp.'</td>
					<td>';
					if(isset($_SESSION['user'])){
						echo '<br/><a href="horarioMLB.php?v='.$_GET['v'].'&id='.$horarioSede[$k]->id.'"><button class="[ btn-primary ]"> Inscribirse </button></a>';
					}
					else {
						echo '<br/><a href=register".php"><button class="[ btn-primary ]"> Inscribirse </button></a>';
					}
				echo '</td></tr>';		
			}
		echo '</tbody>
	</table>
	<p><br></p>';
	}
	if(isset($_SESSION['user'])){
	echo '<p><a href="horario.php?v='.$_GET['v'].'"><input type="button" value="Inscribirse" class="[ btn btn-primary ][ button ]" /></a></p>';
	}
	else {
		echo '<p><a href="register.php"><input type="button" value="Inicia Sesión" class="[ btn btn-primary ][ button ]" /></a></p>';
	}
}


//**********************
//Función para generar el contenido en index.php.
//@Return void.
//**********************
function indexContent($programa){

	switch ($programa) {
		case 'MLB':
			contentProgramMLB('2');
			$index=1;
			break;

		case 'SL':
			contentProgram('1');
			$index=1;
			break;
		
		default:
		echo '		<h2>Elige tu proyecto</h2>
					<div class="pad_bot2">
						<table>
							<tr>
								<td><figure> <a href="index.php?v=SL"> <img src="images/SL.png" class="proy_img"></figure></a></td>	      
						        <td><figure> <a href="index.php?v=MLB"> <img src="images/MLB.png" class="proy_img"></figure></a></td>	      
  							</tr>
  							<tr>
								<td> <p class="pad_bot1">Is a project focused on teaching languages to university students to provide them the opportunity to improve and perfect their language with native speakers, and allows them to have a multicultural exchange with the different teachers who are part of this program through formal integration activities as panel discussions of topics like global interest, business, sustainability, values and ethics. </p></td>
						        <td> <p class="pad_bot1">Is a project focused on teaching languages, in a specialized and personalized way, focused on small groups of students, who can choose the time, place and content of the courses in order to provide an international learning experience creating a link between the teacher and students to accelerate learning and ensure the development thereof.</p></td>
  							</tr>
  							<tr>
								<td> <p class="pad_bot1">Fechas: <br/>25 Junio 2015 / 24 Julio 2015</p></td>
						        <td> <p class="pad_bot1">Fechas: <br/>15 Junio 2015 / 17 Julio 2015</p></td>
  							</tr>
  							<tr>
								<td> <p class="pad_bot1">Duración: <br/>4 Semanas</p></td>
						        <td> <p class="pad_bot1">Duración: <br/>5 Semanas</p></td>
  							</tr>
  						</table>
				    </div>';
			break;
	}
}


//**********************
//Función para retornar el nombre de la página actual.
//@Return void.
//**********************
function get_title(){
	$url = $_SERVER['PHP_SELF'];
	$title = explode('/', $url);
	return $title[sizeof($title)-1];
}


//**********************
//Función para retornar el JS de la página actual.
//@Return void.
//**********************
function footer_javascript(){
	$title=get_title();
	$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = ''; 

	switch ($title) {
	  case 'index.php':
	    echo $title;
	    $s1='class="active"';
	    break;
	  case 'products.php':
	    echo $title;
	    $s2='class="active"';
	    break;
	  case 'locations.php':
	    echo $title;
	    $s3='class="active"';
	    break;
	  case 'register.php':
	    echo $title;
	    $s4='class="active"';
	    break;
	  case 'contact.php':
	    echo $title;
	    $s5='class="active"';
	    break;
	  case 'login.php':
	    echo $title;
	    $s6='class="active"';
	    break;
	  case 'horario.php':
	    echo $title;
	    $s6='class="active"';
	    break;
	  case 'reportes.php':
	    echo $title;
	    $s7='class="active"';
	    break;
	  case 'horarioMLB.php':
	    echo $title;
	    $s8='class="active"';
	    break;
	  case 'miHorario.php':
	    echo $title;
	    $s9='class="active"';
	    break;
	  
	  default:
	    # code...
	    break;
	}

	if($s4!=''){
	  echo '<script type="text/javascript">
	  login();
	  registrar();
	  validarDisponibilidad();
	  </script>';
	}

	if($s6!=''){
	  echo '<script type="text/javascript">	
	  filtrar();
	  registrarGrupos();
	  </script>';
	}
	if($s7!=''){
	  echo '<script type="text/javascript">	  
		reportes();
	  </script>';
	}
	if($s8!=''){
	  echo '<script type="text/javascript">	  
		horariosMLB();
		inscribirMLB();
		inscribirIndividialMLB();
	  </script>';
	}

	if($s9!=''){
	  echo '<script type="text/javascript">	  
	  subirComprobante();
	  </script>';
	}

	if(isset($_SESSION)){
	  echo '<script type="text/javascript">
	  logout();
	  </script>';
	}
}?>
