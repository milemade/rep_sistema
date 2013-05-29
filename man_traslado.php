<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<? //print_r($_POST);//exit;
include "conf/tiemposesion.php";
function validarserial($serial,$codigo)
{
   $dbs = new Database();
   $sqls = "SELECT serial FROM d_traslado 
            WHERE cod_mtras_dtra=".$codigo." AND serial=".$serial.";"; 
   $dbs->query($sqls);
   $numrows = $dbs->num_rows();
   $dbs->close();
   return $numrows;
}
if($_POST['codigo_fry']!='')
{
  $dbbus = new Database();
  $sqlbus = "SELECT a.cod_mar_pro,
                    a.cod_tpro_pro,
					a.cod_pro,
					a.cod_fry_pro 
			   FROM producto a
			   JOIN kardex b ON a.cod_pro=b.cod_ref_kar AND b.cod_bod_kar=".$_POST['bodega_salida']."
			  WHERE a.cod_fry_pro='".$_POST['codigo_fry']."';";
  $dbbus->query($sqlbus);
  $dbbus->next_row();
  $_POST['marca'] = $dbbus->cod_mar_pro;
  $_POST['tipo_producto'] = $dbbus->cod_tpro_pro;
  $_POST['combo_referncia'] = $dbbus->cod_pro;
  $_POST['codigo_fry'] = $dbbus->cod_fry_pro;
  $dbbus->close();
}
$n = $_POST['n'];
if($_POST['codigo']>0)
   $codigo = $_POST['codigo'];
if ($codigo >0) { /* BUSCAR DATOS*/
	 $sql =" SELECT * , (SELECT nom_bod FROM bodega WHERE cod_bod=cod_bod_sal_tras) AS bodega_salida, (SELECT nom_bod FROM bodega WHERE cod_bod=cod_bod_ent_tras) AS bodega_entrada FROM m_traslado WHERE cod_tras=$codigo";		
	$dbdatos= new Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
	if(empty($bodega_salida) )
	    $bodega_salida=$dbdatos->cod_bod_sal_tras;
	if(empty($bodega_entrada) )
	   $bodega_entrada=$dbdatos->cod_bod_ent_tras;
	/*echo $bodega_salida;*/
        $dbdatos->close();
} ?>
<?php

 function formair($action){
?>
	<center>
	<br><br><br><br><img src="imagenes/indicator.gif"><b><font size=5 color=red><?=$msg?>......<br>
	 <script>
	     function voy(){
		    location.href="<? echo $ir?>";
		 }
		 setTimeout("voy()",<? echo $tiempo?>);
	</script>
</form> 
<? echo '</center>'; }  ?>
<?php

