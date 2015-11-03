	var miHorario = [];
	var clases = {};

	function comprobarHorario(horaInicio){
		if (miHorario.length == 0)
			return false;
		for (var j = 0; j < miHorario.length; j++){
			if (miHorario[j].localeCompare(horaInicio) == 0){
				return true;
			}
		}
		
	}
	function quitarHora(horaAQuitar){
		var index = miHorario.indexOf(horaAQuitar);
		miHorario.splice(index, 1);
		return true;
	}

	function sumar(elemento){
		fila = $(elemento).parent().parent();
		horaInicio = fila.attr('id');

		if (comprobarHorario(horaInicio))
			sweetAlert("Oops...", "Ya tienes un grupo en la misma hora!", "error");
		else{
			miHorario.push(horaInicio);
			$(fila).find('img').removeClass('Add');
			$(fila).find('img').parent().html('<img id='+horaInicio+' src="images/menos.png" onclick="quitar(this)" class="quitar" />');
			
			$('.misHorarios').append(fila);
			swal("Operación Realizada!", "Se ha agregado el grupo!", "success");

			console.log(miHorario);
			return 0;
		}
	}

	function quitar(elemento){
		fila = $(elemento).parent().parent();
		horaInicio = $(elemento).attr('id');

		if (quitarHora(horaInicio)){
			$(fila).find('img').removeClass('quitar');
			$(fila).find('img').parent().html('<img  id='+horaInicio+' src="images/mas.png"  onclick="sumar(this)" class="Add" />');			
			$('.horarios').append(fila);
			swal("Operación Realizada!", "Se ha quitado el grupo de tu horario!", "success");	
			
			console.log(miHorario);
			return 0;
		}else
		console.log("algo salió mla al eliminar la hora");			
	}

	function filtrar(){
		$('#sede').on('change', function(e){
			sede = $('#sede').val();
			programa = 1;
			//programa = $('#programa').val();
			idioma = $('#idioma').val();
			modalidad = $('#modalidad').val();
			cadena=sede+''+programa+''+idioma+''+modalidad;
			filtrosMultiples(cadena);
			console.log(cadena);
		});
		$('#programa').on('change', function(e){
			sede = $('#sede').val();
			programa = 1;
			//programa = $('#programa').val();
			idioma = $('#idioma').val();
			modalidad = $('#modalidad').val();
			cadena=sede+''+programa+''+idioma+''+modalidad;
			filtrosMultiples(cadena);
			console.log(cadena);
		});
		$('#idioma').on('change', function(e){
			sede = $('#sede').val();
			programa = 1;
			//programa = $('#programa').val();
			idioma = $('#idioma').val();
			modalidad = $('#modalidad').val();
			cadena=sede+''+programa+''+idioma+''+modalidad;
			filtrosMultiples(cadena);
			console.log(cadena);
		});
		$('#modalidad').on('change', function(e){
			sede = $('#sede').val();
			programa = 1;
			//programa = $('#programa').val();
			idioma = $('#idioma').val();
			modalidad = $('#modalidad').val();
			cadena=sede+''+programa+''+idioma+''+modalidad;
			filtrosMultiples(cadena);
			console.log(cadena);
		});	

	}

	function escuela(){
		var escuela = aceptacion =  "";
		$('.otro').hide();
		$('.register_input').on('change', function(e){
			escuela = $('#selectEscuela').val();
			if(escuela=='0'){
				$('.otro').show();
				$('.IPN').hide();
			}else{
				$('.otro').hide();
				$('.IPN').show();
			}
			//post_data['tipo']    = $('.reporte select[name="reportes"]').val();
		});

		$('#js-RegisterForm').on('change', function(e){
			if ( $('#AP').is(':checked') ) {
				document.getElementById("registerSubmit").disabled = false;
			}
			else {
				document.getElementById("registerSubmit").disabled = true;	
			}
			comprobarDisponibilidad();
		});

	}

	function filtrosMultiples(cadena){
		$('.horarios tr').show();

		switch(cadena[0]){
			case '1':
			$('.ESE').hide();
			$('.IMEJ').hide();
			break;

			case '2':
			$('.ESCOM').hide();
			$('.IMEJ').hide();
			break;

			case '3':
			$('.ESE').hide();
			$('.ESCOM').hide();
			break;

			default:
			break;
		}

		switch(cadena[1]){
			case '1':
			$('.MLB').hide();
			break;

			case '2':
			$('.SL').hide()
			break;

			default:
			break;
		}

		switch(cadena[2]){
			case '1':
			//$('.Inglés').hide();
			$('.Francés').hide();
			$('.Alemán').hide();
			$('.Chino').hide();
			$('.Italiano').hide();
			$('.Portugués').hide();
			break;

			case '2':
			$('.Inglés').hide();
			//$('.Francés').hide();
			$('.Alemán').hide();
			$('.Chino').hide();
			$('.Italiano').hide();
			$('.Portugués').hide();
			break;

			case '3':
			$('.Inglés').hide();
			$('.Francés').hide();
			//$('.Alemán').hide();
			$('.Chino').hide();
			$('.Italiano').hide();
			$('.Portugués').hide();
			break;

			case '4':
			$('.Inglés').hide();
			$('.Francés').hide();
			$('.Alemán').hide();
			//$('.Chino').hide();
			$('.Italiano').hide();
			$('.Portugués').hide();
			break;

			case '5':
			$('.Inglés').hide();
			$('.Francés').hide();
			$('.Alemán').hide();
			$('.Chino').hide();
			//$('.Italiano').hide();
			$('.Portugués').hide();
			break;

			case '6':
			$('.Inglés').hide();
			$('.Francés').hide();
			$('.Alemán').hide();
			$('.Chino').hide();
			$('.Italiano').hide();
			//$('.Portugués').hide();
			break;

			default:
			break;
		}

		switch(cadena[3]){
			case '1':
			$('.S').hide();
			break;

			case '2':
			$('.L-V').hide();
			break;

			default:
			break;
		}

		$('.misHorarios tr').show();

	}

	function registrarGrupos(){
		$('.js-inscribir').click(function(e){
			e.preventDefault();
			//confirmacion = confirm("¿Estás seguro de realizar tu inscripción?");
			var confirmacion = false;
			
			swal({
			  title: "¿Estás seguro de finalizar tu inscripción?",
			  text: "Una vez confirmada no te será posible modificarla por ti mism@. ",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Si, Estoy de acuerdo!",
			  cancelButtonText: "No, Cancelar!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
				console.log(isConfirm);
				confirmacion = true;
			  if (isConfirm) {
			    swal("Registrado!", "A continuación verás los detalles de tu inscripción.", "success");
			    var infoTabla= document.getElementById('misHorarios');
				infoTabla = infoTabla.childNodes[1].childNodes;

				for (var k = 2; k < infoTabla.length; k++) {
					var childs = infoTabla[k].childNodes;
					idFila = infoTabla[k].getAttribute('data-id');
					console.log(idFila);
					for (var i = 0; i < childs.length-2; i++) {
						if(i%2 != 0)
							console.log(childs[i].innerText);
					};
					var post_data= {};
					post_data['action']  = 'registrar_grupo_SL';
					post_data['id']  = $('.user_id').val();
					post_data['id_curso'] = idFila;
					post_data['sede'] = childs[1].innerText;
					post_data['programa'] = childs[3].innerText;
					post_data['idioma'] = childs[5].innerText;
					post_data['dias'] = childs[9].innerText;
					post_data['inscritos'] = 30-post_data['cupo'];
					inscribir(post_data);
					console.log(post_data);
				};
			    
			  } else {
			    swal("Cancelado", "Sigue buscando entre nuestros grupos.", "error");
			  }
			});//swal
		});
}


