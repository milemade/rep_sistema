<? include("lib/database.php")?>
<? include("js/funciones.php")?>
<?

$db_edicion = new Database();

if ($codigo!=0) { //editando devolucion


 $sql ="SELECT 
  m_devolucion.cod_dev,
  m_devolucion.fec_dev,
  m_devolucion.cod_bod_dev,
  m_devolucion.num_fac_dev,
  m_devolucion.val_del,
  m_devolucion.obs_dev,
  m_devolucion.cod_ven_dev,
  bodega.nom_bod,
  usuario.nom_usu,
  m_factura.cod_cli,
  bodega1.nom_bod,
  m_factura.cod_razon_fac,
  rsocial.nom_rso
FROM
  m_devolucion
  INNER JOIN bodega ON (m_devolucion.cod_bod_dev = bodega.cod_bod)
  INNER JOIN usuario ON (m_devolucion.cod_ven_dev = usuario.cod_usu)
  INNER JOIN m_factura ON (m_devolucion.num_fac_dev = m_factura.cod_fac)
  INNER JOIN bodega1 ON (m_factura.cod_cli = bodega1.cod_bod)
  INNER JOIN rsocial ON (m_factura.cod_razon_fac = rsocial.cod_rso)
WHERE
  cod_dev =$codigo";
	$dbdatos_edi= new  Database();
	$dbdatos_edi->query($sql);
	if($dbdatos_edi->next_row()){
		$fecha_venta = $dbdatos_edi->fec_dev;
		$empresa = $dbdatos_edi->cod_razon_fac;
		$cliente = $dbdatos_edi->cod_cli;
		$bodega = $dbdatos_edi->cod_bod_dev;
		$codigo = $dbdatos_edi->num_fac_dev;
		$total_devolucion = $dbdatos_edi->val_del;
		$obs = $dbdatos_edi->obs_dev;
		$var_edicion=1;
	}
}


else { /// creando una devolucion  desde el numero de factura
	if(!empty($num_factura)){
	
	$sql = "SELECT  * FROM m_devolucion where num_fac_dev=$num_factura ";
	$db_edicion->query($sql);	
	if($db_edicion->next_row()) {
		echo " <script language='javascript'>
				alert('Ya existe una devolucion a esta Factura, Edite la devolucion')
				window.location = 'con_devolucion.php?confirmacion=0&editar=$editar&insertar=$insertar&eliminar=$eliminar'; 
				</script> ";
	}
	
	
	$sql = "select *  from m_factura WHERE cod_fac=$num_factura ";
	$db_edicion->query($sql);	
		if($db_edicion->next_row()) {
			$fecha_venta = $db_edicion->fecha;
			$empresa = $db_edicion->cod_razon_fac;
			$cliente = $db_edicion->cod_cli;
			$bodega = $db_edicion->cod_bod;
			$codigo = $db_edicion->cod_fac;
			$total_fac = $db_edicion->tot_fac;
			$var_edicion=0;
		}
	}
}


$sql =" select   valor_abono  from cartera_factura where cod_fac= $codigo";
$db_edicion->query($sql);

if($db_edicion->next_row()){
	 $valor_Abono = $db_edicion->valor_abono;
}



