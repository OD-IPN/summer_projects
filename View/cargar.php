<?php
//session_start();
include 'header.php';
include '../Model/consultas.php';

//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//if(!$_SESSION["autentificado"])
//{
//  echo "<script language='javascript'> alert('Hey!! Usted no puede entrar aquí sin registro!'); location.href='index.php'; </script>";
//}

?>

<html>
<head>
<meta charset="utf-8">
<title>.: Sube una foto :.</title>
</head>

<body>

<div id="Contenedor">

    <div id="Info">
      <p class="Titulo"> Formulario</p><br>

<form id="form1" name="form1" method="post" action="recibir.php" enctype="multipart/form-data">
  <p> Seleccione la imagen
    <input  type="file" name="Imagen"/>
  </p>
  <p>
    Categoria:<br>
    <select name="Ctg">
      <option value="Abstractos"> Abstractos </option>
      <option value="Animales"> Animales </option>
      <option value="Caricaturas"> Caricaturas </option>
      <option value="Deportes"> Deportes </option>
      <option value="Naturaleza"> Naturaleza </option>
      <option value="Paisajes"> Paisajes </option>
      <option value="Tecnologia"> Tecnologia </option>
    </select>
    <br>
  </p>
  <p>
    <br>
    <input type="submit" name="Aceptar" id="Aceptar" value="Enviar" />
    <input type="reset" value="Limpia eso!">
    <br>
  </p>
</form>
  <br>
    <a href="index.php"><div class="Imagen">
      <img src="images/Favicon.png"><p> Pagina principal</p>
    </div></a>
    <div id="Auxiliar"></div>

</div>
</div>
</div>
----
        <center>
          <form class="[ comprobantePago ]" name="comprobantePago" id="comprobantePago"  method="post" action="recibir.php" enctype="multipart/form-data" target='_blank'>
            <table class="[ horarios ][ cell ][ table table-striped ]">
              <tbody>
                <tr>
                  <td> COMPROBANTE </td>
                  <td> ESTADO </td>
                </tr>
                <tr>
                  <td> 
                    <input type="hidden" value="01" name="id" class="[ inpH ]">
                    <input type="file" name="foto" class="[  ]"/>(Máximo 2000KB) <br/>
                    <span>Fecha:</span> <input type="text" name="fecha" placeholder="aaaa/mm/dd" class="[  ][ inputBorder ]" /> <br/><br/>
                    <span>No. Autorización:</span> <input type="text" name="aut" placeholder="00000" class="[  ][ inputBorder ]" /> <br/><br/>
                    <span>No. Sucursal:</span> <input type="text" name="suc" placeholder="0000" class="[  ][ inputBorder ]" /> <br/><br/>
                    <span>Monto:</span> <input type="text" name="monto" placeholder="$0.00" class="[  ][ inputBorder ]" /> <br/><br/>
                    <input type="submit" class="[ button ][ btn-primary ][ js_uploadImage ]" value="Enviar"/>
                    <input type="hidden" value="1" name="programa" class="[ - ]" />
                  </td>
                </tr>                
              </tbody>
            </table>
          </form>
        </center>

</body>
</html>