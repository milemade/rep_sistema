<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> 
 
<title>Proga-Tero</title> 
 <link rel="stylesheet" type="text/css" href="css/mbContainer.css" title="style"  media="screen"/> 
  <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script> 
  <script type="text/javascript" src="inc/ui.core.min.js"></script> 
  <script type="text/javascript" src="inc/ui.draggable.min.js"></script> 
  <script type="text/javascript" src="inc/ui.resizable.min.js"></script> 
  <script type="text/javascript" src="inc/jquery.metadata.js"></script> 
  <script type="text/javascript" src="inc/mbContainer.js"></script> 
  <script type="text/javascript" src="inc/jquery.timers.js"></script> 
<script type="text/javascript" src="inc/jquery.dropshadow.js"></script> 
<script type="text/javascript" src="inc/mbTooltip.js"></script> 
<script type="text/javascript" src="inc/categorias.js"></script> 
<link href="css/mbTooltip.css" rel="stylesheet" type="text/css" title="style1"  media="screen" /> 
  <script language="text/JavaScript"  type="text/javascript"> 
    $(function(){
      function wConsole(o, prop){
        if (!$("#consoleAct").is(':checked')) return;
        var p={};
        $.extend(p,prop);
		//<![CDATA[
        var txt = ""+o.find(".n:first").html()+"::  ";
		//]]>
        for (var property in p)
        {
		  //<![CDATA[	
          var pr = p [property];
          txt+= "<br />" + property + " = " + pr ;
		  
        }
        txt+="<br /><hr />";
		//]]>
        $("#mb_console").append(txt);
      }
 
      //      $(".containerPlus").buildContainers({
      //        containment:"document",
      //        elementsPath:"elements/"
      //      });
 
      $(".containerPlus").buildContainers({
        containmentId:"document",
        elementsPath:"elements/",
        onResize:function(o){
          wConsole(o,{
            resized:true,
            width: o.outerWidth(),
            height: o.outerHeight()
          });
        },
        onClose:function(o){
          wConsole(o,{
            closed: o.mb_getState("closed")
          });
        },
        onCollapse:function(o){
          wConsole(o,{
            collapse: o.mb_getState("collapsed")
          });
        },
        onIconize:function(o){
          wConsole(o,{
            iconized: o.mb_getState("iconized")
          });
        },
        onDrag:function(o){
          wConsole(o,{
            top: o.offset().top,
            left: o.offset().left
          });
        }
      });
	  $(".pub").hover(function() {
		$(this).css({ color: "#F60"}); 
	  }, function() {
		$(this).css({ color: "#FFF"}); 
	});
    
    $(".publi2").hover(function() {
		$(this).css({ color: "#F60"}); 
	  }, function() {
		$(this).css({ color: "#FFF"}); 
	});
    });
    
    
    $(function(){
    $("[title]").mbTooltip({ // also $([domElement]).mbTooltip  >>  in this case only children element are involved
      opacity : .97,       //opacity
      wait:100,           //before show
      cssClass:"default",  // default = default
      timePerWord:70,      //time to show in milliseconds per word
      hasArrow:false,			// if you whant a little arrow on the corner
      hasShadow:true,
      imgPath:"images/",
      ancor:"mouse", //"parent"  you can ancor the tooltip to the mouse position or at the bottom of the element
      shadowColor:"black", //the color of the shadow
      mb_fade:200 //the time to fade-in
    });
  });
  </script> 
  
  <script language="text/JavaScript"  type="text/javascript"> 
	function categorias(){
    window.open("categorias.php","Categorias","width=400,height=400,scrollbars=YES")
	} 
  </script> 
  
<style type="text/css"> 
    .evidence{
      color:gray;
      padding:10px;
      margin-right:5px;
      margin-top:5px;
      -moz-border-radius:10px;
      -webkit-border-radius:10px;
    }
 
    #dock{
      display:block;
      padding-top:10px;
      height:30px;
    }
    #dock img{
      padding-right:10px;
    }
 
    #desk{
      width:100%;
    }
 
    #desk td{
      padding:5px;
      -moz-border-radius:5px;
      -webkit-border-radius:5px;
    }
    #mb_console{
      padding:5px;
      background:gainsboro;
      -moz-border-radius:5px;
      -webkit-border-radius:5px;
      font-size:10px;
      height:400px;
      overflow:auto;
    }
  body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.publi {
	font-size:10px;
	color:#F60;
	
}
.publi2 {
	font-size:12px;
	color:#FFF;
}
.publi_search {
	font-size:12px;
	color:#F60;
}
.pub {
	font-size:10px;
	color:#FFF;
}
.pub2 {
	font-size:10px;
	color:#F60;
}
.categor {
	display:none;
}
 
