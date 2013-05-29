<?php
     require_once("lib/database.php");
	 require_once("js/funciones.php");
	 function saldocantidad($serial,$cantidad)
	 { //Revisa que haya existencias
	        $dbx = new Database();
		    $sqlx = "SELECT cant_ref_kar FROM kardex WHERE serial='".$serial."';";			
			$dbx->query($sqlx);
			$dbx->next_row();
			$cantidad_actual = $dbx->cant_ref_kar;
			$saldo = $cantidad_actual - $cantidad;
			return $saldo;
	 }
	 $lista = new Database();
	 //Para saber las tablas de la base de datos y guardarlas en un arreglo
	 $sql = "SHOW TABLES FROM facturacion 
	        WHERE Tables_in_facturacion LIKE '%m_remision%' OR 
			      Tables_in_facturacion LIKE '%d_remision%';";
	 $lista->query($sql);
	 while($lista->next_row())
	 {
	         $arrtablas[] = $lista->Tables_in_facturacion;
	 }
	 $dbb= new Database(); 
         $sqll = "SELECT cod_usu,dir_usu
		    FROM usuario a
		   INNER JOIN cargo b ON a.car_usu = b.cod_car
		          AND a.car_usu=2";
         $dbb->query($sqll);
	 $i = 0;
         while  ($dbb->next_row())
         {
	     $mailusuario = $dbb->dir_usu;
		 $maestra = "m_remision".$dbb->cod_usu;
		 $detalle = "d_remision".$dbb->cod_usu;
		 for($i=0;$i<count($arrtablas);$i++)
		 {
		     if(trim($arrtablas[$i]) == $maestra)
		     {   
		          
			  $dbsel = new Database();
			  $sqlg = "SELECT cod_fac,cod_usu,cod_cli,fecha,num_fac,obs,cod_razon_fac,tot_fac FROM ` ".$maestra."`;";
			  $dbsel->query($sqlg);
			  $campos = "cod_usu,cod_cli,fecha,num_fac,obs,cod_razon_fac,tot_fac";
			  $contadormaestro = 0;
			  while($dbsel->next_row())
			  {    //In
			      $dbmax = new Database();
			      $sqlmax = "SELECT MAX(num_fac) + 1 as max FROM m_remision;";
			      $dbmax->query($sqlmax);
			      $dbmax->next_row();
			      $maximo = $dbmax->max; //exit;				  $dbmax->close();
			      if ($maximo=="") $maximo=1; 
			      $valores = $dbsel->cod_usu.",".$dbsel->cod_cli.",'".$dbsel->fecha."',".$maximo.",'".$dbsel->obs."',".$dbsel->cod_razon_fac.",";
			      $valores .= $dbsel->tot_fac;
			      $dbi = new Database();
			      $sqli = "INSERT INTO m_remision(".$campos.") VALUES(".$valores.");";
			      $dbi->query($sqli);
			      $id_maestra = $dbi->insert_id();// El id del registro en la tabla maestra
			      $dbi->close();
			      $camposdet = "cod_dfac,cod_mfac,cod_tpro,cod_cat,cod_peso,cod_pro,cod_bod,disponible,cant_pro,val_uni,total_pro,serial";
			      $camposdetinsert = "cod_mfac,cod_tpro,cod_cat,cod_peso,cod_pro,cod_bod,disponible,cant_pro,val_uni,total_pro,serial";
			      $dbd = new Database();
			      $sqldd = "SELECT ".$camposdet." FROM ` ".$detalle."` WHERE cod_mfac=".$dbsel->cod_fac.";";//exit;
			      $dbd->query($sqldd);
			      while($dbd->next_row())
			      {
			     $valoresdt = $id_maestra.",".$dbd->cod_tpro.",".$dbd->cod_cat.",".$dbd->cod_peso;
				 $valoresdt .= ",".$dbd->cod_pro.",'".$dbd->cod_bod."',".$dbd->disponible.",'".$dbd->cant_pro;
				 $valoresdt .= "',".$dbd->val_uni.",'".$dbd->total_pro."',".$dbd->serial;
				 $saldoproducto = saldocantidad($dbd->serial,$dbd->cant_pro); 
				 if($saldoproducto>=0)
				 {
					 $sqldt = "INSERT INTO d_remision(".$camposdetinsert.") VALUES(".$valoresdt.");";
					 $dbdd = new Database();				 
					 $dbdd->query($sqldt);
					 kardex("resta",$dbd->cod_pro,$dbd->cod_bod,$dbd->cant_pro,$dbd->val_uni,$dbd->cod_peso,$dbd->serial);
				 }
				 if($saldoproducto<0)
				 {
				      $despachado = $dbd->cant_pro + $saldoproducto;
					  $faltante = abs($saldoproducto);
					  $dbd->disponible = 0 ;
					  $dbd->total_pro = $despachado * $dbd->val_uni;
					  $valoresdt = $id_maestra.",".$dbd->cod_tpro.",".$dbd->cod_cat.",".$dbd->cod_peso;
				      $valoresdt .= ",".$dbd->cod_pro.",'".$dbd->cod_bod."',".$dbd->disponible.",".$despachado;
				      $valoresdt .= ",".$dbd->val_uni.",".$dbd->total_pro.",".$dbd->serial;
					  $sqldt = "INSERT INTO d_remision(".$camposdetinsert.") VALUES(".$valoresdt.");";
					 //echo $sqldt; exit;
					  $dbdd = new Database();				 
					  $dbdd->query($sqldt);
					  kardex("resta",$dbd->cod_pro,$dbd->cod_bod,$despachado,$dbd->val_uni,$dbd->cod_peso,$dbd->serial);   
					  $mensaje = "Remision No ".$maximo." Serial ".$dbd->serial." Existencias Solicitadas: ".$dbd->cant_pro." 
					               Existencias Despachadas ".$despachado." Existencias Faltantes: ".$faltante."."; 
					  //echo $mensaje;
					  $cabecera = "MIME-Version: 1.0\r\n";
				      $cabecera .= "Content-type: text/html; charset=iso-8859-1\r\n";
				      $cabecera .= "From: admin@constructora-alianza.com\n";
					  $cabecera .= "X-Mailer: PHP/" . phpversion();
					  $asunto="REPORTE SALIDA Remisiones";
					  @mail($mailusuario, $asunto, $mensaje, $cabecera);
					  @mail($global[9], $asunto, $mensaje, $cabecera);
				 }
			      }				
			      $contadormaestro++;
			  }
			 $dedel = new Database();
			 $sqldel = "DROP TABLE ` ".$maestra."`;";
			 $dedel->query($sqldel);
			 $dedel->close();
			$dedel = new Database();
			 $sqldel = "DROP TABLE ` ".$detalle."`;";
			 $dedel->query($sqldel);
			 $dedel->close(); 
		     }//End if maestra existe
		 } 
		 
         	 
         }//End While Usuarios     
		 
?> 
<form name="fgei" id="fgei" method="post" action="con_salida_inventarios.php">
  <input type="hidden" name="mensaje" value="<?php echo $mensaje;?>">
</form>   
<script>document.fgei.submit();</script>
<? exit;  ?>   
 
