<?php 
echo "consultas HERE! again";
include 'conexion.php';
function consultaUsuario($email, $conexion){
	$consul="SELECT * FROM `usuario` WHERE  `email` =  '".$email."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	if($result==null){
		echo 0;
		}
	else
		{
			return $result;
		}
}

function consultaUsuarioId($id_usuario, $conexion){
	$consul="SELECT * FROM `usuario` WHERE  `id` =  '".$id_usuario."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	if($result==null){
		echo 0;
		}
	else
		{
			return $result;
		}
}

function reporteMensajesPrograma($id_programa, $conexion){
	$consul="SELECT * FROM `mensajes` WHERE  `programa` =  '".$id_programa."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	if($result==null){
		echo '';
		}
	else
		{
			return $result;
		}
}

function reporteRegistradosPrograma($id_programa, $conexion){
	//SELECT * FROM  `usuario` WHERE  `programa` =  '2';
	$consul="SELECT `nombre`, `apellido`, `email`, `telefono` FROM `usuario` WHERE  `programa` =  '".$id_programa."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	if($result==null){
		echo 0;
		}
	else
		{
			return $result;
		}
}

function registrarPagoFull($pago, $archivo, $conexion){
	$rutaEnServidor='images/uploads';
	$rutaTemporal=$archivo['foto']['tmp_name'];
	$nombreImagen=$archivo['foto']['name'];
	var_dump($nombreImagen);
	$rutaDestino= $rutaEnServidor.'/'.$nombreImagen;
	echo $rutaDestino.'<br/>';
	$moved = move_uploaded_file($rutaTemporal,$rutaDestino);
	echo $rutaTemporal.'<br/>';
	var_dump($moved);

	$sql="INSERT INTO images (`id`, `lugar`) VALUES( NULL, '".$rutaDestino."')";
	$res=mysql_query($sql);

var_dump($res);
}

function updatePrograme($id_usuario, $programa, $conexion){
	//UPDATE  `leviathan`.`usuario` SET  `programa` =  '1' WHERE  `usuario`.`id` =1;
	$updateQ= "UPDATE  `usuario` SET  `programa` =  '".$programa."' WHERE  `usuario`.`id` ='".$id_usuario."';";
	$res2 = mysql_query($updateQ, $conexion) or die ("Error: ".mysql_error());
}

function saveMSJ($msj, $conexion){
$programa;
if ($msj['programa']=='SL') {
	$programa = 1;
} else if ($msj['programa']=='MLB') {
	$programa = 2;
}
//INSERT INTO  `leviathan`.`mensajes` ( `id` , `programa` , `nombre` , `email` , `msj` )VALUES ( NULL ,  '2',  'Miguel',  'cesar.seguracruz@aiesec.net',  'Primer mensaje de prueba MLB.');
$consul = "INSERT INTO  `mensajes` ( `id` , `programa` , `nombre` , `email` , `msj` )VALUES ( NULL ,  '".$programa."',  '".$msj['nombre']."',  '".$msj['email']."',  '".$msj['msj']."');";
$result =  mysql_query($consul, $conexion) or die("Error: ".mysql_error());
return $result;
}

//Información de una sede en especifico.
function consultaInfoSede($sede, $conexion){

	$consul="SELECT * FROM `sede` WHERE `id` = ".$sede.";";
	//echo $consul;
	$sedeInfo = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_row($sedeInfo); 
	if($result==null){
		echo "Elemento no encontrado<br/>";
		//include 'cerrar_conexion.php';
		}
	else
		{
			return json_encode($result);
		}
}


//Información de un proyecto en especifico.
function consultaInfoProyecto($proyecto, $conexion){

	$consul="SELECT * FROM `proyecto` WHERE `id` = ".$proyecto.";";
	//echo $consul;
	$sedeInfo = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_row($sedeInfo); 
	if($result==null){
		echo "Elemento no encontrado<br/>";
		//include 'cerrar_conexion.php';
		}
	else
		{
			return json_encode($result);
		}
}

