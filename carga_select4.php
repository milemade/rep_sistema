<? include "lib/database.php";
//Creado por Cesar Walter Gerez en Micodigobeta.com.ar
//A manera de ejemplo solo lo realizo con array, pero para que realmente sea dinamico se debería traer las opciones de una base de datos.
//Modificado por Milena Amaya BUSCA COLORES EN KARDEX DEL PRODUCTO ESCOGIDO
$producto = $_REQUEST["id"];
//realizamos la consulta
  $dbzon = new Database();
  $sqlzon = "SELECT distinct(c.cod_pes),c.nom_pes
               FROM producto a JOIN kardex b ON a.cod_pro=b.cod_ref_kar
	           JOIN peso c ON b.cod_talla=c.cod_pes
	          WHERE b.cod_ref_kar=".$producto.";";
  //echo $sqlzon; exit;
  $opciones = "<option value=0>Seleccione</option>";
  $dbzon->query($sqlzon);
  while($dbzon->next_row())
  {
     $opciones .= "<option value='".$dbzon->cod_pes."|".$producto."'>".$dbzon->nom_pes."</option>";
  }
  $dbzon->close();
  echo $opciones; 
?>