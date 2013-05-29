<? include("lib/database.php");?>
<?
setcookie("nombre",$global[3]);
setcookie("global[2]", $global[2], time() + 86400); 
setcookie("global[3]", $global[3], time() + 86400); 
setcookie("global[4]", $global[4], time() + 86400); 
?>


</html>

<html >

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?=$nombre_aplicacion?></title>

<script type="text/javascript">var tWorkPath="menus/data.files/";</script>

<script type="text/javascript" src="menus/data.files/dtree.js"></script>

<link href="css/styles.css" rel="stylesheet" type="text/css">

<style type="text/css">

<!--

.Estilo1 {

	color: #FF9933;

	font-size: 14px;

	font-weight: bold;

}

.style2 {font-size: 12px}

-->

</style>



<script language="javascript">

function cerrar() {

window.close();



}

</script>

<script language="JavaScript1.2">

<!--

// Maximizar Ventana por Nick Lowe (nicklowe@ukonline.co.uk)

window.moveTo(0,0);

if (document.all) {

	top.window.resizeTo(screen.availWidth,screen.availHeight);

}

else if (document.layers||document.getElementById) {

if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){

	top.window.outerHeight = screen.availHeight;

	top.window.outerWidth = screen.availWidth;

}

}

//-->

</script>





</head>



<body  bgcolor="#E9E9E9" <?=$sis?> >

<table width="95%" height="98%" border="0" align="center">

  <tr>

    <td valign="middle">

	<table  border="0" cellpadding="0" cellspacing="0" align="center"  bgcolor="#FFFFFF" width="100%"   >

  <tr>

  

    <td width="16%"  height="55" rowspan="2" valign="top">&nbsp;</td>

    <td  colspan="2" ><img src="imagenes/lineasup.jpg"  width="100%" height="16" /></td>

  </tr>

  

  <tr>

   

    <td height="19" align="right" valign="middle" bgcolor="#67678D" class="nombreusuario" style="height:19px">

		<span class="nombreusuario" style="height:19px"><span class="titulosup">USUARIO: </span>

        <?=$global[3]?> 

        <span class="titulosup">FECHA: </span>

        <?=date("d/m/y")?>

    	</span>	</td>

  </tr>

  <tr>

    <td height="401" rowspan="2" valign="top" > 

	<?  include("menus/data.php") ?>

		<a href="index.html" ></a><span class="Estilo1"> <a href="#" onClick="cerrar()"  > &nbsp;&nbsp;&nbsp;<span class="style2">SALIR</span></a></span>	</td>



    <td height="501" colspan="2"  valign="top">  <iframe  frameborder="0" scrolling="auto"  src="interna.php" name="interna" width="100%" height="100%"> </iframe> </td>

  </tr>

  

  <tr>

   <td height="76" colspan="2" valign="top" bgcolor="#FFFFFF"><div align="left" >

          <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>

              <td width="100%" height="7"><img src="imagenes/rect1.gif" width="100%" height="7" /></td>

            </tr>

            <tr>

              <td height="4"><img src="imagenes/spacer.gif" width="100%" height="4" /></td>

            </tr>

            <tr>

              <td height="26" bgcolor="#67678D">&nbsp;</td>

            </tr>

        </table>

        </div>		</TD>

  </tr>

</table>

</td>

  </tr>

</table>









</body>

</html>