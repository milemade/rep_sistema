	<div id="solapa1" style="display:inline" >
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="121" class="textotabla1">Cuenta:</td>
        <td width="162"><input name="cuentaed" id="cuentaed" type="text" class="textfield2"  value="<?=$dbdatos->cuen_aco?>" />
          <span class="textorojo">*</span></td>
        <td width="10" class="textorojo">&nbsp;</td>
        <td width="119" class="textotabla1">Fecha:</td>
        <td width="196"><input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?=$dbdatos->fec_aco?>" />
            <img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/><span class="textorojo">*</span></td>
        <td width="10" class="textorojo">&nbsp;</td>
        <td width="17" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Nombre Edificio :</td>
        <td><input name="nom_edificio" id="nom_edificio" type="text" class="textfield2"  value="<?=$dbdatos->nom_edi_aco?>" /></td>
         <td class="textorojo">&nbsp;</td>
        <td class="textotabla1">Estado Visita :</td>
        <td><select name="estado"  class='SELECT'>
		 <? if($dbdatos->estado_aco=="Nueva") { ?> <option value="Nueva" selected="selected">Nueva</option> 
		 <? } else {?> <option value="Nueva">Nueva</option>  <? }?>
		<? if($dbdatos->estado_aco=="Replanteada") { ?><option value="Replanteada" selected="selected">Replanteada</option>
		 <? } else  { ?> <option value="Replanteada">Replanteada</option> <? }?>
        </select>        </td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" class="textotabla1">Direccion :</td>
        <td><input name="direccion" id="direccion" type="text" class="textfield2"  value="<?=$dbdatos->dir_aco?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">COM:</td>
        <td><input name="com" id="com" type="text" class="textfield2"  value="<?=$dbdatos->com_aco?>" /></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Barrio:</td>
        <td><input name="barrio" id="barrio" type="text" class="textfield2"  value="<?=$dbdatos->barr_aco?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Estrato:</td>
        <td><select name="estrato"  class='SELECT'>
		<? if($dbdatos->estra_aco>1 && $dbdatos->estra_aco<7) { ?>
			<option value="<?=$dbdatos->estra_aco?>" selected="selected"><?=$dbdatos->estra_aco?></option>
		<? } ?>
          <option value="6">6</option>
          <option value="5">5</option>
          <option value="4">4</option>
          <option value="3">3</option>
          <option value="2">2</option>
          <option value="1">1</option>
          </select></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">N&deg; Bloq/Torres: </td>
        <td><input name="num_torres" id="num_torres" type="text" class="textfield2"  value="<?=$dbdatos->num_bloq_aco?>" /></td>
        <td>&nbsp;</td>
        <td colspan="2" class="textotabla1">
		   Aptos <? if ($dbdatos->tip_lugar_aco=="Aptos") {?> <input name="tipo_lugar" type="radio" value="Aptos"  checked="checked"/> <? } else {?><input name="tipo_lugar" type="radio" value="Aptos"/> <? }?>
		   Casas <? if ($dbdatos->tip_lugar_aco=="Casas") {?> <input name="tipo_lugar" type="radio" value="Casas"  checked="checked"/> <? } else {?><input name="tipo_lugar" type="radio" value="Casas"/> <? }?>          
		   Oficina <? if ($dbdatos->tip_lugar_aco=="Oficina") {?> <input name="tipo_lugar" type="radio" value="Oficina"  checked="checked"/> <? } else {?><input name="tipo_lugar" type="radio" value="Oficina"/> <? }?>          
		   Local <? if ($dbdatos->tip_lugar_aco=="Local") {?> <input name="tipo_lugar" type="radio" value="Local"  checked="checked"/> <? } else {?><input name="tipo_lugar" type="radio" value="Local"/> 
		   <? }?>Cant:
		   <input name="catidad" type="text" class="textfield0010" id="catidad"  value="<?=$dbdatos->cant_lugar_aco?>" size="4" maxlength="2" />
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Producto</td>
        <td class="textotabla1"><? combo("producto","producto","cod_pro","nom_pro",$dbdatos->cod_pro_aco); ?></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Horario de Trabajo: </td>
        <td><input name="horario" id="horario" type="text" class="textfield2"  value="<?=$dbdatos->horario_aco?>" /></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Constructora:</td>
        <td><input name="contructora" id="contructora" type="text" class="textfield2"  value="<?=$dbdatos->contruc_aco?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Cia Administradora:</td>
        <td><input name="cia_admin" id="cia_admin" type="text" class="textfield2"  value="<?=$dbdatos->cia_admin_aco?>" /></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Administrador:</td>
        <td><input name="administrador" id="administrador" type="text" class="textfield2"  value="<?=$dbdatos->administrador_aco?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Tel Administracion: </td>
        <td><input name="tel_admin" id="tel_admin" type="text" class="textfield2"  value="<?=$dbdatos->tel_admin_aco?>" /></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Tel Porteria: </td>
        <td><input name="tel_proteria" id="tel_proteria" type="text" class="textfield2"  value="<?=$dbdatos->tel_porte_aco?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">Observaciones:</td>
        <td rowspan="3"><textarea name="observaciones" cols="35" rows="4" class="textfield02"><?=$dbdatos->obs_edi_aco?></textarea></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Planta Elec. </td>
        <td><input name="planta_elec" id="planta_elec" type="text" class="textfield2"  value="<?=$dbdatos->plan_elec_aco?>" /></td>
        <td>&nbsp;</td>
        <td class="textotabla1">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="textotabla1">&nbsp;</td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
    </table>
	</div>
	<div id="solapa2" style="display:none" >
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="7" class="textotabla1"><div align="center"><strong>CAJAS</strong></div></td>
        </tr>
      <tr>
        <td width="146" class="textotabla1">
          <div align="right">
            <input name="com1_0" type="text" class="textfiel_caja" id="com1_0"  value="<?=$dbdatos->com_ava?>"  />
            </div></td>
        <td width="17" class="textotabla1"> <div align="center"><strong>AL </strong></div></td>
        <td width="108" class="textorojo"><input name="com1_1" type="text" class="textfiel_caja" id="com1_1"  value="<?=$dbdatos->com_ava?>" size="15"  /></td>
        <td width="144" class="textotabla1"><div align="right">
            <input name="com6_0" type="text" class="textfiel_caja" id="com6_0"  value="<?=$dbdatos->com_ava?>">
        </div></td>
        <td width="19"class="textotabla1"> <div align="center"><strong>AL</strong></div></td>
        <td width="183" class="textorojo"><input name="com6_1" type="text" class="textfiel_caja" id="com6_1"  value="<?=$dbdatos->com_ava?>"></td>
        <td width="12" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" class="textotabla1"><div align="right">
          <input name="com2_0" type="text" class="textfiel_caja" id="com2_0"  value="<?=$dbdatos->com_ava?>" />
        </div></td>
        <td class="textotabla1"><div align="center"><strong>AL</strong></div></td>
        <td><span class="textorojo">
          <input name="com2_1" type="text" class="textfiel_caja" id="com2_1"  value="<?=$dbdatos->com_ava?>"  size="15"  />
        </span></td>
        <td class="textotabla1"><div align="right">
            <input name="com7_0" type="text" class="textfiel_caja" id="com7_1"  value="<?=$dbdatos->com_ava?>" />
        </div></td>
        <td class="textotabla1"> <div align="center"><strong>AL</strong></div></td>
        <td><span class="textorojo">
          <input name="com2322" type="text" class="textfiel_caja" id="com2322"  value="<?=$dbdatos->com_ava?>">
        </span></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1"><div align="right">
          <input name="com3_0" type="text" class="textfiel_caja" id="com3_0"  value="<?=$dbdatos->com_ava?>"  />
        </div></td>
        <td class="textotabla1"><div align="center"><strong>AL</strong></div></td>
        <td><span class="textorojo">
          <input name="com3_1" type="text" class="textfiel_caja" id="com3_1"  value="<?=$dbdatos->com_ava?>"  size="15"  />
        </span></td>
        <td class="textotabla1"><div align="right">
            <input name="com8_0" type="text" class="textfiel_caja" id="com8_1"  value="<?=$dbdatos->com_ava?>">
        </div></td>
        <td class="textotabla1"> <div align="center"><strong>AL</strong></div></td>
        <td><span class="textorojo">
          <input name="com2323" type="text" class="textfiel_caja" id="com2323"  value="<?=$dbdatos->com_ava?>">
        </span></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1"><div align="right">
          <input name="com4_0" type="text" class="textfiel_caja" id="com4_1"  value="<?=$dbdatos->com_ava?>"  />
        </div></td>
        <td class="textotabla1"><div align="center"><strong>AL</strong></div></td>
        <td><span class="textorojo">
          <input name="com2324" type="text" class="textfiel_caja" id="com2324"  value="<?=$dbdatos->com_ava?>"   size="15" />
        </span></td>
        <td class="textotabla1"><div align="right">
            <input name="com9_0" type="text" class="textfiel_caja" id="com9_1"  value="<?=$dbdatos->com_ava?>">
        </div></td>
        <td  class="textotabla1"> <div align="center"><strong>AL</strong></div></td>
        <td><span class="textorojo">
          <input name="com9_1" type="text" class="textfiel_caja" id="com9_1"  value="<?=$dbdatos->com_ava?>">
        </span></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      
      <tr>
        <td class="textotabla1"><div align="right">
          <input name="com5_0" type="text" class="textfiel_caja" id="com5_0"  value="<?=$dbdatos->com_ava?>"  />
        </div></td>
        <td class="textotabla1"><div align="center"><strong>AL</strong></div></td>
        <td><span class="textorojo">
          <input name="com5_1" type="text" class="textfiel_caja" id="com5_1"  value="<?=$dbdatos->com_ava?>"   size="15" />
        </span></td>
        <td class="textotabla1"><div align="right">
            <input name="com10_0" type="text" class="textfiel_caja" id="com10_0"  value="<?=$dbdatos->com_ava?>">
        </div></td>
        <td class="textotabla1"> <div align="center"><strong>AL</strong></div></td>
        <td><span class="textorojo">
          <input name="com10_1" type="text" class="textfiel_caja" id="com10_1"  value="<?=$dbdatos->com_ava?>">
        </span></td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1"><div align="right">Observaiones:</div></td>
        <td colspan="5" rowspan="3" class="textotabla1">
		<textarea name="obscaja"  id="obscaja" cols="75" rows="4" class="textfield02"><?=$dbdatos->obs_caja?></textarea></td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
    </table>
	</div>
	
	<div id="solapa3" style="display:none" >
		<table border="1" cellspacing="0" bordercolor="#FF9933">
	<tr> <td>
	<table width="629" align="center" cellpadding="0" cellspacing="0"  >
      <tr>
        <td colspan="5" class="textotabla1"><div align="center"><strong>PARTE INTERNA </strong></div></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td width="75" rowspan="3" class="textotabla1">Punto Inicial: </td>
        <td width="197" rowspan="3"><span class="textotabla1">
          <textarea name="punto_inicial" id="punto_inicial" cols="30" rows="4" class="textfield02"><?=$dbdatos->int_inicial_aco?></textarea>
        </span></td>
        <td width="116" class="textotabla1"><div align="center">Instalacion</div></td>
        <td width="84" class="textotabla1"><div align="center">Canalizacion</div></td>
        <td width="144" class="textotabla1"><div align="center">Informante</div></td>
        <td width="5" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1"><div align="right">Aerea
            <input type="checkbox" name="aerea" value="checkbox"   <? if($dbdatos->int_aerea_aco==1) { echo "checked='checked'"; } ?> />
        </div></td>
        <td class="textotabla1"><div align="right">Conjunto
            <input type="checkbox" name="conjunto" value="checkbox" <? if($dbdatos->int_conj_aco==1) { echo "checked='checked'"; } ?> />
        </div></td>
        <td><input name="informante" id="informante" type="text" class="textfield2"  value="<?=$dbdatos->int_infor_aco?>" /></td>
        <td rowspan="2" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1"><div align="right">Subterranea
          <input type="checkbox" name="subterranea" value="checkbox" <? if($dbdatos->int_subte_aco==1) { echo "checked='checked'"; } ?> />
        </div></td>
        <td class="textotabla1"><div align="right">Codensa
            <input type="checkbox" name="codensa" value="checkbox"   <? if($dbdatos->int_codensa_aco==1) { echo "checked='checked'"; } ?> />
        </div></td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td height="22" class="textotabla1">Descripcion:</td>
        <td colspan="4" rowspan="2"><span class="textotabla1">
          <textarea name="textarea" cols="86" rows="2" class="textfield02"><?=$dbdatos->obs_ava?></textarea>
        </span></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" class="textotabla1">Tiempo de Costruccion: 
          <input name="tel_admin3" id="tel_admin3" type="text" class="textfield2"  value="<?=$dbdatos->tel_admon_ava?>" />
          &nbsp; &nbsp; &nbsp;Costo Acometida: 
          <input name="tel_admin32" id="tel_admin32" type="text" class="textfield2"  value="<?=$dbdatos->tel_admon_ava?>" /></td>
        <td >&nbsp;</td>
      </tr>
    </table>
	</td></tr></table>
	
		<table border="1" cellspacing="0" bordercolor="#FF9933">
	<tr> <td>
	<table width="629" align="center" cellpadding="0" cellspacing="0"  >
      <tr>
        <td colspan="2" class="textotabla1"><div align="center"><strong>PARTE EXTERNA </strong></div></td>
        <td width="5" class="textorojo">&nbsp;</td>
      </tr>
      
      <tr>
        <td width="75" class="textotabla1">Descripcion</td>
        <td><span class="textotabla1">
          <textarea name="desc_ext" cols="86" rows="2" class="textfield02"><?=$dbdatos->ext_desc_aco?></textarea>
        </span></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      
      
      <tr>
        <td colspan="2" class="textotabla1">Tiempo de Costruccion: 
          <input name="tiempo_ext" id="tiempo_ext" type="text" class="textfield2"  value="<?=$dbdatos->ext_tiempo_aco?>" />
          &nbsp; &nbsp; &nbsp;Costo Acometida: 
          <input name="costo_ext" id="costo_ext" type="text" class="textfield2"  value="<?=$dbdatos->ext_valor_aco?>" /></td>
        <td >&nbsp;</td>
      </tr>
    </table>
	</td></tr></table>
	
		<table border="1" cellspacing="0" bordercolor="#FF9933">
	<tr> <td>
	<table width="629" align="center" cellpadding="0" cellspacing="0"  >
      <tr>
        <td colspan="5" class="textotabla1"><div align="center"><strong>RED INTERNA </strong></div></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td width="87" class="textotabla1">Ubicacion: </td>
        <td width="179"><input name="red_ubicacion_aco" id="red_ubicacion_aco" type="text" class="textfield2"  value="<?=$dbdatos->red_ubicacion_aco?>" /></td>
        <td width="179" class="textotabla1">&nbsp;</td>
        <td width="179" class="textotabla1">&nbsp;</td>
        <td width="179" class="textotabla1">&nbsp;</td>
        <td width="6" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td width="87" class="textotabla1">Alimentacion:</td>
        <td width="179"><input name="red_alimenta_aco" id="red_alimenta_aco" type="text" class="textfield2"  value="<?=$dbdatos->red_alimenta_aco?>" /></td>
        <td class="textotabla1">Voltaje:</td>
        <td class="textotabla1"><input name="red_voltaje_aco" id="red_voltaje_aco" type="text" class="textfield2"  value="<?=$dbdatos->tel_admon_ava?>" /></td>
        <td>&nbsp;</td>
        <td rowspan="3" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Distribucion:</td>
        <td colspan="4" class="textotabla1" >Ducteria
          <input type="checkbox" name="red_ducto_aco" value="checkbox" <? if($dbdatos->red_ducto_aco==1) echo "checked='checked'";?> />
          Respiradores
          <input type="checkbox" name="red_respi_aco" value="checkbox" <? if($dbdatos->red_respi_aco==1) echo "checked='checked'";?> />
          Cable Externo
          <input type="checkbox" name="red_cable_ext_aco" value="checkbox" <? if($dbdatos->red_cable_ext_aco==1) echo "checked='checked'";?>/>
          Foso Ascensor
          <input type="checkbox" name="red_asensor_aco" value="checkbox" <? if($dbdatos->red_asensor_aco==1) echo "checked='checked'";?>/>
          Otros
          <input type="checkbox" name="red_otros_aco" value="checkbox" <? if($dbdatos->red_otros_aco==1) echo "checked='checked'";?>/></td>
        </tr>
      <tr>
        <td width="87" class="textotabla1">Costo Cableado Edificio: </td>
        <td colspan="4" class="textotabla1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>N&deg; Aptos </td>
            <td>Costo</td>
            <td>Primer Punto </td>
            <td>Adicional</td>
            <td>Total Puntos </td>
            <td>Costo Total </td>
          </tr>
          <tr>
            <td><input name="red_aptos1_aco" id="red_aptos1_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_aptos1_aco?>" /></td>
            <td><input name="red_costos1_aco" id="red_costos1_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_costos1_aco?>" /></td>
            <td><input name="red_pri_pun1_aco" id="red_pri_pun1_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_pri_pun1_aco?>" /></td>
            <td><input name="red_adici1_aco" id="red_adici1_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_adici1_aco?>" /></td>
            <td><input name="red_tot_punt1_aco" id="red_tot_punt1_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_tot_punt1_aco?>" /></td>
            <td><input name="red_cos_tot1_aco" id="red_cos_tot1_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_cos_tot1_aco?>" /></td>
          </tr>
		   <tr>
            <td><input name="red_aptos2_aco" id="red_aptos2_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_aptos2_aco?>" /></td>
            <td><input name="red_costos2_aco" id="red_costos2_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_costos2_aco?>" /></td>
            <td><input name="red_pri_pun2_aco" id="red_pri_pun2_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_pri_pun2_aco?>" /></td>
            <td><input name="red_adici2_aco" id="red_adici2_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_adici2_aco?>" /></td>
            <td><input name="red_tot_punt2_aco" id="red_tot_punt2_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_tot_punt2_aco?>" /></td>
			 <td><input name="red_cos_tot2_aco" id="red_cos_tot2_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->red_cos_tot2_aco?>" /></td>
          </tr>
        </table></td>
        </tr>
    </table>
	</td></tr></table>

		<table border="1" cellspacing="0" bordercolor="#FF9933">
      <tr>
        <td><table width="629" align="center" cellpadding="0" cellspacing="0"  >
            <tr>
              <td colspan="2" class="textotabla1"><div align="center"><strong>ACONDICIONAMIENTOS </strong></div></td>
              <td width="5" class="textorojo">&nbsp;</td>
            </tr>
            <tr>
              <td width="75" class="textotabla1">Descripcion</td>
              <td><span class="textotabla1">
                <textarea name="aco_desc_aco" cols="86" rows="2" class="textfield02"><?=$dbdatos->aco_desc_aco?></textarea>
              </span></td>
              <td class="textorojo">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" class="textotabla1">Tiempo de Costruccion:
                <input name="aco_tiem_aco" id="aco_tiem_aco" type="text" class="textfield2"  value="<?=$dbdatos->aco_tiem_aco?>" />
                 &nbsp;Costo Acondicionamientos:
                <input name="aco_cost_aco" id="aco_cost_aco" type="text" class="textfield2"  value="<?=$dbdatos->aco_cost_aco?>" /></td>
              <td >&nbsp;</td>
            </tr>
        </table></td>
      </tr>
	  </table>
	  
	  <div>
	  <div id="solapa4" style="display:none" >
	<table border="1" cellspacing="0" bordercolor="#666666">
      <tr>
        <td><table width="629" align="center" cellpadding="0" cellspacing="0"  >
            <tr>
              <td colspan="2" class="textotabla1"><div align="center"><strong>AUTORIZACION ADMNISTRACION </strong></div></td>
              <td width="5" class="textorojo">&nbsp;</td>
            </tr>
            <tr>
              <td width="211" class="textotabla1">Fecha: 
                <input name="aut_fecha_aco" type="text" class="fecha" id="aut_fecha_aco" readonly="1" value="<?=$dbdatos->aut_fecha_aco?>" />
                <img src="imagenes/date.png" alt="Calendario" name="calendario1" width="16" height="16" border="0" id="calendario1" style="cursor:pointer"/></td>
              <td width="411" class="textotabla1">Nombre:<span class="textotabla1">
                <input name="aut_nom_aco" type="text" class="fecha" id="aut_nom_aco" value="<?=$dbdatos->aut_nom_aco?>" />
              </span class="textotabla1"> Telefono <span class="textotabla1">
              <input name="aut_tel_aco" type="text" class="fecha" id="aut_tel_aco"  value="<?=$dbdatos->aut_tel_aco?>" />
              </span></td>
              <td class="textorojo">&nbsp;</td>
            </tr>
            
        </table></td>
      </tr>
    </table>
	<table border="1" cellspacing="0" bordercolor="#666666">
      <tr>
        <td><table width="629" align="center" cellpadding="0" cellspacing="0"  >
            <tr>
              <td colspan="3" class="textotabla1"><div align="center"><strong>INFORMACION TECNICOS </strong></div></td>
              </tr>

            <tr>
              <td width="154" class="textotabla1"><div align="center">Tecnico </div></td>
              <td width="235" class="textotabla1"><div align="center">Acompa&ntilde;o Visita </div></td>
              <td width="238" class="textotabla1"><div align="center">Referencia</div></td>
            </tr>
            <tr>
              <td class="textotabla1"><div align="center">
                <? combo("producto","producto","cod_pro","nom_pro",$dbdatos->inf_tec_tec_aco); ?>
              </div></td>
              <td class="textotabla1"><div align="center">
                <? combo("producto","producto","cod_pro","nom_pro",$dbdatos->inf_tec_acom_aco ); ?>
              </div></td>
              <td class="textotabla1"><div align="center">
                <input name="tel_admin22222" id="tel_admin22222" type="text" class="textfield2"  value="<?=$dbdatos->inf_tec_ref_aco?>" />
              </div></td>
            </tr>
        </table></td>
      </tr>
	  </table>
	<table  border="1" cellspacing="0" bordercolor="#666666">
      <tr>
        <td><table  align="center" cellpadding="0" cellspacing="0"  >
            <tr>
              <td colspan="5" class="textotabla1"><div align="center"><strong>INFORMACION COMERCIAL </strong></div></td>
            </tr>
            <tr>
              <td class="textotabla1">Responsable</td>
              <td class="textotabla1">1er Apellido </td>
              <td class="textotabla1">2do Apellido </td>
              <td class="textotabla1">2do Apellido </td>
              <td class="textotabla1">Celular</td>
            </tr>
            <tr>
              <td class="textotabla1">Especialista</td>
              <td class="textotabla1"><input name="inf_com_esp_ape_aco" id="inf_com_esp_ape_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->inf_com_esp_ape_aco?>" /></td>
              <td class="textotabla1"><input name="inf_com_esp_ape1_aco" id="inf_com_esp_ape1_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->inf_com_esp_ape1_aco?>" /></td>
              <td class="textotabla1"><input name="inf_com_esp_ape2_aco" id="inf_com_esp_ape2_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->inf_com_esp_ape2_aco?>" /></td>
              <td class="textotabla1"><input name="inf_com_esp_celu_aco" id="inf_com_esp_celu_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->inf_com_esp_celu_aco?>" /></td>
            </tr>
            <tr>
              <td width="103" class="textotabla1">Asesor</td>
              <td width="160" class="textotabla1"><input name="inf_com_ase_ape_aco" id="inf_com_ase_ape_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->inf_com_ase_ape_aco?>" /></td>
              <td width="157" class="textotabla1"><input name="inf_com_ase_ape1_aco" id="inf_com_ase_ape1_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->inf_com_ase_ape1_aco?>" /></td>
              <td width="166" class="textotabla1"><input name="inf_com_ase_ape2_aco" id="inf_com_ase_ape2_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->inf_com_ase_ape2_aco?>" /></td>
              <td width="144" class="textotabla1"><input name="inf_com_ase_celu_aco" id="inf_com_ase_celu_aco" type="text" class="caja_mediana"  value="<?=$dbdatos->inf_com_ase_celu_aco?>" /></td>
            </tr>            
        </table></td>
      </tr>
    </table>
	<table border="1" cellspacing="0" bordercolor="#666666">
      <tr>
        <td><table width="629" align="center" cellpadding="0" cellspacing="0"  >
            <tr>
              <td colspan="3" class="textotabla1"><div align="center"><strong>COMPROMISO COMERCIAL  </strong></div></td>
            </tr>
            <tr>
              <td width="154" class="textotabla1"><div align="center">N&deg; Servicios </div></td>
              <td width="235" class="textotabla1"><div align="center">Hogares</div></td>
              <td width="238" class="textotabla1"><div align="center">Tiempo Compromiso</div></td>
            </tr>
            <tr>
              <td class="textotabla1"><div align="center">@
                  <input type="checkbox" name="com_com_arroba_aco" value="checkbox" <? if($dbdatos->com_com_arroba_aco==1) echo "checked='checked'";?>/>