//Consulta de Programas by Sede SL
function consultaProgramasSede($sede, $conexion){

	$consul="SELECT DISTINCT `programa` FROM `cursos` WHERE `sede` = ".$sede.";";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	if($result==null){
		echo "Elemento no encontrado<br/>";
		include 'cerrar_conexion.php';
		}
	else
		{
			//var_dump($result);
			//include 'cerrar_conexion.php';
			return json_encode($result);
		}
}

//Consulta de Programas by Sede MLB
function consultaProgramasSedeMLB($sede, $conexion){

	$consul="SELECT COUNT(*) FROM `mlb_grupos` WHERE `sede` = ".$sede.";";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	if($result==null){
		echo "Elemento no encontrado<br/>";
		include 'cerrar_conexion.php';
		}
	else
		{
			//var_dump($result);
			//include 'cerrar_conexion.php';
			return json_encode($result);
		}
}

//Consulta de Programas by Sede
function consultaInscripcionId($id_curso, $conexion){
	$result = "";
	$consul="SELECT * FROM `inscripcion` WHERE `id_curso` = '".$id_curso."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	if($res){
		$result =  mysql_fetch_all($res);
		if($result==null){
			return 0;
		}
		else
		{
			return json_encode($result);
		}
	}
	else {
		$result=null;
	}
	
}

//Consulta de Programas by Sede MLB
function consultaInscripcionIdMLB($id_curso, $conexion){
	$result = "";
	$consul="SELECT * FROM `inscripcion_mlb` WHERE `id_curso` = '".$id_curso."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	if($res){
		$result =  mysql_fetch_all($res);
		if($result==null){
			return 0;
		}
		else
		{
			return json_encode($result);
		}
	}
	else {
		$result=null;
	}
	
}

//Consulta de Sedes by Programa
function consultaSedesPrograma($programa, $conexion){

	$consul="SELECT DISTINCT `sede` FROM `cursos` WHERE `id_programa` = '".$programa."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	if($result==null){
		echo "Elemento no encontrado<br/>";
		//include 'cerrar_conexion.php';
		}
	else
		{
			//var_dump($result);
			//include 'cerrar_conexion.php';
			return json_encode($result);
		}
}

//Consulta de Sedes by Programa MLB
function consultaSedesProgramaMLB($conexion){

	$consul="SELECT DISTINCT `sede` FROM `mlb_grupos` WHERE `status` = '1';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	if($result==null){
		echo "Elemento no encontrado<br/>";
		//include 'cerrar_conexion.php';
		}
	else
		{
			//var_dump($result);
			//include 'cerrar_conexion.php';
			return json_encode($result);
		}
}

//Consulta nombre de sede.
function nombreSede($sede, $conexion){

	$consul="SELECT DISTINCT `nombre` FROM `sede` WHERE `id` = '".$sede."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	if($result==null){
		echo "Elemento no encontrado<br/>";
		include 'cerrar_conexion.php';
		}
	else
		{
			//var_dump($result);
			//include 'cerrar_conexion.php';
			return json_encode($result);
		}
}

//Consulta nombre de progrma.
function nombrePrograma($id_proyecto, $conexion){

	$consul="SELECT DISTINCT `nombre`, `imagen` FROM `proyecto` WHERE `id` = '".$id_proyecto."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	if($result==null){
		echo "Elemento no encontrado<br/>";
		include 'cerrar_conexion.php';
		}
	else
		{
			//var_dump($result);
			//include 'cerrar_conexion.php';
			return json_encode($result);
		}
}


