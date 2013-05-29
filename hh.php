<? include("lib/database.php") ?>
<?
$sql =" SELECT DISTINCT(ven_rmov) AS vendedor FROM  resumen_movimineto ORDER BY ven_rmov ASC ";		
$dbdatos= new  Database();
$dbdatos_saldo= new  Database();
$dbdatos_final= new  Database();

$dbdatos->query($sql);

while($dbdatos->next_row()){
	$sql =" SELECT * FROM  resumen_movimineto WHERE ven_rmov=$dbdatos->vendedor ORDER BY ven_rmov,cod_rmov ASC ";		
	$dbdatos_saldo->query($sql);
	$i=0;
	while($dbdatos_saldo->next_row())
	{
		if($i==0)
		{
			$saldo=($dbdatos_saldo->saldo_anterior + $dbdatos_saldo->valor_suma) - $dbdatos_saldo->valor_resta;
			echo $sql1 =" update resumen_movimineto set saldo_anterior=0 WHERE ven_rmov=$dbdatos->vendedor and cod_rmov=$dbdatos_saldo->cod_rmov ";		
			$i=1;
		}
		else 
		{
		
			echo $sql1 = " update resumen_movimineto set saldo_anterior=$saldo WHERE ven_rmov=$dbdatos->vendedor  and cod_rmov=$dbdatos_saldo->cod_rmov ";		
			$saldo=($saldo + $dbdatos_saldo->valor_suma) - $dbdatos_saldo->valor_resta;
		}
		
		$dbdatos_final->query($sql1);
		echo "==$saldo";
		echo "<BR>";
	}
	
	
}


?>