if($guardar==1 and $codigo!=0) 	{ // RUTINA PARA  INSERTAT REGISTROS NUEVOS

	// ACTUALIZA EL ANTERIOR VALOR Y BORRA LOS REGISTRO, LUEGO AFECTA LA DEVOLUCION DE LA FACTURA
	
	//BORRA DETALLES DE LA DEVOLUCION
	 $sql = "delete from d_devolucion where d_devolucion.cod_mfac_dev = $codigo ";
	$db_edicion->query($sql);	
	
	// BORRA MAESTRA DE LA DEVOLUCION
	 $sql = "delete FROM m_devolucion where num_fac_dev = $codigo ";
	$db_edicion->query($sql);	
	
	
	//ACTUALIZA LA DEVOLCION EN AL FACTURA
	
	$sql = "update m_factura   set tot_dev_mfac='$todocompra'  where m_factura.cod_fac= $codigo ";
	$db_edicion->query($sql);	

	
	//inicia la insercion de datos
	$compos="(fec_dev, cod_bod_dev, num_fac_dev ,val_del,cod_ven_dev, obs_dev)";
	$valores="('".date("Y-m-d")."','".$bodega_fac."','".$codigo."','".$todocompra."','".$global[2]."','".$observaciones."')" ; 
	$ins_id=insertar_maestro("m_devolucion",$compos,$valores); 	
	
	///////////// creacion de nota debito
	
	$sql="SELECT  num_fac   from  m_factura  where cod_fac=$codigo"; 
	$db_edicion->query($sql);
	if($db_edicion->next_row())
	{
		$numero_factura=$db_edicion->num_fac;
	}
	
	$error=eliminar("nota",$codigo,"cod_fac_not");
	$compos="(fec_not, val_not, obs_not,cod_fac_not )";
	$valores="('".date("Y-m-d")."','".$todocompra."',' Nota Automatica de descuento,  por devolucion  a la Facturavion   No: $numero_factura ',$codigo)" ;
	$error=insertar("nota",$compos,$valores); 
	////////////////
	

	if ($ins_id > 0) 
	{
		//insercion del credito
		$compos="(cod_mdev, cod_mfac_dev , cod_dfac_dev, cod_prod_ddev, cod_pes_ddev, cant_fac_dev, val_fac ,cant_ddev,total_ddev) ";
		for ($ii=1 ;  $ii <= $val_inicial + 1 ; $ii++) 
		{
			if($_POST["caja_cant_desc_".$ii]!=NULL) 
			{
				$val_total_dev_detalle=$_POST["costo_ref_".$ii] * $_POST["caja_cant_desc_".$ii];			
				$valores="('".$ins_id."','".$codigo."','".$_POST["codigo_det_fac_".$ii]."','".$_POST["codigo_referencia_".$ii]."','".$_POST["codigo_peso_".$ii]."' ,'".$_POST["cantidad_ref_".$ii]."','".$_POST["costo_ref_".$ii]."','".$_POST["caja_cant_desc_".$ii]."','".$val_total_dev_detalle."')";
				
				$error=insertar("d_devolucion",$compos,$valores); 
				
				if ($_POST["caja_cant_desc_".$ii]!="") 
				{
				
					kardex("resta",$_POST["codigo_referencia_".$ii],$bodega_fac,$_POST["canti_original_devuelta_ref_".$ii],$_POST["costo_ref_".$ii],$_POST["codigo_peso_".$ii]);
					kardex("suma",$_POST["codigo_referencia_".$ii],$bodega_fac,$_POST["caja_cant_desc_".$ii],$_POST["costo_ref_".$ii],$_POST["codigo_peso_".$ii]);
				}
			}	
		}

		header("Location: con_devolucion.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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

<script language="javascript">

<?
if($valor_Abono>0) {
	echo " alert('Ya existen ABONOS a la Factura, No se pueden hacer mas Devoluciones a la factura')";
//	header("Location: con_devolucion.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
}

?>

$valor_Abono



function buscar_datos_total(opc) {
	var vec_datos_total = new Array;
	var vec_codigo=0;
	var vec_nombre=0; 
	var combo_llenar="";
	var xx=1 ;
	<?
	$dbdatos_total= new  Database();
	$sql="SELECT   kardex.cod_ref_kar,  kardex.cod_bod_kar,  kardex.cant_ref_kar,  producto.cod_fry_pro,  producto.nom_pro,  producto.iva_pro,  producto.cod_tpro_pro,  tipo_producto.nom_tpro,  producto.cod_mar_pro,  marca.nom_mar,  kardex.cod_talla,  peso.nom_pes,  bodega1.cod_bod,  bodega1.cod_lista,  listaprecio.nom_list,  det_lista.cod_pro,  det_lista.pre_list FROM  kardex  left JOIN producto ON (kardex.cod_ref_kar = producto.cod_pro)   left JOIN peso ON (kardex.cod_talla = peso.cod_pes)   left JOIN marca ON (producto.cod_mar_pro = marca.cod_mar)   left JOIN tipo_producto ON (producto.cod_tpro_pro = tipo_producto.cod_tpro)   left JOIN det_lista ON (det_lista.cod_pro = kardex.cod_ref_kar)   left JOIN listaprecio ON (listaprecio.cos_list = det_lista.cod_lista)  left JOIN bodega1 ON (bodega1.cod_lista = listaprecio.cos_list) WHERE  cod_bod_kar = $bodega AND   cant_ref_kar > 0 AND   bodega1.cod_bod =$cliente"; 
	$dbdatos_total->query($sql);
	$i = 0;
	while($dbdatos_total->next_row()){
		echo "vec_datos_total[$i]=  new Array('$dbdatos_total->cod_ref_kar'   ,'$dbdatos_total->cod_bod_kar' , '$dbdatos_total->cant_ref_kar' , '$dbdatos_total->cod_fry_pro' , \"$dbdatos_total->nom_pro\" , '$dbdatos_total->iva_pro' , '$dbdatos_total->cod_tpro_pro' , '$dbdatos_total->nom_tpro' , '$dbdatos_total->cod_mar_pro' , '$dbdatos_total->nom_mar' , '$dbdatos_total->cod_talla' , '$dbdatos_total->nom_pes' , '$dbdatos_total->cod_bod' , '$dbdatos_total->cod_lista' , '$dbdatos_total->nom_list' , '$dbdatos_total->cod_pro' , '$dbdatos_total->pre_list' );\n";
		$i++;
	}
	?>
	
	/*if(opc="tipo_producto") {
		vec_codigo=6;
		vec_nombre=7; 
		combo_llenar=document.getElementById('tipo_producto');
	}*/

	if(opc=="marca") {
		limpiar_combos();
		vec_codigo=6;
		vec_nombre=7; 
		combo_llenar=document.getElementById('tipo_producto');
		combo_llenar.options.length=0;
		combo_llenar.options[0] = new Option('Seleccione','0'); 

		for (j=1; j<= vec_datos_total.length  ;j++)
		{
			if(document.getElementById('marca').value== vec_datos_total[j-1][8]) 
			{
				combo_llenar.options[xx] = new Option(vec_datos_total[j-1][vec_nombre],vec_datos_total[j-1][vec_codigo]);  
				xx++;
			}
		}
	}
	
	if(opc=="tipo_producto") {
		vec_codigo=0;
		vec_nombre=4; 
		combo_llenar=document.getElementById('combo_referncia');
		combo_llenar.options.length=0;
		combo_llenar.options[0] = new Option('Seleccione','0'); 

		for (j=1; j<= vec_datos_total.length  ;j++)
		{
			if(document.getElementById('tipo_producto').value== vec_datos_total[j-1][6]) 
			{
				combo_llenar.options[xx] = new Option(vec_datos_total[j-1][vec_nombre],vec_datos_total[j-1][vec_codigo]);  
				xx++;
			}
		}
	}	
	
	if(opc=="combo_referncia") {
		vec_codigo=10;
		vec_nombre=11; 
		combo_llenar=document.getElementById('peso');
		combo_llenar.options.length=0;
		combo_llenar.options[0] = new Option('Seleccione','0'); 
		
		for (j=1; j<= vec_datos_total.length  ;j++)
		{
			if(document.getElementById('combo_referncia').value== vec_datos_total[j-1][0]) 
			{
				document.getElementById('codigo_fry').value = vec_datos_total[j-1][3];
			}
			
			if(document.getElementById('combo_referncia').value== vec_datos_total[j-1][0]) 
			{
				combo_llenar.options[xx] = new Option(vec_datos_total[j-1][vec_nombre],vec_datos_total[j-1][vec_codigo]);  
				xx++;
			}
		}
	}
	
	if(opc=="cantidad") {
		var cantidad_actu;
		for (j=1; j<= vec_datos_total.length  ;j++)
		{
			if(document.getElementById('combo_referncia').value== vec_datos_total[j-1][0] &&  document.getElementById('peso').value== vec_datos_total[j-1][10]) 
			{	
				if( parseInt(document.getElementById('cantidad').value) > parseInt(vec_datos_total[j-1][2])) {
					alert("La Cantidad No Corresponde")
					return false;
				}
				else 
					return true;
			}
		}
	}
	
	
	if(opc=="valor_lista") {
		for (j=1; j<= vec_datos_total.length  ;j++)
		{
			if(document.getElementById('combo_referncia').value== vec_datos_total[j-1][0] &&  vec_datos_total[j-1][10]>0) 
			{	
				document.getElementById('valor_lista').value=vec_datos_total[j-1][16];
			}
		}
		
		if(document.getElementById('valor_lista').value==""){
			alert("No hay Precio Asignado")
			return false;
		}
		else 
			return true;	
	}
	
	
	if(opc=="refe_codigo") {
		for (j=1; j<= vec_datos_total.length  ;j++)
		{
			if(document.getElementById('codigo_fry').value== vec_datos_total[j-1][3]) 
			{	
				document.getElementById('marca').value=vec_datos_total[j-1][8];
				
				document.getElementById('tipo_producto').options.length=0;
				document.getElementById('tipo_producto').options[0] = new Option(vec_datos_total[j-1][7],vec_datos_total[j-1][6]);  
				
				document.getElementById('combo_referncia').options.length=0;
				document.getElementById('combo_referncia').options[0] = new Option(vec_datos_total[j-1][4],vec_datos_total[j-1][0]);  
				
				buscar_datos_total('combo_referncia');
			}
		}
	}
	
	
}


function limpiar_combos()
{
	document.getElementById('tipo_producto').options.length=0;
	document.getElementById('combo_referncia').options.length=0;
	document.getElementById('codigo_fry').value="";
	document.getElementById('peso').options.length=0;
	document.getElementById('valor_lista').value="";
	document.getElementById('cantidad').value="";
}

function datos_completos(){ 


	if( document.getElementById('todocompra').value < -1) {
		alert('No Valor en la Devolucion')
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
	if (document.getElementById("credito").checked==false)
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
			document.getElementById("credito").checked=false;
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

	if(document.getElementById('marca').value < 1 || document.getElementById('tipo_producto').value < 1 || document.getElementById('combo_referncia').value < 1 || document.getElementById('peso').value < 1  || document.getElementById('cantidad').value=="" ) 
	{
		alert("Datos Incompletos")
		return false;
	}

	if(buscar_datos_total('cantidad')==false)
		return false;
		
	if(buscar_datos_total('valor_lista')==false)
		return false;
	

	if(document.getElementById("marca").value>0  && document.getElementById("tipo_producto").value > "" && document.getElementById('combo_referncia').value > 0 && document.getElementById('peso').value > 0 && document.getElementById("cantidad").value>0 ) 
	{
		Agregar_html_venta();						
		limpiar_combos();
		document.getElementById("codigo_fry").focus();
		return false;
	}
	
	else 
	{
		alert("Ingrese una Referencia Valida junto con los demas Valores")
		document.getElementById("codigo_fry").focus();
	}
}



function crear_descuento(div_caja,caja,val_uni,span_desc,boton_crear, div_guardar){
document.getElementById(boton_crear).style.display='none';
document.getElementById(div_guardar).style.display='inline';
document.getElementById(span_desc).style.display='none';
document.getElementById(div_caja).style.display='inline';
//crear_descuento(\"div_caja_desc_$jj\",\"caja_cant_desc_$jj\",\"$dbdatos_1->val_uni\",\"span_crear_desc_$jj\",\"boton_desc_$jj\")
}

function guardar_descuento(div_caja,caja,val_uni,span_desc,boton_crear, div_guardar,cant_ori,letrero_span,descuento_anterior){

	var total_total=parseInt(document.getElementById(caja).value) +  parseInt(document.getElementById(descuento_anterior).value );
	
	if ( parseInt(document.getElementById(cant_ori).value) < parseInt(total_total)    ){
		alert('Cantidad No permitida, Verifique')
		return false;
}

document.getElementById("todocompra").value = parseInt(document.getElementById("todocompra").value) - parseInt((val_uni * document.getElementById(letrero_span).value) );
document.getElementById(boton_crear).style.display='inline';
document.getElementById(div_guardar).style.display='none';
document.getElementById(span_desc).style.display='inline';
document.getElementById(div_caja).style.display='none';
document.getElementById(letrero_span).value=document.getElementById(caja).value;

document.getElementById("todocompra").value = parseInt(document.getElementById("todocompra").value) + parseInt((val_uni * document.getElementById(letrero_span).value));
}


</script>

<script type="text/javascript" src="js/js.js"></script>
<link href="css/stylesforms.css" rel="stylesheet" type="text/css" />
<link href="css/styles2.css" rel="stylesheet" type="text/css" />
<link href="informes/styles.css" rel="stylesheet" type="text/css" />
</head>
<body <?=$sis?>>
<div id="total">
<form  name="forma" id="forma" action="man_devolucion.php"  method="post">
<table width="750" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
   <td bgcolor="#E9E9E9" >
   <table width="100%" height="30" border="0" cellspacing="0" cellpadding="0" align="center" > 
      <tr>
        <td width="5" height="30">&nbsp;</td>
        <td width="20" >
	<?	if($valor_Abono<1) { ?>
		<img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0" onClick="cambio_guardar()" style="cursor:pointer"/>
		<?  } ?>
		</td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"><a href="con_cargue.php?confirmacion=0&editar=<?=$editar?>&insertar=<?=$insertar?>&eliminar=<?=$eliminar?>"><img src="imagenes/iconolupa.gif" alt="Buscar" width="16" height="16" border="0" /></a></td>
        <td width="70" class="ctablaform">Consultar</td>
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
        <td width="275" class="subtitulosproductos"><?=$fecha_venta?>
          <input name="fecha_fac" id="fecha_fac" type="hidden" value="<?=$fecha_venta?>"  /></td>
        <td width="20" class="textorojo">*</td>
        <td width="77" class="textotabla1">Vendedor:</td>
        <td width="145"  class="subtitulosproductos">
		<?
		 echo $global[3];
		
		?>
		<input name="vendedor" id="vendedor" type="hidden" value="<?=$global[2]?>"></td>		 
        <td width="171" class="textorojo">&nbsp;</td>
       </tr>
	   <tr>
        <td width="62" class="textotabla1">Empresa:</td>
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
			<input name="numero_factura" id="numero_factura" type="hidden" value="<?=$num_factura?>" />
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
	
	$sql ="SELECT SUM(((SELECT SUM(total_pro) FROM d_factura WHERE cod_mfac=m_factura.cod_fac)- valor_abono )) AS cartera 
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
        <td width="77" class="textotabla1">&nbsp;</td>
        <td colspan="2"><div id="cupo" style="display:none">
          <span class="textotabla1">Cupo:<span class="textorojo">
          <input name="cupo_credito" id="cupo_credito" type="text" class="caja_resalte1"  readonly="-1"/>
          </span></span>		  </div>		  
		<span  id="div_credito" style="display:none" class="textoproductos1"> 
		$  <?=number_format($cupo_covinoc ,0,",",".")?>
		<input name="cupo_covinoc" type="hidden" id="cupo_covinoc"  value="<?=$cupo_covinoc?>" readonly="-1" align="right"/>
		</span></td>		 
        </tr>
	   <tr>
        <td colspan="7" class="textotabla1" >
		<table  width="100%" border="1">
		      
		  <tr >
		  <td width="4%">
			  <table width="100%">
				<tr id="fila_0">
				
				<td width="20%"  class="ctablasup">Referencia</td>
				<td width="13%"  class="ctablasup">Codigo</td>
				<td width="9%"   class="ctablasup">Talla</td>
				<td width="10%"  class="ctablasup">Cantidad</td>
				<td width="7%"  class="ctablasup">Valor</td>
				<td width="13%"   class="ctablasup">Opcion</td>
				<td width="21%"    class="ctablasup">Cantidad Dev. </td>
				
				</tr>
				<?
				if ($codigo!="") { // BUSCAR DATOS
					 $sql =" select * from d_factura left join tipo_producto on d_factura.cod_tpro=tipo_producto.cod_tpro
left join marca on d_factura.cod_cat=marca.cod_mar left join peso on d_factura.cod_peso= peso.cod_pes left join producto  on d_factura.cod_pro= producto.cod_pro where cod_mfac =$codigo order by cod_dfac ";//=		
					$dbdatos_1= new  Database();
					$dbdatos_1->query($sql);
					$jj=1;
					//echo "<table width='100%'>";
					
					//busca el valor ya descontado en la devolucion
					$dbdatos_buscar= new  Database();
					//busca el valor ya descontado en la devolucion
					
					while($dbdatos_1->next_row()){ 
						echo "<tr id='fila_$jj'>";
						
						//referencia
						echo "<td > 
						<INPUT type='hidden'  name='codigo_mfac_$jj' id='codigo_mfac_$jj' value='$codigo'> 
						<INPUT type='hidden'  name='codigo_det_fac_$jj' id='codigo_det_fac_$jj' value='$dbdatos_1->cod_dfac'> 
						<INPUT type='hidden'  name='codigo_referencia_$jj'  id='codigo_referencia_$jj' value='$dbdatos_1->cod_pro'>
						<span  class='textfield01'> $dbdatos_1->nom_pro </span> </td>";
						
						//% codigo barra
						echo "<td ><span  class='textfield01'> $dbdatos_1->cod_fry_pro </span> </td>";
						
						//talla
						echo "<td>
						<INPUT type='hidden'  name='codigo_peso_$jj' id='codigo_peso_$jj' value='$dbdatos_1->cod_peso'>
						<span  class='textfield01'> $dbdatos_1->nom_pes </span> </td>";
						
						//cantidad
						echo "<td align='right'>
						<INPUT type='hidden'  name='cantidad_ref_$jj'  id='cantidad_ref_$jj' value='$dbdatos_1->cant_pro'>
						<span  class='textfield01'>".number_format($dbdatos_1->cant_pro ,0,",",".")."  </span> </td>";	
						
						//costo
						echo "<td align='right'>
						<INPUT type='hidden'  name='costo_ref_$jj' id='costo_ref_$jj' value='$dbdatos_1->val_uni'>
						<span  class='textfield01'>".number_format($dbdatos_1->total_pro ,0,",",".")."  </span> </td>";	
						
						echo "<td>
						<div align='center'>	
<INPUT type='button' class='botones' value='Descontar' id='boton_desc_$jj' onclick='crear_descuento(\"div_caja_desc_$jj\",\"caja_cant_desc_$jj\",\"$dbdatos_1->val_uni\",\"span_crear_desc_$jj\",\"boton_desc_$jj\",\"div_actua_$jj\" );'>
						</div>
						
						<div align='center' style='display:none' id='div_actua_$jj'>	
<INPUT type='button' class='botones' value='Actualizar' id='boton_actua_$jj' onclick='guardar_descuento(\"div_caja_desc_$jj\",\"caja_cant_desc_$jj\",\"$dbdatos_1->val_uni\",\"span_crear_desc_$jj\",\"boton_desc_$jj\",\"div_actua_$jj\" ,\"cantidad_ref_$jj\" ,\"valor_span_$jj\" ,\"canti_original_devuelta_ref_$jj\" );'> 
						</div>
						</td>";
						
						//cajita para el descuento
						if($var_edicion==1) {
							$sql="select cant_ddev from d_devolucion where cod_mfac_dev=$codigo  and cod_dfac_dev=$dbdatos_1->cod_dfac  and cod_prod_ddev=$dbdatos_1->cod_pro and  cod_pes_ddev=$dbdatos_1->cod_peso ";
							$dbdatos_edi->query($sql);		
							if($dbdatos_edi->next_row()){
								$valor_cantidad_dev=$dbdatos_edi->cant_ddev;	
							}
							
						}
						else  {
							$valor_cantidad_dev =0;
						}
					
						echo "<td>
								<table width='100%'>
									<tr>
										<td >
										 	<div style='display:none' id='div_caja_desc_$jj'>
										 		<input name='caja_cant_desc_$jj' id='caja_cant_desc_$jj' type='text' class='textfield01'  value='$valor_cantidad_dev'   onkeypress='return validaInt(this)' />
										 	</div>
										 </td>
										 <td  style='display:inline'>
										 	<div id='span_crear_desc_$jj' >
											<input name='valor_span_$jj' id='valor_span_$jj' type='text' class='botones'  value='$valor_cantidad_dev' readonly='-1'/>
											<INPUT type='hidden'  name='canti_original_devuelta_ref_$jj' id='canti_original_devuelta_ref_$jj'  value='$valor_cantidad_dev'  >
											</div>
										 </td>
									</tr>
								</table>
						 </td>";
						 
						//boton q quita la fila
						echo "</tr>";
						$jj++;
					}
				}
				?>
				</table>			</td>
			</tr>			
		 <tr >
		  <td>
			  <table width="100%">
				<tr >
				<td  class="ctablasup"><div align="left">Observaciones:</div></td>
				<td  class="ctablasup"><div align="right">Resumen Venta </div></td>
				</tr>
				<tr >
				<td width="47%" ><div align="left" >
				  <textarea name="observaciones" cols="45" rows="3" class="textfield02"><?=$obs?></textarea>
				</div>				  </td>
				<td width="53%" ><div align="right"><span class="ctablasup">Total  Descuento:</span>
 <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1"  value="<? if (empty($total_devolucion)) echo "0"; else echo $total_devolucion; ?> "/>
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
