<?
//session_start();
$codigo_usuario= $global[2];
function paginar($sql) {
	$db= new  Database();
	$db->query($sql);
return  $db->num_rows();
}
function letra_capital($palabra) {
	$palabra=ucwords(strtolower($palabra));
return  $palabra;
}
function reemplazar($busquedas) {
	$busquedas=str_replace(" like '%","|",$busquedas);
$busquedas=str_replace("%'","",$busquedas);
return $busquedas;
}
function reemplazar_1($busquedas) {
	$busquedas=str_replace("|"," like '%",$busquedas);
$busquedas=$busquedas."%'";
return $busquedas;
}
function combo($nombre_obj,$tabla,$valor,$nombre,$valor_edicion) 
{
$db= new  Database();
$sql="select * from ".$tabla;
$db->query($sql);
echo " <select name='".$nombre_obj."' class='SELECT'>";
while($db->next_row()) {
	if($valor_edicion==$db->$valor) 
		echo" <option value=".$db->$valor." selected='selected'>".$db->$nombre."</option>";
	else
		 echo" <option value=".$db->$valor.">".$db->$nombre."</option>";
}
echo "</select>";
$db->close();
}
function combo_almacen($nombre_obj,$valor,$nombre,$valor_edicion,$proyecto) {
	$db= new  Database();
$sql="select * from  almacen where  cod_pro_alm=".$proyecto;
$db->query($sql);
echo " <select name='".$nombre_obj."' class='SELECT'>";
while($db->next_row()) {
	if($valor_edicion==$db->$valor) 
		echo" <option value=".$db->$valor." selected='selected'>".$db->$nombre."</option>";
	else
		 echo" <option value=".$db->$valor.">".$db->$nombre."</option>";
}
echo "</select>";
$db->close();
}
function combo11($nombre_obj,$tabla,$valor,$nombre,$valor_edicion) {
	$db= new  Database();
$sql="select * from ".$tabla;
$db->query($sql);
echo " <select name='".$nombre_obj."' class='SELECT01'>";
while($db->next_row()) {
	if($valor_edicion==$db->$valor) 
		echo" <option value=".$db->$valor." selected='selected'>".$db->$nombre."</option>";
	else
		 echo" <option value=".$db->$valor.">".$db->$nombre."</option>";
}
echo "</select>";
$db->close();
}


function combo_evento($nombre_obj,$tabla,$valor,$nombre,$valor_edicion,$evento, $orden) 
{
$db= new  Database();
$sql="select ".$valor.", ".$nombre." as nombre  from ".$tabla. " order by ".$orden;
$db->query($sql);
echo " <select name='".$nombre_obj."' id='".$nombre_obj."' class='SELECT'  $evento  >";
echo "<option value='0' selected='selected'>Seleccione..</option>";
while($db->next_row()) {
	if($valor_edicion==$db->$valor) 
		echo" <option value=".$db->$valor." selected='selected'>".$db->nombre."</option>";
	else
		 echo" <option value=".$db->$valor.">".strtoupper($db->nombre)."</option>";
}
echo "</select>";
$db->close();
}


function combo_evento_1($nombre_obj,$tabla,$valor,$nombre,$valor_edicion,$evento, $orden, $default) 
{
$db= new  Database();
$sql="select ".$valor.", ".$nombre." as nombre  from ".$tabla. " order by ".$orden;
$db->query($sql);
echo " <select name='".$nombre_obj."' id='".$nombre_obj."' class='SELECT'  $evento  >";

if ($default==1){
	echo "<option value='0' selected='selected'>Seleccione..</option>";
}

	
while($db->next_row()) {
	if($valor_edicion==$db->$valor) 
		echo" <option value=".$db->$valor." selected='selected'>".$db->nombre."</option>";
	else
		 echo" <option value=".$db->$valor.">".$db->nombre."</option>";
}
echo "</select>";
$db->close();
}



function combo_polar($nombre_obj,$valor_edicion) {
	echo " <select name='".$nombre_obj."' class='SELECT'>";
	if($valor_edicion=="POSITIVO") 
		echo "<option value='POSITIVO' selected='selected'>POSITIVO</option>";
	else
		echo "<option value='POSITIVO'>POSITIVO</option>";
	if($valor_edicion=="NEGATIVO") 
		echo "<option value='NEGATIVO' selected='selected'>NEGATIVO</option>";	
	else
		echo "<option value='NEGATIVO'>NEGATIVO</option>";	
	if($valor_edicion=="NEUTRO") 
		echo "<option value='NEUTRO' selected='selected'>NEUTRO</option>";	
	else
		echo "<option value='NEUTRO'>NEUTRO</option>";	
	echo "</select>";
	}


