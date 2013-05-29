nnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn
<? include("lib/sesion.php")?>
<? include("lib/database.php")?>
<?
 $dbe = new Database();
	echo $sql = 'SELECT txs_num FROM tiempo;';
	$dbe->query($sql);
	$dbe->next_row();
	$tmp = $dbe->txs_num;
	$dbe->close();
$db= new  Database();
//exit;
$sql="SELECT * FROM permisos INNER JOIN usuario ON cod_usu= cod_usu_per WHERE log_usu='".$_POST['txt_usuario']."'  AND pas_usu='".$_POST['txt_clave']."'; ";//echo $sql; exit;
echo $sql; //exit;
$db->query($sql);
//echo $db->num_rows(); exit;


if($db->next_row()) {
    $_SESSION["ultimoAcceso"]= date("Y-n-j H:i:s");
	$global[1]=$db->car_usu;
	$global[2]=$db->cod_usu;
	$global[3]=$db->nom_usu; 
	$global[4]=$db->log_pro;
 $global[5]= "` m_entrada".$global[2]."`"; //Nombre de la tabla maestra Entradas temporal
	$global[6]= "` d_entrada".$global[2]."`"; //Nombtre de la tabla detalle Entradas temporal
	$global[7]= "` m_remision".$global[2]."`";
	$global[8]= "` d_remision".$global[2]."`";
	$global[9]=$db->dir_usu;
	if($global[1]==1)
	{
	     $global[5] = "m_entrada";
	     $global[6] = "d_entrada";
		 $global[7] = "m_remision";
	     $global[8] = "d_remision";
	}
    $global[13] = $tmp;	
}

if( $db->num_rows()>0 ){
	//header ("location: aplicacion.php");
	/*echo "<script language='javascript'> location.href='aplicacion.php' </script>";*/
	$usu_atu=1;
	
}
else {
	/*echo "<script  language='javascript'> alert('Usuario No Autorizado, Rectifique sus Datos , test 2'); window.close();  opener.document.getElementById('val').value=1 </script>";*/
	$usu_atu=0;
}
	$db->close();

?>


