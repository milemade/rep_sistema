<? include "lib/database.php";
//Creado por Cesar Walter Gerez en Micodigobeta.com.ar
//A manera de ejemplo solo lo realizo con array, pero para que realmente sea dinamico se debería traer las opciones de una base de datos.
//Modificado por Milena Amaya para filtrar TIPO DE PRODUCTO que este en kardex
$marca = $_REQUEST["id"];
//realizamos la consulta
  $dbzon = new Database();
  $sqlzon = "SELECT DISTINCT(a.cod_tpro_pro),b.nom_tpro
               FROM producto a JOIN tipo_producto b ON a.cod_tpro_pro=b.cod_tpro
	           JOIN marca c ON a.cod_mar_pro=c.cod_mar
	           JOIN kardex d ON d.cod_ref_kar=a.cod_pro
	           WHERE a.cod_mar_pro=".$marca.";";
  $opciones = "<option value='0'>Seleccione</option>";
  $dbzon->query($sqlzon);
  while($dbzon->next_row())
  {
     $opciones .= "<option value='".$dbzon->cod_tpro_pro."'>".$dbzon->nom_tpro."</option>";
  }
  $dbzon->close();
  echo $opciones; 
?>