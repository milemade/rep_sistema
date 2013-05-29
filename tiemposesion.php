<?php
    require_once("lib/database.php");
	$db = new Database();
	$sql = 'SELECT txs_num FROM tiempo;';
	$db->query($sql);
	$db->next_row();
	$tmp = $db->txs_num;
	$db->close();
	if($tiempo>0 && $tiempo<=20)
	{
	    $sql = 'UPDATE tiempo SET txs_num='.$tiempo.';';
		$db = new Database();
		$db->query($sql);
		$filaafec = $db->affected_rows();
		if($filaafec ==1)
		{ ?>
		<script>alert('Actualizado con exito');window.location="inicio.php";</script>
	<?	}
	}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <title>Configurar tiempo de la sesion</title>
		<style>
		 nav{
		 		float:left;
				width: 150px;
			}
			section{
				float:right;
				width:570px;
			}
			footer{
			  padding-top: 150px;
			  float:left
			  font-family: Arial, Helvetica, sans-serif;
			  font-weight: bolder;
	          color: #333333;
			
			}
			.tabla
			{
			   clear: none;
			   overflow: auto;
			}
			.fila
			{
			   clear: both;
			}

			.columna
			{
			   float: left;
			   padding: 5px;
			   //border-style: solid;
			   border-right-width: 0px;
			   border-left-width: 0px;
			   border-top-width: 0px;
			   border-bottom-width: 1px;
			   font-family: Arial, Helvetica, sans-serif;
	           font-size: 12px;
	           font-weight: bolder;
	           color: #333333;
			}
		</style>
		<script>
		function validarnumero(e) { // 1
    tecla = (document.all) ? e.keyCode : e.which; // 2
    if (tecla==8) return true; // 3
    //patron =/[A-Za-z\s]/; // 4
    patron = /\d/; // Solo acepta números
    //patron = /\w/; // Acepta números y letras
    //patron = /\D/; // No acepta números
    //patron =/[A-Za-zñÑ\s]/; // igual que el ejemplo, pero acepta también las letras ñ y Ñ
    //patron = /[ajt69]/;
    te = String.fromCharCode(tecla); // 5
    return patron.test(te); // 6
} 
		</script>
    </head>
    <body>
       <header><h1>Tiempo de sesion</h1></header>
        <nav>
        </nav>
		<form name="frm5" method="POST">
	<div class="tabla">
    <div class="fila">
        <div class="columna">Tiempo</div>
        <div class="columna"><input type="number" name="tiempo" onkeypress="return validarnumero(event);" size="5" value="<?=$tmp?>" maxlength="2">&nbsp;&nbsp;Minutos</div>
		<div class="columna"><input type="submit" name="enviar" value="Enviar"></div>
    </div>
    </div>
     </form>   
        <footer>
            <small>
                Copyright &copy; 2012<br/>
                Actualizado en: 11 Noviembre 2012           
            </small>        
        </footer>
    </body>