function reportes(){
	$('.reportes_js').click(function(e){
		var post_data= {};
		post_data['action']  = 'reportes';
		post_data['programa']  = $('#programa').val();;
		post_data['tipo']    = $('.reporte select[name="reportes"]').val();
		console.log(post_data);

		$.post(
			ajax_url,
			post_data,
			function(response){
				console.log(response);
				$('.reporteInfo').append(""+response);

			});
		
	});
}


ajax_url="../Controller/functions.php";

function aceptarPago(){
	$('.pago_js_A').click(function(e){
		e.preventDefault();
		var pago_id = this.parentNode.parentNode.parentNode.childNodes[0].childNodes[13].childNodes[1].value;

		var post_data= {};
		post_data['action'] = 'updatePago';
		post_data['estado'] = '2';
		post_data['programa'] = $('#programa').val();
		post_data['user_id']  = pago_id;
		console.log(post_data);

		$.post(
			ajax_url,
			post_data,
			function(response){
				console.log(response);
				if(response=='1'){
					swal("Cambio Realizado", "El comprobante ha sido considerado valido!", "info");
					setTimeout("location.reload();", 1000);
				}
			});

	});
	
}
function rechazarPago(){
	$('.pago_js_R').click(function(e){
		e.preventDefault();

		var pago_id = this.parentNode.parentNode.parentNode.childNodes[0].childNodes[13].childNodes[1].value;
		//console.log(pago_id);

		var post_data= {};
		post_data['action'] = 'updatePago';
		post_data['estado'] = '3';
		post_data['programa'] = $('#programa').val();
		post_data['user_id']  = pago_id;
		console.log(post_data);

		$.post(
			ajax_url,
			post_data,
			function(response){
				console.log(response);
				if(response=='1'){
					swal("Cambio Realizado", "El comprobante ha sido rechazado.", "warning");
					setTimeout("location.reload();", 1000);
				}
			});
	});

}


