<?
include "../lib/sesion.php";
include("../lib/database.php");
include("../conf/clave.php");				
	$db = new Database();
	$db_ver = new Database();
	$sql = "select *, DATE_ADD(fecha ,interval 1 month) as fac_fecha_vence   from m_remision where cod_fac=$codigo";
	$db_ver->query($sql);	
	if($db_ver->next_row())
	{ 
		$rem_fac=$db_ver->rem_fac;
		$cod_razon=$db_ver->cod_razon_fac;
		$fac_numero=$db_ver->num_fac;
		$fac_fecha=$db_ver->fecha;
		$tipo_fac=$db_ver->tipo_fac;
		$codigo_bod=$db_ver->bod_cli_fac;
		$codigo_cli=$db_ver->cod_cli;
		$codigo_razon=$db_ver->cod_razon_fac;
		$tipo_pago=$db_ver->tipo_pago;
		$fac_fecha_vence=$db_ver->fac_fecha_vence;
		$estado_factura=$db_ver->estado;
		$cod_usuario=$db_ver->cod_usu;
		$obs_fac =$db_ver->obs;
	}

$codigo_salida=$codigo_cli;
$db_fac = new Database();
$sql ='select * from rsocial where cod_rso='.$codigo_razon ;
$db_fac->query($sql);
if($db_fac->next_row()){ 
	$razon=$db_fac->nom_rso;
	$nit=$db_fac->nit_rso;
	$telefono=$db_fac->tel_rso;
	$direccion=$db_fac->dir_rso;
	$ciudad=$db_fac->ciu_razon;
	$leyenda=$db_fac->desc1_rso;
	//$leyenda2=$db_fac->desc2_rso;
	$logo=$db_fac->logo_rso;
	//$regimen = $db_fac->reg_rso;
	$obs_fac = $db_ver->obs;
}




?>
<script language="javascript">
function imprimir(){
	document.getElementById('imp').style.display="none";
	document.getElementById('cer').style.display="none";
	window.print();
}


</script>


