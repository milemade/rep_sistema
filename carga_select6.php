<?
//Creado por Cesar Walter Gerez en Micodigobeta.com.ar
//A manera de ejemplo solo lo realizo con array, pero para que realmente sea dinamico se deber�a traer las opciones de una base de datos.
//Modificado por Milena Amaya MUESTRA LA CANTIDAD DEL PRODUCTO
$arrcan = explode("|",$_REQUEST["id"]);
$cantidad = $arrcan[0]; 
$bodega = $arrcan[1];
?>

  
  <option value='0'>Seleccione</option>
  <option value='<?=$cantidad?>'><?=$cantidad?></option>
  