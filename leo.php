l<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
<title>Documento sin t&iacute;tulo</title>
</head>
<script language="javascript">
function anti_trampa_borrar()
{	
	var myString ="@1,621@1,514@1,427";
	alert(myString)
	var cadena='427';
	myString=myString.replace(cadena,"---");
	alert(myString)
	
var frase = "Son tres mil trescientos treinta y tres con nueve";
frase = frase.replace("tres","dos");
alert(frase);
	
}

</script>
<body>
<form id="form1" name="form1" method="post" action="">
  <label>
  <input type="button" name="Submit" value="Enviar"  onclick="anti_trampa_borrar()"/>
  </label>
</form>
</body>
</html>