function registrar(){
	$('.js-registrar').click(function(e) {
		formValidation('.js-RegisterForm', null);
	});
}
function borrarAlumno(){
	$('.group_delete_js').click(function(e){
		e.preventDefault();
		var user_id = this.parentNode.childNodes[1].value;
		var group_id = this.parentNode.childNodes[2].value;
		var programa = this.parentNode.childNodes[3].value;
		var insc_id = this.parentNode.childNodes[4].value;

		var post_data= {};
		post_data['action'] = 'borrarAlumno';
		post_data['programa'] = programa;
		post_data['user_id']  = user_id;
		post_data['group_id']  = group_id;
		post_data['id']  = insc_id;
		
		swal({
			  title: "¿Estás seguro de eliminar a este usuario del grupo?",
			  text: "Una vez eliminado dejará de formar parte de este grupo.",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Si, Estoy de acuerdo!",
			  cancelButtonText: "No, Cancelar!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
				if (isConfirm) {
				    swal("Eliminando...", "Solicitud en proceso.", "info");
				    $.post(
						ajax_url,
						post_data,
						function(response){
							console.log(response);
							if(response=='1'){
								swal("Cambio Realizado", "El usuario ha sido eliminado.", "success");
								setTimeout("location.reload();", 1000);
							}
						});			    
				} else {
					swal("Cancelado", "No ha sido realizado cambio alguno.", "error");
				}
			});
		});
}

function formValidation(forma, par){
	//console.log(forma);
	$(forma).validate({
		rules: {
			password_confirmation:{
				equalTo: "#password"
			},
			password_confirmation2:{
				equalTo: "#password2"
			}
		},
		submitHandler:function(){
			//console.log(forma);
			switch(forma){
				case '.j-register-user':
                //registerUser();
                break;

                case '.js-RegisterForm':
                register_info();
                break;

                case '.login_form':
                login_info(par);
                break;

                case '.comprobantePago':
                registrarPago(par);
                break;

                case '.ContactForm':
                enviarEmailContacto();
                break;

                default:
                console.log('default');
                break;
            }
        }
    });
}

function limpiar(){
	$('.clear_form').click(function(e){
		e.preventDefault();
		var formulario = this.parentNode.parentNode.parentNode;
		formulario.reset();
	});
	
}

