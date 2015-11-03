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

		case 'pago':
			registrarPago();
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

		case 'updatePago':
			validarPago();
			break;

		case 'uploadImage':
			uploadedImage();
			break;

		case 'borrarAlumno':
			borrarAlumno();
			break;

		case 'registrar_individual_MLB':
			inscribir_individual_MLB();
			break;

		case 'emailContacto':
			emailContacto();
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
//Función para saber el ID del usuario.
//@Return void.
//**********************
function myID(){
	//var_dump($_SESSION);
	return $_SESSION['info']->get_id();
}

//**********************
//Función para subir el comprobante de pago mediante ajax.
//@Return void.
//**********************
function uploadedImage(){
	include '../Model/consultas.php'; 
	$inserted = registrarPagoFull($_POST, $_FILES, $conexion);
	//return $_SESSION['info']->get_id();
}

//**********************
//Función para saber el día de los horarios de MLB.
//@Return void.
//**********************
function dias($valor, $dia){
	$dias = $valor;
	
	switch ($dia) {
		case 'Lunes':
			$dias=$dias.'1';
			break;
		case 'Martes':
			$dias=$dias.'2';
			break;
		case 'Miércoles':
			$dias=$dias.'3';
			break;
		case 'Jueves':
			$dias=$dias.'4';
			break;
		case 'Viernes':
			$dias=$dias.'5';
			break;
		default:
			$dias+=100;
			break;
	}
	return $dias;
}

//**********************
//Función para identificar los horarios de MLB pagados.
//@Return void.
//**********************
function pintarMLB($horarios, $dias, $horas){
	$d1 = substr($dias, 0, 1);
	$d2 = substr($dias, 1, 1);
	$d3 = substr($dias, 2, sizeof($dias));
	$h1 = substr($horas, 0, 1);
	$h2 = substr($horas, 1, 1);
	$h3 = substr($horas, 2, sizeof($horas));
	//echo $d1.' '.$d2.' '.$d3.' - ';
	//echo $h1.' '.$h2.' '.$h3;
	
	$horarios[$d1-1][$h1-1]='X';
	$horarios[$d2-1][$h2-1]='X';
	$horarios[$d3-1][$h3-1]='X';

	return $horarios;

}

//**********************
//Función para identificar los horarios de MLB pagados.
//@Return void.
//**********************
function pintarMLB_ESCOM($horarios, $dias, $horas){
	$d1 = substr($dias, 0, 1);
	$d2 = substr($dias, 1, 1);
	$d3 = substr($dias, 2, sizeof($dias));
	$h1 = substr($horas, 0, 1);
	$h2 = substr($horas, 1, 1);
	$h3 = substr($horas, 2, sizeof($horas));
	//echo $d1.' '.$d2.' '.$d3.' - ';
	//echo $h1.' '.$h2.' '.$h3;
	if($horarios[$d1-1][$h1-1]=='0'){
		$horarios[$d1-1][$h1-1]='X';
	}elseif ($horarios[$d1-1][$h1-1]=='X') {
		$horarios[$d1-1][$h1-1]='Y';
	}
	if ($horarios[$d2-1][$h2-1]=='0') {
		$horarios[$d2-1][$h2-1]='X';
	}elseif ($horarios[$d2-1][$h2-1]=='X') {
		$horarios[$d2-1][$h2-1]='Y';
	}
	if ($horarios[$d3-1][$h3-1]=='0') {
		$horarios[$d3-1][$h3-1]='X';
	}elseif ($horarios[$d3-1][$h3-1]=='X') {
		$horarios[$d3-1][$h3-1]='Y';
	}
	

	return $horarios;

}

//**********************
//Función para identificar los horarios de MLB sin pagar.
//@Return void.
//**********************
function pintarMLB_SP($horarios, $dias, $horas){
	$d1 = substr($dias, 0, 1);
	$d2 = substr($dias, 1, 1);
	$d3 = substr($dias, 2, sizeof($dias));
	$h1 = substr($horas, 0, 1);
	$h2 = substr($horas, 1, 1);
	$h3 = substr($horas, 2, sizeof($horas));
	//echo $d1.' '.$d2.' '.$d3.' - ';
	//echo $h1.' '.$h2.' '.$h3;

	if($horarios[$d1-1][$h1-1]!='X'){
		$horarios[$d1-1][$h1-1]='1';	
	}
	if($horarios[$d2-1][$h2-1]!='X'){
		$horarios[$d2-1][$h2-1]='1';
	}
	if($horarios[$d3-1][$h3-1]!='X'){
		$horarios[$d3-1][$h3-1]='1';
	}
	return $horarios;

}

