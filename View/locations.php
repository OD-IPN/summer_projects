<title>Locations</title>
<?php 
include 'header.php'; 
include '../Model/consultas.php';
?>
  <article id="content">
  <div class="wrapper">

<?php

if(isset($_GET['v'])){
  if($_GET['v']=='SL'){ ?>
    <h2>Sedes de Sharing Languages</h2> <?php
    $sedes = consultaSedesPrograma(1, $conexion);
    $sedes = json_decode($sedes);

    for ($sede=0; $sede < sizeof($sedes) ; $sede++) { 
      $infoEspecifica = consultaInfoSede($sedes[$sede]->sede, $conexion);
      $infoEspecifica = json_decode($infoEspecifica); ?>
      <section class="cols">
        <div class="wrapper pad_bot<?php echo ($sede)%2+1; ?>">
          <h3><?php echo $infoEspecifica[1]; ?></h3>
          <a href="infoSede.php?v=<?php echo $infoEspecifica[0].'&x='.$_GET['v']; ?>" class="link1">
            <figure><img src="<?php echo $infoEspecifica[4]; ?>" alt="" class="sede_img"></figure>
          </a>
          <p class="pad_bot1"><?php echo $infoEspecifica[3]; ?> <br><br>
            <a href="infoSede.php?v=<?php echo $infoEspecifica[0].'&x='.$_GET['v']; ?>" class="link1">Ver Horarios</a> 
          </p>          
        </div>
      </section>
    <?php }
   }elseif ($_GET['v']=='MLB') { ?>
    <h2>Sedes MLB</h2> <?php
    $sedes = array(
      0 => '1', 
      1 => '3',
      );
    for ($sede=0; $sede < sizeof($sedes) ; $sede++) { 
      $infoEspecifica = consultaInfoSede($sedes[$sede], $conexion);
      $infoEspecifica = json_decode($infoEspecifica); ?>
      <section class="cols">
        <div class="wrapper pad_bot<?php echo ($sede)%2+1; ?>">
          <h3><?php echo $infoEspecifica[1]; ?></h3>
          <a href="horarioMLB.php?v=<?php echo $infoEspecifica[0].'&x='.$_GET['v']; ?>" class="link1">
            <figure><img src="<?php echo $infoEspecifica[4]; ?>" alt="" class="sede_img"></figure>
          </a>
          <p class="pad_bot1"><?php echo $infoEspecifica[3]; ?> <br><br>
            <a href="horarioMLB.php?v=<?php echo $infoEspecifica[0].'&x='.$_GET['v']; ?>" class="link1">Ver Horarios</a> 
          </p>          
        </div>
      </section>
    <?php }
   }

}else{
    $sedes = consultaSedes($conexion);
    $sedes = json_decode($sedes);
    for ($j=0; $j < sizeof($sedes); $j++) {  ?>
      <section class="cols">
        <div class="wrapper pad_bot<?php echo "$j+1"; ?>">
          <h3><span class="dropcap"><?php echo $sedes[$j]->id; ?></span><?php echo $sedes[$j]->nombre ?></h3>
          <figure><img src="<?php echo $sedes[$j]->imagen_url; ?>" alt="" class="sede_img"></figure>
          
          <p class="pad_bot1"><?php echo $sedes[$j]->direccion ?> <br><br>
          <a href="infoSede.php?v=<?php echo $j+1; ?>" class="link1">Read More</a> 
          </p>          
          
        </div>
      </section>
      <?php } } ?>        
   </div>
  </article>
<?php include 'footer.php'; ?>