.bot_cat {
	cursor:pointer;
}
.bot_ana {
	cursor:pointer;
	font-size:10px;
}
 
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
.esta {
	color: #F60;
}
 
 
 
</style> 
 
</head> 
<body> 
 
<div class="categoria"> 
<div class="containerPlus draggable resizable {buttons:'m', icon:'publicacion.png', skin:'default', collapsed:'false',width:'240',height:'450' ,iconized:'false',dock:'dock'}" style="top:170px;left:830px"> 
    
    <div class="no"><div class="ne"><div class="n">Categorias</div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
        <form name="categorias" action="" method="post"> 
        <table cellpadding="0" width="100%" cellspacing="0"> 
		<tr><td width='15'><img src='cat/noticias.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=1' />Noticias</td></tr><tr><td width='15'><img src='cat/php.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=2' />PHP</td></tr><tr><td width='15'><img src='cat/as.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=3' />Action Script</td></tr><tr><td width='15'><img src='cat/appicondoc.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=4' />XHTML</td></tr><tr><td width='15'><img src='cat/java.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=5' />Java Script</td></tr><tr><td width='15'><img src='cat/scripts.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=6' />Scripts</td></tr><tr><td width='15'><img src='cat/proyectos.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=7' />Proyectos</td></tr><tr><td width='15'><img src='cat/css.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=8' />CSS</td></tr><tr><td width='15'><img src='cat/xml.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=9' />XML</td></tr><tr><td width='15'><img src='cat/mini.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=10' />Tutoriales</td></tr><tr><td width='15'><img src='cat/book.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=11' />Libros</td></tr><tr><td width='15'><img src='cat/vt.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=12' />Video Tutoriales</td></tr><tr><td width='15'><img src='cat/tools.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=13' />Herramientas</td></tr><tr><td width='15'><img src='cat/apli.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=14' />Aplicaciones</td></tr><tr><td width='15'><img src='cat/ajax.png' alt='Categoria' width='24' height='24' border='0' /></td><td width='85'><a href='index.php?cat=15' />Ajax</td></tr>        </table> 
        </form>  
        </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
</div> 
 
<div class="normas"> 
<div class="containerPlus draggable resizable {buttons:'m', icon:'rules.png', skin:'default', collapsed:'false',width:'750',height:'450' ,iconized:'false',dock:'dock'}" style="top:170px;left:10%"> 
    
    <div class="no"><div class="ne"><div class="n">Normas Generales</div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
        
        <table cellpadding="0" style="width:100%;" cellspacing="0"> 
        <tr><td> 
		PHP-Tero, es una pagina diseÃ±ada para compartir imagenes, informacion, videos, <br /> 
tutoriales, herramientas, dejar comentarios a las publicaciones que mas te gusten...etc.<br /> 
<br /> 
Cualquiera puede publicar en PHP-Tero <br /> 
<br /> 
Publica informacion que te parezca interesante para las demas personas.<br /> 
Cuanto mas calidad tengan tus publicaciones mas puntos recibiras.<br /> 
Deja comentarios creativos, asi otros usuarios se ven tentados a ver tus publicaciones.<br /> 
Y muchas otras genialidades que iras descubiendo mientras uses PHP-Tero.<br /> 
<br /> 
<br /> 
<strong>Esta Prohibido:</strong><br /> 
<br /> 
* Publicar pornografia (acuerdate que en esta pagina pueden entrar menores).<br /> 
* Publicar con el fin de generar polemica (todos queremos pasarlo bien, no pelearnos).<br /> 
* Material racista.<br /> 
* Cosas morbosas (asesinatos, sangre, cosas escatologicas, etc).<br /> 
* Apologia del delito.<br /> 
* Hacer Spam<br /> 
* Datos de terceros (mails, Numeros telefonicos, etc).<br /> 
* Publicar mensajes privados, tanto de otros usuarios, como propias, los mensajes <br /> 
privados deben mantener caracter de tal.<br /> 
* Publicaciones a favor del nazismo, fachismo, a favor de la violencia, <br /> 
la guerra o que contengan ideaoligias extremas y/o fanaticas.<br /> 
Publicaciones a favor o en contra de campaÃ±as politicas.<br /> 
* Publicar cosas que no tengan que ver con los temas, PHP, Herramientas Web, Web 2.0, Scripts php,<br /> 
tutoriales php, etc...<br /> 
<br /> 
<strong>Esta permitido:</strong><br /> 
<br /> 
* Todo, menos lo que esta prohibido.<br /> 
<br /> 
<br /> 
<strong>Trata de:</strong><br /> 
<br /> 
* Si lo que posteas no es material propio, citar la fuente original de donde lo sacaste.<br /> 
* No repetir post con el mismo contenido (salvo que los links no sean los mismos).<br /> 
* No realizar comentarios ofensivos, racistas e insultantes (nunca digas algo que te <br /> 
ofenderia si te lo dijeran a ti).<br /> 
<br /> 
<br /> 
<strong>Sobre comentarios:</strong><br /> 
<br /> 
Se eliminan o modifican comentarios que contengan:<br /> 
<br /> 
<br /> 
* Abuso de mayÃºsculas.<br /> 
* Insultos, ofensas, etc..<br /> 
* Comentarios racistas y/o peyorativos.<br /> 
* TipografÃ­as o imagenes muy grandes queriendo llamar la atenciÃ³n.
        </td></tr> 
        </table> 
          
        </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