function registrarUsuario($usuario, $conexion){
	if ($usuario['escuela']=='IPN') {
		$campus=$usuario['campus'];
	}else{
		$campus=$usuario['externo'];
	}
	if ($usuario['programa']=='SL') {
		$programa = 1;
	}else if ($usuario['programa']=='MLB'){
		$programa = 2;
	}
	$query="INSERT INTO  `usuario` (  `id` ,  `programa`,  `comite` ,  `nombre` ,  `apellido` ,  `edad` ,  `email` ,  `password` ,  `direccion` ,  `escuela` ,  `campus` , `telefono` ,  `rol` ) 
			VALUES ( NULL , '".$programa." ',  '1', '".$usuario['nombre']." ',  '".$usuario['apellido']."',  '".$usuario['edad']."',  '".$usuario['email']."',  '".$usuario['password']."',  '".$usuario['direccion']."',  '".$usuario['escuela']."',  '".$campus."',  '".$usuario['tel']."',  '0')";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	//var_dump($res);
	if($res)echo '1';
	else echo '0';
	//var_dump($usuario);
}

//registrar Pago
function registerPago($pago, $ruta, $conexion){
	//INSERT INTO  `leviathan`.`pagos` ( `id` , `fecha` , `autentificacion` , `sucursal` , `monto`) VALUES ( NULL ,  '22-Mayo',  '101010',  '111',  '1111');
	$user_id = $pago['user_id'];
	$query = "INSERT INTO `pagos` ( `id` , `id_programa` , `foto` , `fecha` , `autentificacion` , `sucursal` , `monto`, `user_id`) VALUES ( NULL , '".$pago['programa']."', '".$ruta."', '".$pago['fecha']."',  '".$pago['aut']."',  '".$pago['suc']."',  '".$pago['monto']."',  '".$pago['user_id']."');";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$last_id = mysql_insert_id();
	//var_dump($last_id);
	//var_dump($res);
	if($res)
		if($pago['programa']=='1'){	
			
			$query2= "UPDATE  `inscripcion` SET  `estado` =  '1' WHERE  `inscripcion`.`id` =".$pago['id'].";";
			$res2 = mysql_query($query2, $conexion) or die ("Error: ".mysql_error());
			//var_dump($res2);
			$query3= "UPDATE  `inscripcion` SET  `pago` =  '".$last_id."' WHERE  `inscripcion`.`id` =".$pago['id'].";";
			$res3 = mysql_query($query3, $conexion) or die ("Error: ".mysql_error());
			//var_dump($res3);
			if($res && $res2 && $res3 ) {return "1";}
		} else if($pago['programa']=='2'){	

			$query2= "UPDATE  `inscripcion_mlb` SET  `estado` =  '1' WHERE  `inscripcion_mlb`.`id` =".$pago['id'].";";
			$res2 = mysql_query($query2, $conexion) or die ("Error: ".mysql_error());
			//var_dump($res2);
			$query3= "UPDATE  `inscripcion_mlb` SET  `pago` =  '".$last_id."' WHERE  `inscripcion_mlb`.`id` =".$pago['id'].";";
			$res3 = mysql_query($query3, $conexion) or die ("Error: ".mysql_error());
			//var_dump($res3);
			if($res && $res2 && $res3 ) return "1";
	}
}
	
//registrar inscripción
function registrarInscripcion($inscripcion, $conexion){
	//var_dump($inscripcion);
	$query="INSERT INTO `inscripcion` (`id`, `id_usuario`, `id_curso`, `programa`, `idioma`) VALUES (NULL, '".$inscripcion['id']."', '".$inscripcion['id_curso']."', '".$inscripcion['programa']."', '".$inscripcion['idioma']."');";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	//var_dump($query);
		$query="SELECT `registrados` FROM `cursos` WHERE `id` = '".$inscripcion['id_curso']."';";
		$res2 = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
		$res2 =  mysql_fetch_row($res2); 
		$registrados = $res2[0]+1;
		$updateQ = "UPDATE `cursos` SET  `registrados` =  '".$registrados."' WHERE  `cursos`.`id` ='".$inscripcion['id_curso']."';";
		$updated = mysql_query($updateQ, $conexion) or die ("Error: ".mysql_error());
		return $updated;
	//var_dump($usuario);
}

