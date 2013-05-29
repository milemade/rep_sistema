<?php
require_once("lib/database.php");
function infproducto($serial,$campo)
{
   $sql = "SELECT a.nom_pro, a.cod_fry_pro, c.nom_bod, b.cant_ref_kar
		   FROM producto a
		   JOIN kardex b ON a.cod_pro = b.cod_ref_kar
		   JOIN bodega c ON b.cod_bod_kar = c.cod_bod
		   WHERE b.serial = '".$serial."';";
   $db = new Database();
   $db->query($sql);
   $db->next_row();
   $valor = $db->$campo;
   return $valor;
}
$nroinicial = $_POST['inicial'] - 1;
$nrofinal = $_POST['final'] ;
$Totaletiquetas = ceil(($_POST['total'])/3); 
$TotalHojas = ceil($_POST['total']/30); //exit;
$serie = $_POST['serie'];
require('fpdf17/fpdf.php');
$tt = 0;
$d = 0;
$pdf = new FPDF();
for($tt=0;$tt<$TotalHojas;$tt++){
    $pdf->AddPage('P','letter');
	
	 for($i=0; $i<10;$i++)
	{   //Posicion COLUMNA 1
	    if($nroinicial + ($d+1)<=$nrofinal)
		{
			$pdf->SetXY(12, 8+($i*26));
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(10,10,'TEXTILFILH');
			$pdf->SetXY(44, 8+($i*26)); 
			$pdf->Cell(10,10,$serie);
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(12, 12+($i*26));
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+1)),"cod_fry_pro"));
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(12, 15+($i*26)); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+1)),"nom_pro"));
			$pdf->SetFont('Arial','B',9);
			$pdf->SetXY(28, 18+($i*26)); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+1)),"nom_bod"));
			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(12, 21+($i*26)); 
			$pdf->Cell(10,11,($nroinicial + ($d+1)));   
			$pdf->SetXY(38,21+($i*26)); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+1)),"cant_ref_kar"));
		}
		//Posicion COLUMNA 2
		if($nroinicial + ($d+2)<=$nrofinal)
		{
			$pdf->SetXY(85, 8+($i*26));
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(10,10,'TEXTILFILH');
			$pdf->SetXY(117, 8+($i*26)); 
			$pdf->Cell(10,10,$serie);
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(85, 12+($i*26));
			$pdf->Cell(85,10,infproducto(($nroinicial + ($d+2)),"cod_fry_pro"));
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(85, 17); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+2)),"nom_pro"));
			$pdf->SetFont('Arial','B',9);
			$pdf->SetXY(101, 18+($i*26)); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+2)),"nom_bod"));
			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(85, 21+($i*26)); 
			$pdf->Cell(10,11,($nroinicial + ($d+2)));   
			$pdf->SetXY(111,21 +($i*26)); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+2)),"cant_ref_kar"));
		}
		if($nroinicial + ($d+3)<=$nrofinal)
		{
		/*POSICION columna 3*/
			$pdf->SetXY(158, 8 +($i*26));
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(10,10,'TEXTILFILH');
			$pdf->SetXY(190, 8+($i*26)); 
			$pdf->Cell(10,10,$serie);
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(158, 12+($i*26));
			$pdf->Cell(85,10,infproducto(($nroinicial + ($d+3)),"cod_fry_pro"));
			$pdf->SetFont('Arial','B',8);
			$pdf->SetXY(158, 15+($i*26)); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+3)),"nom_pro"));
			$pdf->SetFont('Arial','B',9);
			$pdf->SetXY(174, 18+($i*26)); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+3)),"nom_bod"));
			$pdf->SetFont('Arial','B',6);
			$pdf->SetXY(158, 21+($i*26)); 
			$pdf->Cell(10,11,($nroinicial + ($d+3)));   
			$pdf->SetXY(179,21+($i*26)); 
			$pdf->Cell(10,10,infproducto(($nroinicial + ($d+3)),"cant_ref_kar"));
		}
		$d +=3;
		#Establece el margen inferior: 
		$pdf->SetAutoPageBreak(true,-15);	 		
	 } 
}
	
$pdf->Output();
?>