if($n==1)
{
   $ahora = date("Y-n-j H:i:s");
   $_SESSION["ultimoAcceso"] = $ahora;
   $dbu = new Database();
   $sqlu = "UPDATE m_traslado SET fec_tras='".$_POST['fechatemp']."',obs_tras='".$_POST['obstemp']."' ";
   $sqlu .= "WHERE cod_tras=".$_POST['codigo'];
   $dbu->query($sqlu); ?>
   <form name="frm1" action="con_traslado.php" method="GET">
   <input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">
   <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
   <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
   <input type="hidden" name="confirmacion" id="confirmacion" value="<?=$confirmacion?>">
   </form>
   <script>document.frm1.submit();</script>
<? exit;} ?>
<?php
//Guarda adicion de productos 
if($n==4)
{ /*echo "huhuhuh"; exit;*/
  $ahora = date("Y-n-j H:i:s");
  $_SESSION["ultimoAcceso"] = $ahora;
  if($_POST['codigo']==0)
  {
	  $compos="(fec_tras,cod_bod_sal_tras,cod_bod_ent_tras,obs_tras)";
	  $valores="('".$fechatmp."','".$bodega_salida."','".$bodega_entrada."','".$obstmp."')" ;
	  $ins_id=insertar_maestro("m_traslado",$compos,$valores); //$exit;
	  if($ins_id>0)
	  {
		 $campos="(cod_mtras_dtra,cod_tpro_dtra,cod_mar_dtra,cod_pes_dtra,cod_ref_dtra,cant_dtra,serial)";
		 $valoresdetalle = "(".$ins_id.",".$_POST['tipo_producto'].",".$_POST['marca'].",".$_POST['peso'].",".$_POST['combo_referncia'];
		 $valoresdetalle .= ",'".$_POST['cantmp']."',".$_POST['sertmp'].")";
		 $error = insertar("d_traslado",$campos,$valoresdetalle); //exit;
		 /*echo $error; exit;
		 //SE hacen las transacciones en kardex*/
		 $referencia = $_POST['combo_referncia'];
		 $cantidad = $_POST['cantmp'];
		 $serial = $_POST['sertmp'];
		 $talla = $_POST['peso'];
		 $serial = $_POST['sertmp'];
		 $dbcn = new Database();
		 $sqlcn = "SELECT valor_precio FROM kardex WHERE serial='".$serial."';";
		 $dbcn->query($sqlcn);
		 $dbcn->next_row();
		 $valor_precio = $dbcn->valor_precio;
		 $dbcn->close();
		 kardex("suma", $referencia,$bodega_entrada, $cantmp,$valor_precio,$talla,$serial);
		 kardex("resta", $referencia,$bodega_salida, $cantmp,$valor_precio,$talla,$serial);
		 ?>
		 <form id="frm4" name="frm4" method="POST">
		 <input type="text" name="codigo" id="codigo" value="<?=$ins_id?>">
		 </form>
		 <script>document.frm4.submit();</script>
	  <? exit;
	  }
	  else
	  {
		  echo "NO GUAAARDO MAESTRO";
		  exit;
	  }
  }
  else
  { 
     $campos="(cod_mtras_dtra,cod_tpro_dtra,cod_mar_dtra,cod_pes_dtra,cod_ref_dtra,cant_dtra,serial)";
	 $valoresdetalle = "(".$_POST['codigo'].",".$_POST['tipo_producto'].",".$_POST['marca'].",".$_POST['peso'].",".$_POST['combo_referncia'];
	 $valoresdetalle .= ",'".$_POST['cantmp']."',".$_POST['sertmp'].")";
	 $t = validarserial($_POST['sertmp'],$codigo); 
	 if($t==0)
	 {
	     $error = insertar("d_traslado",$campos,$valoresdetalle);
	     if($error==0)
	     {
			echo "NO GUAAARDO DETALLE";
			exit;
	     }
	}
         $referencia = $_POST['combo_referncia'];
		 $cantidad = $_POST['cantmp'];
		 $serial = $_POST['sertmp'];
		 $talla = $_POST['peso'];
		 $serial = $_POST['sertmp'];
		 $dbcn = new Database();
		 $sqlcn = "SELECT valor_precio FROM kardex WHERE serial='".$serial."';";
		 $dbcn->query($sqlcn);
		 $dbcn->next_row();
		 $valor_precio = $dbcn->valor_precio;
		 $dbcn->close();
		 kardex("suma", $referencia,$bodega_entrada, $cantmp,$valor_precio,$talla,$serial);
		 kardex("resta", $referencia,$bodega_salida, $cantmp,$valor_precio,$talla,$serial);
		 ?>
		 <form id="frm4" name="frm4" method="POST">
		 <input type="text" name="codigo" id="codigo" value="<?=$codigo?>">
		 </form>
		 <script>document.frm4.submit();</script>
	  <? exit;
   }
}
?>
<? if($n==5)
   {
     $dbdel = new Database();
     $sqldel = "DELETE FROM d_traslado WHERE cod_dtra=".$_POST['iddetalle']." AND cod_mtras_dtra=".$_POST['codigo'].";";
     $dbdel->query($sqldel);
     $dbdel->close(); 
     $referencia = $_POST['combo_referncia'];
     $cantidad = $_POST['cantidad'];
     $valor_precio = 0;
     $talla = $_POST['peso'];
     $serial = $_POST['serial'];
     kardex("resta", $referencia,$bodega_entrada, $cantidad,$valor_precio,$talla,$serial);
     kardex("suma", $referencia,$bodega_salida, $cantidad,$valor_precio,$talla,$serial);
   ?>
   <form name="frmd" id="frmd" method="post">
   <input type="hidden" name="codigo" id="codigo" value="<?=$_POST['codigo']?>">
   </form>
   <script>document.frmd.submit();</script>
<? exit; } ?>
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

