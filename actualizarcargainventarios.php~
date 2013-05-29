<?php
     require_once("lib/database.php");
	 require_once("js/funciones.php");
	 function repiteserial($serial)
	 {
	        $db = new Database();
		$sql = "SELECT serial FROM kardex WHERE serial='".$serial."'";
		$db->query($sql);
		$numrows = $db->num_rows();
		return $numrows;
	 }
	 $lista = new Database();
	 //Para saber las tablas entrada de la base de datos y guardarlas en un arreglo
	 $sql = "SHOW TABLES 
	         FROM facturacion 
	        WHERE Tables_in_facturacion LIKE '%m_entrada%' OR 
			Tables_in_facturacion LIKE '%d_entrada%';";     //echo $sql; exit;
	 $lista->query($sql);	 
	 while($lista->next_row())	 
	 {	         
	     $arrtablas[] = $lista->Tables_in_facturacion;	 
	 }	 
	 $lista->close();	 //print_r($arrtablas); exit;
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
		 $maestra = "m_entrada".$dbb->cod_usu;
		 $detalle = "d_entrada".$dbb->cod_usu;
		 for($i=0;$i<count($arrtablas);$i++)
		 {
		     if(trim($arrtablas[$i]) == $maestra)
		     {   
		          
			  $dbsel = new Database();
			  $sqlg = "SELECT cod_ment,fec_ment,remision,fac_ment,obs_ment,cod_bod,cod_prove_ment,usu_ment FROM ` ".$maestra."`;";
			  $dbsel->query($sqlg);
			  $campos = "fec_ment,remision,fac_ment,obs_ment,cod_bod,cod_prove_ment,usu_ment";
			  $contadormaestro = 0;
			  while($dbsel->next_row())
			  {    //In
			      $dbmax = new Database();
			      $sqlmax = "SELECT MAX(fac_ment) + 1 as max FROM m_entrada WHERE remision=1;";
			      $dbmax->query($sqlmax);
			      $dbmax->next_row();
			      $maximo = $dbmax->max; //exit;
			      if ($maximo=="") $maximo=1; 
			      $dbmax->close();
			      $valores = "'".$dbsel->fec_ment."',1,'".$maximo."','".$dbsel->obs_ment."',".$dbsel->cod_bod.",";
			      $valores .= $dbsel->cod_prove_ment.",".$dbsel->usu_ment;
			      $dbi = new Database();
			      $sqli = "INSERT INTO m_entrada(".$campos.") VALUES(".$valores.");";
			      $dbi->query($sqli);
			      $id_maestra = $dbi->insert_id();// El id del registro en la tabla maestra
			      $dbi->close();
			      $camposdet = "cod_dent,cod_ment_dent,cod_tpro_dent,cod_mar_dent,cod_pes_dent,cod_serial,cant_dent,cos_dent,cod_ref_dent";
			      $camposdetinsert = "cod_ment_dent,cod_tpro_dent,cod_mar_dent,cod_pes_dent,cod_serial,cant_dent,cos_dent,cod_ref_dent";
			      $dbd = new Database();
			      $sqldd = "SELECT ".$camposdet." FROM ` ".$detalle."` WHERE cod_ment_dent=".$dbsel->cod_ment.";";//exit;
			      $dbd->query($sqldd);
			      while($dbd->next_row())
			      {
			         $valoresdt = $id_maestra.",".$dbd->cod_tpro_dent.",".$dbd->cod_mar_dent.",".$dbd->cod_pes_dent;
				 $valoresdt .= ",".$dbd->cod_serial.",'".$dbd->cant_dent."',".$dbd->cos_dent.",".$dbd->cod_ref_dent;
				 $repiteseriall = repiteserial($dbd->cod_serial);
				 if($repiteseriall==0 && $dbd->cod_tpro_dent>0 && $dbd->cod_ref_dent>0 && $dbd->cod_serial>0 && $dbd->cant_dent>0)
				 {
					 $sqldt = "INSERT INTO d_entrada(".$camposdetinsert.") VALUES(".$valoresdt.");";
					 $dbdd = new Database();				 
					 $dbdd->query($sqldt);
					 kardex("suma",$dbd->cod_ref_dent,$dbsel->cod_bod,$dbd->cant_dent,$dbd->cos_dent,$dbd->cod_pes_dent,$dbd->cod_serial);
					 $dbup = new Database();
					 $ssqlu = "UPDATE ` ".$detalle."` SET bandera=1 WHERE cod_dent=".$dbd->cod_dent.";";
					 $dbup->query($ssqlu);
					 $dbup->close();
				 }
				 else
				 {
				          
					  $mensaje = "Datos inconsistentes, serial ".$dbd->cod_serial." repetido o no encontrado.<BR>
					              Codigo del Producto no valido o producto no valido.";
					  $cabecera = "MIME-Version: 1.0\r\n";
				          $cabecera .= "Content-type: text/html; charset=iso-8859-1\r\n";
				          $cabecera .= "From: APLICACION INVENTARIOS\n";
					  $cabecera .= "X-Mailer: PHP/" . phpversion();
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
	 
		     }//End for
		 } 
		 
                  	 
?> 
 <form name="fgei" id="fgei" method="post" action="con_cargue_inventario.php">
  <input type="hidden" name="mm" value="mm">
  </form>
  <script>document.fgei.submit();</script>    
<? exit;  ?>