function inicio() {
	echo '<script type="text/javascript" src="calendario/javascript/calendar.js"></script>
	<script type="text/javascript" src="calendario/javascript/calendar-es.js"></script>
	<script type="text/javascript" src="calendario/javascript/calendar-setup.js"></script>
	<link rel="stylesheet" type="text/css" media="all" href="calendario/styles/calendar-win2k-cold-1.css" title="win2k-cold-1" />
	<link href="css/styles.css" rel="stylesheet" type="text/css" /> 
	<script type="text/javascript" src="js/funciones.js"></script> ';
}


function escribe_sql($sql){
 // $ar=fopen("sincronia/sql_$codigo_usuario.txt","a") or die("Problemas en la creacion");
 // $sql="@@@@@@@@".$sql;
  //fputs($ar,"$sql");
  //fclose($ar);
}




function insertar($tabla,$compos,$valores) {
	$sql="insert into $tabla $compos values $valores ";
	//Fecho "<BR>";
	//exit;
	$db= new  Database();
	$db->query($sql);
	$retorno= $db->affected_rows();
	$db->close();
	escribe_sql($sql);
	auditoria ($tabla,1);
	return $retorno;
}


function editar($tabla,$compos,$where_campo, $where_valor) {
	$sql="UPDATE  $tabla  set $compos where $where_campo=$where_valor ";
	$db= new  Database();
	
	$db->query($sql);
	$retorno= $db->Errno;
	if ($retorno==0)
		$retorno=1;
	$db->close();
	escribe_sql($sql);
	auditoria ($tabla,2);
	return $retorno;
}




function eliminar($tabla, $codigo, $campo) {
	$sql="DELETE FROM $tabla WHERE $campo=$codigo ";
	$db= new  Database();
	$db->query($sql);
	$retorno= $db->affected_rows();
	$db->close();
	escribe_sql($sql);
	auditoria ($tabla,3);
	return $retorno;
}


function auditoria ($tabla, $codigo) {
	if(empty($_SESSION["global"][2]))
		$codigo_usuario=0;
	else 
		$codigo_usuario=$_SESSION["global"][2];
	
	$codigo_proyecto=1;
	$fecha= date("Y-m-d H:i:s");
	$sql="INSERT INTO auditoria VALUES (NULL,$codigo_usuario,'$tabla','$fecha',$codigo,$codigo_proyecto) ";
	$db= new  Database();
	$db->query($sql);
	escribe_sql($sql);
}


function completar($codigo,$tam) {
	$a=strlen($codigo);
for ($i=$a ; $i<$tam; $i++) {
	$codigo="0".$codigo;
}
return  $codigo;
}


function insertar_maestro($tabla,$compos,$valores) {
	$sql="insert into $tabla $compos values $valores "; //exit;
	$db= new  Database();
	$db->query($sql);
	$retorno= $db->insert_id();
	$db->close();
	escribe_sql($sql);
	auditoria ($tabla,1);
	return $retorno;
}


function combo_ref($nombre_obj,$tabla,$valor,$nombre,$valor_edicion) {
	$db= new  Database();
$sql="select * from ".$tabla;
$db->query($sql);
echo " <select name='".$nombre_obj."' class='SELECT01' onchange=\"cargar('0','$nombre_obj','0')\">";
echo" <option value=0>Seleccione</option>";
while($db->next_row()) {
	if($valor_edicion==$db->$valor) 
		echo" <option value=".$db->$valor." selected='selected'>".$db->$nombre."</option>";
	else
		 echo" <option value=".$db->$valor.">".$db->$nombre."</option>";
}
echo "</select>";
$db->close();
}


function actual_insertar($referencia,$cantidad){
$sql=" SELECT act_ref + ".$cantidad."  as total FROM referencia WHERE  cod_ref=$referencia ";
$db= new  Database();
$db->query($sql);
$db->next_row();
$cant_actual=$db->total;
//$cant_actual=$db->argumento($sql,"total");
$sql = "UPDATE referencia SET act_ref=".$cant_actual." WHERE  cod_ref=".$referencia ;
$db->query($sql);
escribe_sql($sql);
}


