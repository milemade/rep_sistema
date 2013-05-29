<? include("lib/database.php")?>
<? include("js/funciones.php");?>
<? include "conf/tiemposesion.php"; ?>
<? 
   $n = $_POST['n']; 
    if(empty($global[5]) && empty($global[6]))
	{
	   print "<script>alert('Debe ingresar de nuevo al sistema.')</script>";
	   print "<script> window.location='inicio.php'; </script>";
	 }
?>
<?php
if ($codigo>0) {   // BUSCAR DATOS PARA EDITAR UN REGISTRO DE REMISION
	$sql ="SELECT  *  FROM ".$global[5]." inner join bodega on bodega.cod_bod=".$global[5].".cod_bod WHERE cod_ment=$codigo AND ".$global[5].".remision=1";		
	$dbdatos= new  Database();
	$dbdatos->query($sql);
	$dbdatos->next_row();
}
?>
<?php
function insertar_maestrodelay($tabla,$compos,$valores) {
	$sql="INSERT INTO ".$tabla." ".$compos." VALUES ".$valores.";"; //exit;     
	//echo $sql; exit;
	$db= new  Database();
	$db->query($sql);
	$idmaster = $db->insert_id();
	$db->close();
	return $idmaster;
}
function insertardelay($tabla,$compos,$valores) {
	$sql="INSERT INTO ".$tabla." ".$compos." VALUES ".$valores.";"; 
	//echo $sql;
	$db= new  Database();
	$db->query($sql);
	$iddetalle = $db->insert_id();
	$db->close();
	return $iddetalle;
}
function sumartotal($id,$tabla,$maestra)
{
  $d = new Database();
  $sql = "SELECT cant_dent,cos_dent FROM ".$tabla." WHERE cod_ment_dent=".$id.";"; //exit;
  $d->query($sql);
  $total = 0;
  while($d->next_row())
  {
       $total = $total + ($d->cant_dent * $d->cos_dent);
  }
  $du = new Database();
  $sqlu = "UPDATE ".$maestra." SET total_ment='".$total."' WHERE cod_ment=".$id.";"; 
  $du->query($sqlu);
  $du->close(); //exit;
  return $total;
}
?>
<?php
 function repiteserial($serial,$tabla)
 {
     //Consulta para ver que no hay seriales repetidos
	 $dbex = new Database();
	 $sqlex = "SELECT cod_kar FROM kardex WHERE serial=".$serial.";";
	 $dbex->query($sqlex);
	 $nrows = $dbex->num_rows();
	 $dbexx = new Database();
	 $sqlxx = "SELECT cod_dent FROM ".$tabla." WHERE cod_serial=".$serial.";";
	 $dbexx->query($sqlxx);
	 $nrowss = $dbexx->num_rows();
	 $dbex->close();
	 $dbexx->close();
	 if($nrows==0 && $nrowss==0)
	    $repite = 0; //No se repite
	 else
	 {
	    $repite = 1;
		print "<script>alert('No se permite repetir SERIAL!')</script>";
	 }
	 return $repite;
 }