function enviarEmail(){
	$('.sendEmail').click(function(e){
		var formulario = this.parentNode.parentNode.parentNode;
		formValidation('.ContactForm', formulario);
	});
}

function enviarEmailContacto(){
	//console.log(param);
	var post_data= {};

	post_data['action']  = 'emailContacto';
	post_data['nombre']    = $('.ContactForm input[name="nombre"]').val();
	post_data['email']    = $('.ContactForm input[name="email"]').val();
	post_data['msj'] = $('#MSJ').val();
	post_data['programa'] = $('#programe').val();

	console.log(post_data);

	$.post(
		ajax_url,
		post_data,
		function(response){
			if(response=='1'){
				swal("Mensaje Enviado!", "Nos pondremos en contacto.", "success");
				setTimeout("location.reload()", 2000);
			}else if(response=='0'){
				swal("Ha ocurrido un error!", "Por favor intenta de nuevo!", "error");
				//setTimeout("location.href='miHorario.php?v=SL'", 2000);
			}
		});

}

function login(programa){
	$('.login_submit ').click(function(e) {
		formValidation('.login_form', programa);
	});
}

function logoutSL(){
	$('.js-logoutSL ').click(function(e) {
		e.preventDefault();

		var post_data= {};
		post_data['action']  = 'logout';

		$.post(
			ajax_url,
			post_data,
			function(response){
				console.log(response);
				if(response=="0")setTimeout("location.href='register.php?v=SL'", 1000);

			});
	});
}
function logout(){
	$('.js-logout ').click(function(e) {
		e.preventDefault();

		var post_data= {};
		post_data['action']  = 'logout';

		$.post(
			ajax_url,
			post_data,
			function(response){
				console.log(response);
				if(response=="0")setTimeout("location.href='register.php?v=MLB'", 1000);

			});
	});
}

function inscribir(post_data){
	$.post(
		ajax_url,
		post_data,
		function(response){
			if(response){
				swal("Operación Realizada!", "Se han registrado correctamente los cambios!", "success");
				setTimeout("location.href='miHorario.php?v=SL'", 2000);
			}
		});
}

function inscribir_MLB(post_data){
	$.post(
		ajax_url,
		post_data,
		function(response){
			console.log(response);
			if(response){
				console.log("Registrado");
				swal("Éxito!", "Has creado un nuevo grupo!", "success");
				setTimeout("location.href='miHorario.php?v=MLB'", 2000);
			}else{
				sweetAlert("Oops...", "Ha ocurrido un error.", "error");
			}
		});
}




function login_info(programa){
	var login_data= {};

	login_data['action']  = 'login';
	login_data['email']    = $('.login_form input[name="email"]').val();
	login_data['password'] = $('.login_form input[name="password"]').val();
	login_data['programa'] = $('#programe').val();
	console.log(login_data);
	$.post(
		ajax_url,
		login_data,
		function(response){
			response = response[response.length-1];
			if(response=='1'){
				//console.log("success");
				swal("Bienvenido!", "Contraseña Correcta!", "success");
				if(programa == 'SL'){
					setTimeout("location.href='index.php?v=SL'", 2000);
				}else if(programa == 'MLB'){
					setTimeout("location.href='index.php?v=MLB'", 2000);
				}
			}
			else if(response=='0'){
				console.log("Error - Password incorrecta");
		            	//setTimeout("location.href='index.php'", 1000);
		            	sweetAlert("Oops...", "Contraseña Incorrecta!", "error");
		            }
		            else if(response=="2"){
		            	console.log("Error - Usuario no registrado");
		            	sweetAlert("Oops...", "Este usuario no está registrado.", "error");
		            	//setTimeout("location.href='index.php'", 1000);
		            }
		            else if(response=="3"){
		            	console.log("Error - Formato de e-mail incorrecto");
		            	//setTimeout("location.href='index.php'", 1000);
		            }

		        } //response
		        );
}

var estadOriginal = "";