</div> 
 
<div align="center"> 
<div id="getState" class="containerPlus {skin:'black', collapsed:'false',width:'1000',height:'50' ,iconized:'false',dock:'dock'}" style="top:0px;left:0px"> 
    
    <div class="no"><div class="ne"><div class="n"></div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
 
          <!--     texto     --> 
          <div align="left"> 
            <table style="width:100%;" border="0" cellspacing="0" cellpadding="0"> 
              <tr> 
                <td width="50%"><img src="elements/icons/logo.png" width="259" height="79" alt="#" /></td> 
                <td width="50%" align="right"> 
               <a href="http://www.000webhost.com/47391.html/" target="_blank"><img src="http://www.000webhost.com/images/banners/468x60/banner13.gif" alt="Free Website Hosting" style="height:60; width:480;" border="0" /></a> 
                </td> 
              </tr> 
            </table> 
          </div> 
          </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
</div> 
 
<div id="contenedor" align="center"> 
<div class="containerPlus {skin:'white',width:'1000',height:'20'}" style="top:0px;left:0px"> 
    
    <div class="no"><div class="ne"><div class="n"> 
      <div style="font-size:12px"> 
    <a href="index.php">Inicio</a>  |
      <span class="bot_ana" title="AÃ±adir PublicaciÃ³n"><a href="input.php"> Agregar Publicacion</a></span>  |
        <a href="#"><span class="bot_norm" title="Haz click, para abrir / cerrar la ventana">Normas</span></a>  |
          <a href="#">Preguntas</a>  |
            <a href="registro.php">Registrarse</a> |
             <a href="#"><span class="bot_cat" title="Haz click, para abrir / cerrar la ventana">Categorias</span></a> 
          </div> 
           
    </div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
 
          </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
</div> 
 
<table align="center" style="width:1000;" border="0" cellpadding="0" cellspacing="0"> 
<tr> 
<td width="260" valign="top"> 
<div id="getState0" class="containerPlus {buttons:'m', icon:'login.png', skin:'black', collapsed:'false',width:'260',height:'100%' ,iconized:'false',dock:'dock'}" style="top:0px;left:0px"> 
    
    <div class="no"><div class="ne"><div class="n">Login</div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
 
          <!--     texto     --> 
