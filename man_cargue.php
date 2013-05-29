<? include("lib/database.php")?>

<? include("js/funciones.php")?>

<?
include "conf/tiemposesion.php";
if ($codigo!="") { // BUSCAR DATOS



	$sql ="SELECT  *  FROM m_entrada 

	inner join bodega on bodega.cod_bod=m_entrada.cod_bod WHERE cod_ment=$codigo";		

	$dbdatos= new  Database();

	$dbdatos->query($sql);

	$dbdatos->next_row();
        $dbdatos->close();

}



if($guardar==1 and $codigo==0)
{ // RUTINA PARA  INSERTAR REGISTROS NUEVOS
  $ahora = date("Y-n-j H:i:s");
  $_SESSION["ultimoAcceso"] = $ahora;



	$compos="(fec_ment,fac_ment,obs_ment,cod_bod,total_ment,cod_prove_ment,usu_ment,est_ment)";

	$valores="('".$fecha."','".$num_fac."','".$observaciones."','".$bodega."','".$todocompra."','".$proveedor."','".$global[2]."','PENDIENTE')" ; 

	$ins_id=insertar_maestro("m_entrada",$compos,$valores); 	

		

	$tipo_pago = 'Credito'; // para q sea por defecto todo a credito

	if($tipo_pago != 'Contado' )
	{

	

		$compos="(cod_doc_ccom,cod_tdoc_ccom,fec_ccom,val_ccom,cod_pro_ccom)";

		$valores="('".$ins_id."','1','$fecha','$todocompra','$proveedor')" ; 

		insertar("cartera_compras",$compos,$valores);

	}	

	

	if ($ins_id > 0) 

	{

		$compos="(cod_ment_dent,cod_tpro_dent,cod_ref_dent,cant_dent,cos_dent)";

		

		for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 

		{

			if($_POST["marca_".$ii]!=NULL) 

			{

				$valores="('".$ins_id."','".$_POST["marca_".$ii]."','".$_POST["codigo_items_".$ii]."','".$_POST["cantidad_".$ii]."','".$_POST["costo_".$ii]."')" ;

				$error=insertar("d_entrada",$compos,$valores); 

				//kardex("suma",$_POST["codigo_referencia_".$ii],$bodega,$_POST["cantidad_ref_".$ii],$_POST["costo_ref_".$ii],$_POST["codigo_peso_".$ii]);

			}	

		}



echo " <script language='javascript'>window.location = 'con_cargue.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar'; </script> "; 


     
	}


}





if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS 

	

	$compos="fec_ment='".$fecha."', fac_ment='".$num_fac."', obs_ment='".$observaciones."', cod_bod='".$bodega."', total_ment='".$todocompra."',cod_prove_ment='".$proveedor."',usu_ment='".$global[2]."'  ";

	$error=editar("m_entrada",$compos,'cod_ment',$codigo); 

	

	//actualiza la cartera

	$compos="fec_ccom='$fecha',val_ccom='$todocompra', cod_pro_ccom='$proveedor'";

	$error=editar("cartera_compras",$compos,'cod_doc_ccom',$codigo); 

	//actualiza la cartera

	

	

	$sql="select * from  d_entrada  where cod_ment_dent=$codigo ";

	$dbser= new  Database();	

	$dbser->query($sql);

	while($dbser->next_row()){

	/*

		kardex("resta",$dbser->cod_items,$bodega,$dbser->cant_dent,0);*/

	}

	

	$sql="DELETE from  d_entrada  where cod_ment_dent=$codigo ";

	$dbser->query($sql);
        $dbser->close();

	$compos="(cod_ment_dent,cod_tpro_dent,cod_ref_dent,cant_dent,cos_dent)";

		

	for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 

	{

		if($_POST["marca_".$ii]!=NULL) 

		{

			$valores="('".$codigo."','".$_POST["marca_".$ii]."','".$_POST["codigo_items_".$ii]."','".$_POST["cantidad_".$ii]."','".$_POST["costo_".$ii]."')" ;

			$error=insertar("d_entrada",$compos,$valores); 

			/*kardex("suma",$_POST["marca_".$ii],$bodega,$_POST["cantidad_".$ii],$_POST["costo_".$ii]);*/

		}	

	}





	echo " <script language='javascript'>window.location = 'con_cargue.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar'; </script> "; 



}





?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>CARGA COMPRAS</title>

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

<script language="javascript">