function actual_insertar_debitar($referencia,$cantidad){
$sql=" SELECT act_ref - ".$cantidad."  as total FROM referencia WHERE  cod_ref=$referencia ";
$db= new  Database();
$db->query($sql);
$db->next_row();
$cant_actual=$db->total;
//$cant_actual=$db->argumento($sql,"total");
$sql = "UPDATE referencia SET act_ref=".$cant_actual." WHERE  cod_ref=".$referencia ;
$db->query($sql);
escribe_sql($sql);
}


function reverzar_referencias_compras ($movimineto) {
	$sql =" SELECT cod_ref_mae, cant_mae FROM maestro_movimiento  WHERE cod_mov_mae=$movimineto and cod_tip_mae=2";
	$dbdatos= new  Database();	
	$dbdatos->query($sql);
	$dbcos= new  Database();
	$dbcos1= new  Database();
	while($dbdatos->next_row())
	{	
		$sql_revertido = " SELECT act_ref -".$dbdatos->cant_mae." as total FROM referencia WHERE cod_ref=".$dbdatos->cod_ref_mae;
		$dbcos= new  Database();
		$dbcos->query($sql_revertido);
		$dbcos->next_row();
		$cant_actual=$dbcos->total;
		$dbcos1->query($sql);
		$sql = "UPDATE referencia SET act_ref=".$cant_actual." WHERE  cod_ref=".$dbdatos->cod_ref_mae ;
		$dbcos1->query($sql);	
		escribe_sql($sql);
	}
	$dbcos1->query($sql);
	$sql = "delete from maestro_movimiento WHERE cod_mov_mae=$movimineto  and cod_tip_mae=2" ;
	$dbcos1->query($sql);
	escribe_sql($sql);
}


function reverzar_referencias_salidas ($movimineto) {
	$sql =" SELECT cod_ref_mae, cant_mae * -1 as cant_mae FROM maestro_movimiento  WHERE cod_mov_mae=$movimineto and cod_tip_mae=7";
	$dbdatos= new  Database();	
	$dbdatos->query($sql);
	$dbcos= new  Database();
	$dbcos1= new  Database();
	while($dbdatos->next_row())
	{	
		$sql_revertido = " SELECT act_ref +".$dbdatos->cant_mae." as total FROM referencia WHERE cod_ref=".$dbdatos->cod_ref_mae;
		$dbcos= new  Database();
		$dbcos->query($sql_revertido);
		$dbcos->next_row();
		$cant_actual=$dbcos->total;
		$dbcos1->query($sql);
		$sql = "UPDATE referencia SET act_ref=".$cant_actual." WHERE  cod_ref=".$dbdatos->cod_ref_mae ;
		$dbcos1->query($sql);	
		escribe_sql($sql);
	}
	$dbcos1->query($sql);
	$sql = "delete from maestro_movimiento WHERE cod_mov_mae=$movimineto  and cod_tip_mae=7" ;
	$dbcos1->query($sql);
	
	//BORROA MAESTRO SERIALES
	$sql = "delete from maestro_serial WHERE cod_mov_ser=$movimineto and tip_mov_ser=7 " ;
	$dbcos1->query($sql);
	escribe_sql($sql);
}



function reverzar_referencias_ingresos ($movimineto) {
	$sql =" SELECT cod_ref_mae, cant_mae FROM maestro_movimiento  WHERE cod_mov_mae=$movimineto and cod_tip_mae=3";
	$dbdatos= new  Database();	
	$dbdatos->query($sql);
	$dbcos= new  Database();
	$dbcos1= new  Database();
	while($dbdatos->next_row())
	{	
		$sql_revertido = " SELECT act_ref -".$dbdatos->cant_mae." as total FROM referencia WHERE cod_ref=".$dbdatos->cod_ref_mae;
		$dbcos->query($sql_revertido);
		$dbcos->next_row();
		$cant_actual=$dbcos->total;
		$sql = "UPDATE referencia SET act_ref=".$cant_actual." WHERE  cod_ref=".$dbdatos->cod_ref_mae ;
		$dbcos1->query($sql);	
		escribe_sql($sql);
	}
	$dbcos1->query($sql);
	$sql = "delete from maestro_movimiento WHERE cod_mov_mae=$movimineto  and cod_tip_mae=3" ;
	$dbcos1->query($sql);
	escribe_sql($sql);
}