<table style="width:205; height:26;" border="0" cellpadding="0" cellspacing="0"> 
       
       <tr> 
         <td valign="top">&nbsp;</td> 
         <td valign="top">&nbsp;</td> 
       </tr> 
       <tr> 
         <td width="20" valign="top">&nbsp;</td> 
         <td width="270" valign="top"> 
                           <form id="form2" name="form2" method="post" action="connect.php"> 
           <table width="200" border="0" cellspacing="1" cellpadding="0"> 
             <tr> 
               <td width="88">Usuario:</td> 
               <td width="159"><input name="user" type="text" class="Estilo1" id="user" size="15" maxlength="35" /></td> 
             </tr> 
             <tr> 
               <td>Contrase&ntilde;a:</td> 
               <td><input name="pass" type="password" class="Estilo1" id="pass" size="15" maxlength="35" /></td> 
             </tr> 
             <tr> 
               <td>&nbsp;</td> 
               <td><input name="enviar" type="submit" class="Estilo1" id="enviar" value="Logear" /></td> 
             </tr> 
             <tr> 
               <td colspan="2"><hr /></td> 
               </tr> 
             <tr> 
               <td class="Estilo3" colspan="2"><div align="center">Recordar Contrase&ntilde;a</div></td> 
               </tr> 
             <tr> 
               <td class="Estilo3" colspan="2"><div align="center"><a href="registro.php">Registrarse</a></div></td> 
               </tr> 
             <tr> 
               <td colspan="2"><hr /></td> 
               </tr> 
           </table> 
                </form> 
                           </td> 
       </tr> 
       <tr> 
         <td colspan="2" valign="top">&nbsp;</td> 
       </tr> 
     </table> 
           </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
<!--   Columna izquierda     --> 

<div id="getState1" class="containerPlus {buttons:'m', icon:'estadisticas.png', skin:'black', collapsed:'false',width:'260',height:'100%' ,iconized:'false',dock:'dock'}" style="top:0px;left:0px"> 
    
    <div class="no"><div class="ne"><div class="n">Estadisticas</div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
 
          <!--     texto     --><table style="width:213; height:36;" border="0" cellpadding="0" cellspacing="0"> 
         <tr> 
           <td colspan="4" class="Estilo2">&nbsp;</td> 
         </tr> 
         <tr> 
           <td colspan="4"> 
             Hay <span class='esta'>1 </span>usuario en linea.           </td> 
         </tr> 
         <tr> 
           <td colspan="4"><hr /></td> 
         </tr> 
         <tr> 
           <td width="33"><img src="elements/icons/publicacion.png" width="20" height="20" alt="#" /></td> 
           <td>Publicaciones:</td> 
           <td width="22" colspan="2"><iframe name="rotater"