function datos_completos()
{ 
	 document.getElementById('guardar').value=1;
  	if(document.getElementById("fecha").value=="" || document.getElementById("bodega").value==""|| document.getElementById("todocompra").value=="")
	{	
	  return false; 
	
	}
	else {
	
	       $("#bpru").click(function()
		   {
	  	        var elemento = $("#bpru");
		        elemento.hide();
		        $("#div_pricipal2").html("<img src='imagenes/ajax-loader.gif' alt='ajax loader'/>");
	       });
		      return true;
		}
	
}

  

    function  adicion() 

    {

		

	    if(document.getElementById("cantidad").value>0 && document.getElementById("codigo_items").value > "" && document.getElementById

		("costo").value >0 && document.getElementById('marca').value > 0  ) 

	    {

	

	        costo_unda();

		    Agregar_html_entrada();		



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







          function enfocar(obj_ini,obj_fin)

	      {

             if(window.event.keyCode==13)

             {

			  window.event.keyCode=0;

			  document.getElementById(obj_fin).focus();

			  return false;

              }

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
                        $dbdatos111->close();

	        ?>

	        

			for (j=0; j<<?=$i?>;j++)

	        {

		        if(codigo_buscar_referencia==vec_productos[j][0]) 

		        {

			       combo_llenar.value=vec_productos[j][1];

		        }        

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

</head>

<body <?=$sis?>>

<div id="total">

<form  name="forma" id="forma" action="man_cargue.php"  method="post">

<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >

  <tr>

   <td bgcolor="#E9E9E9" >

   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 

      <tr>

        <td width="5" height="30">&nbsp;</td>

        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0"  id="bpru" onClick="cambio_guardar()" style="cursor:pointer"/></td>

        <td width="61" class="ctablaform">Guardar</td>

        <td width="21" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>

        <td width="65" class="ctablaform">Cancelar </td>

        <td width="22" class="ctablaform"><a href="#"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" onclick="buscar_producto()" /></a><a href="con_cargue.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"></a></td>

        <td width="70" class="ctablaform">Consultar (F9) </td>

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
    </table>	</td>
  </tr>

  <tr>

    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>
  </tr>

  <tr>

    <td class="textotabla01">CARGUE COMPRAS :</td>
  </tr>
  <tr>
    <td class="textotabla01"><div style="text-align:center;" id="div_pricipal2"></div></td>
  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>

  <tr>

    <td bgcolor="#E9E9E9" valign="top">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

       <tr>

        <td width="50" class="textotabla1">Fecha:</td>

        <td width="164">

          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_ment ?>" />

          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>

        <td width="8" class="textorojo">*</td>

        <td width="93" rowspan="2" class="textotabla1" valign="top">Observaicones:</td>

        <td rowspan="2">

		  <textarea name="observaciones" cols="45" rows="4" class="textfield02"  ><?=$dbdatos->obs_ment?></textarea></td>
        </tr>

      

       <tr>

         <td class="textotabla1">Bodega</td>

         <td><?

		  $sql="select distinct punto_venta.cod_bod as valor , nom_bod as nombre from punto_venta
		    left join  bodega  on punto_venta.cod_bod=bodega.cod_bod where cod_ven=$global[2]";

		 combo_sql("bodega","rsocial","valor","nombre",$dbdatos_edi->cod_bod,$sql); 

		 ?></td>

         <td>&nbsp;</td>
         </tr>

       

	         <tr>

         <td class="textotabla1">Factura No:</td>

         <td class="textotabla1"><input name="num_fac" id="num_fac" type="text" class="textfield2" value="<?=$dbdatos->fac_ment?>" onkeypress=" return validaInt()"/></td>

         <td>&nbsp;</td>

         <td width="93" class="textotabla1" valign="top">Proveedor</td>

         <td><? combo_evento("proveedor","proveedor","cod_pro","nom_pro",$dbdatos->cod_prove_ment," ", "nom_pro"); ?></td>
            </tr>

	   <tr>

        <td colspan="5" class="textotabla1" >

		<table  width="99%" border="1">         

          <tr >

            <td  class="ctablasup">Categoria</td>

			<td  class="ctablasup">&nbsp;Codigo</td>

            <td   class="ctablasup">Cantidad</td>

			<td   class="ctablasup">costo und </td>

			<td    class="ctablasup">Costo</td>

			<td width="4%" class="ctablasup" align="center">Agregar:</td>
          </tr>

          <tr >

            <td ><? combo_evento("marca","items","cod_items","nombre_items",""," onchange=\"busca_codigo() \" ", "nombre_items"); ?>

              <span class="titulosup04">

              <input name="codigo_marca" id="codigo_marca" type="hidden" class="textfield013" value="0"/>
              </span></td>

			<td align="center"><input name="codigo_items" id="codigo_items" type="text" class="caja_resalte1" onkeypress=" return valida_evento(this,'cantidad')" ></td>

			 <td align="center">

			 <input name="cantidad" type="text" class="caja_resalte" id="cantidad" onchange="limpiar_total()"/>			 </td>

			 <td align="center"><input name="costo_und" type="text" class="caja_resalte1" id="costo_und" onkeypress="return validaInt_evento(this,'mas')" onblur="costo_total()" /></td>

			 <td align="center">

			 <input name="costo" type="text" class="caja_resalte1" id="costo" onblur="costo_unda()"/></td>

			 <td align="center"> 

			 <input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">			 </td>
          </tr>

		      

		  <tr >

		  <td  colspan="6">

			  <table width="100%">

				<tr id="fila_0">

				<td  class="ctablasup">Categoria</td>

				<td  class="ctablasup">Codigo</td>

				<td   class="ctablasup">Cantidad:              </td>

				<td   class="ctablasup">costo und </td>

				<td    class="ctablasup">Costo</td>

				<td width="4%" class="ctablasup" align="center">Borrar:</td>
				</tr>

				<?

				if ($codigo!="") { // BUSCAR DATOS

					$sql =" SELECT * FROM d_entrada 

					INNER JOIN items ON (d_entrada.cod_tpro_dent=items.cod_items) WHERE cod_ment_dent=$codigo order by cod_dent ";//=		

					$dbdatos_1= new  Database();

					$dbdatos_1->query($sql);

					$jj=1;

					//echo "<table width='100%'>";

					while($dbdatos_1->next_row()){ 

						echo "<tr id='fila_$jj'>";

						

						//cmarca

						//Nombre del servicio

						echo "<td align='center'class='titulosup04'><INPUT type='hidden'  name='codigo_marca_$jj' id='codigo_marca_$jj' value='$dbdatos_1->cod_ment_dent'><INPUT type='hidden'  name='marca_$jj' id='marca_$jj' value='$dbdatos_1->cod_items'><span  class='textfield01'>$dbdatos_1->nombre_items</span> </td>";

						

										

						//% codigo barra

						echo "<td ><INPUT type='hidden'  name='codigo_items_$jj' value='$dbdatos_1->codigo_items'><span  class='textfield01'> $dbdatos_1->codigo_items </span> </td>";

												

						//cantidad

						echo "<td align='right'><INPUT type='hidden'  name='cantidad_$jj' value='$dbdatos_1->cant_dent'><span  class='textfield01'>".$dbdatos_1->cant_dent."  </span> </td>";	

						

						

						//costo unidad

						echo "<td align='right'><INPUT type='hidden'  name='costo_und_$jj' value='$dbdatos_1->cos_dent/$dbdatos_1->cant_dent'><span  class='textfield01'>".$dbdatos_1->cos_dent/$dbdatos_1->cant_dent."  </span> </td>";	

						//costo

						echo "<td align='right'><INPUT type='hidden'  name='costo_$jj' value='$dbdatos_1->cos_dent'><span  class='textfield01'>".$dbdatos_1->cos_dent."  </span> </td>";	

						

						//boton q quita la fila

						echo "<td><div align='center'>	

<INPUT type='button' class='botones' value='  -  ' onclick='removerFila_entrada(\"fila_$jj\",\"val_inicial\",\"fila_\",\"$dbdatos_1->cos_dent\");'>

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

				<td  class="ctablasup"><div align="right">Resumen Entrada </div></td>
				</tr>

				<tr >

				<td ><div align="right" >Total  Compra:

				    <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1" value="<? if($codigo !=0) echo $dbdatos->total_ment; else echo "0"; ?>"/>

				</div>				  </td>
				</tr>
				</table>			</td>
			</tr>
		</table>	
		  </table>	    </td>
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

<script type="text/javascript">

		Calendar.setup(

			{

			inputField  : "fecha",      

			ifFormat    : "%Y-%m-%d",    

			button      : "calendario" ,  

			align       :"T3",

			singleClick :true

			}

		);

</script>

<div  id="relacion" align="center" style="display:none" >

<!-- <div  id="relacion" align="center" >-->

<table width="413" border="0" cellspacing="0" cellpadding="0" bgcolor="#E9E9E9" align="center">

   <tr id="pongale_0" >

    <td width="81" class="textotabla1"><strong>Referncia:</strong></td>

    <td width="332" class="textotabla1"><strong id="serial_nombre_"> </strong>

      <input type="hidden" name="textfield3"  id="ref_serial_"/>

	  <input type="hidden" name="textfield3"  id="campo_guardar"/>

	  </td>

   </tr>

   

   

   

   <tr>

     <td class="textotabla1" colspan="2"><div align="center">

       <input type="button" name="Submit" value="Guardar"  onclick="guardar_serial()"/>  

	    <input type="button" name="Submit" value="Cancelar"  onclick="limpiar()" id="cancelar" />  

       <input type="hidden" name="textfield32"  id="catidad_seriales" value="0"/>

     </div></td>

   </tr>

</table>

</div>

</body>

</html>

<?php $dbdatos_1->close();?>
