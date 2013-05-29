<? include("lib/database.php")?>
<? include("lib/data.php")?>
<?
$cadena="UEFA0086@1@20=
UEFA0086@1@19=
UEFA0086@1@20=
UEFA0086@1@16=
UEFA0086@1@17=
";


$dbdatos= new  Database1();

$dbd = new  Database();


$arr = explode('=',$cadena);

for($i=0;$i<=count($arr)-1;$i++){
	$cadena = $arr[$i];
	$subcadena = explode('@',$cadena);	
	for($j=0;$j<=count($subcadena)-2;$j++){
		//echo $subcadena[$j];
		//echo "====" ;
		if($j==0) 
		{
			$sql= "select cod_pro from producto where nom_pro='".trim($subcadena[0])."'";
			$dbdatos->query($sql);
			$dbdatos->next_row();
			$cod_producto=$dbdatos->cod_pro;	
			
			//echo "===";
			echo $sql_inser="INSERT INTO kardex ( cod_ref_kar, cod_bod_kar, cant_ref_kar, cod_talla) VALUES( $cod_producto, 225, '$subcadena[2]',  $subcadena[1]);";
			//$dbd->query($sql_inser);
			echo "<br>";
		}
	}
	//echo "<br>";
}

//$sql="select * from producto where cod_fry_pro='BAB0002'"

/*$sql ="SELECT cod_pro,cod_fry_pro,nom_pro,pre_ven_pro,pre_com_pro,iva_pro,cod_tpro_pro, cod_mar_pro ,cod_pes_pro , unidad from producto WHERE cod_pro=$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
*/


?>