Width="100%"
height="100%"
frameborder="0"
src="http://xlphp.net/blog2/"
marginwidth="0"
marginheight="0"
vspace="0"
hspace="0"
allowtransparency="true"
scrolling="auto"> 
</iframe> 
<!-- 399 310 772 188 121 747 908 375 658 989 471 891 842 282 539 788 863 399 310 772 188 121 747 908 375 658 989 471 891 842 282 539 788 863 399 310 772 188 121 747 908 375 658 989 471 891 842 282 539 788 863 526 640 917 51 415 140 573 716 965 688 395 829 76 810 801 733 244 95 205 283 488 189 705 173 743 574 947 608 694 973 886 298 223 449 99 309 936 432 209 623 454  ph--><td width='94%'><a href='verpost.php?val=61' title='Cualquier Chuleta, recopilacion de chuletas'><span class='publi2'>Cualquier Chuleta, recopilacion de chuletas</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=60' title='Herramientas online para diseÃ?Â±o web'><span class='publi2'>Herramientas online para diseÃ?Â±o web</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/java.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=59' title='Ventana Aceptar/Cancelar con Javascript'><span class='publi2'>Ventana Aceptar/Cancelar con Javascript</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/scripts.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=58' title='Enviar email con PHP'><span class='publi2'>Enviar email con PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=57' title='Iconos, Banners, Templates y muxo mas'><span class='publi2'>Iconos, Banners, Templates y muxo mas</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/css.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=56' title='Manual CSS'><span class='publi2'>Manual CSS</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=54' title='Chuleta JavaScript'><span class='publi2'>Chuleta JavaScript</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=53' title='Chuleta MySQL'><span class='publi2'>Chuleta MySQL</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=52' title='Chuleta Caracteres Especiales'><span class='publi2'>Chuleta Caracteres Especiales</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=51' title='Chuleta HTML'><span class='publi2'>Chuleta HTML</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/mini.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=47' title='Optimiza tu codigo PHP'><span class='publi2'>Optimiza tu codigo PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/mini.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=46' title='Tutorial XSLT'><span class='publi2'>Tutorial XSLT</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/scripts.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=45' title='Comprobar que una direcciÃ?Â³n existe con PHP'><span class='publi2'>Comprobar que una direcciÃ?Â³n existe con PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=44' title='scripts PHP que deberÃ?Â­as conocer'><span class='publi2'>scripts PHP que deberÃ?Â­as conocer</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=43' title='recursos para programadores PHP'><span class='publi2'>recursos para programadores PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/scripts.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=42' title='Eliminar espacios en blanco con PHP'><span class='publi2'>Eliminar espacios en blanco con PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/scripts.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=41' title='nÃ?Âºmero de lÃ?Â­neas de un archivo con PHP'><span class='publi2'>nÃ?Âºmero de lÃ?Â­neas de un archivo con PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/scripts.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=40' title='Tipos de enlaces en HTML5'><span class='publi2'>Tipos de enlaces en HTML5</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=39' title='Chuleta completa de PHP'><span class='publi2'>Chuleta completa de PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=38' title='webmail en PHP con AtMail'><span class='publi2'>webmail en PHP con AtMail</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/css.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=37' title='Barras de progreso con CSS'><span class='publi2'>Barras de progreso con CSS</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/css.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=36' title='Chuleta completa sobre CSS'><span class='publi2'>Chuleta completa sobre CSS</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/apli.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=35' title='CodeGear DELPHI FOR PHP'><span class='publi2'>CodeGear DELPHI FOR PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=34' title='Iconos y Cursores para la WEB'><span class='publi2'>Iconos y Cursores para la WEB</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=33' title='Listado de directorio HTTP mediante PHP'><span class='publi2'>Listado de directorio HTTP mediante PHP</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/mini.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=32' title='Mejoras de rendimiento en PHP 5.3'><span class='publi2'>Mejoras de rendimiento en PHP 5.3</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/apli.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=31' title='ISP Config (tu negocio de hosting)'><span class='publi2'>ISP Config (tu negocio de hosting)</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/apli.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=30' title='eyeOS 1.6'><span class='publi2'>eyeOS 1.6</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=28' title='Comparte archivos con PHP de forma segura'><span class='publi2'>Comparte archivos con PHP de forma segura</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/tools.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=26' title='Nueva versiÃ?Â³n de TCPDF, clase PHP para crear PDFs'><span class='publi2'>Nueva versiÃ?Â³n de TCPDF, clase PHP para crear PDFs</span></a></td></tr></table><table width='100%' border='0' cellspacing='1' cellpadding='0'><tr><td width='6%'><img src='cat/apli.png' width='18' height='18' align='middle' alt='?' /></td><td width='94%'><a href='verpost.php?val=25' title='Epiware: gestiona tu documentacion'><span class='publi2'>Epiware: gestiona tu documentacion</span></a></td></tr></table></form><br /><center><a href='index.php?pagina=2'><span class='publi'>&lt;&lt;Anterior</span></a><a href='index.php?pagina=1'> 1 </a><a href='index.php?pagina=2'> 2 </a><a href='index.php?pagina=3'> 3 </a><a href='index.php?pagina=4'> 4 </a><a href='index.php?pagina=4'><span class='publi'>Siguiente&gt;&gt;</span></a></center>           
           </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
 
</td> 
<td width="260" valign="top"> 
<div align="left" id="getState4" class="containerPlus {buttons:'m', icon:'buscar.png', skin:'black', collapsed:'false',width:'260',height:'100%' ,iconized:'false',dock:'dock'}" style="top:0;left:0px"> 
    
    <div class="no"><div class="ne"><div class="n">Buscador</div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
		  <center> 
          <form name="form_bus" method="post" action="" id="form_bus"> 
          <input type="text" name="bus" id="bus" /> 
          <!-- <input type="submit" name="submit" value="Buscar" class="bot_bus" /> --> 
          <a href="#" onclick="document.form_bus.submit();return false"> 
          <img src="elements/icons/searching.png" width="26" height="26" align="middle" border="0" alt="#" /></a> 
          </form> 
          </center> 
           </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
 
 