<title>REMISION SALIDA</title>
<style type="text/css">
<!--
.Estilo1 {font-family: Arial, Helvetica, sans-serif}
.Estilo4 {font-size: 16px}
.Estilo17 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; }
.Estilo19 {font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo25 {font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo28 {font-size: 10px}
.Estilo30 {font-family: Arial, Helvetica, sans-serif; font-size: 8px; }
.Estilo32 {font-size: 10px}
.Estilo37 {font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.Estilo38 {font-size: 9px; }
-->
</style>

<?
if($estado_factura=="anulado")
	$anulacion="background='../imagenes/anulacion.gif'";
?>
<link href="styles1.css" rel="stylesheet" type="text/css" />
<TABLE border="0" cellpadding="2" cellspacing="0"  width="600" <?=$anulacion?> >
		
			<INPUT type="hidden" name="mapa" value="<?=$mapa?>">
			<INPUT type="hidden" name="id" value="<?=$id?>">


			<TR>
			  <TD width="126" align="center">
			  <? include("remision_cabezote1.php") ?>			 </TD>
			  <TD width="126" align="center"><? include("remision_cliente1.php") ?></TD>
	      </TR>
			<TR>
			  <TD colspan="2" align="center">&nbsp;</TD>
		  </TR>
			
			<TR>
			  <TD colspan="2" align="left"><table width="600" border="0"  id="select_tablas" >
                <tr >
                  <td width="2%" >&nbsp;</td>
                  <td width="52%" class="subtitulosproductos" >DESCRIPCION</td>
                  <td width="23%" ><div align="center" class="subtitulosproductos">CANT.</div></td>
                  <td colspan="2" ><div align="center" class="subtitulosproductos">VALOR UNITARIO </div></td>
				  <td colspan="2" ><div align="center" class="subtitulosproductos">TOTAL </div></td>
                </tr>
                <?
				$total=0;
				$sql = " select * from d_remision left join tipo_producto on d_remision.cod_tpro=tipo_producto.cod_tpro
left join marca on d_remision.cod_cat=marca.cod_mar left join peso on d_remision.cod_peso= peso.cod_pes left join producto  on d_remision.cod_pro= producto.cod_pro  WHERE cod_mfac= $codigo";
					$db->query($sql);
					$estilo="formsleo";
					while($db->next_row()){ 
						//$db->fec_ent;
						if($estilo=="formsleo")
							$estilo="formsleo1";
						else
							$estilo="formsleo";
				?>
                <tr id="fila_0"  >
                  <td >&nbsp;</td>
                  <td ><span class="textoproductos1"><? echo  substr($db->nom_pro,0,20)." - ".$db->nom_pes ; ?></span></td>
                  <td colspan="1" class="textotabla01" ><div align="right" class="Estilo37">
                      <div align="center">
                        <span class="textoproductos1">
                        <?=$db->cant_pro?>
                      </span></div>
                  </div></td>
				  <td width="12%" class="textotabla01"><div align="right" class="Estilo37">
                    <span class="textoproductos1">
                    <?=number_format($db->val_uni,2,".",".")?>
                  </span></div></td>
                  <td width="11%" class="textotabla01 Estilo38">&nbsp;</td>
                  <td width="12%" class="textotabla01"><div align="right" class="Estilo37">
                    <span class="textoproductos1">
                    <?=number_format($db->total_pro,2,".",".")?>
                  </span></div></td>
                  <td width="11%" class="textotabla01 Estilo38">&nbsp;</td>
                </tr>
                <?
				$total++;
				  } 
				  
				  $sql = "SELECT SUM(total_pro) as total FROM d_remision WHERE cod_mfac= $codigo";
			$db->query($sql);
			if($db->next_row()){ 
				$total = $db->total;
			}	
				  
				?>
                <tr id="fila_0"  >
                  <td colspan="2"  >&nbsp;</td>
                  <td colspan="1" class="textotabla01 Estilo38" >&nbsp;</td>
                  <td colspan="2" class="textotabla01"><div align="right" class="Estilo17"></div></td>
                </tr>
				
                <tr >
                  <td class="<?=$estilo?> Estilo1 Estilo4" >&nbsp;</td>  
                  <td class="<?=$estilo?> Estilo1 Estilo4" >&nbsp;</td>
                  <td class="Estilo1 <?=$estilo?> Estilo38" ><span class="subtitulosproductos">TOTAL REMISION SALIDA </span></td>
                  <td colspan="2" class="<?=$estilo?> Estilo1 Estilo4" ><div align="right" class="Estilo38">
                      <table  border="0">
                        <tr>
                          <td width="46"><div align="right" class="Estilo32" ><span class="textoproductos1">
                          <?=number_format($total,2,".",".")?>
                          </span></div></td>
                          <td width="25">&nbsp;</td>
                        </tr>
                      </table>
                  </div></td>
				</tr>  
				  
				<?
				
				if($regimen=="Comun") { 
				$base = $total / 1.16;
				$iva_reg=$total-  $base ;
				?>
				 <tr >
                  <td class="<?=$estilo?> Estilo1 Estilo4" >&nbsp;</td>  
                  <td class="<?=$estilo?> Estilo1 Estilo4" ><span class="textoproductos1"> BASE </span></td>
                  <td class="Estilo1 <?=$estilo?> Estilo38" >&nbsp;</td>
                  <td colspan="2" class="<?=$estilo?> Estilo1 Estilo4" ><div align="right" class="Estilo38">
                      <table  border="0">
                        <tr>
                          <td width="46"><div align="right" class="Estilo32" ><span class="textoproductos1">
                          <?=number_format($base,0,".",".")?>
                          </span></div></td>
                          <td width="25">&nbsp;</td>
                        </tr>
                      </table>
                  </div></td>
				</tr>  
				
				<tr >
                  <td class="<?=$estilo?> Estilo1 Estilo4" >&nbsp;</td>  
                  <td class="<?=$estilo?> Estilo1 Estilo4" ><span class="textoproductos1"> I.V.A. </span></td>
                  <td class="Estilo1 <?=$estilo?> Estilo38" >&nbsp;</td>
                  <td colspan="2" class="<?=$estilo?> Estilo1 Estilo4" ><div align="right" class="Estilo38">
                      <table  border="0">
                        <tr>
                          <td width="46"><div align="right" class="Estilo32" ><span class="textoproductos1">
                          <?=number_format($iva_reg,0,".",".")?>
                          </span></div></td>
                          <td width="25">&nbsp;</td>
                        </tr>
                      </table>
                  </div></td>
				</tr>   
				  
				 <? 
				 } 
				 ?>
				  
				  
				  
                  <?
			 $sql = "select * from usuario WHERE cod_usu= $cod_usuario";
			$db->query($sql);
			if($db->next_row()){ 
				$usuario = $db->nom_usu;
				$obs = $db->obs;
			}
			$sql = "SELECT SUM(total_pro) as total FROM d_remision WHERE cod_mfac= $codigo";
			$db->query($sql);
			if($db->next_row()){ 
				$total = $db->total;
			}	
				
			
			?>
                
              </table></TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center">             </TD>
		  </TR>
			<TR>
			  <TD colspan="2" align="center"><p></TD>
		  </TR>
		  

			<TR><TD colspan="2" align="left">
			
			<?
			if( !empty($obs_fac) ) {
			?>
			<table width="600" border="0" class="forms1">
              <tr>
                <td width="7" ></td>
                <td width="225" >
				<div align="justify" class="textoproductos1">Observaciones:<br> <?=$obs_fac?>
                      
                </div></td>
              </tr>
            </table>
			<p>
			  <?
			}
			?>
			</p>
			<table width="589" border="0" class="forms1">
			  <tr>
			    <td width="10"  align="justify" class="Estilo4"></td>
			    <td width="550"  align="justify" class="Estilo4"><div align="justify" class="Estilo30">
			      <?=$leyenda2?>
			      </div></td>
		      </tr>
			  </table>
			<p>&nbsp;</p>
			<table width="593" border="0" class="forms1">
              <tr>
                <td width="10" ></td>
                <td width="236" class="Estilo17" ><div align="justify" class="Estilo17 Estilo28"></div>                </td>
              </tr>
			   <tr>
                <td class="Estilo4" >&nbsp;</td>
                <td class="Estilo17" ><span class="Estilo25">Recibido Por: </span></td>
		      </tr>
              <tr>
                <td class="Estilo4" >&nbsp;</td>
                <td class="Estilo17" ><span class="Estilo25">Firma:_____________________</span></td>
              </tr>
              <tr>
                <td height="21" class="Estilo4" >&nbsp;</td>
                <td class="Estilo17" ><span class="Estilo25">Cedula:___________________</span></td>
              </tr>
            </table>
			<br /></TD>
		  </TR>
		  
		  
				<TR><TD colspan="2" align="center" class="Estilo4"><INPUT type="button" value="Imprimr" id="imp"  class="botones" onClick="imprimir()">
					<INPUT type="button" value="Cerrar"  id="cer"  class="botones" onClick="window.close()"></TD>
		  </TR>
</TABLE>
	