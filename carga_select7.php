<?
//Creado por Cesar Walter Gerez en Micodigobeta.com.ar
//A manera de ejemplo solo lo realizo con array, pero para que realmente sea dinamico se debería traer las opciones de una base de datos.
//Modificado por Milena Amaya MUESTRA EL PRECIO DEL PRODUCTO
$arrcan = explode("|",$_REQUEST["id"]);
$cantidad = $arrcan[0]; 
$bodega = $arrcan[1];
$serial = $arrcan[2];
$precio = $arrcan[3];

?>

  
  <option value='0'>Seleccione</option>
  <option value='<?=$precio?>'><?=number_format($precio,2,",",".")?></option>
  