<div align="left" id="getState5" class="containerPlus {buttons:'m', icon:'publicaciones.png', skin:'black', collapsed:'false',width:'260',height:'100%' ,iconized:'false',dock:'dock'}" style="top:0;left:0px"> 
    
    <div class="no"><div class="ne"><div class="n">Publicaciones mas vistas</div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
 
          <!--     texto     --><form id='pub_mas_vistas' name='pub_mas_vistas' method='post' action=''><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=15' title='950 Scripts PHP'><span class='pub'>950 Scripts PHP</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 951</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=37' title='Barras de progreso con CSS'><span class='pub'>Barras de progreso con CSS</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 157</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=36' title='Chuleta completa sobre CSS'><span class='pub'>Chuleta completa sobre CSS</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 144</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=19' title='PHP para programadores'><span class='pub'>PHP para programadores</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 137</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=44' title='scripts PHP que deberÃ?Â­as conocer'><span class='pub'>scripts PHP que deberÃ?Â­as co... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 128</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=12' title='Aprender Fundamentos Web'><span class='pub'>Aprender Fundamentos Web</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 121</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=34' title='Iconos y Cursores para la WEB'><span class='pub'>Iconos y Cursores para la WE... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 115</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=39' title='Chuleta completa de PHP'><span class='pub'>Chuleta completa de PHP</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 112</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=116' title='Desarrollo de Sitios Web VersiÃ?Â³n 2.0'><span class='pub'>Desarrollo de Sitios Web Ver... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 110</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=32' title='Mejoras de rendimiento en PHP 5.3'><span class='pub'>Mejoras de rendimiento en PH... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 109</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=119' title='Como se mide la calidad de una pagina web?'><span class='pub'>Como se mide la calidad de u... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 99</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=43' title='recursos para programadores PHP'><span class='pub'>recursos para programadores ... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 94</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=47' title='Optimiza tu codigo PHP'><span class='pub'>Optimiza tu codigo PHP</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 93</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=110' title='Haz copia de seguridad de los registros MySql'><span class='pub'>Haz copia de seguridad de lo... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 92</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=71' title='70 Javascript  para cada Programador web'><span class='pub'>70 Javascript  para cada Pro... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 88</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=146' title='Varias Herramientas Web'><span class='pub'>Varias Herramientas Web</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 87</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=11' title='Servidor Web Portable'><span class='pub'>Servidor Web Portable</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 81</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=105' title='Funciones PHP Ã?Âºtiles'><span class='pub'>Funciones PHP Ã?Âºtiles</span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 80</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=69' title='Libro gratis PHP 5 formato PDF'><span class='pub'>Libro gratis PHP 5 formato P... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 75</span></div></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='85%'><a href='verpost.php?val=63' title='Administrador Portable para MySQL (EMS Manager)'><span class='pub'>Administrador Portable para ... </span></a></td><td class='Estilo5' width='15%'><div align='right'><span class='publi'> 74</span></div></td></tr></table></form>           </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
 
 
<div align="left" id="getState6" class="containerPlus {buttons:'m', icon:'ultimoscom.png', skin:'black', collapsed:'false',width:'260',height:'100%' ,iconized:'false',dock:'dock'}" style="top:0;left:0px"> 
    
    <div class="no"><div class="ne"><div class="n">Ultimos Comentarios</div></div> 
      <div class="o"><div class="e"><div class="c"> 
        <div class="mbcontainercontent"> 
 
          <!--     texto     --><form id='comentarios' name='comentarios' method='post' action=''><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=149'><span class='pub'>Â¿Y no te lo puede... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· dani</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=149'><span class='pub'>Â¿Que dices?
 
... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· Miguelithox</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=116'><span class='pub'>LINK MUERTO...... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· Miguelithox</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=14'><span class='pub'>Ã?Â¿Esto te ayudarÃ?... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· Miguelithox</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=129'><span class='pub'>Yo te podrÃ?Â­a ayu... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· Miguelithox</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=129'><span class='pub'>no puedo venderte... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· admin</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=0'><span class='pub'>Que dices?... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· Miguelitho</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=128'><span class='pub'>Se Agradece!!!... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· </span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=116'><span class='pub'>muy bueno, pero c... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· Miguelitho</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=117'><span class='pub'>Saludines, Ã?Â¿CuÃ?Â¡... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· Miguelitho</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=15'><span class='pub'>Ã?Â¿El de esta web ... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· Miguelitho</span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=101'><span class='pub'>Buena... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· </span></td></tr></table><table width='100%' border='0' cellspacing='0' cellpadding='1'><tr><td class='Estilo6' width='65%'><a href='verpost.php?val=98'><span class='pub'>No has metido ima... </span></a></td><td class='Estilo6' width='35%'><span class='pub2'>Â· </span></td></tr></table></form>           </div> 
      </div></div></div> 
      <div > 
        <div class="so"><div class="se"><div class="s"> </div></div></div> 
      </div> 
    </div> 
  </div> 
 
</td> 
</tr> 
</table> 
 
 
 
 
</body> 
</html> 
 
 
 
 
 
 
 
 
 
 
 