function horariosMLB(){
	var contador=0, lunes=0, martes=0, miercoles=0, jueves=0, viernes=0;
	var identificador ="";
	var clase = "";
	clases['1']= [];
	clases['2']= [];
	clases['3']= [];
	clases['4']= [];
	clases['5']= [];
	
	$('#misHorarios .disp, .conI, .con1').click(function(e){
		clase = this.getAttribute('class');
		identificador = clase.substring(0,5);
		estado = clase.substring(5,clase.length);
		var caso = identificador.substring(2,3);
		var valor = this.childNodes[0]['data'];

		if((estado=='[ disp ]' || estado=='[ conI ]' || estado=='[ con1 ]') && contador<3){
			switch(caso){
				case '1':
					if(lunes<2){
						this.setAttribute("class", identificador+"[ select ]");		
						lunes++;
						contador++;
						clases['1'].push(valor);
						clases['1'].sort();
						estadOriginal = estado;
						}
				break;
				
				case '2':
					if(martes<2){
						this.setAttribute("class", identificador+"[ select ]");		
						martes++;
						contador++;
						clases['2'].push(valor);
						clases['2'].sort();
						estadOriginal = estado;
						}
				break;
				
				case '3':
					if(miercoles<2){
						this.setAttribute("class", identificador+"[ select ]");		
						miercoles++;
						contador++;
						clases['3'].push(valor);
						clases['3'].sort();
						estadOriginal = estado;
						}
				break;
				
				case '4':
					if(jueves<2){
						this.setAttribute("class", identificador+"[ select ]");		
						jueves++;
						contador++;
						clases['4'].push(valor);
						clases['4'].sort();
						estadOriginal = estado;
						}
				break;
				
				case '5':
					if(viernes<2){
						this.setAttribute("class", identificador+"[ select ]");		
						viernes++;
						contador++;
						clases['5'].push(valor);
						clases['5'].sort();
						estadOriginal = estado;
						}
				break;
			}
		}
		else if(estado=='[ select ]'){
			this.setAttribute("class", identificador+""+estadOriginal);
			contador--;
			switch(caso){
				case '1':
					for (var index = 0; index < clases['1'].length; index++) {
						if(clases['1'][index]==valor){
							clases['1'].splice(index,1);
						}
					};
					lunes--;
					break;
					
				case '2':
					for (var index = 0; index < clases['2'].length; index++) {
						if(clases['2'][index]==valor){
							clases['2'].splice(index,1);
						}
					};
					martes--;
					break;
				
				case '3':
					for (var index = 0; index < clases['3'].length; index++) {
						if(clases['3'][index]==valor){
							clases['3'].splice(index,1);
						}
					};
					miercoles--;
					break;
				case '4':
				for (var index = 0; index < clases['4'].length; index++) {
					if(clases['4'][index]==valor){
						clases['4'].splice(index,1);
					}
				};
				jueves--;
				break;
				case '5':
				for (var index = 0; index < clases['5'].length; index++) {
					if(clases['5'][index]==valor){
						clases['5'].splice(index,1);
					}
				};
				viernes--;
				break;
			}
		}
		actualizarInfo(clases);
		if(contador==3){
			document.getElementById("submitBtn").disabled = false;
		}
		else{
			document.getElementById("submitBtn").disabled = true;	
		}

	});
}

function actualizarInfo(clases){
	console.log(clases);
	var conteo=0, dia;
	var mostrador;
	document.getElementById('data1').innerText="";
	document.getElementById('data2').innerText="";
	document.getElementById('data3').innerText="";

	for (var iknus = 1; iknus <= 5; iknus++) {
		if(clases[iknus].length>0){
			for (var jk = 0; jk < clases[iknus].length; jk++){
				switch(iknus){
					case 1:
						dia= "Lunes\n";
					break;
					case 2:
						dia= "Martes\n";
					break;
					case 3:
						dia= "Miércoles\n";
					break;
					case 4:
						dia= "Jueves\n";
					break;
					case 5:
						dia= "Viernes\n";
					break;
				}
				switch(conteo){
					case 0:
						mostrador=document.getElementById('data1');
						mostrador.innerText=dia+clases[iknus][jk];	
						conteo++;
					break;
					case 1:
						mostrador=document.getElementById('data2');
						mostrador.innerText=dia+clases[iknus][jk];	
						conteo++;
					break;
					case 2:
						mostrador=document.getElementById('data3');
						mostrador.innerText=dia+clases[iknus][jk];	
						conteo++;
					break;
				}
			}
		}
	};
}

