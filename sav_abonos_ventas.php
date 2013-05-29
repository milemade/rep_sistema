<? include("js/funciones.php")?>
<? include("lib/database.php")?>
<?	$ahora = date("Y-n-j H:i:s");
    $_SESSION["ultimoAcceso"] = $ahora;//Es solo un registro de abono por cliente (bodega)
//print_r($_POST);
         $fecha = date("Y-m-d");
         $db = new Database();
$leotabla=str_replace("'",'"',$leotabla);//Agregue esto por incompatibilidad de comillas
	     $campos = "cod_bod_Abo, val_abo,cod_usu_abo,fec_abo,saldo,observacion,anotacion,cod_rso_abo,cheq_abo,efec_abo";
	     $values = "'$bodega','$valor','".$global[2]."','$fecha','$saldo', '$observaciones', '$leotabla', '$rsocial_fac',$cheq_abo,$efec_abo "; 
	     $sql = "INSERT INTO abono ($campos) VALUES($values)";//exit;
	     //echo "<br>";
	     $db->query($sql);	
	     $id=$db->insert_id();
//print_r($_POST);
    //De acuerdo con la cantidad de facturas se realizan los abonos y se actualiza cartera_factura (Solo Un registro por factura)
	//actualiza la cartera
	for($i=1;$i<=$cantidad;$i++){
	    //Realiza Los Abonos Inserta en la tabla abono
		 $observacion_abo = "observacion_".$i;
		 $valor = "valor_".$i;
	     if($_POST["accion_".$i]=='CANCELADA' || $_POST["accion_".$i]=='ABONADO'){
			$num_abonos = $_POST["num_abonos_".$i]."|".$id;
			$sql="UPDATE cartera_factura SET num_abono= '".$num_abonos."',
			             estado_car='".$_POST["accion_".$i]."', valor_abono='".$_POST["valor_abono_".$i]."'  
				   WHERE  cod_car_fac=".$_POST["codigo_cartera_".$i]."  ";
			echo $sql;"<br>";
			 $db->query($sql);	

			//TRAZA DE LA CARTERA
			$campos = " cod_car_tpag, fec_tpag, val_tpag, tipo_doc_tpag, num_doc_tpag ";
			$values = "'".$_POST['codigo_cartera_'.$i]."','".$fecha."','".$_POST['val_traza_'.$i]."','ABONO', '$id' "; 
			$sql = "  INSERT INTO traza_ventas_pagos ($campos) VALUES($values)";
			//echo "<br>";
			$db->query($sql);	
			//TRAZA DE LA CARTERA
		 }
	}
	
	//exit;
?>

<FORM method="POST" action="con_abono.php" name="myForm">
<input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
<input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
<input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" />
</FORM>
<SCRIPT>
	alert('SE HAN GUARDADO SATISFACTORIAMENTE SUS DATOS');
	//window.open("informes/ver_abono.php?codigo="+<?=$id?>,"ventana","menubar=0,resizable=1,width=700,height=400,toolbar=0,scrollbars=yes")
	//document.myForm.submit();
</SCRIPT>