form {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

</style> 



<? inicio() ?>

<script language="javascript">
function  adicion() 
{
	if (document.getElementById('fecha').value == ""  || document.getElementById('fecha').value == "0000-00-00")
    {
		alert('Debe ingresar la Fecha, Gracias!');
		return false;
    }
	if(document.getElementById('marca').value < 1 || 
	   document.getElementById('tipo_producto').value < 1 || 
	   document.getElementById('combo_referncia').value < 1 || 
	   document.getElementById('peso').value < 1  || 
	   document.getElementById('serial').value ==""  || 
	   document.getElementById('cantidad').value=="" )
	{
		alert("Datos Incompletos")
		return false;
	}
    else
	{
       document.getElementById('cantmp').value = document.getElementById('cantidad').value;
       document.getElementById('fechatmp').value = document.getElementById('fecha').value;
       document.getElementById('obstmp').value = document.getElementById('observaciones').value;
       document.getElementById('sertmp').value = document.getElementById('serial').value;
       document.getElementById('banprod').value = 1;  
       document.getElementById('frmf').submit();
       return false;
    } 
}
function enfocar(obj_ini,obj_fin){

if(window.event.keyCode==13)
{
  window.event.keyCode=0;
  document.getElementById(obj_fin).focus();
  return false;
}
}





function limpiar_combos()

{

	document.getElementById('tipo_producto').options.length=0;

	document.getElementById('combo_referncia').options.length=0;

	document.getElementById('codigo_fry').value="";

	document.getElementById('peso').options.length=0;

	document.getElementById('cantidad').value="";



return false;

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

	alto=500;slta

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

function cambio_guardar()

{

   if(document.getElementById('fecha').value=="" || document.getElementById('fecha').value=="0000-00-00")

   {

       alert("Debe seleccionar una fecha.");

	   document.getElementById('fecha').focus();

	   return false();

   }

   else

   {

      document.getElementById('fechatemp').value=document.getElementById('fecha').value;

	  document.getElementById('obstemp').value=document.getElementById('observaciones').value;

	  document.frmg.submit();

   }

}

</script>



<script type="text/javascript" src="js/js.js"></script>
<script language="javascript" src="js/jquery-1.3.min.js"></script>
<script language="javascript">
$(document).ready(function() {
    $().ajaxStart(function() {
        $('#loading').show();
        $('#result').hide();
    }).ajaxStop(function() {
        $('#loading').hide();
        $('#result').fadeIn('slow');
    });
    $('#form, #fat, #fo3').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
            $('#result').html(data);
            }
        })
        return false;
    }); 
	$('#form, #fat, #frmtipo').submit(function() {
    $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
            $('#result').html(data);
            }
        })
        return false;
    }); 
	$('#form, #fat, #frmref').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#result').html(data);
            }
        })
        return false;
    });
	$('#form, #fat, #frmfry').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#result').html(data);
            }
        })
        return false;
    });
	$('#form, #fat, #frmad').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#result').html(data);
            }
        })
        return false;
    });
	$('#form, #fat, #frmser').submit(function() {
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $('#result').html(data);
           }
        })
        return false;
    });
}) 
function borra()
{ 
   if(confirm("Desea borrar este registro ?"))
      this.form.submit();
   else
     return false;
} 
</script>
</head>

<body <?=$sis?>>

<div id="total">

<table width="80%" border="0" align="center">

  <tr>

    <td bgcolor="#E9E9E9"><table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 

      <tr>

        <td width="5" height="30">&nbsp;</td>

        <td width="20" >

		<form name="frmg" method="post">

		<img src="imagenes/icoguardar.png" alt="Nuevo Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/>

		<input type="hidden" name="fechatemp" id="fechatemp" value="0">

		<input type="hidden" name="obstemp" id="obstemp" value="0">

		<input type="hidden" name="editar"   id="editar"   value="<?=$editar?>">

		  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">

		  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">

          <input type="hidden" name="n" id="n" value="1">

		  <input type="hidden" name="confirmacion" id="confirmacion" value="1">

		  <input type="hidden" name="codigo" id="$codigo" value="<?=$codigo?>">

		</td>

        <td width="61" class="ctablaform">Guardar</td></form>

        <td width="21" class="ctablaform"><a href="con_traslado.php?confirmacion=0&editar=1&insertar=1&eliminar=1"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>

        <td width="65" class="ctablaform">Cancelar </td>

        <td width="22" class="ctablaform"><a href="con_traslado.php?editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"></a><a href="con_cargue.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"></a></td>

        <td width="70" class="ctablaform"><!--Consultar(F9)--> </td>

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

    <td><table width="100%"><tr>

    <td height="4" valign="bottom"><img src="imagenes/lineasup2.gif" alt="." width="100%" height="4" /></td>

  </tr>

  <tr>

    <td class="textotabla01">TRASLADO INVENTARIO :</td>

  </tr>

  <tr>

    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>

  </tr></table></td>

  </tr> 

  <tr>

    <td bgcolor="#E9E9E9"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="textotabla1">