function register_info(){
	var register_data= {};

	register_data['action']  = 'register';
	register_data['nombre']  = $('.js-RegisterForm input[name="nombre"]').val();
	register_data['apellido']  = $('.js-RegisterForm input[name="apellidos"]').val();
	register_data['edad']  = $('.js-RegisterForm input[name="edad"]').val();
	register_data['direccion']  = $('.js-RegisterForm input[name="direccion"]').val();
	register_data['tel']  = $('.js-RegisterForm input[name="tel"]').val();
	register_data['escuela']  = $('.js-RegisterForm select[name="escuela"]').val();
	register_data['externo']  = $('.js-RegisterForm input[name="externo"]').val();
	register_data['campus']  = $('.js-RegisterForm input[name="campus"]').val();
	register_data['email']  = $('.js-RegisterForm input[name="email"]').val();
	register_data['password']  = $('.js-RegisterForm input[name="password"]').val();
	register_data['programa'] = $('#programe').val();
	
	console.log(register_data);
	$.post(
		ajax_url,
		register_data,
		function(response){
			console.log(response);
			if(response=='1'){
				console.log("success");
				swal("Usuario registrado", "Ahora inicia sesión!", "success");
				//setTimeout("location.href='register.php'", 1000);
				setTimeout("location.reload();", 1000);
			}
			else if(response=='0'){
				console.log("Error - Password incorrecta");
		            	//setTimeout("location.href='index.php'", 1000);
		            }
		            else if(response=="-1"){
		            	console.log("Error - Usuario no registrado");
		            	//setTimeout("location.href='index.php'", 1000);
		            }
		            else if(response=="-2"){
		            	console.log("Error - Formato de e-mail incorrecto");
		            	//setTimeout("location.href='index.php'", 1000);
		            }

		        } //response
		        );
}

function comprobarDisponibilidad(){
	var mail = $('#userEmail').val();
		console.log(mail);
		var post_data = {};
		post_data['action'] = "verificarDisponibilidad";
		post_data['mail'] = mail;

		$.post(
		ajax_url,
		post_data,
		function(response){
			if(""+response!=0){
				console.log("No Disponible");
				$('#errorEmail').show();
				document.getElementById("registerSubmit").disabled = true;
			}else{
				console.log("Disponible");
				$('#errorEmail').hide();
				document.getElementById("registerSubmit").disabled = false;
			}
		});
}

function validarDisponibilidad(){
	$('#errorEmail').hide();
	//document.getElementById("registerSubmit").disabled = true;
	$('#userEmail').on("change", function(e){
		comprobarDisponibilidad();
	});

	$('#userEmail').on("focusout", function(e){
		e.preventDefault();
		comprobarDisponibilidad();
	});

}

function inscribirIndividialMLB(){
	$('.js_MLB_Inscripcion').click(function(e){
		e.preventDefault();	
		//confirmacion = confirm("¿Estás seguro de realizar tu inscripción?");
		var temp = this;
		swal({
			  title: "¿Estás seguro de finalizar tu inscripción?",
			  text: "Una vez confirmada no te será posible modificarla por ti mism@. ",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Si, Estoy de acuerdo!",
			  cancelButtonText: "No, Cancelar!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
				var parent = temp.parentNode.parentNode;
				var text = parent.childNodes[5].childNodes[0];
				var post_data= {};
				post_data['action']  = "registrar_individual_MLB";
				post_data['user_id']  = $('.user_id').val();
				post_data['group_id']  = parent.getAttribute('data-id');
				post_data['cantidad']  = '1';
				console.log(post_data);
				$.post(
					ajax_url,
					post_data,
					function(response){
						console.log(response);
						if(response){
							swal("Operación Realizada!", "Te has registrado dentro de un nuevo grupo!", "success");
							setTimeout("location.href='miHorario.php?v=MLB'", 2000);
						}else{
							sweetAlert("Oops...", "Ha ocurrido un error.", "error");
						}
					});
			  } else {
			    swal("Cancelled", "Your imaginary file is safe :)", "error");
			  }
			}); //swal
	});
}

