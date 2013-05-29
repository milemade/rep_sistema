<? include "lib/database.php";
//Creado por Cesar Walter Gerez en Micodigobeta.com.ar
//A manera de ejemplo solo lo realizo con array, pero para que realmente sea dinamico se debería traer las opciones de una base de datos.
//Modificado por Milena Amaya para filtrar los PRODUCTOS-CODIGO del tipo de producto elegido
$tipo = $_REQUEST["id"];
//realizamos la consulta
  $dbzon = new Database();
  $sqlzon = "SELECT distinct(a.cod_pro),a.nom_pro,a.cod_fry_pro
               FROM producto a JOIN tipo_producto b ON a.cod_tpro_pro=b.cod_tpro
	           JOIN marca c ON a.cod_mar_pro=c.cod_mar
	           JOIN kardex d ON a.cod_pro=d.cod_ref_kar
	          WHERE a.cod_tpro_pro=".$tipo.";";
  //echo $sqlzon; exit;
  $opciones = "<option value=0>Seleccione</option>";
  $dbzon->query($sqlzon);
  while($dbzon->next_row())
  {
     $opciones .= "<option value='".$dbzon->cod_pro."'>".$dbzon->cod_fry_pro." / ".$dbzon->nom_pro."</option>";
  }
  $dbzon->close();
  echo $opciones; 
?>