<form method="post" action="" id="fo3" name="fo3" >
       <tr>
        <td width="124" class="textotabla1">Fecha:</td>
        <td width="232">
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<? if($_POST['fecha']!="")
		                                                                                     echo $_POST['fecha'];
											  else
												 echo $dbdatos->fec_tras ?>" />

         <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>

        <td width="13" class="textorojo">*</td>

        <td width="93" rowspan="3" class="textotabla1" valign="top">Observaciones:</td>

        <td width="647" rowspan="3">

	     <textarea name="observaciones" id="observaciones" cols="45" rows="4" class="textfield02"  ><? if($_POST['observaciones']!="")

		                                                                          echo $_POST['observaciones'];

											else										

		                                                                          echo $dbdatos->obs_tras;?></textarea></td>

  </tr>

      

       <tr>

         <td class="textotabla1">Bodega Salida </td>

         <td><span class="textotabla1">

           <? 

		   $dbdatos333= new  Database();

		   

		 if ($codigo > 0 ) {

			echo "$dbdatos->bodega_salida <input name='bodega_salida' type='hidden' id='bodega_salida' value='$dbdatos->cod_bod_sal_tras' />";

			

			}

		 else {

			$sql ="select * from bodega where cod_bod=$bodega_salida "; 

			$dbdatos333->query($sql);

			while($dbdatos333->next_row()){

				echo "$dbdatos333->nom_bod <input name='bodega_salida' type='hidden' id='bodega_salida' value='$bodega_salida' />";

				}

			}
                        

			 ?>

         </span></td>

         <td><span class="textorojo">*</span></td>

         </tr>

       

	         <tr>

         <td class="textotabla1">Bodega Entrada </td>

         <td class="textotabla1">

		 

		 <? 

		 if ($codigo > 0 ) {

		 	echo "$dbdatos->bodega_entrada<input name='bodega_entrada' type='hidden' id='bodega_entrada' value='$dbdatos->cod_bod_ent_tras'/>";
                        
                 }      
		 else   {

		 	$sql ="select * from bodega where cod_bod=$bodega_entrada "; 

			$dbdatos333->query($sql);

			while($dbdatos333->next_row()){

				echo "$dbdatos333->nom_bod <input name='bodega_entrada' type='hidden' id='bodega_salida' value='$bodega_entrada' />";

				}

				//combo_evento("bodega_salida","bodega","cod_bod","nom_bod",$dbdatos->cod_bod_sal_tras,"  ", "nom_bod");

			}
                        
		 	//combo_evento("bodega_entrada","bodega","cod_bod","nom_bod",$bodega_entrada,"  ", "nom_bod"); 			

			//$bodega_entrada

			?>

			</td>

         

		 

		 <td><span class="textorojo">*</span></td>

         </tr>

