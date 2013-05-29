<?php
$vali = 19000;
$valf = 19021;
echo $filas = ($valf - $vali) /3;
?>
<table>
<? $d = 0;
  for($k=0;$k<=$filas;$k = $k +3) { ?>
<tr>
<td><?=$vali + ($d+1);?></td>
<td><?=$vali + ($d+2);?></td>
<td><?=$vali + ($d +3);?></td>
<tr>
<? $d+=3;} ?>
</table> 
<?php $m = 1;
for($n=0;$n<4;$n++)
{   echo $n."TABLE";
    echo "<table border='1'>";
	for($fila=0;$fila<3;$fila++)
	{
		echo "<tr>";
		for($r=0;$r<3;$r++)
		{
		   echo "<td>CELDA".$m."</td>";
		   $m++;
			echo "<td>CELDA".$m."</td>";
			$m++;
			 echo "<td>CELDA".$m."</td>";
		   $m++;
		}
		echo "</tr>";
	}
	echo "</table><br>";
	
}
?>