//Registrar inscripción individual de MLB
function registrar_individual_MLB($inscripcion, $conexion){
	$query="INSERT INTO `inscripcion_mlb` (`id`, `id_usuario`, `id_curso`, `integrantes`) VALUES (NULL, '".$inscripcion['user_id']."', '".$inscripcion['group_id']."', ".$inscripcion['cantidad'].");";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	//var_dump($query);
		//$query="SELECT `registrados` FROM `cursos` WHERE `id` = '".$inscripcion['id_curso']."';";
		//$res2 = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
		//var_dump($res2);
	if($res){
		echo $res;
	//	$inscritos = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	//	echo $inscritos;
		//var_dump($inscritos);
		//$query = "UPDATE `cursos` SET `disponibilidad`=['".$inscripcion['cupo']."'],`registrados`=['".$inscripcion['inscritos']."'] WHERE `id_programa` = '".$inscripcion['id_curso']."';";
	}

}

function dia($valor){
	switch ($valor) {
		case 1:
			return 'Lunes';
			break;
		
		case 2:
			return 'Martes';
			break;
		
		case 3:
			return 'Miércoles';
			break;
		
		case 4:
			return 'Jueves';
			break;
		
		case 5:
			return 'Viernes';
			break;
		
		default:
			# code...
			break;
	}
}

//registrar inscripción de grupo MLB
function registrarInscripcionMLB($inscripcion, $conexion){
	$d1 = $d2 = $d3 = $h1 = $h2 = $h3 = $contador=0;
	for ($i=1; $i <= 5; $i++) { 
		if(isset($inscripcion['horario'][$i])){
			for ($k=0; $k < sizeof($inscripcion['horario'][$i]); $k++) { 
				switch ($contador) {
					case 0:
						$d1=dia($i);
						$h1=$inscripcion['horario'][$i][$k];
						$contador++;
						break;
					
					case 1:
						$d2=dia($i);
						$h2=$inscripcion['horario'][$i][$k];
						$contador++;
						break;
					
					case 2:
						$d3=dia($i);
						$h3=$inscripcion['horario'][$i][$k];
						$contador++;
						break;
					
					default:
						# code...
						break;
				}
			}
		}
	}

	$query="INSERT INTO `mlb_grupos` (`id`, `user_id`, `idioma`, `sede`, `dia_1`, `hr_1`, `dia_2`, `hr_2`, `dia_3`, `hr_3`, `nombre`, `registrados`, `status`) VALUES (NULL, '".$inscripcion['id']."', '".$inscripcion['idioma']."', '".$inscripcion['sede']."', '".$d1."', '".$h1."', '".$d2."', '".$h2."', '".$d3."', '".$h3."', '".$inscripcion['nombre']."', '".$inscripcion['registrados']."', '0');";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$last_id = mysql_insert_id();
	var_dump($res);
	if($res){
		inscripcionesMLB($last_id, $inscripcion['id'], $inscripcion['registrados'], $inscripcion['sede'], $conexion);
	}
}

//Registrar las incripciones de MLB
function inscripcionesMLB($group_id, $user_id, $cantidad, $sede, $conexion){
	$query="INSERT INTO `inscripcion_mlb` (`id`, `id_usuario`, `id_curso`, `integrantes`) VALUES (NULL, '".$user_id."', '".$group_id."', ".$cantidad.");";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	//var_dump($query);
		//$query="SELECT `registrados` FROM `cursos` WHERE `id` = '".$inscripcion['id_curso']."';";
		//$res2 = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
		//var_dump($res2);
	if($res){
		echo $res;
	//	$inscritos = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	//	echo $inscritos;
		//var_dump($inscritos);
		//$query = "UPDATE `cursos` SET `disponibilidad`=['".$inscripcion['cupo']."'],`registrados`=['".$inscripcion['inscritos']."'] WHERE `id_programa` = '".$inscripcion['id_curso']."';";
	}


}


