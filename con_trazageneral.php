<? include("lib/database.php")?>
<? include("js/funciones.php")?>

<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript" src="calendario/javascript/calendar.js"></script>
<script type="text/javascript" src="calendario/javascript/calendar-es.js"></script>
<script type="text/javascript" src="calendario/javascript/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="calendario/styles/calendar-win2k-cold-1.css" title="win2k-cold-1" />  <script src="utilidades.js" type="text/javascript"> </script>
<title><?=$nombre_aplicacion?></title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function abrir() {		


	var cod_categoria= document.getElementById('marca').value;	
	var cod_tipo= document.getElementById('tipo_producto').value;	
	var cod_talla= document.getElementById('peso').value;	
	
	var producto= document.getElementById('producto').value;	
	
	//alert(producto)
	///return false;
	var fecha_ini= document.getElementById('fec_ini').value;	
	var fecha_fin= document.getElementById('fec_fin').value;	
	var ruta=  ' '+cod_categoria+'&cod_categoria='+cod_categoria+'&tipo_producto='+cod_tipo+'&peso='+cod_talla+'&producto='+producto+'&fecha_ini='+fecha_ini+'&fecha_fin='+fecha_fin;
	//alert(ruta)
	imprimir_inf("inf_traza_total.php?",ruta,'mediano');
	

}

</script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
 <link href="css/styles.css" rel="stylesheet" type="text/css">
 
</head>
<body  <?=$sis?> >

<table width="769" align="center">
<tr>
<td valign="top" >
<form id="forma_total" name="forma_total" method="post" action="formatos/ver_traza.php">
                  <table width="729" border="0" cellspacing="0" cellpadding="0" align="center" >
                    
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                    
                    <tr>
                      <td><img src="imagenes/lineasup2.gif" width="624" height="4" /></td>
                    </tr>
        </table>
                  <table width="480" border="0" align="center">
                    <tr>
                     <td width="275"  class="ctablasup" ><div align="left">CATEGORIA</div></td>
                      <td width="195"><? combo_evento("marca","marca","cod_mar"," nom_mar ",$dbdatos->cod_mar_pro,"", "nom_mar"); ?></td>
                    </tr>
                    <tr>
                      <td width="275"  class="ctablasup" ><div align="left">TIPO PRODUCTO </div></td>
                      <td><? combo_evento("tipo_producto","tipo_producto","cod_tpro"," nom_tpro ",$dbdatos->cod_tpro_pro,"", "nom_tpro"); ?></td>
                    </tr>
                    <tr>
                      <td width="275"  class="ctablasup" ><div align="left">PRODUCTO</div></td>
                      <td><? 
			  
		    $sql=" select *, concat( cod_fry_pro, ' - ', nom_pro ) as nom_pro  from producto order by cod_fry_pro asc";
			combo_sql("producto","producto","cod_pro","nom_pro",$dbdatos->cod_bod,$sql); 
			  
			//  combo_evento("peso","peso","cod_pes","nom_pes"," "," ", "nom_pes"); 
			  ?></td>
                    </tr>
                    <tr>
                      <td width="275"  class="ctablasup" ><div align="left">TALLA</div></td>
                      <td><? combo_evento("peso","peso","cod_pes","nom_pes"," "," ", "nom_pes"); ?></td>
                    </tr>
                    <tr>
                      <td width="275"  class="ctablasup" ><div align="left">FECHA INICIAL</div></td>
                      <td><span class="ctablablanc">
                        <input name="fecha" type="text" class="textotabla01" id="fec_ini" readonly="1"  />
                      </span><span class="ctablablanc"><img src="imagenes/date.png" alt="Calendario" name="imageField" width="16" height="16" border="0" id="imageField" style="cursor:pointer"/></span></td>
                    </tr>
                    <tr>
                      <td width="275"  class="ctablasup" ><div align="left">TALLA</div></td>
                      <td><input name="fec_fin" type="text" class="textotabla01" id="fec_fin" readonly="1"  />
                          <img src="imagenes/date.png" alt="Calendario" name="imageField1" width="16" height="16" border="0" id="imageField1" style="cursor:pointer"/></td>
                    </tr>
					
					<tr>
                      <td colspan="2"><div align="center"><img src='imagenes/mirar.png' alt="." width='16' height='16'  style="cursor:pointer"  onclick="abrir()" /></div></td>
                    </tr>
                  </table>
        <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
</form>
</td>
</tr>
</table>	
				
<form name="forma" method="post" action="con_traza_general.php">
  <input type="hidden" name="editar" id="editar" value="<?=$editar?>">
  <input type="hidden" name="insertar" id="insertar" value="<?=$insertar?>">
  <input type="hidden" name="eliminar" id="eliminar" value="<?=$eliminar?>">
  <input type="hidden" name="cant_pag"  id="cant_pag" value="<?=$cant_pag?>">
  <input type="hidden" name="act_pag"  id="act_pag" value="<? if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">
  <input type="hidden" name="busquedas" id="busquedas" value="<?=$busquedas?>">
   <input type="hidden" name="eliminacion" id="eliminacion" >
    <input type="hidden" name="eli_codigo" id="eli_codigo" >
</form>

    <script type="text/javascript">
Calendar.setup(
	{
	inputField  : "fec_ini",      // ID of the input field
	ifFormat    : "%Y-%m-%d",    // the date format
	button      : "imageField" ,   // ID of the button
	//align       :"T2",
	singleClick :true
	}
);

Calendar.setup(
	{
	inputField  : "fec_fin",      // ID of the input field
	ifFormat    : "%Y-%m-%d",    // the date format
	button      : "imageField1" ,   // ID of the button
	//align       :"T2",
	singleClick :true
	}
);
</script>


</body>

</html>



