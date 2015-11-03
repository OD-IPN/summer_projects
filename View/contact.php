<title>Contact</title>
<?php include 'header.php'; ?>
    <article id="content">
    <input type="hidden" value="<?php if(isset($_GET['v'])) echo $_GET['v'];  ?>" id="programe">
      <div class="wrapper">
        <section class="col1">
          <h2 class="under">Formulario de Contacto</h2>
          <form id="ContactForm" action="#" method="post" class="[ ContactForm ]">
            <div>
              <div  class="wrapper"> <span>Nombre:</span>
                <input type="text" class="[ input ][ required ]" name="nombre">
              </div>
              <!--
              <div  class="wrapper"> <span>Ciudad:</span>
                <input type="text" class="[ input ][ required ]" name="cuidad">
              </div>-->
              <div  class="wrapper"> <span>E-mail:</span>
                <input type="text" class="[ input ][ required email ]" name="email">
              </div>
              <div  class="textarea_box"> <span>Mensaje:</span>
                <textarea name="textarea" cols="1" rows="1" name="msj"  class="[ required ]" id="MSJ"></textarea>
              </div>
              <center>
                <input type="submit" value="Registrar" class="[ btn btn-success ][ sendEmail ]"/> <input type="submit" value="Limpiar" class="[ btn btn-primary ][ clear_form ]" /></a>
              </center>
              <br/>
      	    </div>
          </form>
        </section>
        <section class="col2 pad_left1">
          <h2 class="[ under ][ register_c ]">Bienvenido!</h2>
	      <p>Para cualquier duda o aclaración. No dudes en comunicarte con nosotros, te responderemos a la mayor brevedad posible.</p>
	      <br/>	      
          <h2 class="[ under ][ register_c ]">Contacto</h2>
          <div id="address">

          <?php if (isset($_GET['v'])) {
            if ($_GET['v']=='SL') { ?>
            <a href="">fernanda.escobar@aiesec.net </a>55-3586-0537
            <br/>
            <br/>
            <a href="">gustavo.hurtado@aiesec.net </a>55-2110-2304
            <br/>
            <br/>
            <a href="">antonio.bravo@aiesec.net </a>55-1890-4967

         <?php   }
         else if ($_GET['v']=='MLB') { ?>
          <a href="">juan.estrada@aiesec.net </a>
            <br/>
            <br/>
            <a href="">operations.ipn@aiesec.org.mx </a>55-2302-6700
            <br/>
       <?php  }
        } ?>

          <!--
          <span>Informes:<br>
            Fernanda Escobar:<br>
            Gustavo Hurtado:<br>
            Antonio Bravo:
          </span> 
            <br>
            DF<br>
            5523026700<br>
            <a href="#" class="color2">operations.ipn@aiesec.org.mx</a></div>      -->
        </section>
      </div>
    </article>
<?php include 'footer.php'; ?>