?>
<?php
   if($n==1)
   { $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
      //Cuando presiona bot�n Guardar y es un nuevo registro
     //Si no ha elegido productos no hace nada
     if($codigo>0)//Si es una modificacion, actualiza tabla maestra
     { //Actualiza los datos de la tabla maestra temporal 
        $dbup = new Database();
	$ssqlup = "UPDATE ".$global[5]." SET fec_ment='".$_POST['fechatemp']."',remision=1,obs_ment='".$_POST['obstemp']."',cod_bod=".$_POST['bodegatemp'].",cod_prove_ment=".$_POST['proveedortemp']." WHERE fac_ment=".$_POST['num_factemp'].";";
	$dbup->query($ssqlup);
	$dbup->close();
	$dbk = new Database();
	$totalentrada = sumartotal($codigo,$global[6],$global[5]);
        $sqlup = "UPDATE ".$global[5]." SET total_ment=".$totalentrada." WHERE cod_ment=".$id_new.";";
        $dbk->query($sqlup);
        $dbk->close(); 
     }
     ?>
  <form name="fgei" id="fgei" method="post" action="con_cargue_inventario.php">
  <input type="hidden" name="confirmacion" value="1">
  <input type="hidden" name="editar" value="<?=$editar?>">
  <input type="hidden" name="insertar" value="<?=$insertar?>">
  <input type="hidden" name="eliminar" value="<?=$eliminar?>">
  </form>
  <script>document.fgei.submit();</script>    
<? exit; } ?>
<?php
  if($n==2)
  {
     //Existe un codigo y actualiza datos bot�n Guardar
     $dbup = new Database();
     $sqlup = "UPDATE ".$global[5]." SET fec_ment='".$_POST['fecha']."',obs_ment='".$_POST['observaciones']."',
                      cod_bod=".$_POST['bodega'].",cod_prove_ment=".$_POST['proveedor']." WHERE cod_ment=".$_POST['codigo'];
     $dbup->query($sqlup); ?>
     <form name="fgei" id="fgei" method="post" action="con_cargue_inventario.php">
     <input type="hidden" name="confirmacion" value="2">
    <input type="hidden" name="editar" value="<?=$editar?>">
    <input type="hidden" name="insertar" value="<?=$insertar?>">
    <input type="hidden" name="eliminar" value="<?=$eliminar?>">
    </form>
  <script>document.fgei.submit();</script>
<? exit;  } ?>
<?php
  if($n==3)
  {  $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
    //Adiciona  nuevo producto a un nuevo registro de maestro entrada usuario
    if($codigo==0)//Si aun no existe id temporal, crea el registro en la tabla maestro temporal
    { 
         $compos = "(fec_ment,fac_ment,obs_ment,cod_bod,total_ment,cod_prove_ment,usu_ment,est_ment,remision,cod_usu,fechahora)";
	 $valores = "('".$fecha."','".$num_fac."','".$observaciones."','".$bodega."','".$todocompra."','".$proveedor."',
	              '".$global[2]."','PENDIENTE',".$remision.",".$global[2].",CURRENT_TIMESTAMP)" ; 
         if($fecha>0 && $bodega>0)
            $ins_tmp = insertar_maestrodelay($global[5],$compos,$valores); //exit;
         
	 if($ins_tmp>0) 
	 {
	         //echo "ENTRA AQUI";exit;
		 $compos="(cod_ment_dent,cod_tpro_dent,cod_mar_dent,cod_pes_dent,cod_ref_dent,cant_dent,cos_dent,cod_serial,num_remision)";
		 $valores="('".$ins_tmp."','".$_POST["tipo_producto"]."','".$_POST["marca"]."','".$_POST["peso"]."','".
		            $_POST["combo_referncia"]."','".$_POST["cantidad"]."','".$_POST["costo"]."',".$_POST["serial"].",".$num_fac.")" ;
		 $banrepite = repiteserial($_POST['serial'],$global[6]);//bandera
		 if($banrepite==0)
		 {
		     if($_POST['cantidad']>0 && $_POST['costo']>0)
		        $error = insertardelay($global[6],$compos,$valores);
             if($global[1]==1 && $_POST['cantidad']>0 && $_POST['costo']>0) //Si es Superadministrador Afecta inventarios
			 {   
			     kardex("suma",$_POST["combo_referncia"],$_POST['bodegatmp'],$_POST["cantidad"],$_POST["costo"],$_POST["peso"],$_POST["serial"]);
			 }				
		 }
	 }
	  ?>
	  <form name="frmtp" id="frmtp" method="post">
	  <input type="hidden" name="codigo" id="codigo" value="<?=$ins_tmp?>">
	  <input type="hidden" name="editar" value="<?=$editar?>">
	  <input type="hidden" name="insertar" value="<?=$insertar?>">
	  <input type="hidden" name="eliminar" value="<?=$eliminar?>">
	  </form>
	  <script>document.frmtp.submit();</script> 
	 <? exit; ?>
   <?  }} ?>
 <?php 
   if($n==4)
   { //Actualiza maestra entradas
     $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
      $dbmaster = new Database();
      $sqlmaster = "UPDATE ".$global[5]." SET cod_bod=".$_POST['bodegatmp'].",obs_ment='".$_POST['obstmp']."',cod_prove_ment=".$_POST['provetmp']." WHERE cod_ment=".$codigo.";";
      //echo $sqlmaster;  exit;
      $dbmaster->query($sqlmaster);
     //Adicion productos y existe codigo
	 $compos = "(cod_ment_dent,cod_tpro_dent,cod_mar_dent,cod_pes_dent,cod_ref_dent,cant_dent,cos_dent,cod_serial,num_remision)";
	 $valores = "('".$codigo."','".$_POST["tipo_producto"]."','".$_POST["marca"]."','".$_POST["peso"]."','".
	                 $_POST["combo_referncia"]."','".$_POST["cantidad"]."','".$_POST["costo"]."',".$_POST["serial"].",".$codigo.");" ;
	 $banrepite = repiteserial($_POST['serial'],$global[6]);//bandera
         if($banrepite==0)
	     {		 
             insertardelay($global[6],$compos,$valores); 
			 if($global[1]==1)
			 {   
			     kardex("suma",$_POST["combo_referncia"],$_POST['bodegatmp'],$_POST["cantidad"],$_POST["costo"],$_POST["peso"],$_POST["serial"]);
			 }
	         $total = sumartotal($codigo,$global[6],$global[5]); 
         }	 ?>
     <form name="frmedi" id="frmedi" method="post">
     <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>">
     <input type="hidden" name="editar" value="<?=$editar?>">
     <input type="hidden" name="insertar" value="<?=$insertar?>">
     <input type="hidden" name="eliminar" value="<?=$eliminar?>">
     </form>
     <script>document.frmedi.submit();</script> 
 <? } ?>  

