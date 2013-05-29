<?php
    include("lib/database.php");
    if($opcion==1)
	{
	  //Limpiar Compras limpia m_entrada , d_entrada , notas_compra 
	  $dbb = new Database();
	  $sqll = "SELECT MAX(cod_ment) max FROM m_entrada;";
	  $dbb->query($sqll);
	  $dbb->next_row();
	  echo $consecutivo = $dbb->max;
	  $dbb->close(); 
	  $db1 = new Database();
	  $sql1 = "SELECT cod_ment FROM m_entrada WHERE remision=0 ORDER BY cod_ment;";
	  $db1->query($sql1);
	  while($db1->next_row())
	  {
	     $idmaestra = $db1->cod_ment;
		 $db11 = new Database();
		 $sql11 = "DELETE FROM d_entrada WHERE cod_ment_dent=".$idmaestra.";";
		 $db11->query($sql11);
		 $db11->close();
		 $db111 = new Database();
	     $sdel = "DELETE FROM m_entrada WHERE cod_ment=".$idmaestra.";"; //exit;
	     $db111->query($sdel);
	     $db111->close();
	  }
	  $db1->close();
	  $dbc = new Database();
	  $dbc->query("TRUNCATE TABLE notas_compra;");
	  $dbc->close();
	  $dbo = new Database();
	  $db= new Database();
  	  $sqlo = "OPTIMIZE TABLE `d_entrada`;";
	  $dbo->query($sqlo);
	  $dbo->close();
	  $db= new Database();
	  $sql = "OPTIMIZE TABLE `m_entrada`;";
	  $db->query($sql);
	  $db->close();
	  $dba = new Database();
	  $sqla = "ALTER TABLE m_entrada AUTO_INCREMENT =".$consecutivo;
	  $dba->query($sqla);
	  $dba->close();
	   ?>
<script>alert('Operacion Finalizada!')</script>
<form name="frm" action="borrartablas.html" method="post">
<input type="hidden" name="a" value="1">
</form>
<script>document.frm.submit();</script>
<?php	}
if($opcion==2)
{   //Limpiar ventas Limpia m_factura , d_factura , notas_venta
   $db2 = new Database();
   $sql2 = "SELECT cod_fac FROM m_factura;";
   $db2->query($sql2);
   while($db2->next_row())
   {
      $idfac = $db2->cod_fac;
      $db22 = new Database();
	  $sql22 = "DELETE FROM d_factura WHERE cod_mfac=".$idfac.";";
	  $db22->query($sql22);
	  $db22->close();
	  $db222 = new Database();
	  $db222->query("DELETE FROM m_factura WHERE cod_fac=".$idfac.";");
	  $db222->close();
   }
   $db2->close();
   $dbc = new Database();
   $dbc->query("TRUNCATE TABLE notas_ventas;");
   $dbc->close();
   $db= new Database();
   $sql = "OPTIMIZE TABLE `d_factura`;";
   $db->query($sql);
   $db->close();
   $dbb= new Database();
   $sql = "OPTIMIZE TABLE `m_factura`;";	  
   $dbb->query($sql);
   $dbb->close();?>
	   <script>alert('Operacion Finalizada!')</script>
	   <form name="frm" action="borrartablas.html" method="post">
       <input type="hidden" name="a" value="1">
       </form>
<script>//document.frm.submit();</script>
<?php	
}
if($opcion==3)
{ //Limpia cuentas por cobrar abonos, cartera_factura, traza_ventas_pagos , dias_credito
   $dbc = new Database();
   $dbc->query("TRUNCATE TABLE abono;");
   $dbc->close();
   $dbc1 = new Database();
   $dbc1->query("TRUNCATE TABLE cartera_factura;");
   $dbc1->close();
   $dbc2 = new Database();
   $dbc2->query("TRUNCATE TABLE traza_ventas_pagos;");
   $dbc2->close(); ?>
	   <script>alert('Operacion Finalizada!')</script>
	   <form name="frm" action="borrartablas.html" method="post">
       <input type="hidden" name="a" value="1">
       </form>
<script>document.frm.submit();</script>
<?php
}
if($opcion==4)
{
   //Limpia cuentas por pagar
     $dbc = new Database();
     $dbc->query("TRUNCATE TABLE abono_pago;");
     $dbc->close(); 
     $dbc1 = new Database();
     $dbc1->query("TRUNCATE TABLE ajuste;");
     $dbc1->close();
     $dbc2 = new Database();
     $dbc2->query("TRUNCATE TABLE cartera_compras;");
     $dbc2->close();?>
	   <script>alert('Operacion Finalizada!')</script>
	   <form name="frm" action="borrartablas.html" method="post">
       <input type="hidden" name="a" value="1">
       </form>
<script>document.frm.submit();</script>
<?php	 
}
?> 