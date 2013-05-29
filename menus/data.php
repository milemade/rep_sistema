<? //include("lib/database.php")?>
<script language="javascript">
var tstylesNames=["Individual Style","Individual Style","Individual Style","Individual Style",];
var tXPStylesNames=["Individual Style",];
//--- Common
var tlevelDX=20;
var texpanded=0;
var texpandItemClick=1;
var tcloseExpanded=1;
var tcloseExpandedXP=0;
var ttoggleMode=1;
var tnoWrap=1;
//var titemTarget="_blank";
var titemTarget="interna";

var titemCursor="hand";
var statusString="link";
var tblankImage="menus/data.files/blank.gif";
var tpathPrefix_img="";
var tpathPrefix_link="";

//--- Dimensions
var tmenuWidth="190px";
var tmenuHeight="auto";

//--- Positioning
var tabsolute=0;
var tleft="2px";
var ttop="2px";

//--- Font
var tfontStyle="normal 9 pt Tahoma";
var tfontColor=["#3F3D3D","#7E7C7C"];
var tfontDecoration=["none","underline"];
var tfontColorDisabled="#ACACAC";
var tpressedFontColor="#AA0000";

//--- Appearance
var tmenuBackColor="";
var tmenuBackImage="menus/data.files/blank.gif";
var tmenuBorderColor="#FFFFFF";
var tmenuBorderWidth=0;
var tmenuBorderStyle="solid";

//--- Item Appearance
var titemAlign="left";
var titemHeight=22;
var titemBackColor=["#E9E9E9","#E9E9E9"];
var titemBackImage=["menus/data.files/blank.gif","menus/data.files/blank.gif"];

//--- Icons & Buttons
var ticonWidth=21;
var ticonHeight=15;
var ticonAlign="left";
var texpandBtn=["menus/data.files/expandbtn2.gif","menus/data.files/expandbtn2.gif","menus/data.files/collapsebtn2.gif"];
var texpandBtnW=9;
var texpandBtnH=9;
var texpandBtnAlign="left";

//--- Lines
var tpoints=0;
var tpointsImage="";
var tpointsVImage="";
var tpointsCImage="";

//--- Floatable Menu
var tfloatable=0;
var tfloatIterations=10;
var tfloatableX=1;
var tfloatableY=1;

//--- Movable Menu
var tmoveable=0;
var tmoveHeight=12;
var tmoveColor="transparent";
var tmoveImage="menus/data.files/movepic.gif";

//--- XP-Style
var tXPStyle=1;
var tXPIterations=10;
var tXPBorderWidth=1;
var tXPBorderColor="#FFFFFF";
var tXPTitleBackColor="#FF823B"; 
var tXPTitleBackImg="menus/data.files/xptitle_s.gif";
var tXPTitleLeft="menus/data.files/xptitleleft_s.gif";
var tXPTitleLeftWidth=4;
var tXPIconWidth=25;
var tXPIconHeight=32;
var tXPExpandBtn=["menus/data.files/xpexpand1_s.gif","menus/data.files/xpexpand1_s.gif","menus/data.files/xpcollapse1_s.gif","menus/data.files/xpcollapse1_s.gif"];
var tXPBtnWidth=25;
var tXPBtnHeight=23;
var tXPFilter=1;

//--- Dynamic Menu
var tdynamic=0;

//--- State Saving
var tsaveState=0;
var tsavePrefix="menu1";

var tstyles = [
    ["tfontStyle=bold 10pt Tahoma","tfontColor=#FFFFFF,#E6E6E6","tfontDecoration=none,none"],
    ["tfontStyle=bold 9pt Tahoma","tfontColor=#3F3D3D,#7E7C7C","tfontDecoration=none,none"],
    ["tfontDecoration=none,none"],
    ["tfontStyle=bold 9pt Tahoma","tfontColor=#444444,#5555FF"],
];
var tXPStyles = [
    ["tXPTitleBackColor=#D9DAE2","tXPTitleBackImg=data.files/xptitle2_s.gif","tXPExpandBtn=data.files/xpexpand2_s.gif,data.files/xpexpand3_s.gif,data.files/xpcollapse2_s.gif,data.files/xpcollapse3_s.gif"],
];
<?

$db= new  Database();
$sql="SELECT  cod_mod, nom_mod, cod_int_per,nom_int,rut_int, cod_usu_per,con_per,edi_per, ins_per,eli_per ,concat(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(CONCAT(rut_int,'?consulta='),cod_usu_per),'&editar='),edi_per),'&insertar='),ins_per),'&eliminar='),eli_per),'&pagina=1')
	AS rutas,cod_per FROM  permisos INNER JOIN interfaz   ON permisos.cod_int_per=interfaz.cod_int INNER JOIN modulos ON interfaz.cod_mod_int=modulos.cod_mod
	WHERE permisos.cod_usu_per=$global[2]  AND con_per>0 ORDER BY modulos.cod_mod ,interfaz.nom_int,cod_per asc"; 
#echo $sql;
#exit;
$db->query($sql); 
$aux=1;
$modulo=0;
?>
var tmenuItems = [
    ["Menu del Sistema","", "menus/data.files/xpicon1_s.gif", "", "", "Menu del Sistema", "", "0", "", ],
        ["|Inicio","index.html", "menus/data.files/icon2_s.gif", "menus/data.files/icon2_so.gif", "", "Inicio", "", "", "", ], 
<?  if($global[1]==1)
	{ ?>	
          ["|Etiquetas","cuadroetiquetas.html", "menus/data.files/icon2_s.gif", "menus/data.files/icon2_so.gif", "", "Inicio", "", "", "", ],  
<? } ?>	  
			<? while($db->next_row()) 
			{			
				if($modulo != $db->cod_mod) 
				{//IMPRIMIR PADRE
					echo '["|'.$db->nom_mod.'","", "menus/data.files/icon3_s.gif", "menus/data.files/icon3_so.gif", "", "'.$db->nom_mod.'", "", "", "", ],';
					$modulo=$db->cod_mod;
				}
				//IMPRIMIR HIJO
		   			echo '  ["||'.$db->nom_int.'","'.$db->rutas.'", "menus/data.files/iconarrs.gif", "menus/data.files/iconarrt.gif", "", "Consultar '.$db->nom_int.'", "", "", "", ],';
		    } 
			$db->close()?>
	
];

dtree_init();

</script>