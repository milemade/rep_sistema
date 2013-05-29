<?php
$fechaOld= $_SESSION["ultimoAcceso"];
$ahora = date("Y-n-j H:i:s");
$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaOld));
$tiempoprogramado = $global[13] * 60;
if($tiempo_transcurrido>= $tiempoprogramado) { //comparamos el tiempo y verificamos si pasaron 5 minutos o 300 segs
  session_destroy();// destruimos la sesión
  echo "<script>alert('Fin de sesion, Ingrese de nuevo!');</script>";
  echo "<script>window.top.location='inicio.php'</script>"; 
  //echo "<script>window.close()'</script>";   
  exit;
}else {       //sino, actualizo la fecha de la sesión
$_SESSION["ultimoAcceso"] = $ahora;
//print_r($_SESSION);
} ?>