T.V.
<input type="checkbox" name="com_com_arroba_aco" value="checkbox"   <? if($dbdatos->com_com_tv_aco==1) echo "checked='checked'";?>/>
              </div></td>
              <td class="textotabla1"><div align="center">
                <input name="com_com_hogares_aco" id="com_com_hogares_aco" type="text" class="textfield2"  value="<?=$dbdatos->com_com_hogares_aco?>" />
              </div></td>
              <td class="textotabla1"><div align="center">
                <input name="com_com_compro_aco" id="com_com_compro_aco" type="text" class="textfield2"  value="<?=$dbdatos->com_com_compro_aco?>" />
              </div></td>
            </tr>
        </table></td>
      </tr>
    </table>
	<table  border="1" cellspacing="0" bordercolor="#666666">
      <tr>
        <td><table width="629" align="center" cellpadding="0" cellspacing="0"  >
            <tr>
              <td colspan="4" class="textotabla1"><div align="center"><strong>APROBACION TV CLIENTE </strong></div></td>
            </tr>
            <tr>
              <td width="144" class="textotabla1"><div align="center">Asesor</div></td>
              <td width="158" class="textotabla1"><div align="center">Jefe Avanzada </div></td>
              <td width="152" class="textotabla1"><div align="center">Dise&ntilde;o</div></td>
              <td width="173" class="textotabla1">Operaciones</td>
            </tr>
            <tr>
              <td class="textotabla1"><div align="center">
                <input name="apro_cli_ase_aco" id="apro_cli_ase_aco" type="text" class="textfield2"  value="<?=$dbdatos->apro_cli_ase_aco?>" />
              </div></td>
              <td class="textotabla1"><div align="center">
                  <input name="apro_cli_jefe_aco" id="apro_cli_jefe_aco" type="text" class="textfield2"  value="<?=$dbdatos->apro_cli_jefe_aco?>" />
              </div></td>
              <td class="textotabla1"><div align="center">
                  <input name="apro_cli_diseno_aco" id="apro_cli_diseno_aco" type="text" class="textfield2"  value="<?=$dbdatos->apro_cli_diseno_aco?>" />
              </div></td>
              <td class="textotabla1"><input name="apro_cli_opera_aco" id="apro_cli_opera_aco" type="text" class="textfield2"  value="<?=$dbdatos->apro_cli_opera_aco?>" /></td>
            </tr>
        </table></td>
      </tr>
    </table>
	<div>
	
	<div id="solapa5" style="display:none" >
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="3" class="textotabla1"><div align="center"><strong>ADJUNTAR</strong></div></td>
      </tr>
      <tr>
        <td width="146" class="textotabla1"><div align="right">Adjuntar Archivo: </div></td>
        <td class="textotabla1"><div align="left">
          <input type="file" name="adjunto_aco"  id="adjunto_aco" />
        </div>          <div align="right"></div>          <div align="center"></div></td>
        <td width="12" class="textorojo">&nbsp;</td>
      </tr>
    </table>
	<div>
	
	
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
<script type="text/javascript">
			Calendar.setup(
				{
				inputField  : "fecha2",      
				ifFormat    : "%Y-%m-%d",    
				button      : "calendario1" ,  
				align       :"T3",
				singleClick :true
				}
			);
</script>