<?php  //Borra productos
   if($n==5)
   {
      $ahora = date("Y-n-j H:i:s");
     $_SESSION["ultimoAcceso"] = $ahora;
      if($_POST['ideli']>0)
      {   
      	  if($codigo>0)
          { 
		     if($global[1]==1)
			 {   
			     $sqlbus = "SELECT a.cod_bod,b.cod_ref_dent,b.cant_dent,b.cos_dent,b.cod_pes_dent,b.cod_serial  
						      FROM m_entrada a JOIN d_entrada b ON a.cod_ment=b.cod_ment_dent
					         WHERE b.cod_dent=".$_POST['ideli'].";";
				  $dbk = new Database();
				  $dbk->query($sqlbus);
				  $dbk->next_row();
				  //Afecta inventarios, resta lo ingresado
				  kardex("resta",$dbk->cod_ref_dent,$dbk->cod_bod,$dbk->cant_dent,0,$dbk->cod_pes_dent,$dbk->cod_serial);
				  $sqldel = "DELETE FROM d_entrada WHERE cod_dent=".$_POST['ideli'].";";
				  $del = new Database();
				  $del->query($sqldel);
				  $numdelete = $del->affected_rows();//exit;
				  if($numdelete==0)
				  {
					  echo "No borro de la tabla detalle;"; 
					  exit;
				  }
				  $del->close();
			 }
			 if($global[1]==2)
			 {
				 //Borra de la tabla usuario inventarios, no afecta inventarios
				 $sqldel = "DELETE FROM ".$global[6]." WHERE cod_dent=".$_POST['ideli'].";";//exit;
				 $del = new Database();
				 $del->query($sqldel);
				 $numdelete = $del->affected_rows();//exit;
				 if($numdelete==0)
				 {
					echo "No borr� detalle;"; 
					exit;
				 }
				 $del->close();
			 }
	     } 
		 
		 ?>
	  <form name="frndel" id="frndel" method="POST">
	  <input type="hidden" name="editar" value="<?=$editar?>">
	  <input type="hidden" name="insertar" value="<?=$insertar?>">
	  <input type="hidden" name="eliminar" value="<?=$eliminar?>">
	  <input type="hidden" name="codigo" id="codigo" value="<?=$_POST['codigo']?>">
	  </form>
	  <script>document.frndel.submit();</script>
<?php exit;   } ?>
	
<?  } ?>
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
<script language="javascript">

function datos_completos()
{  
	if (document.getElementById('fecha').value == "" || 
	document.getElementById('bodega').value == 0)
	{
	    alert("Debe ingresar Fecha y seleccionar una Bodega, Gracias!");
		return false;
	}
	else
		return true;		

}

