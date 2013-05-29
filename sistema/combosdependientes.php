<? include("lib/database.php")?>
<html>
<head>
<title>Combos combinados</title>
<script language = "JavaScript">
<? //'CONSULTA PARA OBTENER LOS DATOS
$db1= new  Database();
$sql="SELECT DISTINCT cod_mod_int,cod_int,nom_int FROM interfaz order by cod_mod_int ";
//echo $sql;
$db1->query($sql);
$x=0
?>

// FUNCION DE COMBO BOX COMBINADO

function sublist(inform, selecteditem)
{
inform.subcatagory.length = 0

<?
$count= 0;
$y=0;
while($db1->next_row()) {
?>

x = <?=$y?>;

subcat = new Array();
subcatagorys = "<?=$db1->nom_int?>";
subcatagoryof = "<?=$db1->cod_mod_int?>";
subcatagoryid = "<?=$db1->cod_int?>";
subcat[x,0] = subcatagorys;
subcat[x,1] = subcatagoryof;
subcat[x,2] = subcatagoryid;
if (subcat[x,1] == selecteditem) {
var option<?=$count?> = new Option(subcat[x,0], subcat[x,2]);
inform.subcatagory.options[inform.subcatagory.length]=option<?=$count?>;
}
<?
$count = $count + 1;
$y = $y + 1;
}
?>
}

</script>


</head>

<body >
<form name="prueba">

<table border="0" width="80%">
<tr>

<td width="77%">
<select size="1" id="familia" name="familia" onChange = "javascript:sublist(this.form, familia.value);">
<option selected value="0">Seleccione Opcion</option>
<? 
$db= new  Database();
$Sql = "SELECT DISTINCT cod_mod,nom_mod FROM modulos";
$db->query($Sql);
while($db->next_row())
{
?>
<option value="<?=$db->cod_mod?>"><?=$db->nom_mod?></option>
<? }  $db->close() ?>

</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <SELECT id="subcatagory" name="subcatagory" size="1">
<Option selected value="none"></option>
</SELECT> <label>
<input type="button" name="Submit" value="Enviar" onClick="alert(document.prueba.subcatagory.value)">
</label></td>
<td width="9%">

</td>
</tr>
</table>

</form>

</body>
</html>

 