<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?
  include "conf/tiemposesion.php";
if ($codigo!=0) {
	$sql ="select * , bodega1.nom_bod as nom_cliente 
	from m_factura
	inner join usuario on usuario.cod_usu=m_factura.cod_usu 
	inner join bodega1 on bodega1.cod_bod=m_factura.cod_cli 
	inner join bodega on bodega.cod_bod =m_factura.cod_bod 

	inner join rsocial on rsocial.cod_rso =m_factura.cod_razon_fac where cod_fac=$codigo";

	$dbdatos_edi= new  Database();

	$dbdatos_edi->query($sql);

	$dbdatos_edi->next_row();
}
if($guardar==1 and $codigo==0) 	{ // RUTINA PARA  INSERTAR REGISTROS NUEVOS
    $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
	$db6 = new Database();

	$sql = "select num_fac_rso + 1  as  num_factura from rsocial WHERE cod_rso=$empresa ";

	$db6->query($sql);	

	if($db6->next_row())
		$num_factura = $db6->num_factura;

	
        $db6->close();
	//ACTUALIZA LA ULTIMA FACTURA

	$db2 = new Database();

	$sql = "UPDATE rsocial SET num_fac_rso = $num_factura  WHERE  cod_rso=$empresa";

	$db2->query($sql);	

		

	if($Credito=="") $tipo_pago="Contado"; else  $tipo_pago="Credito";

	

	$compos="(cod_usu,cod_cli,fecha,num_fac,cod_razon_fac,tipo_pago,obs,tot_fac,cod_bod,estado)";

	

	$valores="('".$global[2]."','".$cliente_fac."','".$fecha_fac."','".$numero_factura_tela."','".$empresa."','".$tipo_pago."','".$observaciones."','".$todocompra."','".$bodega_fac."','PENDIENTE')" ;

	

	$ins_id=insertar_maestro("m_factura",$compos,$valores); 	



	if($tipo_pago != 'Contado' ) {

		$sql = "INSERT INTO cartera_factura ( fec_car_fac, cod_fac) VALUES( '$fecha_fac', '$ins_id');";

		$db2->query($sql);	

	}

	

	if ($ins_id > 0) 

	{
        $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
		//insercion del credito

		$compos="(cod_mfac,cod_tpro,cod_pro,cant_pro,val_uni ,total_pro) ";

		for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 

		{

			if($_POST["marca_".$ii]!=NULL) 

			{

								

				$valores="('".$ins_id."','".$_POST["marca_".$ii]."','".$_POST["codigo_items_".$ii]."','".$_POST["cantidad_".$ii]."','".$_POST["costo_und_".$ii]."','".$_POST["costo_".$ii]."')";

				$error=insertar("d_factura",$compos,$valores); 

				

				//kardex("resta",$_POST["codigo_referencia_".$ii],$bodega_fac,$_POST["cantidad_ref_".$ii],$_POST["costo_ref_".$ii],$_POST["codigo_peso_".$ii]);
			}	
		}
		header("Location: con_venta.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 

	}
	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>"; 	
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Documento sin t&iacute;tulo</title>

<style type="text/css">

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

.Estilo1 {font-size: 12px}

</style> 



<? inicio() ?>



<?

$dbdatos_cliente= new  Database();

$sql=" select * from bodega1  where cod_bod=$cliente"; 





$dbdatos_cliente->query($sql);

if($dbdatos_cliente->next_row()){

	$codigo_lista_cliente=$dbdatos_cliente->cod_lista;

}



?>





<script language="javascript">



function datos_completos(){ 



	if(document.getElementById("Credito").checked==true &&  parseInt(document.getElementById('cupo_covinoc').value) <= parseInt(document.getElementById('todocompra').value) ) {

		alert('No hay Cupo para esta Compra')

		return false;

	}

		

	if (document.getElementById('todocompra').value == ""){	

		return false;

	}

	else 

		return true;



}





function verificar_credito()

{

	if (document.getElementById("Credito").checked==false)

	{

		document.getElementById("div_credito").style.display="none";

	}

	else 

	{

		if(document.getElementById("cupo_covinoc").value>0) 

		{

			document.getElementById("div_credito").style.display="inline";

		}

		else 

		{

			alert("Este Cliente No tiene Credito")

			document.getElementById("Credito").checked=false;

		}

	}

}





function resalte (declarado, sumado){

if(document.getElementById(declarado).value!=document.getElementById(sumado).value) {

	document.getElementById(declarado).style.color="#FF0000";

}

else 

	document.getElementById(declarado).style.color="#000000";

}











function  adicion() 

{





	    if(document.getElementById("cantidad").value>0 && document.getElementById("codigo_items").value > "" && document.getElementById

		("costo").value >0 && document.getElementById('marca').value > 0  ) 

	    {

	

			

            costo_unda();

		   	Agregar_html_venta();						

			

			document.getElementById('marca').value=0;

			document.getElementById("codigo_items").value='';

			document.getElementById("cantidad").value='';

			document.getElementById("costo_und").value='';

			document.getElementById("costo").value='';

			document.getElementById("codigo_items").focus();

			return false;

	    }

	        else 

	        {

		      alert("Ingrese una Referencia Valida junto con los demas Valores")

		      document.getElementById("codigo_items").focus();

	        }

      }



function buscar_producto(){

var ruta="con_consulta_inf.php";

var tamano="recibo";

var ancho=0;

var alto=0;

	

if(tamano=="mediano") {

	ancho=900;

	alto=600;

}



if(tamano=="grande") {

	ancho=900;

	alto=700;

}



if(tamano=="recibo") {

	ancho=700;

	alto=500;

}







var marginleft = (screen.width - ancho) / 2;

var margintop = (screen.height - alto) / 2;

propiedades = 'menubar=0,resizable=1,height='+alto+',width='+ancho+',top='+margintop+',left='+marginleft+',toolbar=0,scrollbars=yes';

window.open(""+ruta+"?codigo=0","Busqueda",propiedades)



}





document.onkeydown = function(e) 

{ 

	

	

	if(e) 

	document.onkeypress = function(){return true;} 





	var evt = e?e:event; 

	if(evt.keyCode==120 || evt.keyCode==121) 

	{ 

		if(evt.keyCode==120)

		buscar_producto();

		if(evt.keyCode==121){

		calcula_cambio();

		cambio_guardar();		

		}

	

		if(e) 

		document.onkeypress = function(){return false;} 

		else 

		{ 

		evt.keyCode = 0; 

		evt.returnValue = false; 

		} 

	} 

} 





function anti_trampa(cod_ref_comp,peso_comp)

{	

	var myString =document.getElementById("tipo_referencias").value;

	var mySplitResult = myString.split("@");

	var myString_sub;

	var mySplitResult_sub ;

	var validador=0;

	

	//alert(cod_ref_comp)

	//alert(peso_comp)

	//var cod_ref_comp= 594;

	//var peso_comp=5;

	

	

	for(i = 1; i < mySplitResult.length; i++)

	{		

		//alert(mySplitResult[i]) 

		myString_sub=mySplitResult[i];

		mySplitResult_sub = myString_sub.split(",");

		//cod_ref_comp= document.getElementById("combo_referncia ").value;

		//peso_comp=document.getElementById("peso").value;

		

//		alert(mySplitResult_sub[0])

//		alert(mySplitResult_sub[1])

		

		if(mySplitResult_sub[1]== cod_ref_comp &&  mySplitResult_sub[0]== peso_comp) 

		{

			//alert('si')

			//return false;

			validador=1;

		}

		//else  {

		//	alert('nooo')

		//}

		//alert(mySplitResult_sub[0]) 		//alert(mySplitResult_sub[1])

	}

	

	return validador;

}





function busca_codigo()

		  {

		    var codigo_buscar_referencia =document.getElementById('marca').value;	

			var combo_llenar=document.getElementById('codigo_items');	

			combo_llenar.value='';

			var vec_productos = new Array;

			document.getElementById('cantidad').focus();

			<?

			$dbdatos111= new  Database();

			$sql ="SELECT cod_items,codigo_items FROM  items "; 

			$dbdatos111->query($sql);

			$i = 0;

			while($dbdatos111->next_row())

			{

				echo "vec_productos[$i]=  new Array('$dbdatos111->cod_items','$dbdatos111->codigo_items');\n";	

				$i++;

	        }

	        ?>

	        

			for (j=0; j<<?=$i?>;j++)

	        {

		        if(codigo_buscar_referencia==vec_productos[j][0]) 

		        {

			       combo_llenar.value=vec_productos[j][1];

		        }        

	        }

         }

		 

		 

    function limpiar_costos()

	{



	document.getElementById("cantidad").value='';

	document.getElementById("costo_und").value='';

	document.getElementById("costo").value='';

    }



    function limpiar_total()

	{



		document.getElementById("costo_und").value='';

		document.getElementById("costo").value='';



     }

		   

	function costo_unda()

	{



		if(document.getElementById('cantidad').value != '')

		{

		var costo_total=document.getElementById('costo').value;

		var cant=document.getElementById('cantidad').value;

		

		document.getElementById('costo_und').value=parseInt(costo_total/cant);

		//document.getElementById('costo_und').readOnly=true;

        }

      }

	  

	  function costo_total()

	  {



		var costo_und=document.getElementById('costo_und').value;

		var cant=document.getElementById('cantidad').value;

		

		//document.getElementById('costo').readOnly=true;

		document.getElementById('costo').value=costo_und*cant;



       }

		 

</script>



<script type="text/javascript" src="js/js.js"></script>

<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />

<link href="css/styles2.css" rel="stylesheet" type="text/css" />

<link href="informes/styles.css" rel="stylesheet" type="text/css" />

</head>

<body <?=$sis?>>

<div id="total">

<form  name="forma" id="forma" action="man_venta.php"  method="post">

<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >

  <tr>

   <td bgcolor="#E9E9E9" >

   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 

      <tr>

        <td width="5" height="30">&nbsp;</td>

        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>

        <td width="61" class="ctablaform">Guardar</td>

        <td width="21" class="ctablaform"><a href="con_venta.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>

        <td width="65" class="ctablaform">Cancelar </td>

        <td width="22" class="ctablaform"><a href="#"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" onclick="buscar_producto()" /></a></td>

        <td width="70" class="ctablaform">Consultar(F9)</td>

        <td width="21" class="ctablaform"></td>

        <td width="60" class="ctablaform">&nbsp;</td>

        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>

        <td width="193" valign="middle">



          <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">

		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">

		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">

          <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>" /> </td>

        

        <td width="67" valign="middle">&nbsp;</td>

      </tr>

    </table>

	</td>

  </tr>

  <tr>

    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>

  </tr>

  <tr>

    <td class="textotabla01">FACTURACION :</td>

  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>

  </tr>

  <tr>

    <td bgcolor="#E9E9E9" valign="top">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>

        <td width="62" class="textotabla1">Fecha:</td>

        <td width="275" class="subtitulosproductos"><? echo $fecha_venta; ?>

          <input name="fecha_fac" id="fecha_fac" type="hidden" value="<? echo $fecha_venta; ?>"  /></td>

        <td width="20" class="textorojo">*</td>

        <td width="77" class="textotabla1">Vendedor:</td>

        <td width="145"  class="subtitulosproductos">

		<?

		if ($codigo!=0) echo $dbdatos_edi->nom_usu;

		else  echo $global[3];

		

		?>

		<input name="vendedor" id="vendedor" type="hidden" value="<?=$global[2]?>"></td>		 

        <td width="171" class="textorojo">&nbsp;</td>

       </tr>

	   <tr>

        <td width="62" height="24" class="textotabla1">Empresa:</td>

        <td width="275" class="subtitulosproductos">

		<?

		$sql ="SELECT * from rsocial where cod_rso=$empresa";

	$db->query($sql);

	while($db->next_row()){

		echo $db->nom_rso;

	}

		?>

		<input name="empresa" id="empresa" type="hidden" value="<?=$empresa?>"></td>

        <td width="20" class="textorojo">*</td>

        <td width="77" class="textotabla1"> Bodega:</td>

        <td class="subtitulosproductos"><span class="textoproductos1">

          <?

		$sql ="SELECT * from bodega where cod_bod=$bodega";

	$db->query($sql);

	while($db->next_row()){

		echo $db->nom_bod;

	}

		?>

          <input name="bodega_fac" id="bodega_fac" type="hidden" value="<?=$bodega?>">

        </span></td>		 

        <td width="171" >

          <input name="precio_lista" id="precio_lista" type="hidden" class="subtitulosproductos" />

        </td>

       </tr>

	   <tr>

        <td width="62" class="textotabla1">Cliente:</td>

        <td width="275" class="subtitulosproductos">

		<?

	$sql ="SELECT * from bodega1 where cod_bod=$cliente";

	$db->query($sql);

	while($db->next_row())

	{

		echo $db->nom_bod;

		$cupo_covinoc=$db->cupo_au_covinoc;

	}

	

	 $sql ="SELECT SUM(((SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=m_factura.cod_fac)- valor_abono )) -(SUM(tot_dev_mfac)) AS cartera 

FROM m_factura

INNER JOIN cartera_factura ON cartera_factura.cod_fac= m_factura.cod_fac

WHERE  tipo_pago='Credito'   AND estado_car<>'CANCELADA' AND cod_cli=$cliente";

	$db->query($sql);

	while($db->next_row())

	{



		$cartera_ocupada=$db->cartera;

	}

	

	

	$cupo_covinoc=$cupo_covinoc-$cartera_ocupada;

		?>

		<input name="cliente_fac" id="cliente_fac" type="hidden" value="<?=$cliente?>"></td>

        <td width="20" class="textorojo">*</td>

        <td width="77" class="textotabla1"> Credito:</td>

        <td colspan="2">

          <input name="Credito" id="Credito" type="checkbox"  value="Credito" onclick="verificar_credito()"  />

          <div id="cupo" style="display:none">

            <span class="textotabla1">Cupo:<span class="textorojo">

              <input name="cupo_credito" id="cupo_credito" type="hidden" class="caja_resalte1"  readonly="-1"/>

              </span></span>		  </div>		  

          <span  id="div_credito" style="display:none" class="textoproductos1"> 

            $  <?=number_format($cupo_covinoc ,0,",",".")?>

            <input name="cupo_covinoc" type="hidden" id="cupo_covinoc"  value="<?=$cupo_covinoc?>" readonly="-1" align="right"/>

            </span>

          <textarea name="tipo_referencias"  id="tipo_referencias"   cols="45" rows="4"  style="display:none"></textarea>

          Numero Factura:

          <input name="numero_factura_tela" type="text" class="caja_resalte1" id="numero_factura_tela" onkeypress="return validaInt_evento(this,'mas')" value="<?=$numero_factura_tela_d?>" readonly="-1"/></td>

        </tr>

	   <tr>

        <td colspan="7" class="textotabla1" >

		<table  width="100%" border="1">         

          <tr >

            

            <td width="9%"  class="ctablasup">Categoria</td>

			<td width="20%"  class="ctablasup">&nbsp;Codigo

			  <label></label></td>

            <td width="19%"   class="ctablasup">Cantidad</td>

            <td width="8%"   class="ctablasup">Valor U.</td>

			<td width="9%"   class="ctablasup">Costo</td>

			<td width="8%" class="ctablasup" align="center">Agregar:</td>

          </tr>

          <tr >

            <td ><? combo_evento("marca","items","cod_items","nombre_items",""," onchange=\"busca_codigo() \" ", "nombre_items"); ?>

              <span class="titulosup04">

              <input name="codigo_marca" id="codigo_marca" type="hidden" class="textfield013" value="0"/>

              </span></td>

			<td align="center"><input name="codigo_items" id="codigo_items" type="text" class="caja_resalte1" onkeypress=" return valida_evento(this,'cantidad')"></td>

			 <td align="center">

			 <input name="cantidad" type="text" class="caja_resalte" id="cantidad" onchange="limpiar_total()"/></td>

			 <td align="center">

             <input name="costo_und" type="text" class="caja_resalte1" id="costo_und" onkeypress="return validaInt_evento(this,'mas')" onblur="costo_total()" />		         </td>

			 

			 

		     <td align="center"><input name="costo" type="text" class="caja_resalte1" id="costo" onblur="costo_unda()"/></td>

		     <td align="center"> 

		      <input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">			 </td>

          </tr>

		      

		  <tr >

		  <td  colspan="6">

			  <table width="100%">

				<tr id="fila_0">

				

				<td width="14%"  class="ctablasup">Categoria</td>

				<td width="9%"  class="ctablasup">Codigo</td>

				<td width="8%"   class="ctablasup">Cantidad</td>

				<td width="6%"    class="ctablasup">Valor u </td>

				<td width="7%"    class="ctablasup">Costo</td>

				<td width="7%" class="ctablasup" align="center">Borrar</td>

				</tr>

				<?

				if ($codigo!="") { // BUSCAR DATOS

					$sql =" select * 

					from d_factura 

					INNER JOIN items ON (d_factura.cod_tpro=items.cod_items)

					where cod_mfac =$codigo order by cod_dfac ";//=		

					$dbdatos_1= new  Database();

					$dbdatos_1->query($sql);

					$jj=1;

					//echo "<table width='100%'>";

					while($dbdatos_1->next_row()){ 

						echo "<tr id='fila_$jj'>";

						//cmarca

						

						echo "<td align='center'class='titulosup04'><INPUT type='hidden'  name='codigo_marca_$jj' id='codigo_marca_$jj' value='$dbdatos_1->cod_ment_dent'><INPUT type='hidden'  name='marca_$jj' id='marca_$jj' value='$dbdatos_1->cod_items'><span  class='textfield01'>$dbdatos_1->nombre_items</span> </td>";

							

									

						

						//% codigo barra

						echo "<td ><INPUT type='hidden'  name='codigo_items_$jj' value='$dbdatos_1->codigo_items'><span  class='textfield01'> $dbdatos_1->codigo_items </span> </td>";

						

						

						//cantidad

						echo "<td align='right'><INPUT type='hidden'  name='cantidad_$jj' value='$dbdatos_1->cant_pro'><span  class='textfield01'>".$dbdatos_1->cant_pro."  </span> </td>";	

						

						//costo unidad

						echo "<td align='right'><INPUT type='hidden'  name='costo_und_$jj' value='$dbdatos_1->total_pro/$dbdatos_1->cant_pro'><span  class='textfield01'>".$dbdatos_1->total_pro/$dbdatos_1->cant_pro."  </span> </td>";

							

							

							//costo

						echo "<td align='right'><INPUT type='hidden'  name='costo_$jj' value='$dbdatos_1->total_pro'><span  class='textfield01'>".$dbdatos_1->total_pro."  </span> </td>";

											

						

						

						//boton q quita la fila

						echo "<td><div align='center'>	

<INPUT type='button' class='botones' value='  -  ' onclick='removerFila_venta(\"fila_$jj\",\"val_inicial\",\"fila_\",\"$dbdatos_1->total_pro\");'>

											

						

						</div></td>";

						echo "</tr>";

						$jj++;

					}

				}

				?>

				</table>			</td>

			</tr>			

		 <tr >

		  <td  colspan="6">

			  <table width="100%">

				<tr >

				<td  class="ctablasup"><div align="left">Observaciones:</div></td>

				<td  class="ctablasup"><div align="right">Resumen Venta </div></td>

				</tr>

				<tr >

				<td width="47%" ><div align="left" >

				  <textarea name="observaciones" cols="45" rows="3" class="textfield02"  onchange='buscar_rutas()' ><?=$dbdatos->obs_tras?></textarea>

				</div>				  </td>

				<td width="53%" ><div align="right"><span class="ctablasup">Total  Venta:</span>

				  <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->total_ment; else echo "0"; ?>"/>

				</div></td>

				</tr>

				</table>			  </td>

			</tr>

		</table>

		  </table>

	    </td>

	  </tr>

	  <tr> 

		  <td colspan="8" >		  </td>

	  </tr>

    </table>

<tr>



  <tr>

    <td>

	<input type="hidden" name="val_inicial" id="val_inicial" value="<? if($codigo!=0) echo $jj-1; else echo "0"; ?>" />

	<input type="hidden" name="guardar" id="guardar" />

		 <?  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>

	   <input type="hidden" id="valDoc_inicial" value="<?=$valueInicial?>"> 

	   <input type="hidden" name="cant_items" id="cant_items" value=" <?  if ($codigo!="") echo $aa; else echo "0"; ?>">

	</td>

  </tr>

  

</table>

</form> 

</div>

</body>

</html>