function reverzar_referencias_traslado ($movimineto) {
	$dbcos1= new  Database();
	//BORROA MAESTRO SERIALES
	$sql = "delete from maestro_serial WHERE cod_mov_ser=$movimineto and tip_mov_ser=5 " ;
	$dbcos1->query($sql);
	escribe_sql($sql);
	//BORROA MAESTRO MOVIMIENTOS
	$sql = "delete from maestro_movimiento WHERE cod_mov_mae=$movimineto and cod_tip_mae=5 " ;
	$dbcos1->query($sql);
	escribe_sql($sql);
	//BORROA TRASLADOS
	$sql = "delete from traslado WHERE cod_tras=$movimineto  " ;
	$dbcos1->query($sql);
	escribe_sql($sql);
}

function sumar_referencias ($referencia,$cantidad ) {
	$dbcos= new  Database();
	$sql = " SELECT act_ref +".$cantidad." as total FROM referencia WHERE cod_ref=".$referencia;

	$dbcos->query($sql);
	$dbcos->next_row();
	$cant_actual=$dbcos->total;
	
	$sql = "UPDATE referencia SET act_ref=".$cant_actual." WHERE  cod_ref=".$referencia ;
	$dbcos->query($sql);	
	escribe_sql($sql);

}


function restar_referencias ($referencia,$cantidad ) {
	$dbcos= new  Database();
	$sql = " SELECT act_ref -".$cantidad." as total FROM referencia WHERE cod_ref=".$referencia;
	$dbcos->query($sql);
	$dbcos->next_row();
	$cant_actual=$dbcos->total;
	$sql = "UPDATE referencia SET act_ref=".$cant_actual." WHERE  cod_ref=".$referencia ;
	$dbcos->query($sql);	
	escribe_sql($sql);

}


function combo_movil($nombre_obj,$valor,$nombre,$valor_edicion,$proyecto,$activo) {
	$db= new  Database();
	$sql="select * from  moviles ";
	$db->query($sql);
	
	if ($activo=="") { echo " <select name='".$nombre_obj."' class='SELECT'>"; }
	else { echo " <select name='".$nombre_obj."'  disabled='$activo'  class='SELECT'>"; }
	
	echo" <option value=0>Seleccione</option>";
	while($db->next_row()) {
		if($valor_edicion==$db->$valor) 
			echo" <option value=".$db->$valor." selected='selected'>".$db->$nombre."</option>";
		else
			 echo" <option value=".$db->$valor.">".$db->$nombre."</option>";
	}
	echo "</select>";
	$db->close();
}

function combo_tercero($nombre_obj,$tabla,$valor,$nombre,$valor_edicion) {
$db= new  Database();
$sql="select cod_ter , concat(nom_ter,concat(' ', ape_ter)) AS nombre  from ".$tabla;
$db->query($sql);
echo " <select name='".$nombre_obj."' class='SELECT'>";
while($db->next_row()) {
	if($valor_edicion==$db->$valor) 
		echo" <option value=".$db->$valor." selected='selected'>".$db->nombre."</option>";
	else
		 echo" <option value=".$db->$valor.">".$db->$nombre."</option>";
}
echo "</select>";
$db->close();
}



function verifica_precios($codigo_ref,$valor_venta,$valor_compra){
$db= new  Database();
$sql="UPDATE producto SET pre_ven_pro= $valor_venta , pre_com_pro= $valor_compra WHERE  cod_pro=$codigo_ref";
$db->query($sql);
escribe_sql($sql);
}


function resumen_saldosssss($nom_mov,$cod_doc,$fec_mov,$cod_ven,$valor,$accion){
$db= new  Database();

//ELIMINA LOS MOVIMINETOS PARA INSERCION O EDICION
$sql="delete from resumen_movimineto where tipo_mov_rmov=$nom_mov and cod_doc_rmov=$cod_doc ";
$db->query($sql);

//INSERTA EL DETALLE DEL SALDO Y EL MOVIMINETO
$sql="INSERT INTO  resumen_movimineto  ( tipo_mov_rmov ,  cod_doc_rmov ,  fec_rmov ,  ven_rmov ,  valor ,  acc_rmov ,  fec_sal_ant ,  saldo_anterior ) VALUES( $nom_mov, $cod_doc, '$fec_mov', $cod_ven, $valor, '$accion', '', 0)";
$db->query($sql);

}


