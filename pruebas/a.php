<html> 
<head><title>WICK Testing Ground</title> 
<!-- WICK STEP 1: INSERT CSS --> 
<link rel="stylesheet" type="text/css" href="wick.css" /> 
</head> 
<body> 

<script type="text/javascript" language="JavaScript"> 
function checkForm() {

/*answer = true;
if (siw && siw.selectingSomething)
	answer = false;
return answer;*/

}
registerSmartInputListeners();

</script> 
<div id="wickStatus"></div> 
<form onsubmit="return checkForm()"> 
<!-- WICK STEP 5: this prevents form from being submitted right-away if a user hits RETURN to select an address --> 
My First Box:<br /> 
<input class="wickEnabled" type="text" size="50" id="leo" /><br />
<!-- WICK STEP 4: ADD "wickEnabled" attribute to input that'll receive autocompletion using data stored in the "collection" array defined in STEP 2 --> 
<br />
&#160;<br /> 
  <div style="position:relative;text-align:left"> 
		<table id="MYCUSTOMFLOATER" class="myCustomFloater" style="position:absolute;top:50px;left:0;background-color:#cecece;display:none;visibility:hidden"> 
		<tr><td>
			<div class="myCustomFloaterContent"> 
			you should never be seeing this
			</div> 
		</td></tr> 
		</table> 
		<textarea class="wickEnabled:MYCUSTOMFLOATER" cols="50" rows="3" wrap="virtual"></textarea> 
  </div> 
<br /> 
<br /> 
My Fifth Box:<br /> 
<input class="wickEnabled" type="text" size="50" /><br /> 
</form> 
</p> 
</center> 
<script type="text/javascript" language="JavaScript" src="sample_data.js"></script> <!-- WICK STEP 2: DEFINE COLLECTION ARRAY THAT HOLDS DATA --> 
<script type="text/javascript" language="JavaScript" src="wick.js"></script> <!-- WICK STEP 3: INSERT WICK LOGIC --> 
</body> 
</html>