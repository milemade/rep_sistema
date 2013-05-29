<? include("../lib/database.php") ?>
<? include("../js/funciones.php")?>
<?php 

if($archivo != NULL)
{ 
	$file = $archivo_name;	
	copy("$archivo","$file");
	$fp = fopen ("$file" , "r" ); 
	$dbdatos_edi= new  Database();
	$i=0;

	if($reinicio=="SI") {
		$sql="delete from kardex where cod_bod_kar=$bodega";
		$db->query($sql); 
	}
	$cant_reg=0;
	while (( $data = fgetcsv ( $fp ,20000, ";" )) !== FALSE ) 
	{ 
		
			//kardex($operador, $referencia,$bodega, $cantidad,$valor_precio,$talla)
			echo $referencia = $data[0];
			echo "ref---";
			echo $talla = $data[1];
			echo "talla---";
			echo $cantidad=$data[5];
			echo "cant---";
			echo "---bodega".$bodega;
			echo "<br>";
			if(!empty($referencia) && !empty($talla) && !empty($cantidad)  ) {
				//kardex("suma",$referencia,$bodega,$cantidad,"0",$talla);
				$cant_reg++;
				echo "entro";
			}
			
		$i++;
	} 
	fclose ( $fp ); 
	echo "El Proceso Termino correctamente...";
	echo "<br>";
	echo "Se Procesaron $cant_reg  Registros ";

}

else echo "Ocurrio un Error con el archivo";	
?>