function resumen_movimiento($documento,$tipo_movimineto,$fecha,$vendedor,$valor,$accion,$eliminar){

$db= new  Database();
$dboo= new  Database();

if($eliminar=="")
{
	$sql="DELETE FROM resumen_movimineto WHERE tipo_mov_rmov='$tipo_movimineto' and cod_doc_rmov=$documento and ven_rmov=$vendedor";
	$db->query($sql);
	escribe_sql($sql);
	$sql="SELECT valor_suma,valor_resta,saldo_anterior FROM  resumen_movimineto WHERE cod_rmov=(SELECT MAX(cod_rmov) FROM resumen_movimineto WHERE ven_rmov = $vendedor) ";
	$dboo->query($sql);
	$dboo->next_row();
	$saldo_anterior=$dboo->saldo_anterior;

	
	if($saldo_anterior<0)
		$saldo_anterior=0;
	else
		$saldo_anterior=($dboo->saldo_anterior + $dboo->valor_suma) - $dboo->valor_resta;
		
	//echo $saldo_anterior;
	//exit;
	$compos="(tipo_mov_rmov,cod_doc_rmov,fec_rmov,ven_rmov,valor_$accion,acc_rmov ,saldo_anterior)";
	$valores="('$tipo_movimineto','$documento','$fecha','$vendedor','$valor','$accion','$saldo_anterior')";
	insertar("resumen_movimineto",$compos,$valores);
}
else { // eliminacion sin vendedor
	$sql="DELETE FROM resumen_movimineto WHERE tipo_mov_rmov='$tipo_movimineto' and cod_doc_rmov=$documento";
	$db->query($sql);
	escribe_sql($sql);

}

}



function manejo_ventas_movimientos($documento,$fecha,$vendedor,$eliminar){
$total_credito = busca_suma_venta("select sum(val_cred_dvcr) as total  from d_credito_venta where cod_mven_dvcr=$documento");
$total_crobro = busca_suma_venta("SELECT SUM(val_cob_dvco) AS total  FROM d_cobro_venta WHERE cod_mven_dvco=$documento");
$total_cheque = busca_suma_venta("SELECT SUM(val_cheq_dvch) AS total  FROM d_cheque_venta WHERE cod_mven_dvch=$documento");
$total_gastos = busca_suma_venta("SELECT SUM(val_gas_dvga) AS total  FROM d_gastos_venta WHERE cod_mven_dvga=$documento");
$total_efectivo = busca_suma_venta("SELECT SUM(val_dvef) AS total  FROM d_efectivo_venta WHERE cod_mven_dvef=$documento");
$total_consignacion = busca_suma_venta("SELECT SUM(val_consig_dvcon) AS total  FROM d_consignacion_venta WHERE cod_mven_dvcon=$documento");

$total_todo=$total_credito + $total_crobro + $total_cheque + $total_gastos + $total_efectivo + $total_consignacion; 
// actualiza movimientos
resumen_movimiento($documento,"Venta",$fecha,$vendedor,$total_todo,"resta","");
// actualiza movimientos

}

function busca_suma_venta($sql){
$db= new  Database();
$db->query($sql);
$db->next_row();
return $db->total;
}


function calcular_saldos_total(){
	$db_1= new  Database();
	$db_2= new  Database();
	$db_saldo= new  Database();
	$sql="SELECT ven_rmov, SUM(valor_suma) - SUM(valor_resta) AS saldo ,fec_rmov FROM resumen_movimineto 	WHERE procesado= 0
	GROUP by fec_rmov ,ven_rmov 	ORDER BY fec_rmov ASC , ven_rmov ASC ";
	$db_1->query($sql);
	while($db_1->next_row()) {
		$sql="delete from saldos where cod_ven_sal=$db_1->ven_rmov and fec_sal='$db_1->fec_rmov'";
		$db_saldo->query($sql);
		escribe_sql($sql);
		$sql="INSERT INTO saldos(cod_ven_sal, fec_sal,val_sal) VALUES($db_1->ven_rmov, '$db_1->fec_rmov', $db_1->saldo)";
		$db_saldo->query($sql);
		escribe_sql($sql);
	}
	$sql="update resumen_movimineto set procesado= 1";
	$db_2->query($sql);
	escribe_sql($sql);
}
//Se le agrega campo serial en esta funcion