//**********************
//Función para identificar los horarios de MLB sin pagar en ESCOM.
//@Return void.
//**********************
function pintarMLB_SP_ESCOM($horarios, $dias, $horas){
	$d1 = substr($dias, 0, 1);
	$d2 = substr($dias, 1, 1);
	$d3 = substr($dias, 2, sizeof($dias));
	$h1 = substr($horas, 0, 1);
	$h2 = substr($horas, 1, 1);
	$h3 = substr($horas, 2, sizeof($horas));
	//echo $d1.' '.$d2.' '.$d3.' - ';
	//echo $h1.' '.$h2.' '.$h3;

	if(($horarios[$d1-1][$h1-1]!='X') && ($horarios[$d1-1][$h1-1]!='Y')){
		$horarios[$d1-1][$h1-1]='1';	
	}
	if(($horarios[$d2-1][$h2-1]!='X') && ($horarios[$d2-1][$h2-1]!='Y')){
		$horarios[$d2-1][$h2-1]='1';
	}
	if(($horarios[$d3-1][$h3-1]!='X') && ($horarios[$d3-1][$h3-1]!='Y')){
		$horarios[$d3-1][$h3-1]='1';
	}
	return $horarios;

}

//**********************
//Función para saber las haras de los horarios de MLB.
//@Return void.
//**********************
function pintarRegistados($horarios, $X, $Y){
	
	if ($horarios[$X][$Y]=='0') {
		$clase = "disp";
	}elseif ($horarios[$X][$Y]=='X') {
		$clase = "ND";
	}elseif ($horarios[$X][$Y]=='1') {
		$clase = "conI";
	}
	return $clase;

}

//**********************
//Función para saber las haras de los horarios de MLB.
//@Return void.
//**********************
function pintarRegistados_ESCOM($horarios, $X, $Y){
	
	if ($horarios[$X][$Y]=='0') {
		$clase = "disp";
	}elseif ($horarios[$X][$Y]=='Y') {
		$clase = "ND";
	}elseif ($horarios[$X][$Y]=='X') {
		$clase = "con1";
	}elseif ($horarios[$X][$Y]=='1') {
		$clase = "conI";
	}
	return $clase;

}