//Consultar TODAS las sedes.
function consultaSedes($conexion){
	$query= "SELECT * FROM `sede`;";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar la información de  un curso.
function consultaCursoId($id_curso, $conexion){
	$query= "SELECT * FROM `cursos` WHERE `id` = '".$id_curso."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar la información de  un curso de MLB.
function consultaCursoIdMLB($id_curso, $conexion){
	$query= "SELECT * FROM `mlb_grupos` WHERE `id` = '".$id_curso."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar TODoS lOs programas.
function consultaProyectos($conexion){
	$query= "SELECT `id`, `nombre`, `descripcion`, `imagen` FROM `proyecto`;";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar TODOS los horarios.
function consultaHorarios($conexion){
	$query= "SELECT * FROM `cursos`;";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los horarios de acuerdo al programa.
function consultaHorariosPrograma($programa, $sede, $conexion){
	$query= "SELECT * FROM `cursos` WHERE `id_programa` = '".$programa."' and `sede` = '".$sede."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los horarios de acuerdo al programa.
function horariosPrograma($programa, $conexion){
	$query= "SELECT * FROM `cursos` WHERE `id_programa` = '".$programa."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los horarios de acuerdo a la sede.
function consultaHorariosSede($programa, $sede, $conexion){
	$query= "SELECT * FROM `cursos` WHERE `id_programa` = '".$programa."' and `sede` = '".$sede."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los horarios de acuerdo a la sede.
function consultaHorariosSedeMLB($sede, $conexion){
	$query= "SELECT * FROM `mlb_grupos` WHERE `sede` = '".$sede."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los horarios pagados por sede.
function consultaHorariosSedeMLBP($sede, $conexion){
	$query= "SELECT * FROM `mlb_grupos` WHERE `sede` = '".$sede."' AND `status` = '1' ;";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

function estaInscrito($id, $conexion){
	$consul = "SELECT * FROM `inscripcion` WHERE `id_usuario` = '".$id."';";
	//$consul = "SELECT * FROM `usuario` WHERE  `email` =  '".$email."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	if($result==null){
		return 0;
		}
	else
		{
			return 1;
		}	
}

function estaInscritoMLB($id, $conexion){
	$consul = "SELECT * FROM `inscripcion_mlb` WHERE `id_usuario` = '".$id."';";
	//$consul = "SELECT * FROM `usuario` WHERE  `email` =  '".$email."';";
	$res = mysql_query($consul, $conexion) or die("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	if($result==null){
		return 0;
		}
	else
		{
			return 1;
		}	
}

//Consultar los horarios de MLB un usuario en específico.
function consultaHorariosUsuarioMLB($usuario, $conexion){
	$query= "SELECT * FROM `inscripcion_mlb` WHERE `id_usuario` = '".$usuario."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}


//Consultar los datos de SL por pago.
function consultaInfoPago($pagoID, $conexion){
	$query= "SELECT * FROM `inscripcion` WHERE `pago` = '".$pagoID."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}


//Consultar los datos de MLB por pago.
function consultaInfoPagoMLB($pagoID, $conexion){
	$query= "SELECT * FROM `inscripcion_mlb` WHERE `pago` = '".$pagoID."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}


//Consultar los horarios de un usuario en específico.
function consultaHorariosUsuario($usuario, $conexion){
	//SELECT * FROM `inscripcion` WHERE `id_usuario` = '1';
	$query= "SELECT * FROM `inscripcion` WHERE `id_usuario` = '".$usuario."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	if($res){
		$result =  mysql_fetch_all($res); 
		return json_encode($result);
	}
	
}


//Consultar el estado de pago por grupo.
function consultaHorariosEstado($estado, $id_curso, $conexion){
	$query= "SELECT COUNT(*) FROM `inscripcion` WHERE `estado` = '".$estado."' AND `id_curso` = '".$id_curso."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	return json_encode($result);
}

//Consultar el estado de pago por grupo.
function consultaHorariosEstadoMLB($estado, $id_curso, $conexion){
	$query= "SELECT COUNT(*) FROM `inscripcion_mlb` WHERE `estado` = '".$estado."' AND `id_curso` = '".$id_curso."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	return json_encode($result);
}

//Consultar el estado de pago SL.
function consultaPagosEstado($estado, $conexion){
	$query= "SELECT * FROM `inscripcion` WHERE `estado` = '".$estado."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	if($res){
		$result = mysql_fetch_all($res);
	} else
	$result =  mysql_fetch_row($res); 
	return json_encode($result);
}

//Consultar el estado de pago MLB.
function consultaPagosEstadoMLB($estado, $conexion){
	$query= "SELECT * FROM `inscripcion_mlb` WHERE `estado` = '".$estado."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	if($res){
		$result = mysql_fetch_all($res);
	} else
	$result =  mysql_fetch_row($res); 
	return json_encode($result);
}

//Consultar info de un pago por ID.
function consultaPagoID($id, $conexion){
	$query= "SELECT * FROM `pagos` WHERE `id` = '".$id."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	if($res){
		$result = mysql_fetch_all($res);
	} else
	$result =  mysql_fetch_row($res); 
	return json_encode($result);
}

//Consulta el estado de un usuario en específico.
function consultaEstadoUserCurso($id, $id_curso, $conexion){
	$query = "SELECT `estado` FROM `inscripcion` WHERE `id_usuario` = '".$id."' AND `id_curso` = '".$id_curso."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	return json_encode($result);
}

//Consulta el estado de un usuario en específico MLB.
function consultaEstadoUserCursoMLB($id, $id_curso, $conexion){
	$query = "SELECT `estado` FROM `inscripcion_mlb` WHERE `id_usuario` = '".$id."' AND `id_curso` = '".$id_curso."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	return json_encode($result);
}

//Consultar registrados por grupo.
function consultaRegistradosGrupo($id_curso, $conexion){
	$query= "SELECT COUNT(*) FROM `inscripcion` WHERE `id_curso` = '".$id_curso."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	return json_encode($result);
}

//Consultar registrados por grupo.
function consultaRegistradosGrupoMLB($id_curso, $conexion){
	//SELECT `integrantes` FROM `inscripcion_mlb` WHERE `id_curso` = '20';
	$query= "SELECT `integrantes` FROM `inscripcion_mlb` WHERE `id_curso` = '".$id_curso."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	if($res)
		$result =  mysql_fetch_all($res);
	else
		$result = mysql_fetch_row($res);
	return json_encode($result);
}

//Consultar los horarios de MLB por status.
function horariosStatusMLB($status, $conexion){
	$query= "SELECT * FROM `mlb_grupos` WHERE `status` = '".$status."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los horarios de MLB por status y sede.
function horariosStatus_by_Sede_MLB($status, $sede, $conexion){
	$query= "SELECT * FROM `mlb_grupos` WHERE `status` = '".$status."' AND `sede` = '".$sede."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los horarios de un grupo de MLB en base al id.
function infoGrupoMLB($id, $conexion){
	$query= "SELECT * FROM `mlb_grupos` WHERE `id` = '".$id."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los horarios de un grupo de SL en base al id.
function infoGrupoSL($id, $conexion){
	$query= "SELECT * FROM `cursos` WHERE `id` = '".$id."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}


//Consultar los horarios de un grupo de SL en base al id.
function infoGrupoSL2($id, $conexion){
	$query= "SELECT * FROM `cursos` WHERE `id` = '".$id."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Consultar los PAGOS de SL.
function infoPagoGrupo($id, $tipo ,$conexion){
	$query= "SELECT COUNT(*) FROM `inscripcion` WHERE `id_curso` = '".$id."' AND `estado`= '".$tipo."';";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_all($res); 
	return json_encode($result);
}

//Modificar el estado de un pago.
function updatePago($pago ,$conexion){
	if($pago['programa']=='SL'){
		//UPDATE  `leviathan`.`inscripcion` SET  `estado` =  '2' WHERE  `inscripcion`.`id` =60;
		$query= "UPDATE `inscripcion` SET  `estado` =  '".$pago['estado']."' WHERE  `inscripcion`.`pago` ='".$pago['user_id']."';";
	}elseif ($pago['programa']=='MLB') {
		$query= "UPDATE `inscripcion_mlb` SET  `estado` =  '".$pago['estado']."' WHERE  `inscripcion_mlb`.`pago` ='".$pago['user_id']."';";
	}
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	if ($res && $pago['programa']=='MLB') {
		//SELECT `id_curso` FROM `inscripcion_mlb` WHERE `pago` = '99';
		$queryS = "SELECT `id_curso` FROM `inscripcion_mlb` WHERE `pago` = '".$pago['user_id']."';";
		$id_curso = mysql_query($queryS, $conexion) or die ("Error: ".mysql_error());
		$id_curso = mysql_fetch_row($id_curso);
		if ($id_curso) {
			//echo($pago['estado']);
			if($pago['estado']=='2'){
				//echo $pago['estado']."-->" ;
				//UPDATE  `leviathan`.`mlb_grupos` SET  `status` =  '1' WHERE  `mlb_grupos`.`id` =30;
				$queryL= "UPDATE `mlb_grupos` SET  `status` =  '1' WHERE  `mlb_grupos`.`id` ='".$id_curso[0]."';";	
				//echo($queryL);
				$res = mysql_query($queryL, $conexion) or die ("Error: ".mysql_error());
			}else{ $res = '0'; }
		}else { $res = '-1'; }
	}
	// -1 = NO se registró la inscripción.
	// 0 = Error al actualizar el grupo.

	return $res;
}

//Eliminar un alumno de un grupo.
function deleteAlumno($pago ,$conexion){
	if($pago['programa']=='SL'){
		//DELETE FROM `leviathan`.`inscripcion` WHERE `inscripcion`.`id` = 62	
		$query= "DELETE FROM `inscripcion` WHERE  `inscripcion`.`id` ='".$pago['id']."';";
	}
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	return $res;
}

function reporteInscritos($reporte, $conexion){
	$query = "";
	switch ($reporte) {
		case '0': //Registrados
			$query="SELECT COUNT(*) FROM `inscripcion`;";
			break;

		case '1': //Pagados
			$query = "SELECT COUNT(*) FROM `inscripcion` WHERE `estado` = '2';";
			break;
		

		case '2': //Validando
			$query = "SELECT COUNT(*) FROM `inscripcion` WHERE `estado` = '1';";
			break;
		

		case '3': //Rechazados
			$query = "SELECT COUNT(*) FROM `inscripcion` WHERE `estado` = '3';";
			break;
		

		case '4': //Sin pagar
			$query = "SELECT COUNT(*) FROM `inscripcion` WHERE `estado` = '0';";
			break;
		
		default:
			# code...
			break;
	}
	//$query="SELECT * FROM `inscripcion`;";
	$res = mysql_query($query, $conexion) or die ("Error: ".mysql_error());
	$result =  mysql_fetch_row($res); 
	return $result;
	
}
function mysql_fetch_all($result){
	//$return = array();
	//while($row=mysql_fetch_array($result)) {
      // array_push($return, $row);
       //$return[] = $row;
	//return $return;
}
/*function mysql_fetch_all($result) {
   $return = [];
   while($row=mysql_fetch_array($result)) {
       $return[] = $row;
   }
   return $return;
}*/


?>