function cambio_guardar() {	
    
	if(document.getElementById('fecha').value == "" || document.getElementById('fecha').value=="0000-00-00")
	{
	   alert("Debe ingresar una fecha!");
	   document.getElementById('fecha').focus();
	   return false;
	}
	if(document.getElementById('bodega').value == 0)
	{
	   alert("Debe seleccionar una bodega!");
	   document.getElementById('bodega').focus();
	   return false;
	}
	if(document.getElementById('proveedor').value == 0)
	{
	   alert("Debe seleccionar un Proveedor!");
	   document.getElementById('proveedor').focus();
	   return false;
	}
	else 
	{
		document.getElementById('guardar').value=1;
		document.getElementById('num_factemp').value=document.getElementById('num_fac').value;
		document.getElementById('bodegatemp').value=document.getElementById('bodega').value;
		document.getElementById('proveedortemp').value=document.getElementById('proveedor').value;
		document.getElementById('fechatemp').value=document.getElementById('fecha').value;
		document.getElementById('obstemp').value=document.getElementById('observaciones').value;
		document.frmfin.submit();
		return true;
	}
	
	}
	function cambio_guardared() {	
    
	if(document.getElementById('fecha').value == "" || document.getElementById('fecha').value=="0000-00-00")
	{
	   alert("Debe ingresar una fecha!");
	   document.getElementById('fecha').focus();
	   return false;
	}
	if(document.getElementById('bodega').value == 0)
	{
	   alert("Debe seleccionar una bodega!");
	   document.getElementById('bodega').focus();
	   return false;
	}
	if(document.getElementById('proveedor').value == 0)
	{
	   alert("Debe seleccionar un Proveedor!");
	   document.getElementById('proveedor').focus();
	   return false;
	}
	else 
	{
		document.getElementById('guardar').value=1;
		document.frmfin.submit();
		return true;
	}
	
	}

function  adicion() 
{  //alert(document.getElementById("cantidad").value);
    //alert(document.getElementById("bodega").value);
	
	if (document.getElementById('fecha').value == "")
    {
	    alert("Debe ingresar la Fecha!");
		document.getElementById('fecha').focus();
		return false;
    }
    if(document.getElementById('bodega').value == 0)
    {
	    alert('Debe seleccionar alguna bodega!');
		document.getElementById('bodega').focus();
		return false;
    }
    if(document.getElementById("proveedor").value==0)	
	{
	   alert("Debe seleccionar algun proveedor!")
	   document.getElementById("proveedor").focus();
	   return false;
	}
	if(document.getElementById("cantidad").value>0 && 
	document.getElementById("codigo_fry").value >0 && 
	document.getElementById("costo").value>0 && 
	document.getElementById('combo_referncia').value > 0  && 
	document.getElementById('serial').value > 0 &&
	document.getElementById('peso').value > 0) 
	{
	    if(document.fo3.codigo.value>0)
		{  
		   document.getElementById("bodegatmp").value = document.getElementById("bodega").value;
		   document.getElementById("obstmp").value = document.getElementById("observaciones").value;
		   document.getElementById("provetmp").value = document.getElementById("proveedor").value;
		   document.fo3.n.value = 4;
		   document.fo3.submit();
		   document.getElementById("codigo_fry").focus();
		   return true;
		}		
        else
		{
		    document.fo3.n.value=3;
			document.fo3.submit();
		    document.getElementById("codigo_fry").focus();
		    return true;
		}
		
		
	}
	else 
	{
		alert("Complete el formulario, Gracias!")
		document.getElementById("codigo_fry").focus();
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


function busca_proveedores() {
	var codigo_buscar_referencia =document.getElementById('marca').value;	
	var combo_llenar=document.getElementById('tipo_producto');	
	combo_llenar.options.length=0;
	var vec_productos = new Array;
	<?
	$dbdatos111= new  Database();
	$sql =" SELECT    DISTINCT cod_tpro, nom_tpro ,cod_mar_pro FROM producto  left JOIN tipo_producto ON tipo_producto.cod_tpro=producto.cod_tpro_pro   order by nom_tpro"; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_tpro','$dbdatos111->nom_tpro','$dbdatos111->cod_mar_pro');\n";	
		$i++;
	}
	?>
	var cant=1;
	combo_llenar.options[0] = new Option('Seleccione','0'); 
	for (j=0; j<<?=$i?>;j++)
	{
		if(codigo_buscar_referencia==vec_productos[j][2]) 
		{
			combo_llenar.options[cant] = new Option(vec_productos[j][1],vec_productos[j][0]);  
			cant++; 	
		}
	}
}

function busca_empaque() {
	var codigo_buscar_referencia =document.getElementById('marca').value;	
	var combo_llenar=document.getElementById('peso');	
	combo_llenar.options.length=0;
	var vec_productos = new Array;
	<?
	$dbdatos111= new  Database();
	$sql ="SELECT DISTINCT  cod_pes, nom_pes, cod_mar_pro, cod_tpro_pro FROM producto left JOIN peso ON peso.cod_pes=producto.cod_pes_pro  order by nom_pes "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_pes','$dbdatos111->nom_pes','$dbdatos111->cod_mar_pro','$dbdatos111->cod_tpro_pro');\n";	
		$i++;
	}
	?>
	var cant=1;
	combo_llenar.options[0] = new Option('Seleccione','0'); 
	for (j=0; j<<?=$i?>;j++)
	{
		if(codigo_buscar_referencia==vec_productos[j][2] & document.getElementById('tipo_producto').value==vec_productos[j][3]) 
		{
			combo_llenar.options[cant] = new Option(vec_productos[j][1],vec_productos[j][0]);  
			cant++; 	
		}
	}
}

