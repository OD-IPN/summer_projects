<title>Register</title>
<?php include 'header.php'; 
//var_dump($logged);
if($logged) {
  if (isset($_GET['v'])) 
    if($_GET['v']=='SL'){
      header('Location: index.php?v=SL');
    }elseif ($_GET['v']=='MLB') {
      header('Location: index.php?v=MLB');
    }else
  header('Location: index.php');
}
?>
    <article id="content">
    <input type="hidden" value="<?php if(isset($_GET['v'])) echo $_GET['v'];  ?>" id="programe">
      <div class="wrapper">
        <section class="col1">
            <h2 class="under">Registro</h2>
            <form id="js-RegisterForm" action="#" method="post" class="[ js-RegisterForm ][ j-register-user ]">
              <!--<form id="registerForm" action="#" method="post">-->
              <div class="form-style">
                <div  class="[ wrapper ]"> <span>Nombre*:</span><br/>
                  <input type="text" class="[ register_input ][ required ]" name="nombre"/>
                </div>
                <div  class="[ wrapper ]"> <span>Apellidos*:</span><br/>
                  <input type="text" class="[ register_input ][ required ]" name="apellidos"/>
                </div>
                <div  class="[ wrapper ]"  > <span>Email*:</span><br/>
                  <input type="text" class="[ register_input ][ required email ]" name="email" id="userEmail" />
                  <label for="Error" id="errorEmail" class="error">Error - Correo Actualmente Registrado. </label>
                </div>
                <div  class="[ wrapper ]"> <span>Edad:</span><br/>
                  <input type="text" class="[ register_input ][  ]" name="edad" />
                </div>
                <div  class="[ wrapper ]" > <span>Dirección:</span><br/>
                  <input type="text" class="[ register_input ][  ]" name="direccion"  /> <br/>

                </div>
                <div  class="[ wrapper ]"> <span>Teléfono*:</span><br/>
                  <input type="text" class="[ register_input ][ required ]"  name="tel"  />
                </div>
                <div  class="[ wrapper ]" > <span>Escuela/Universidad*:</span>
                  <select class= "[ register_input ][  ]" name="escuela" id="selectEscuela">
                    <option value="IPN" selected>IPN</option>
                    <option value="0">Otro</option>
                  </select>
                </div>
                <div  class="[ wrapper ][ otro ] "  > <span>Otro:</span><br/>
                  <input type="text" class="[ register_input ][ otro ]" name="externo" />
                </div>
                <div  class="[ wrapper ][ IPN ] "  > <span>Campus:</span><br/>
                  <input type="text" class="[ register_input ][ IPN ]" name="campus" />
                </div>

                <div  class="[ wrapper ]"  > <span>Contraseña*:</span><br/>
                  <input type="password" class="[ register_input ][ required ]" name="password" id="password" />
                </div><br/>
                <div  class="[ wrapper ]"  > <span>Confirmación de Contraseña*:</span><br/>
                  <input type="password" class="[ register_input ][ required ]" name="password_confirmation" id="password2" />
                </div><br/>
                    <input type="checkbox" name="accept" value="0" checked id="AP" /> Estoy acuerdo con los términos del <a href="http://www.aiesec.org.mx/privacyPolicy.html">Aviso de Privacidad.</a>
                    <br/>
                    <input type="submit" value="Registrar" class="[ js-registrar ][ btn-primary ]"  id="registerSubmit"/>
                </div>
                <br/>
            </form>
        </section>
        <section class="col2 pad_left1">

        <h3 class="register_c">¿Ya estás registrado?</h3>
        <h2 class="under [ register_c ]">Inicia Sesión</h2>
        <div id="iniciar">
          <form action="../Controller/login.php" method="post" class="[ login_form ]">
            <div  class="[ wrapper ] [ register_c ]"> <span>Email</span>
              <br/>
              <input type="text" class="[ login_input ][ required email ]" name="email">
            </div>
            <div  class="[ wrapper ] [ register_c ]"> <span>Contraseña</span>
              <br/>
              <input type="password" class="[ login_input ][ required ]" name="password">
              <br/>
              <br/>
            </div>
            <div  class="[ wrapper ] [ register_c ]"> 
              <input type="submit" value="Ingresar" class="[ register_c ][ btn-primary ][ login_submit ]">
            </div>
          </form>
        </section>
      </div>
    </article>
<?php include 'footer.php'; ?>