function  kardex($operador, $referencia,$bodega, $cantidad,$valor_precio=0,$talla,$serial=0){

	$kardex = new Database();
	$sql = "select count(*)  as existe from kardex where cod_ref_kar=$referencia and cod_bod_kar=$bodega  and cod_talla=$talla  and serial='$serial';";
	//echo $sql; exit;
	$kardex->query($sql);
	$kardex->next_row(); 
    $existe=$kardex->existe;
	//echo $existe; exit;
	if ($operador=="suma")
	{
		if ($existe==0){ // insertar y sumar
			$sql = "INSERT INTO kardex (cod_ref_kar, cod_bod_kar, cant_ref_kar,valor_precio,cod_talla,serial) 
			        VALUES('$referencia','$bodega', '$cantidad','$valor_precio','$talla','$serial')";
			$kardex->query($sql);
			//echo $sql; exit;
		//	escribe_sql($sql);
			
		}
		else{ // actualizar y sumar
			$sql = "select cant_ref_kar as saldo from kardex 
			        where cod_ref_kar='$referencia' and cod_bod_kar='$bodega' and cod_talla=$talla and serial='$serial';";
			$kardex->query($sql);
			if($kardex->next_row()){ 
				$saldo=$kardex->saldo;
			}
			//echo $saldo;
			$cantidad = $cantidad + $saldo;
			$sql = "UPDATE kardex SET cant_ref_kar= $cantidad  
			        WHERE  cod_ref_kar='$referencia' and cod_bod_kar='$bodega'  and cod_talla=$talla  and serial='$serial';";
			//echo $sql; exit;
			$kardex->query($sql);
			escribe_sql($sql);
			
		}
	}
	if ($operador=="resta")
	{
		$sql = "select cant_ref_kar as saldo 
		         from kardex 
				where cod_ref_kar='$referencia' and cod_bod_kar='$bodega' and cod_talla='$talla' and serial='$serial';";
		$kardex->query($sql);
		if($kardex->next_row()){ 
			$saldo=$kardex->saldo;
		}
		
		$cantidad = $saldo - $cantidad ;
		//echo $cantidad; exit;
		$sql = "UPDATE kardex SET cant_ref_kar= $cantidad  
		        WHERE cod_ref_kar='$referencia' and cod_bod_kar='$bodega' and cod_talla=$talla and serial='$serial';"; //exit;
		$kardex->query($sql);
		escribe_sql($sql);
	}
}


function  kardex_original($operador, $referencia,$bodega, $cantidad,$valor_precio ){
	$kardex = new Database();
	echo $sql = "select count(*)  as existe from kardex where cod_ref_kar=$referencia and cod_bod_kar=$bodega "; exit;
	$kardex->query($sql);
	if($kardex->next_row()){ 
		$existe=$kardex->existe;
	}
		

	if ($operador=="suma"){
		if ($existe==0){ // insertar y sumar
			$sql = "INSERT INTO kardex (cod_ref_kar, cod_bod_kar, cant_ref_kar,valor_precio) VALUES('$referencia','$bodega','$cantidad',$valor_precio)";
			echo $sql; exit;
			$kardex->query($sql);
			escribe_sql($sql);
		}
		else{ // actualizar y sumar
			$sql = "select cant_ref_kar as saldo from kardex where cod_ref_kar='$referencia' and cod_bod_kar='$bodega'  ";
			$kardex->query($sql);
			if($kardex->next_row()){ 
				$saldo=$kardex->saldo;
			}
			$cantidad = $cantidad + $saldo;
			$sql = "UPDATE kardex SET cant_ref_kar= $cantidad  WHERE  cod_ref_kar='$referencia' and cod_bod_kar='$bodega'  ";
			$kardex->query($sql);
			escribe_sql($sql);
		}
	}
	
	if ($operador=="resta"){
		$sql = "select cant_ref_kar as saldo from kardex where cod_ref_kar='$referencia' and cod_bod_kar='$bodega'  ";
		$kardex->query($sql);
		if($kardex->next_row()){ 
			$saldo=$kardex->saldo;
		}
		$cantidad = $saldo - $cantidad ;
		$sql = "UPDATE kardex SET cant_ref_kar= $cantidad  WHERE  cod_ref_kar='$referencia' and cod_bod_kar='$bodega'   ";
		$kardex->query($sql);
		escribe_sql($sql);
	}
}