function busca_referencia() {
	var codigo_buscar_referencia =document.getElementById('peso').value;	
	var combo_llenar=document.getElementById('combo_referncia');	
	combo_llenar.options.length=0;
	var vec_productos = new Array;
	<?
	//marca === talla 
	$dbdatos111= new  Database();
	$sql ="SELECT DISTINCT   cod_pro, nom_pro ,cod_pes_pro,cod_mar_pro,cod_tpro_pro FROM producto  ORDER BY nom_pro  "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_pro','$dbdatos111->nom_pro','$dbdatos111->cod_pes_pro' ,'$dbdatos111->cod_mar_pro','$dbdatos111->cod_tpro_pro');\n";	
		$i++;
	}
	?>
	var cant=1;
	combo_llenar.options[0] = new Option('Seleccione','0'); 
	for (j=0; j<<?=$i?>;j++)
	{
		if(document.getElementById('marca').value==vec_productos[j][3] & document.getElementById('tipo_producto').value==vec_productos[j][4]) 
		{
			combo_llenar.options[cant] = new Option(vec_productos[j][1],vec_productos[j][0]);  
			cant++; 	
		}
	}
}

function busca_codigo() {
	var codigo_buscar_referencia =document.getElementById('combo_referncia').value;	
	var combo_llenar=document.getElementById('codigo_fry');	
	combo_llenar.value='';
	var vec_productos = new Array;
	document.getElementById('cantidad').focus();
	<?
	$dbdatos111= new  Database();
	$sql ="SELECT cod_pro, cod_fry_pro FROM producto  "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_pro','$dbdatos111->cod_fry_pro');\n";	
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

function cargar_combos()
{
	var codigo_buscar_referencia = document.getElementById('codigo_fry').value;	
	document.getElementById('peso').focus();
	var vec_productos = new Array;
	<?
	$dbdatos111= new  Database();
	$sql ="SELECT cod_pro,nom_pro,cod_fry_pro,cod_tpro_pro,cod_mar_pro,nom_mar,cod_pes_pro ,nom_tpro  FROM producto inner JOIN marca ON marca.cod_mar=producto.cod_mar_pro  inner JOIN tipo_producto ON   producto.cod_tpro_pro =tipo_producto.cod_tpro "; 
	$dbdatos111->query($sql);
	$i = 0;
	while($dbdatos111->next_row()){
		echo "vec_productos[$i]=  new Array('$dbdatos111->cod_pro','$dbdatos111->nom_pro','$dbdatos111->cod_fry_pro','$dbdatos111->cod_tpro_pro','$dbdatos111->cod_mar_pro','$dbdatos111->nom_mar','$dbdatos111->cod_pes_pro','$dbdatos111->nom_pes','$dbdatos111->nom_tpro');\n";	
		$i++;
	}
	?>
	var bandera=0;
	for (j=0; j<<?=$i?>;j++)
	{
		if(codigo_buscar_referencia==vec_productos[j][2]) 
		{
			//alert(vec_productos[j][5])
			//alert()
			//document.getElementById('marca').options[0] = new Option(vec_productos[j][5],vec_productos[j][4]); 
			document.getElementById('marca').value=vec_productos[j][4];
			document.getElementById('tipo_producto').options[0] = new Option(vec_productos[j][8],vec_productos[j][3]);
			document.getElementById('combo_referncia').options[0] = new Option(vec_productos[j][1],vec_productos[j][0]); 
			bandera=1;
		}
	}
	if(bandera==0)
	{
		//document.getElementById('marca').options.length=0;
		//document.getElementById('peso').options.length=0;
		document.getElementById('combo_referncia').options.length=0;
		document.getElementById("tipo_producto").value=0;
		//document.getElementById("codigo_fry").value='';
		document.getElementById("cantidad").value='';
		document.getElementById("costo").value='';
		document.getElementById("codigo_fry").focus();
		alert('Esta Referencia No esta Registrada o Verifique la parametrizacion del Producto')
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
</script>
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
}) 
function ponerfoco()
{
   //alert("ponefoco");
   document.getElementById("codigo_fry").focus();
} 
</script>
<script type="text/javascript" src="js/jscargueinventario.js"></script>
</head>
<body <?=$sis?> onload="ponerfoco()">
<div id="total">

<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
		
        <td width="20" >
		<? if($_POST['codigo']>0){ //Edita registro?>
		<form name="frmfin" id="frmfin" method="POST" action="">
		<img src="imagenes/icoguardar.png" alt="Guardar Registro" width="16" height="16" border="0" onClick="cambio_guardared()" style="cursor:pointer"/></td>
                <td width="61" class="ctablaform">Guardar
		<input type="hidden" name="confirmacion" value="2">
		<input type="hidden" name="codigo" value="<?=$codigo?>">
		<input type="hidden" name="guardar" value="0">
		<input type="hidden" name="editar" value="1">
		  <input type="hidden" name="insertar" value="<?=$insertar?>"> 
		  <input type="hidden" name="eliminar" value="<?=$eliminar?>">
		  <input type="hidden" name="todocompra" value="<?=sumartotal($codigo,$global[6],$global[5]);?>">
		  <input type="hidden" name="n" id="n" value="2">
		<? } else { //Nuevo Registro?>
		<form name="frmfin" id="frmfin" method="POST">
		<img src="imagenes/icoguardar.png" alt="Guardar Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar
		<input type="hidden" name="ins_tmp" id="ins_tmp" value="<?if($_POST['ins_tmp']>0) echo $_POST['ins_tmp']; else echo "0";?>">
		<input type="hidden" name="fin" id="fin" value="1">
		<input type="hidden" name="codigo" id="codigo" value="0">
		<input type="hidden" name="num_factemp" id="num_factemp" value="0">
		<input type="hidden" name="fechatemp" id="fechatemp" value="0">
		<input type="hidden" name="proveedortemp" id="proveedortemp" value="0">
		<input type="hidden" name="bodegatemp" id="bodegatemp" value="0">
		<input type="hidden" name="obstemp" id="obstemp" value="0">
		<input type="hidden" name="n" id="n" value="1">
		</td>
		</form>
		<? } ?>
        <td width="21" class="ctablaform"><a href="con_cargue_inventario.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>&bandera=1"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><!--<a href="#"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" onClick="buscar_producto()" /></a><a href="con_cargue_inventario.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>">--></a></td>
        <td width="70" class="ctablaform"><!--Consultar (F9) --></td>
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
    <td class="textotabla01">CARGUE INVENTARIO REMISION:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup2.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td bgcolor="#E9E9E9" valign="top">
	<? if($codigo==0) { ?>
	<form  name="fo3" id="fo3" action=""  method="post">
	<? } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr>
        <td width="50" class="textotabla1">Fecha:</td>
        <td width="164">
          <input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_ment ?>" />
          <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td width="8" class="textorojo">*</td>
        <td width="93" rowspan="2" class="textotabla1" valign="top">Observaciones:</td>
        <td rowspan="2">
		  <textarea name="observaciones" id="observaciones" cols="45" rows="4" class="textfield02"  ><?=$dbdatos->obs_ment?></textarea></td>
        </tr>
      
       <tr>
         <td class="textotabla1">Bodega</td>
         <td><span class="textotabla1">
           <? 
		      

combo_evento("bodega","bodega","cod_bod","nom_bod",$dbdatos->cod_bod,"  ", "nom_bod"); 

				
			  ?>
		 
		 
		 
         </span></td>
         <td>&nbsp;</td>
         </tr>
          <tr>
         <td class="textotabla1">Remision No:</td>
         <td class="textotabla1"><input name="num_fac" id="num_fac" type="text" class="textfield2" readonly value="<?
		  $dbmax = new Database();
		  $sqlmax = "SELECT MAX(fac_ment + 1) as max FROM ".$global[5]." WHERE remision=1;";
		  $dbmax->query($sqlmax);
		  $dbmax->next_row();
		  $maximo = $dbmax->max;
		  $dbmax->close();
		  if($codigo>0)
		     echo $dbdatos->fac_ment;
		  else
		    if($maximo!="" || $maximo>0)
		      echo $maximo;
		  else
		     echo "1";?>" onKeyPress=" return validaInt()"/></td>
         <td rowspan="2">&nbsp;</td>
         <td width="93" rowspan="2" valign="top" class="textotabla1">Proveedor</td>
         <td rowspan="2"><? combo_evento("proveedor","proveedor","cod_pro","nom_pro",$dbdatos->cod_prove_ment," ", "nom_pro"); ?></td>
          
          </tr>
	         <tr>
	           <td class="textotabla1">&nbsp;<input type="hidden" name="remision" value="1"/>
	             </td>
	           <td class="textotabla1"></td>
            </tr>
	   <tr>
        <td colspan="5" class="textotabla1" >
		<? if($codigo>0){?>
		</form>
		<form  name="fo3" id="fo3" action=""  method="post">
		<? } ?>
		<table  width="99%" border="1">         
          <tr >
            <td  class="ctablasup">Categoria</td>
			<td  class="ctablasup">Tipo Producto </td>
            <td colspan="2"  class="ctablasup">Referencia</td>
			<td  class="ctablasup">&nbsp;Codigo</td>
			<td  class="ctablasup">Serial</td>
            <td  class="ctablasup">Color</td>
            <td   class="ctablasup">Cantidad</td>
			<td    class="ctablasup">Costo Unitario</td>
			<td width="4%" class="ctablasup" align="center">Agregar:</td>
          </tr>
          <tr >
            <td ><? combo_evento("marca","marca","cod_mar","nom_mar",""," onchange=\"busca_proveedores()\" ", "nom_mar"); ?></td>
			<td >
			<select size="1" id="tipo_producto" name="tipo_producto"  class='SELECT' onChange="busca_referencia()" >
            </select>			</td>
            <td colspan="2" align="center"><select size="1" id="combo_referncia" name="combo_referncia"  class='SELECT' onChange="busca_codigo()">
            </select>
              <input name="codigo_producto" type="hidden" id="codigo_producto" value="0" /></td>
            <td align="center"><input name="codigo_fry" id="codigo_fry" type="text" class="caja_resalte1" onKeyPress=" return valida_evento(this,'cantidad')"  onchange="cargar_combos()"  ></td>
			<!--Aqui agrego serie-->
			<? // PARA AGREGAR EL CONSECUTIVO DEL SERIAL DE ESA REMISION
			  if(isset($codigo) && $codigo>0) {
			  $dbser = new Database();
			  $ssql = "SELECT MAX(cod_serial + 1) as maximo FROM ".$global[6]." WHERE cod_ment_dent=".$codigo.";";
			  $dbser->query($ssql);
			  $dbser->next_row();
			  $maxserial = $dbser->maximo;
			  $dbser->close();
			}
			?>
			<td><input type="text" class="textfield" name="serial" id="serial" value="<?if(isset($codigo) && $codigo>0 || $_POST['ins_tmp']>0) echo $maxserial; ?>" onKeyPress="return validarnumero(event);"></td>
			<!--Fin agrega serie-->
			<td align="center">
		<? combo_evento("peso","peso","cod_pes","nom_pes"," "," onfocus='cargar_combos()'  ", "nom_pes"); ?>		</td>
			 <td align="center">
			 <input name="cantidad" type="text" class="caja_resalte" id="cantidad"/>			 </td>
			 <td align="center">
			 <input name="costo" type="text" class="caja_resalte1" id="costo" onKeyPress="return validaInt_evento(this,'mas')"/></td>
			 <td align="center"> 
			 <input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">			 </td>
          </tr>
		  <input type="hidden" name="guardar" id="guardar" value="">
		  <input type="hidden" name="codigo" id="codigo" value="<? if($codigo>0) echo $codigo; else echo "0";?>">
		  <input type="hidden" name="n" id="n" value="0">
		  <input type="hidden" name="bodegatmp" id="bodegatmp" value="0">
		  <input type="hidden" name="provetmp" id="provetmp" value="0">
		  <input type="hidden" name="obstmp" id="obstmp" value="">
		  <input type="hidden" name="editar" value="<?=$editar?>">
		  <input type="hidden" name="insertar" value="<?=$insertar?>">
		  <input type="hidden" name="eliminar" value="<?=$eliminar?>">
		   </form>    
		  <tr >
		  <td  colspan="9">
			  <table width="100%">
				<tr id="fila_0">
				<td  class="ctablasup">Categoria</td>
				<td  class="ctablasup">Tipo Producto </td>
				<td   class="ctablasup">Referencia:</td>
				<td  class="ctablasup">Codigo</td>
				<td  class="ctablasup">Serial</td>
				<td  class="ctablasup">Color</td>
				<td   class="ctablasup">Cantidad:              </td>
				<td    class="ctablasup">Costo Unitario</td>
				<td    class="ctablasup">Total</td>
				<td width="4%" class="ctablasup" align="center">Borrar:</td>
				</tr>
		           <?php   if($codigo>0)
				   {
				       $sql =" SELECT * FROM ".$global[6]." 
					                 INNER JOIN ".$global[5]." ON ".$global[6].".`cod_ment_dent` = ".$global[5].".`cod_ment`
					                 INNER JOIN tipo_producto ON tipo_producto.cod_tpro=".$global[6].".cod_tpro_dent 
									 INNER JOIN marca ON marca.cod_mar=".$global[6].".cod_mar_dent 
									 INNER JOIN peso ON peso.cod_pes=".$global[6].".cod_pes_dent 
									 INNER JOIN producto ON producto.cod_pro=".$global[6].".cod_ref_dent 
									 WHERE cod_ment_dent=$codigo AND ".$global[5].".remision=1 order by cod_serial ASC";//=	
				   }
				?>
				<?php
				if ($codigo>0) { // BUSCAR DATOS
						
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$numdatos1 = $dbdatos_1->num_rows();
					while($dbdatos_1->next_row()){ 
					?>
					<tr>
					<!--//cmarca-->
					<td><span class='textfield01'><?=strtoupper($dbdatos_1->nom_mar)?></span> </td>	
					<!--//tipo de producto-->
					<td><span  class='textfield01'><?=strtoupper($dbdatos_1->nom_tpro)?> </span></td>
					<!--//referencia-->
					<td><span  class='textfield01'><?=strtoupper($dbdatos_1->nom_pro)?></span></td>
					<!--//% codigo barra-->
					<td align="center"><span  class='textfield01'><?=$dbdatos_1->cod_fry_pro?></span> </td>
					<!--//Serial Producto-->
					<td class='textfield01' ><div align="center"><?=$dbdatos_1->cod_serial?></div></td>
					<!--//talla COLOR-->
					<td   ><span  class='textfield01'><?=$dbdatos_1->nom_pes?></span> </td>
					<!--//cantidad-->
					<td align='right'><span  class='textfield01'><?=$dbdatos_1->cant_dent?></span></td>
					<!--//costo-->
					<td align='center'><span  class='textfield01'><?=$dbdatos_1->cos_dent?></span> </td>	
					<!--//TOTAL-->
					<td align='right'><span  class='textfield01'><?=number_format(($dbdatos_1->cos_dent * $dbdatos_1->cant_dent) ,0,",",".")?></span></td>	
					<!--//boton q quita la fila-->
					<td><form id="frmdel" name="frmdel" method="post"><div align='center'>
                                                <input type="hidden" name="codigo" id="codigo" value="<?=$codigo?>">
                                                <INPUT type='submit' class='botones' value='  -  '>
						</div><input type="hidden" name="ideli" id="ideli" value="<?=$dbdatos_1->cod_dent?>">
						<input type="hidden" name="n" value="5">
						<input type="hidden" name="editar" value="<?=$editar?>">
						<input type="hidden" name="insertar" value="<?=$insertar?>">
						<input type="hidden" name="eliminar" value="<?=$eliminar?>"></form></td>
					 </tr>
					<?	
					}
				}
				?>
				</table>
                               
                  </td>
			</tr>			
		 <tr >
		  <td  colspan="9">
			  <table width="100%">
				<tr >
				<td  class="ctablasup"><div align="right">Resumen Entrada </div></td>
				</tr>
				<tr >
				<td ><div align="right" >Total  Compra:
				    <input name="todocompraver" id="todocompraver" type="text" class="textfield01" readonly="1" value="<? if($codigo>0)
																	  { 
																		$total = sumartotal($codigo,$global[6],$global[5]);         
																		$total = number_format(round($total),0,",",".");
																		echo $total; 
																         } 
																	?>"/>
	 <input type="hidden" name="todocompra" id="todocompra"value="<? if($codigo>0) echo sumartotal($codigo,$global[6],$global[5]); else echo "0"?>">
				</div>				  </td>
				</tr>
				</table>			</td>
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
		<?  if ($codigo!="") 
		        $valueInicial = $aa; 
		     if(isset($numdatos1) && $numdatos1>0)
			    $valueInicial = $numdatos1;
			 else $valueInicial = "1";?>
	   <input type="hidden" id="valDoc_inicial" value="<?=$valueInicial?>"> 
	   <input type="hidden" name="cant_items" id="cant_items" value=" <?  if ($codigo!="") echo $aa; else echo "0"; ?>">
	</td>
  </tr>
</table>

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
    <td width="81" class="textotabla1"><strong>Referencia:</strong></td>
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