</table></td>

  </tr>

  <tr>

    <td bgcolor="#E9E9E9"><table width="100%" border="0">

      <tr>

        <td class="ctablasup">Categoria</td>

        <td class="ctablasup">Tipo Producto </td>

        <td class="ctablasup">Referencia/P roducto </td>

        <td class="ctablasup">C&oacute;digo</td>

        <td class="ctablasup">Color</td>

        <td class="ctablasup">Pieza/Serial</td>

        <td class="ctablasup">Disponible</td>

        <td class="ctablasup">Cantidad</td>

        <td class="ctablasup">Agregar</td>

      </tr>

      <tr>

        <td valign="middle">

          <select name="marca" id="" name="marca" class="SELECT" onchange="this.form.submit();">

	     <option value="0">[Seleccione]</option>

	     <?php  

		  $dbb = new Database();

		  $sqll = "SELECT DISTINCT (cod_mar), nom_mar

					FROM `kardex` a

					JOIN producto b ON a.`cod_ref_kar` = b.`cod_pro`

					JOIN marca c ON b.`cod_mar_pro` = c.cod_mar

					WHERE `cod_bod_kar` =".$bodega_salida.";";

		 $dbb->query($sqll);

		 while($dbb->next_row()){

		    if($_POST['marca'] == $dbb->cod_mar)

			   $selected = "selected";

			else

			   unset($selected);

		 ?>

		 <option value="<?=$dbb->cod_mar?>" <?=$selected?>><?=$dbb->nom_mar?></option>

		 <? }$dbb->close(); ?>

		 </select>

	<input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>">
	<input type="hidden" name="bodega_entrada" id="bodega_entrada" value="<?=$bodega_entrada?>">
	<input type="hidden" name="bodega_salida" id="bodega_salida" value="<?=$bodega_salida?>">
	</form>
        </td>
        <td><form name="frmtipo" id="frmtipo" method="POST">
			     <select size="1" id="tipo_producto" name="tipo_producto"  class='SELECT' onChange="this.form.submit();">
			     <option value="0">[Seleccione]</option>
				<?
				   $sqltipo = "SELECT DISTINCT (c.cod_tpro), c.nom_tpro
					FROM `kardex` a
					JOIN producto b ON a.`cod_ref_kar` = b.`cod_pro`
					JOIN tipo_producto c ON b.`cod_tpro_pro` = c.cod_tpro
					JOIN marca d ON d.cod_mar = b.cod_mar_pro AND b.cod_mar_pro=".$_POST['marca']."
					WHERE a.cod_bod_kar=".$bodega_salida.";";  //exit;
				   $db = new Database();
				   $db->query($sqltipo);
				   $i = 0;
				   while($db->next_row())
				   { 
				     if($db->cod_tpro==$_POST['tipo_producto'])
					    $selectedt = "selected";
					 else
					    unset($selectedt);
				   ?>

				    <option value="<?=$db->cod_tpro?>" <?=$selectedt?>><?=$db->nom_tpro?></option>  

			    <? } $db->close();

				   ?>

            </select>

			<input type="hidden" name="fecha" id="fecha" value="<?=$_POST['fecha']?>">

			<input type="hidden" name="observaciones" id="observaciones" value="<?=$_POST['observaciones']?>">

			<input type="hidden" name="codigo" id="codigo" value="<?=$_POST['codigo']?>">

			<input type="hidden" name="bodega_entrada" id="bodega_entrada" value="<?=$_POST['bodega_entrada']?>">

			<input type="hidden" name="bodega_salida" id="bodega_salida" value="<?=$_POST['bodega_salida']?>">

			<input type="hidden" name="marca" id="marca" value="<?=$_POST['marca']?>">

			</form></td>

        <td><form name="frmref" id="frmref" method="POST"> 

			<select size="1" id="combo_referncia" name="combo_referncia"  class='SELECT'  onchange="this.form.submit();">

			<option value="0">[Seleccione]</option>

			<?

			  $dbref = new Database();

			  $sqlrefer = "SELECT DISTINCT (b.cod_pro), b.nom_pro

						   FROM `kardex` a

						   JOIN producto b ON a.`cod_ref_kar` = b.`cod_pro`

						   JOIN tipo_producto c ON b.`cod_tpro_pro` = c.cod_tpro AND b.`cod_tpro_pro` =".$_POST['tipo_producto']."

						   JOIN marca d ON d.cod_mar = b.cod_mar_pro AND b.cod_mar_pro =".$_POST['marca']."

						   WHERE a.`cod_bod_kar` =".$_POST['bodega_salida'].";";

			  $dbref->query($sqlrefer); 

			  while($dbref->next_row()){

			     if($_POST['combo_referncia']==$dbref->cod_pro)

				     $selected = "selected";

				 else

				     unset($selected);

			?>

			<option value="<?=$dbref->cod_pro?>" <?=$selected?>><?=$dbref->nom_pro?></option>

			<? } $dbref->close();?>

            </select>

			<input type="hidden" name="fecha" id="fecha" value="<?=$_POST['fecha']?>">

			<input type="hidden" name="observaciones" id="observaciones" value="<?=$_POST['observaciones']?>">

			<input type="hidden" name="codigo" id="codigo" value="<?=$_POST['codigo']?>">

			<input type="hidden" name="bodega_entrada" id="bodega_entrada" value="<?=$_POST['bodega_entrada']?>">

			<input type="hidden" name="bodega_salida" id="bodega_salida" value="<?=$_POST['bodega_salida']?>">

			<input type="hidden" name="marca" id="marca" value="<?=$_POST['marca']?>">

			<input type="hidden" name="tipo_producto" id="tipo_producto" value="<?=$_POST['tipo_producto']?>">

			</form></td>

	<? if($_POST['combo_referncia']>0)

	   {  

	      $dbp = new Database();

		  $sqlp = "SELECT cod_fry_pro FROM producto WHERE cod_pro=".$_POST['combo_referncia'].";";

		  $dbp->query($sqlp);

		  $dbp->next_row();

		  $codpro = $dbp->cod_fry_pro;

		  $dbp->close();

		  if($_POST['codigo_fry']!='')  

		     $codpro = $_POST['codigo_fry']; 

		

	   } 

	?>

        <td valign="top"><form name="frmfry" id="frmfry" method="POST">

		 <input name="codigo_fry" id="codigo_fry" type="text" value="<?=$codpro?>" style="color:#FF0000; text-align:right;" onBlur="this.form.submit();" size="12">

		 <input type="hidden" name="fecha" id="fecha" value="<?=$_POST['fecha']?>">

		 <input type="hidden" name="observaciones" id="observaciones" value="<?=$_POST['observaciones']?>">

		 <input type="hidden" name="codigo" id="codigo" value="<?=$_POST['codigo']?>">

		 <input type="hidden" name="bodega_entrada" id="bodega_entrada" value="<?=$_POST['bodega_entrada']?>">

		 <input type="hidden" name="bodega_salida" id="bodega_salida" value="<?=$_POST['bodega_salida']?>">

		 <input type="hidden" name="marca" id="marca" value="<?=$_POST['marca']?>">

		 <input type="hidden" name="tipo_producto" id="tipo_producto" value="<?=$_POST['tipo_producto']?>">

		 <input type="hidden" name="combo_referncia" id="combo_referncia" value="<?=$_POST['combo_referncia']?>">

		</form></td>

        <td><form name="frmad" id="frmad" method="POST">

			   <select size="1" id="peso" name="peso"  class='SELECT' onChange="this.form.submit();">

			   <option value="0">[Seleccione]</option>

                           <?

			     $dbc = new Database();

				 $sqlc = "SELECT DISTINCT (e.cod_pes), e.nom_pes
								FROM `kardex` a
								JOIN producto b ON a.`cod_ref_kar` = b.`cod_pro` AND b.cod_fry_pro = '".$codpro."'
								JOIN peso e ON e.cod_pes = a.cod_talla WHERE a.`cod_bod_kar` =".$bodega_salida."
								ORDER BY e.nom_pes"; 

				 $dbc->query($sqlc);
				 while($dbc->next_row())
				 { if($dbc->cod_pes==$_POST['peso'])
				     $selected = "selected";
				   else
				     unset($selected);
			   ?>
			   <option value="<?=$dbc->cod_pes?>" <?=$selected?>><?=$dbc->nom_pes?></option>
			   <? } $dbc->close(); ?>
			</select>
			<input type="hidden" name="fecha" id="fecha" value="<?=$_POST['fecha']?>">
			<input type="hidden" name="observaciones" id="observaciones" value="<?=$_POST['observaciones']?>">
			<input type="hidden" name="codigo" id="codigo" value="<?=$_POST['codigo']?>">
			<input type="hidden" name="bodega_entrada" id="bodega_entrada" value="<?=$_POST['bodega_entrada']?>">
			<input type="hidden" name="bodega_salida" id="bodega_salida" value="<?=$_POST['bodega_salida']?>">
			<input type="hidden" name="marca" id="marca" value="<?=$_POST['marca']?>">
			<input type="hidden" name="tipo_producto" id="tipo_producto" value="<?=$_POST['tipo_producto']?>">
			<input type="hidden" name="combo_referncia" id="combo_referncia" value="<?=$_POST['combo_referncia']?>">
			<input type="hidden" name="codigo_fry" id="codigo_fry" value="<?=$codpro?>">
			</form></td>

        <td><form id="frmser" name="frmser" method="POST">

			   <select name="serial" id="serial" class="SELECT" onChange="this.form.submit();"> 

			     <option value="0">[Seleccione]</option>

				 <?

				     $dbser = new Database();
					 $sqlser = "SELECT a.serial FROM kardex a 
					            JOIN producto b ON a.`cod_ref_kar` = b.`cod_pro` AND b.cod_fry_pro = '".$_POST['codigo_fry']."'
								JOIN peso e ON e.cod_pes = a.cod_talla AND a.cod_talla=".$_POST['peso']."
								WHERE a.`cod_bod_kar` =".$bodega_salida."
								ORDER BY e.nom_pes ";

					 $dbser->query($sqlser);
				     while($dbser->next_row()){
					 if($_POST['serial']==$dbser->serial)
					    $selected = "selected";
					 else
				        unset($selected);
				 ?> 
				 <option value="<?=$dbser->serial?>" <?=$selected?>><?=$dbser->serial?></option>
				 <? }$dbser->close(); ?>
			     </select>
				<input type="hidden" name="fecha" id="fecha" value="<?=$_POST['fecha']?>">
				<input type="hidden" name="observaciones" id="observaciones" value="<?=$_POST['observaciones']?>">
				<input type="hidden" name="codigo" id="codigo" value="<?=$_POST['codigo']?>">
				<input type="hidden" name="bodega_entrada" id="bodega_entrada" value="<?=$_POST['bodega_entrada']?>">
				<input type="hidden" name="bodega_salida" id="bodega_salida" value="<?=$_POST['bodega_salida']?>">
				<input type="hidden" name="marca" id="marca" value="<?=$_POST['marca']?>">
				<input type="hidden" name="tipo_producto" id="tipo_producto" value="<?=$_POST['tipo_producto']?>">
				<input type="hidden" name="combo_referncia" id="combo_referncia" value="<?=$_POST['combo_referncia']?>">
				<input type="hidden" name="codigo_fry" id="cod_fry_pro" value="<?=$_POST['codigo_fry']?>">
				<input type="hidden" name="peso" id="peso" value="<?=$_POST['peso']?>">
				 </form></td>

	<?php
	     if($_POST['serial']>0)

		 {
			 $dbf = new Database();
			 $sqlf = "SELECT cant_ref_kar FROM kardex WHERE serial=".$_POST['serial'].";";	
			 $dbf->query($sqlf);					 
			 $dbf->next_row();
			 $exis = $dbf->cant_ref_kar;
             $dbf->close();
		 }

	 ?>

	 <script>
	 function menor(a)
	 {
	    if(parseFloat(document.getElementById('existencias').value)<parseFloat(a))
	    {
	         alert("La cantidad debe ser menor a las existencias.");
		 document.getElementById('cantidad').value = "";
		 document.getElementById('cantidad').focus();
		 return false;
	    }
	 }
     </script>
        <td valign="top"><input type="text" name="existencias" id="existencias" readonly value="<?=$exis?>" size="10" style="color:#FF0000; text-align:right"></td>
        <td valign="top"><input name="cantidad" id="cantidad" type="text" style="color:#FF0000; text-align:right" id="cantidad" size="10" onblur="menor(this.value)"/></td>
        <td><form name="frmf" id="frmf" method="POST">
	<input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">
	<input type="hidden" name="fecha" id="fecha" value="<?=$_POST['fecha']?>">
	<input type="hidden" name="fechatmp" id="fechatmp" value="0">
	<input type="hidden" name="obstmp" id="obstmp" value="0">
	<input type="hidden" name="cantmp" id="cantmp" value="0">
	<input type="hidden" name="sertmp" id="sertmp" value="0">
	<input type="hidden" name="banprod" id="banprod" value="0">
	<input type="hidden" name="codigo" id="codigo" value="<?=$_POST['codigo']?>">
	<input type="hidden" name="bodega_entrada" id="bodega_entrada" value="<?=$_POST['bodega_entrada']?>">
	<input type="hidden" name="bodega_salida" id="bodega_salida" value="<?=$_POST['bodega_salida']?>">
	<input type="hidden" name="marca" id="marca" value="<?=$_POST['marca']?>">
	<input type="hidden" name="tipo_producto" id="tipo_producto" value="<?=$_POST['tipo_producto']?>">
	<input type="hidden" name="combo_referncia" id="combo_referncia" value="<?=$_POST['combo_referncia']?>">
	<input type="hidden" name="codigo_fry" id="cod_fry_pro" value="<?=$_POST['codigo_fry']?>">
	<input type="hidden" name="peso" id="peso" value="<?=$_POST['peso']?>">
	<input type="hidden" name="n" id="n" value="4">
	</form></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="71"><table width="100%" border="0">
      <tr>

        <td  class="ctablasup">Categoria</td>

	<td  class="ctablasup">Tipo Producto </td>

	<td  class="ctablasup">Referencia/Producto</td>

	<td  class="ctablasup">Codigo</td>

	<td   class="ctablasup">Color</td>

	<td  class="ctablasup">Pieza/Serial</td>

	<td   class="ctablasup">Cantidad:</td>

	<td width="4%" class="ctablasup" align="center">Borrar</td>

      </tr>

      <?

				if ($codigo!="") { // BUSCAR DATOS

					$sql =" SELECT * 

					        FROM d_traslado LEFT JOIN tipo_producto ON tipo_producto.cod_tpro=d_traslado.cod_tpro_dtra 

						        INNER JOIN m_traslado ON m_traslado.cod_tras = d_traslado.cod_mtras_dtra

							LEFT JOIN marca ON marca.cod_mar=d_traslado.cod_mar_dtra 

							LEFT JOIN peso ON peso.cod_pes=d_traslado.cod_pes_dtra 

							LEFT JOIN producto ON producto.cod_pro=d_traslado.cod_ref_dtra 

							WHERE cod_mtras_dtra=$codigo ORDER BY serial ";//=		

					$dbdatos_1= new  Database();

					$dbdatos_1->query($sql);

					while($dbdatos_1->next_row()){ ?>

					    

						<tr>

						<!--cmarca-->

						<td><span class='textfield01'><?=$dbdatos_1->nom_mar?></span></td>

						<!--tipo de producto-->

						<td><span  class='textfield01'><?=$dbdatos_1->nom_tpro?></span></td>

						<!--referencia o producto -->

						<td><span  class='textfield01'><?=$dbdatos_1->nom_pro?></span> </td>

						<!--codigo producto-->

						<td ><span  class='textfield01'><?=$dbdatos_1->cod_fry_pro?></span> </td>

						<!--Color-->

						<td><span  class='textfield01'><?=$dbdatos_1->nom_pes?></span></td>

						<!--serial-->

						<td ><span  class='textfield01'><?=$dbdatos_1->serial?></span> </td>

						<!--Cantidad-->

						<td align='right'><span  class='textfield01'><?=number_format($dbdatos_1->cant_dtra ,2,",",".")?> </span></td>	

						<!--boton q quita la fila-->

						<td><form name="frmdel<?=$dbdatos_1->cod_dtra?>" id="frmdel<?=$dbdatos_1->cod_dtra?>" method="POST"><div align='center'>	

                             <INPUT type='submit' class='botones' value='  -  '>

							 <input type="hidden" name="iddetalle" id="iddetalle" value="<?=$dbdatos_1->cod_dtra?>">

							 <input type="hidden" name="n" id="n" value="5">

							 <input type="hidden" name="codigo" id="codigo" value="<?=$dbdatos_1->cod_mtras_dtra?>">

							 <input type="hidden" name="combo_referncia" id="combo_referncia" value="<?=$dbdatos_1->cod_ref_dtra?>">

							 <input type="hidden" name="cantidad" id="cantidad" value="<?=$dbdatos_1->cant_dtra?>">

							 <input type="hidden" name="talla" id="talla" value="<?=$dbdatos_1->cod_pes_dtra?>">

							 <input type="hidden" name="serial" id="serial" value="<?=$dbdatos_1->serial?>">

							 <input type="hidden" name="bodega_entrada" id="bodega_entrada" value="<?=$dbdatos_1->cod_bod_ent_tras?>">

							 <input type="hidden" name="bodega_salida" id="bodega_salida" value="<?=$dbdatos_1->cod_bod_sal_tras?>">

							 </div></form></td>

						</tr>

				<? }

				}$dbdatos_1->close();

				?>

    </table></td>

  </tr>

</table>

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

</div>

</body>

</html>