function inscribirMLB(){
	$('.js-inscribir').click(function(e){
		e.preventDefault();
		//confirmacion = confirm("¿Estás seguro de realizar tu inscripción?");
		
		swal({
			  title: "¿Estás seguro de finalizar tu inscripción?",
			  text: "Una vez confirmada no te será posible modificarla por ti mism@. ",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonClass: "btn-danger",
			  confirmButtonText: "Si, Estoy de acuerdo!",
			  cancelButtonText: "No, Cancelar!",
			  closeOnConfirm: false,
			  closeOnCancel: false
			},
			function(isConfirm) {
			  if (isConfirm) {
			    swal("Registrado!", "Solicitud en proceso.", "info");
			  	var post_data= {};
				post_data['action']  = "registrar_grupo_MLB";
				post_data['id']  = $('.user_id').val();
				post_data['nombre'] = $('#nombreGrupo').val();
				post_data['sede'] = $('#sede').val();;
				post_data['programa'] = '2';
				post_data['idioma'] = $('#idiomas').val();
				post_data['horario'] = clases;
				post_data['registrados'] = $('#integrantes').val();
				console.log(post_data);
				inscribir_MLB(post_data);
	    
				} else {
			    	swal("Cancelado", "Sigue creando tu horario o elige alguno de nuestros grupos.", "error");
			  	}
		});//swal
	});
}

function subirComprobante () {
	$('.js_uploadImage').click(function(e){
		e.preventDefault();
		var form = this.parentNode.parentNode.parentNode.parentNode.parentNode;
		console.log(form);
		//idFila = infoTabla[k].getAttribute('data-id');
		var form_id = form.getAttribute('id');
		console.log(form_id);
		var id = '#'+form_id;
		$(id).submit();
		//formValidation('.comprobantePago', form);
	});
}

function subirComprobanteSubmit(form_id){
	var id = '#'+form_id;
	alert(ajax_url);
	$(id).submit();
}

function registrarPago(form){
	var register_data= {};
	console.log(form);
	var id_ = form.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes;
	var id = form.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[1].value;
	var foto = form.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[3].value;
	var fecha = form.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[9].value;
	var autentificacion = form.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[16].value;
	var sucursal = form.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[23].value;
	var monto = form.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[30].value;
	var programa = form.childNodes[1].childNodes[1].childNodes[3].childNodes[1].childNodes[37].value;
	//console.log(id_);

	register_data['action']  = 'pago';
	register_data['id']  = id;
	register_data['foto']  = foto;
	register_data['fecha']  = fecha;
	register_data['autentificacion']  = autentificacion;
	register_data['sucursal']  = sucursal;
	register_data['monto']  = monto;
	register_data['programa']  = programa;

	console.log(register_data);
	$.post(
		ajax_url,
		register_data,
		function(response){
			//console.log(response);
			if(response=='1'){
				console.log("success");
				swal("Comprobante registrado", "Verificando el estado del pago.", "success");
				//setTimeout("location.href='register.php'", 1000);
				setTimeout("location.reload();", 1000);
			}
			else if(response=='0'){
				console.log("Error - Password incorrecta");
		            	sweetAlert("Oops...", "Error al registrar el comprobante!", "error");
		            }
		            else if(response=="-1"){
		            	console.log("Error - Usuario no registrado");
		            	//setTimeout("location.href='index.php'", 1000par);
		            }
		            else if(response=="-2"){
		            	console.log("Error - Formato de e-mail incorrecto");
		            	//setTimeout("location.href='index.php'", 1000);
		            }

		        } //response
		        );
}

	$(window).load(function(){
	//horarios();
	//sumar();
});