//**********************
//Función para saber las haras de los horarios de MLB.
//@Return void.
//**********************
function horas($valor, $hr){
	$horas = $valor;
	switch (''+$hr) {
		case '08:30 - 10:00':
			$horas=$horas.'1';
			break;
		case '10:30 - 12:00':
			$horas=$horas.'2';
			break;
		case '12:00 - 13:30':
			$horas=$horas.'3';
			break;
		case '13:30 - 15:00':
			$horas=$horas.'4';
			break;
		default:
			break;
	}
	return $horas;
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
		
		case '3':
			$status = "Pago Rechazado.";
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
	$programe = "";
	if($_POST['programa']=='SL'){
		$programe = '1';
	}elseif ($_POST['programa']=='MLB') {
		$programe = '2';
	}

	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$result = consultaUsuario($_POST['email'], $conexion);
		if($result!=''){
			if($result[7]!='' && $_POST['password']!=''){
				if($result[7]==$_POST['password']){

					$_SESSION['user']=$result[0];
					$current_user = new Usuario($result[0],$result[2],$result[3],$result[4],$result[5],$result[6],$result[7],$result[8],$result[9],$result[10],$result[11],$result[12]);
					$_SESSION['info']=$current_user;
					updatePrograme($result[0], $programe, $conexion);
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
//Función para registro de usuarios.
//@Return void.
//**********************

function reporteEsp($reporte, $programaID, $conexion){
	$result="";
	switch ($reporte) {
		#Alumnos
		case '1':
			$result = reporteRegistradosPrograma($programaID, $conexion);
			break;
		
		#Mensajes
		case '2':
			$result = reporteMensajesPrograma($programaID, $conexion);
			break;
		
		default:
			# code...
			break;
	}
	//var_dump($result);
	return $result;
}

//**********************
//Función para enviar email de contacto.
//@Return void.
//**********************

function emailContacto(){
	include '../Model/consultas.php'; 
	$destino = "operations.ipn@aiesec.org.mx";

	//mail(to,subject,message,headers,parameters);
	$env = mail($destino,"Contacto Plataforma",$_POST['msj']);
	$reg = saveMSJ($_POST, $conexion);

	if ($reg) {
		echo 1;
	}else{
		echo 0;
	}
}

//**********************
//Función para modificar el estado de un pago.
//@Return void.
//**********************

function validarPago(){
	include '../Model/consultas.php'; 

	$valor = updatePago($_POST, $conexion);
	echo($valor);
}

//**********************
//Función para eliminar usuarios de un grupo.
//@Return void.
//**********************

function borrarAlumno(){
	include '../Model/consultas.php'; 

	$valor = deleteAlumno($_POST, $conexion);
	echo($valor);
}

//**********************
//Función para registro de clases de un usuario.
//@Return void.
//**********************

function inscribir_SL(){
	include '../Model/consultas.php'; 
	include 'Usuario.php';
	//consultarCupo($conexion);
	$upd = registrarInscripcion($_POST, $conexion);
	echo $upd;
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
	echo $id_programa;
include '../Model/consultas.php';
	echo "content Program";
$sedes=consultaSedesPrograma($id_programa, $conexion);
$locations = json_decode($sedes);
$proyecto = consultaInfoProyecto($id_programa, $conexion);
$infoProyecto = json_decode($proyecto);

echo   '<h2>INFORMACIÓN SOBRE: <br/></h2>
	<table>
		<tbody>
			<tr>
				<td><img src="'.$infoProyecto[4].'" class="[ product_img_sede ]"></td>
				<td><h2>'/*.$infoProyecto[1]." - "*/.$infoProyecto[2].'</h2></td>
			</tr>
			<tr><td></td></tr>
		</tbody>
	</table>';

	echo '<h2> ¿Qué es Sharing Languages? </h2>
	<p>
	Es un taller de liderazgo en otro idioma dirigido a estudiantes
	universitarios que tiene como objetivo crear conciencia sobre
	temas de interés global y cuidado del medio ambiente, desarrollo
	de un pensamiento innovador y una visión emprendedora
	y al mismo tiempo incrementar las habilidades en el uso
	de uno o mas idiomas mediante la interacción con jóvenes
	estudiantes internacionales, quienes imparten el taller como
	voluntarios y así contribuyendo al mutuo entendimiento entre
	sociedades y personas de distintas culturas.
	</p>	
	<img src="http://thinkandstart.com/wp-content/uploads/2012/03/Sharing21.jpg" class="[ img-SL ]"\>
	<br/>
	<table class="indexTableText">
		<tr>
			<td><br/><br/><br/>
				<h2>Objetivo</h2>
				<p>
				Promover el desarrollo personal y profesional de nuestros voluntarios internacionales mediante el desarrollo y/o ejecución de programas socialesque ofrezcan soluciones de mejora a la realidad social en nuestro país.				</p>
			</td>
			<td>
				<img src="http://i284.photobucket.com/albums/ll25/OD-IPN/SL2_zpszqibvlmw.jpg" class= "[ img-SL2 ]"\>

			</td>
		</tr>
		<tr>
			<td>
				<img src="http://i284.photobucket.com/albums/ll25/OD-IPN/SL6_zpsvbgp6n9w.jpg" class= "[ img-SL2 ]"\>

			</td>
			<td><br/><br/>
				<h2> Beneficios de Sharing languages. </h2>
			 	<ul>
					<li>• Aprender y perfeccionar el idioma. </li>
					<li>• Convivencia con maestros extranjeros jóvenes. </li>
					<li>• Intercambio cultural. </li>
					<li>• Aumenta tu valor curricular. </li>
					<li>• Ambiente relajado. </li>
				</ul>
			</td>
			<!--<td><img src="images/SL1.jpg" \></td>-->
		</tr>
	</table>
	
	<h2>Idiomas Disponibles: <br/></h2>
	<img src="images/idiomas2.png" class= "[ img-SLI ]"\>
	<p><br/><br/>
	* Idiomas sujetos a la disponibilidad de cada sede.
	<br/>
	</p>
	<h2>Sedes del Proyecto: <br/></h2>
	<p>
		Nos encontramos ubicados en 3 sedes a lo largo del DF y Edo. de México. Para ver más información de las sedes, selecciona la que más te interese.
	</p>
	';
	echo '<table class="sedes_proyecto_SL">
		<tbody>
		<tr>';
	for ($i=0; $i <sizeof($locations) ; $i++) { 
		$sede = consultaInfoSede($locations[$i]->sede, $conexion);
		$sede = json_decode($sede);
		echo '
				<td class="img-js_SL">
					<center><h3 class="titulos_proyecto">'.$sede[1].'</h3></center>
					<a href="infoSede.php?v='.$sede[0].'&x='.$_GET['v'].'">
						<img src="'.$sede[4].'" class="[ sede_img_SL ]"></td>
					</a>';
					if($i%3==2)
						echo '<tr/>';
		}
			echo '
		</tbody>	
	</table>
	<br/>
	<h2>Cuota única de recuperación: (Según la modalidad)</h2>
	<center><img src="images/costosSL.png"></center>
	<br/>';

	if(isset($_SESSION['user'])){
	echo '<p><a href="horario.php?v='.$_GET['v'].'"><input type="button" value="Inscribirse" class="[ btn btn-primary ][ button ]" /></a></p>';
	}
	else {
		echo '<center><p><br>Para inscribirte es necesario que llenes un breve registro o si ya lo has hecho, que inicies sesión.</br></p></center>
		<p><a href="register.php?v='.$_GET['v'].'"><input type="button" value="Iniciar Sesión/Registrarse" class="[ btn btn-primary ][ button ]" /></a></p>';
	}

	
}

//**********************
//Función para generar el contenido en index.php.
//@Return void.
//**********************
function contentProgramMLB($id_programa){
echo $id_programa;
include '../Model/consultas.php';
echo "content Programe MLB";
//$sedes=consultaSedesProgramaMLB($conexion);	
//$locations = json_decode($sedes);
$locations = array(
      0 => '1', 
      1 => '3',
      );
$proyecto = consultaInfoProyecto($id_programa, $conexion);
$infoProyecto = json_decode($proyecto);
echo   '<h2>INFORMACIÓN SOBRE: <br/></h2>
	<table>
		<tbody>
			<tr>
				<td><img src="'.$infoProyecto[4].'" class="[ product_img_sede ]"></td>
				<td><h2>'.$infoProyecto[1]." - ".$infoProyecto[2].'</h2></td>
			</tr>
		</tbody>
	</table>
	<p class="info_css">
		<h2>¿Qué es My Language Buddy?</h2>
		Es un proyecto enfocado en la enseñanza de idiomas, de manera especializada y personalizada, 
		centrada en pequeños grupos de estudiantes, que pueden elegir la hora, el lugar y el contenido
		 de los cursos con el fin de proporcionar una experiencia de aprendizaje internacional la creación
		  de un vínculo entre el profesor y los estudiantes para acelerar el aprendizaje y garantizar el desarrollo de los mismos.
		<br/>
		<br/>
		<table class="indexTableText">
			<tr>
				<td>
					<img src="http://i284.photobucket.com/albums/ll25/OD-IPN/SL2_zpszqibvlmw.jpg" class= "[ img-SL2 ]"\>
				</td>
				<td>
					<img src="http://i284.photobucket.com/albums/ll25/OD-IPN/SL4_zpsgnhuemiy.jpg" class= "[ img-SL2 ]"\>
				</td>
			</tr>
		</table>
		<p>
		<h2>Información del Programa</h2>
		Durante un periodo de <b>5 semanas</b> te será posible practicar tus conocimientos del idioma inglés en el horario
		de tu preferencia y abordando los temas más adecuados a tus necesidades.
		<br/><br/>
		Este programa consiste en <b> 3 sesiones semanales</b> de <b>1.5 Hrs cada una </b>, con máximo 2 sesiones por día y grupo.
		<br/><br/>
		Cada uno de estos grupos cuenta con una capacidad de hasta 8 personas y existen dos maneras de inscribirse: <br/>
		<li>
			<b>Individual:</b> En esta modalidad puedes elegir formar parte de uno de los grupos disponibles, siempre y cuando cuenten con la disponibilidad necesaria.
		</li><br/>
		<li>
			<b>Grupal:</b> Reune al menos 4 amigos e invitalos a formar parte del mismo grupo. La inscripción grupal tiene el beneficio de 
			contar con un descuento en el precio para todos los integrantes del mismo y la libertad de seleccionar el horario que prefieran.*
		</li>
		
		</p>
		<table class="indexTableText">
			<tr>
				<td><h3>Fechas del proyecto:</h3>
					<center><img src="images/fechasMLB.png"></center>
				</td>
				<td>
					<h3>Cuota única de recuperación:</h3>
					<center><img src="images/costosMLB.png"></center>
				</td>
			</tr>
		</table>
		
	</p>	
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
		<center>
		<br/>
		<h3>¿Tienes dudas sobre el proceso de inscripción?</h3>Te invitamos a ver el siguiente video.<br/>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/rWQUZfUGlV8" frameborder="0" allowfullscreen></iframe>
		<br/>
		<br/>
		<h3>Contacto/Informes:</h3>juan.estrada@aiesec.net<br/><center> <br/> <br/> 

		<!--
		<table>
			<tr>
				<td>
					<br/><b>Fecha de Inicio: </b>'.$infoProyecto[7].'
					<br/><b>Duración: </b>'.$infoProyecto[6].'
					<br/><b>Costo Individual: </b>'.$infoProyecto[5].'
					<center><img src="images/fechasMLB.png"></center>
				</td>
				<td>
					<br/><b>Informes/Contacto: </b> 
					<br/>juan.estrada@aiesec.net
				</td>
			</tr>
		</table>-->
		
	<h2>SEDES DEL PROYECTO: <br/></h2>';

	for ($i=0; $i <sizeof($locations) ; $i++) { 
		$sede = consultaInfoSede($locations[$i], $conexion);
		$sede = json_decode($sede);
		echo '
	<a href="horarioMLB.php?v='.$sede[0].'&x='.$_GET['v'].'">
		<table class="sedes_proyecto">
			<tbody>
				<tr><h3 class="titulos_proyecto">'.$sede[1]." - ".$sede[2].'</h3></tr>
				<tr>
					<td class="img-js"><img src="'.$sede[4].'" alt=""></td>
					<td class="img-js">'.$sede[3].'</td>
				</tr>
			</tbody>	
		</table>
	<a/>'; ?>
	<a href=""></a>
	<br/>
	<center>Inscribete individualmente en alguno de nuestros grupos que ya están activos.</center>
	<br/>
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
			</tr>
	<?php 
			$horarioSede = consultaHorariosSedeMLBP($locations[$i], $conexion);
			$horarioSede = json_decode($horarioSede);
			//echo "<pre>";
			//var_dump($horarioSede);
			//echo "</pre>";
			for ($k=0; $k < sizeof($horarioSede) ; $k++) {
				$inscritos = json_decode(consultaRegistradosGrupoMLB($horarioSede[$k]->id, $conexion));
	    
			    $total=0;
			    	if($inscritos){
			      		for ($conteo=0; $conteo < sizeof($inscritos); $conteo++) { 
			      	 		$total+=$inscritos[$conteo]->integrantes;
			      	 	}
			      	}else{
			      		$total=0;
			      	}
			     $temp=8-$total;

				echo '
				<tr data-id="'.$horarioSede[$k]->id.'">
					<td class="cell">'.$horarioSede[$k]->nombre.'</td>
					<td class="cell">'.$horarioSede[$k]->idioma.'</td>
					<td class="cell">'.$horarioSede[$k]->dia_1." <br/> ".$horarioSede[$k]->hr_1.'</td>
					<td class="cell">'.$horarioSede[$k]->dia_2." <br/> ".$horarioSede[$k]->hr_2.'</td>
					<td class="cell">'.$horarioSede[$k]->dia_3." <br/> ".$horarioSede[$k]->hr_3.'</td>
					<td class="cell">'.$temp.'</td>
					<td>';
					if($temp>0)
					if(isset($_SESSION['user'])){
						//Comment para que dejen de inscribirse en index.php
						//echo '<br/><a href="horarioMLB.php?v='.$locations[$i].'&x='.$_GET['v'].'&id='.$horarioSede[$k]->id.'"><button class="[ btn-primary ]"> Inscribirse </button></a>';
					}
					else {
						echo '<br/><a href="register.php?v=MLB"><button class="[ btn-primary ]"> Inscribirse </button></a>';
					}
				echo '</td></tr>';		
			}
		echo '</tbody>
	</table>
	';
	if(isset($_SESSION['user'])){ ?> <a href=""></a>

<?php   echo '<center>O en caso de que lo prefieras... <br/>También es posible crear tu propio grupo con tus amigos y elegir el horario que se ajuste más a tus necesidades! <br/><br/></center>';
		echo '<p> <a href="horarioMLB.php?v='.$sede[0].'&x='.$_GET['v'].'"><input type="button" value="Crea tu grupo" class="[ btn btn-primary ][ ]" /></a></p>';
	}else {
		echo '<center>Inicia Sesión para inscribir grupos y/o personalizar tu propio horario. <br/><br/>
		<a href="register.php?v=MLB"><input type="button" value="Inicia Sesión" class="[ btn btn-primary ][ ]" /></a></p></center>';
	}
		echo("<br/>");
}

}


//**********************
//Función para generar el contenido en index.php.
//@Return void.
//**********************
function indexContent($programa){
	switch ($programa) {
		case 'MLB':
		echo "case";
			contentProgramMLB('2');
			$index=1;
			break;

		case 'SL':
		echo "case";
			contentProgram('1');
			$index=1;
			break;
		
		default:
		echo "case";
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
						        <td> <p class="pad_bot1">Inicio de Fechas (Semanal): <br/>22 Junio 2015 y  20 Julio 2015 <br/> <br/> <br/> 
						        Inicio de Fechas (Sabatino): <br/>27 Junio 2015 y  25 Julio 2015 <br/> </p></td>
						        <td> <p class="pad_bot1">Fechas: <br/>25 Junio 2015 / 24 Julio 2015</p></td>
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
//Función para registrar un pago.
//@Return void.
//**********************
function registrarPago(){
	include '../Model/consultas.php';
	
	$insert = registerPago($_POST, $conexion);
	//var_dump($insert);
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
	$s1 = $s2 = $s3 = $s4 = $s5 = $s6 = $s7 = $s8 = $s9 = $s10 = $s11 = ''; 

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
	  case 'pagos.php':
	    echo $title;
	    $s10='class="active"';
	    break;

	  case 'xx.php':
	    echo $title;
	    $s11='class="active"';
	    break;
	  
	  default:
	    # code...
	    break;
	}

	if($s4!=''){
	  echo '<script type="text/javascript">';
	  
	  if(isset($_GET['v']))
	  	echo 'login("'.$_GET['v'].'");';
	  
	  
	  echo 'registrar();
	  escuela();
	  validarDisponibilidad();
	  </script>';
	}
	if($s5!=''){
	  echo '<script type="text/javascript">	
	  limpiar();
	  enviarEmail();
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
		filtrar();
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
	  //subirComprobante();
	  </script>';
	}

	if($s10!=''){
	  echo '<script type="text/javascript">	  
	  aceptarPago();
	  rechazarPago();
	  </script>';
	}

	if($s11!=''){
	  echo '<script type="text/javascript">	  
	  alert();
	  </script>';
	}

	if(isset($_SESSION)){
	  echo '<script type="text/javascript">
	  logout();
	  logoutSL();
	  </script>';
	}
}?>
