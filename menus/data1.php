<script language="javascript">

var tstylesNames=["Individual Style","Individual Style","Individual Style","Individual Style",];
var tXPStylesNames=["Individual Style",];

var tlevelDX=20;
var texpanded=0;
var texpandItemClick=1;
var tcloseExpanded=1;
var tcloseExpandedXP=0;
var ttoggleMode=1;
var tnoWrap=1;
var titemTarget="_blank";
var titemCursor="pointer";
var statusString="link";
var tblankImage="data.files/blank.gif";
var tpathPrefix_img="";
var tpathPrefix_link="";

//--- Dimensions
var tmenuWidth="230px";
var tmenuHeight="auto";

//--- Positioning
var tabsolute=1;
var tleft="20px";
var ttop="40px";

//--- Font
var tfontStyle="normal 9pt Tahoma";
var tfontColor=["#3F3D3D","#7E7C7C"];
var tfontDecoration=["none","underline"];
var tfontColorDisabled="#ACACAC";
var tpressedFontColor="#AA0000";

//--- Appearance
var tmenuBackColor="";
var tmenuBackImage="data.files/blank.gif";
var tmenuBorderColor="#FFFFFF";
var tmenuBorderWidth=0;
var tmenuBorderStyle="solid";

//--- Item Appearance
var titemAlign="left";
var titemHeight=22;
var titemBackColor=["#F0F1F5","#F0F1F5"];
var titemBackImage=["data.files/blank.gif","data.files/blank.gif"];

//--- Icons & Buttons
var ticonWidth=21;
var ticonHeight=15;
var ticonAlign="left";
var texpandBtn=["data.files/expandbtn2.gif","data.files/expandbtn2.gif","data.files/collapsebtn2.gif"];
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
var tmoveImage="data.files/movepic.gif";

//--- XP-Style
var tXPStyle=1;
var tXPIterations=10;
var tXPBorderWidth=1;
var tXPBorderColor="#FFFFFF";
var tXPTitleBackColor="#AFB1C3"; 
var tXPTitleBackImg="data.files/xptitle_s.gif";
var tXPTitleLeft="data.files/xptitleleft_s.gif";
var tXPTitleLeftWidth=4;
var tXPIconWidth=31;
var tXPIconHeight=32;
var tXPExpandBtn=["data.files/xpexpand1_s.gif","data.files/xpexpand1_s.gif","data.files/xpcollapse1_s.gif","data.files/xpcollapse1_s.gif"];
var tXPBtnWidth=25;
var tXPBtnHeight=23;
var tXPFilter=1;

//--- Dynamic Menu
var tdynamic=0;

//--- State Saving
var tsaveState=0;
var tsavePrefix="menu1";

var tstyles = [
    ["tfontStyle=bold 8pt Tahoma","tfontColor=#FFFFFF,#E6E6E6","tfontDecoration=none,none"],
    ["tfontStyle=bold 8pt Tahoma","tfontColor=#3F3D3D,#7E7C7C","tfontDecoration=none,none"],
    ["tfontDecoration=none,none"],
    ["tfontStyle=bold 8pt Tahoma","tfontColor=#444444,#5555FF"],
];
var tXPStyles = [
    ["tXPTitleBackColor=#D9DAE2","tXPTitleBackImg=data.files/xptitle2_s.gif","tXPExpandBtn=data.files/xpexpand2_s.gif,data.files/xpexpand3_s.gif,data.files/xpcollapse2_s.gif,data.files/xpcollapse3_s.gif"],
];


var tmenuItems = [

    ["Menu del Sistema","", "data.files/xpicon1_s.gif", "", "", "XP Title Tip", "", "0", "", ],
        ["|Inicio","testlink.htm", "data.files/icon1_s.gif", "data.files/icon1_so.gif", "", "Home Page Tip", "", "", "", ],
        ["|Administracion","", "data.files/icon2_s.gif", "data.files/icon2_so.gif", "", "Product Info Tip", "", "", "", ],
            ["||Parametros de Invenario","", "", "", "", "", "", "", "", ],
			
                ["|||Unidades","", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Almacenes","", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Moviles","", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Tipo de Referncia","", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
            
			["||Parametros de Operacion","", "", "", "", "", "", "", "", ],
			
                ["|||Empleados","", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Carga de Archivo","", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
				
            ["||Parametros de Seguridad","", "", "", "", "", "", "", "", ],
			
                ["|||Perfiles","testlink.htm", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Modulos","testlink.htm", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Permisos","testlink.htm", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
                ["|||Informe Auditoria","testlink.htm", "data.files/iconarrs.gif", "data.files/iconarrt.gif", "", "", "", "", "", ],
				
        ["|Inventario","", "data.files/icon3_s.gif", "data.files/icon3_so.gif", "", "Samples Tip", "", "", "", ],
            ["||Proveedores","testlink.htm", "data.files/iconarrs.gif", "", "", "", "", "", "", ],
            ["||Pedidos","testlink.htm", "data.files/iconarrs.gif", "", "", "", "", "", "", ],
            ["||Referencias","testlink.htm", "data.files/iconarrs.gif", "", "", "", "", "", "", ],
            ["||Movimientos","testlink.htm", "data.files/iconarrs.gif", "", "", "", "", "", "", ],
        ["|Operacion","testlink.htm", "data.files/icon4_s.gif", "data.files/icon4_so.gif", "", "Purchase Tip", "", "", "", ],
        ["|Operaciones Externas","", "data.files/icon5_s.gif", "data.files/icon5_so.gif", "", "Support Tip", "", "", "", ],
            ["||Write Us","mailto:dhtml@dhtml-menu.com", "data.files/iconarrs.gif", "", "", "", "", "", "", ],
];

dtree_init();
</script>