function combo_sql($nombre_obj,$tabla,$valor,$nombre,$valor_edicion,$sql) 
{
$db= new  Database();
$db->query($sql);
echo " <select name='".$nombre_obj."'  id='".$nombre_obj."' class='SELECT'>";
	 echo" <option value=''>Seleccione</option>";
while($db->next_row()) {
	if($valor_edicion==$db->$valor) 
		echo" <option value=".$db->$valor." selected='selected'>".$db->$nombre."</option>";
	else
		 echo" <option value=".$db->$valor.">".strtoupper($db->$nombre)."</option>";
}
echo "</select>";
$db->close();
}






function combo_sql_evento($nombre_obj,$tabla,$valor,$nombre,$valor_edicion,$sql,$evento) 
{
	$db= new  Database();
	$db->query($sql);
	echo " <select name='".$nombre_obj."' id='".$nombre_obj."' class='SELECT' ".$evento." >";
	echo "<option value='0' selected='selected'>Seleccione..</option>";
	while($db->next_row()) 
	{
		if($valor_edicion==$db->$valor) 
			echo" <option value=".$db->$valor." selected='selected'>".$db->$nombre."</option>";
		else
			 echo" <option value=".$db->$valor.">".$db->$nombre."</option>";
	}
	echo "</select>";
	$db->close();
}


function enviar_alerta($subject,$msg)
{

$db= new  Database();
$sql="SELECT * FROM rsocial  limit 1";
$db->query($sql);
if($db->next_row()) 
{
$mail_envio=$db->email;

}
 
 

envar_correo($mail_envio,$msg,$subject);


}


function envar_correo($mail_envio,$msg,$subject) {
	include ("email.inc.php");
	$e = new Email();
	$e->isHTML = true;
	$e->setEmailFrom("Alertas Automaticas", "$mail_envio");
	$e->addEmailFor("Administrador", "$mail_envio");
	$e->setSubject("$subject");
	$e->setBody($msg);
	if ($e->send()) {
		$a=1;
	} else {
		echo "No enviado";
	}
	
	/*$eol="\r\n";
	$mime_boundary=md5(time());
	# Common Headers
	$fromaddress=$mail_envio;
	$headers = "From:  ".$fromname."<".$fromaddress.">".$eol;
	if( $cc != "" ) $headers .= $cc;
	$headers .= "Reply-To: ".$fromname."<".$fromaddress.">".$eol;
	$headers .= "Return-Path: ".$fromname."<".$fromaddress.">".$eol;    // these two to set reply address
	$headers .= "Message-ID: <".time()."-".$fromaddress.">".$eol;
	$headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
	$headers .= 'MIME-Version: 1.0'.$eol.$eol;
	$msg .=$body."<br>".$eol.$eol;
	$msg .=$eol."<br>"."Atentamente,<br> "."<br>"."<br>".$eol.$eol."e-mail: ".$fromaddress."<br>"." ".$fromname."<br>".$eol.$eol;
	$msg .= "--".$htmlalt_mime_boundary."--".$eol.$eol;
	include_once("class.phpmailer.php");
	$sendmail = new PHPMailer();
	$sendmail->IsSMTP();
	$sendmail->Host = "";
	$sendmail->Port = 25;
	$sendmail->AddAddress ($mail_envio);
	$sendmail->SMTPAuth = true;
	$sendmail->Username = "leonardo@kaome.com";
	$sendmail->Password = "leonardo";
	$sendmail->From = ("leonardo@kaome.com");
	$sendmail->FromName = "|||| Envio Automaticos ||||"." ";
	$sendmail->Timeout = 18000000; 
	$sendmail->IsHTML(true);
	$sendmail->Subject = "- ALERTA - ".$subject;
	$sendmail->Body = $msg;
	$sendmail->Send();*/
}

?>