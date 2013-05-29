<?php 
ini_set('memory_limit' , '256M');
set_time_limit(0);
mysql_connect("localhost","construc","D119W5n123");
mysql_select_db("construc_facturacion");
require_once('tcpdf.php');
 
// extend TCPF with custom functions
class MYPDF extends TCPDF {
 
    // Colored table
    public function ColoredTable($header,$data,$buscar,$opcionbuscar) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(28, 20, 20, 80, 20, 20, 16,20,20,27);
        $num_headers = count($header);
		$totalcantidadbuscar = 0;
		$totalprebuscar = 0;
        for($i = 0; $i < $num_headers; ++$i) {             
		    $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
		$cn = 0;
		$vl = 0;
        // Data
        $fill = 0;
		foreach($data as $row) {
		    $nombrebodega = $row['nom_bod'];
		    $nombremarca =  $row['nom_mar'];
			$nombretipoproducto = $row['nom_tpro'];
			$nombreproducto = $row['nom_pro'];
			$codigoproducto = $row['cod_fry_pro'];
			$serial = $row['serial'];
			$color = $row['nom_pes'];
			$cantidad = $row['totalcan'];
			$valorprecio = $row['valor_precio'];
			$totalpre = $row['totalpre'];
			if($nombrebodega!="" && $nombremarca!="" && $nombretipoproducto!="" && $nombreproducto!="" && $codigoproducto!="" && $serial>0
			    && $cantidad>0 && $valorprecio>0 && $totalpre>0)  
			{
				$cn = $cn + $cantidad;
                $vl = $vl + $totalpre;	
				$this->Cell($w[0], 6, $nombrebodega, 'LR', 0, 'L', $fill);
				$this->Cell($w[1], 6, $nombremarca, 'LR', 0, 'C', $fill);
				$this->Cell($w[2], 6, $nombretipoproducto, 'LR', 0, 'C', $fill);
				$this->Cell($w[3], 6, $nombreproducto, 'LR', 0, 'L', $fill);
				$this->Cell($w[4], 6, $codigoproducto, 'LR', 0, 'C', $fill);
				$this->Cell($w[5], 6, $serial, 'LR', 0, 'C', $fill);
				$this->Cell($w[6], 6, $color, 'LR', 0, 'C', $fill);
				$this->Cell($w[7], 6, number_format($cantidad,2,".","."), 'LR', 0, 'C', $fill);
				$this->Cell($w[8], 6, number_format($valorprecio,0,".","."), 'LR', 0, 'C', $fill);
				$this->Cell($w[9], 6, number_format($totalpre,0,".","."), 'LR', 0, 'C', $fill);
				$this->Ln();
				$fill=!$fill;
				
			}//if campos no vacios
			if($nombrebodega!='' && $nombremarca!="" && $nombretipoproducto!="" && $nombreproducto!="" && $codigoproducto=='' && $serial==''  
			   &&color!='' && $cantidad>0 && $valorprecio>0 && $totalpre>0)	{
			    
			    $this->Cell(204, 6, 'CANTIDAD TOTAL PROD', 'LR', 0, 'R', $fill);
				$this->Cell($w[7], 6, number_format($cantidad,2,".","."), 'LR', 0, 'C', $fill);
				$this->Cell($w[8], 6, 'TOTAL', 'LR', 0, 'C', $fill);
				$this->Cell($w[9], 6, number_format($totalpre,0,".","."), 'LR', 0, 'C', $fill);
				$this->Ln();
				$fill=!$fill;
                			
			}
        }//End foreach
		$this->Cell(204, 6, 'CANTIDAD TOTAL', 'LR', 0, 'R', $fill);
		$this->Cell($w[7], 6, number_format($cn,2,".","."), 'LR', 0, 'C', $fill);
		$this->Cell($w[8], 6, 'VAL. TOTAL', 'LR', 0, 'C', $fill);
		$this->Cell($w[9], 6, number_format($vl,0,".","."), 'LR', 0, 'C', $fill);
		$this->Ln();
		$fill=!$fill;	   
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}
 
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
 
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Jordi Girones');
$pdf->SetTitle('TCPDF Tutorial - TCPDF + MySQL');
$pdf->SetSubject('TCPDF Tutorial - TCPDF + MySQL');
$pdf->SetKeywords('TCPDF, PDF, example, test, mysql');
 
// set default header data
$pdf->SetHeaderData("", PDF_HEADER_LOGO_WIDTH, "INFORME INVENTARIOS", "Usuario. ".$usuario." ".Date('Y-m-d H:i:s'));
 
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
 
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
 
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
 
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
 
//set some language-dependent strings
$pdf->setLanguageArray($l);
 
// ---------------------------------------------------------
 
// set font
$pdf->SetFont('helvetica', '', 10);
 
// add a page
$pdf->AddPage();
 
//Column titles
$header = array('Bodega', 'Categoria', 'Tipo Pro','Producto','Codigo','Serial','Color','Cantidad','Precio','Total');
 
//Data loading
$sql = "SELECT SQL_CACHE nom_bod,nom_mar,
               nom_tpro, nom_pro,
			   cod_fry_pro,serial,
			   nom_pes,totalcan,
			   valor_precio,totalpre FROM infinventario ";
                if(isset($buscar) && $opcionbuscar==1)
				{  //Busqueda nombre marca
					$sql .="WHERE nom_mar LIKE '%".$buscar."%'";
				}
				if(isset($buscar) && $opcionbuscar==2)
				{ //Busqueda Codigo producto
					$sql .= "WHERE cod_fry_pro='".$buscar."' ";
				}
				if(isset($buscar) && $opcionbuscar==3)
				{ //Busqueda nombre producto
					$sql .= "WHERE nom_pro LIKE '%".$buscar."%' ";
				}
				if(isset($buscar) && $opcionbuscar==4)
				{ // POr nombre de tipo producto
			       $sql .="WHERE nom_tpro LIKE '%".$buscar."%' ";
				}
                if(isset($buscar) && $opcionbuscar==5)
				{//Nombre de Bodega
					$sql .= "WHERE nom_bod LIKE'%".$buscar."%' ";
				}
				if(isset($buscar) && $opcionbuscar==6)
				{ //Busqueda Pieza/Serial
					$sql .= "WHERE serial='".$buscar."' ";
				}
				//$sql.= "LIMIT 0,90";
$rs = mysql_query($sql);
if (mysql_num_rows($rs)>0){
    while($rw = mysql_fetch_array($rs)){
        $data[] = $rw;
    }
}
 
// print colored table
$pdf->ColoredTable($header, $data,$buscar,$opcionbuscar);
 
// ---------------------------------------------------------
 
//Close and output PDF document
$pdf->Output('informeinventario.pdf', 'I');
 
//============================================================+
// END OF FILE
//=====================================
?>