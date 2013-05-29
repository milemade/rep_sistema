<? include "lib/database.php";
//Creado por Cesar Walter Gerez en Micodigobeta.com.ar
//A manera de ejemplo solo lo realizo con array, pero para que realmente sea dinamico se debería traer las opciones de una base de datos.
//Modificado por Milena Amaya BUSCA SERIAL-CANTIDAD-PRECIO_BODEGA
//realizamos la consulta
  $arrrequest = explode("|",$_REQUEST["id"]);
$color = $arrrequest[0];
$producto = $arrrequest[1];
//realizamos la consulta
  $dbzon = new Database();
  $sqlzon = "SELECT a.cod_bod_kar,a.serial,a.cant_ref_kar,a.valor_precio,b.nom_bod
               FROM kardex a JOIN bodega b ON a.cod_bod_kar=b.cod_bod
	          WHERE cod_ref_kar=".$producto."
	            AND cod_talla=".$color.";";
  //echo $sqlzon; exit;
  $opciones = "<option value='0'>   Seleccione   </option>";
  $dbzon->query($sqlzon);
  while($dbzon->next_row())
  {
     //$opciones .= "<option value='".$producto."|".$dbzon->serial."|".$dbzon->cant_ref_kar."'>".$sqlzon."</option>";
	 $opciones .= "<option value='".$dbzon->cant_ref_kar."|".$dbzon->cod_bod_kar."|".$dbzon->serial."'>".$dbzon->serial." / ".$dbzon->cant_ref_kar." / $".number_format($dbzon->valor_precio,0,".",".")." / ".$dbzon->nom_bod."</option>";
  }
  $dbzon->close();
  echo $opciones; 
?>