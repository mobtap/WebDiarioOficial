<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);

$edi_codigo = $_REQUEST['edi_codigo'];

require_once('library/fpdf/fpdf.php');
require_once('library/fpdi/src/autoload.php');
require_once('library/PDFMerger.php');
include ('db.inc.php'); 


function geracabecario($edi_codigo) {
require_once('library/fpdf/fpdf.php');
require_once('library/fpdi/src/autoload.php');
require_once('library/PDFMerger.php');
include ('db.inc.php'); 

$pdf = new \setasign\Fpdi\Fpdi();
	$q = pg_query("select CASE WHEN EXTRACT(DOW FROM die_datacadastro) = 7 THEN 'Domingo'
            WHEN EXTRACT(DOW FROM die_datacadastro) = 1 THEN 'Segunda-feira'
            WHEN EXTRACT(DOW FROM die_datacadastro) = 2 THEN 'Terca-feira'
            WHEN EXTRACT(DOW FROM die_datacadastro) = 3 THEN 'Quarta-feira'
            WHEN EXTRACT(DOW FROM die_datacadastro) = 4 THEN 'Quinta-feira'
            WHEN EXTRACT(DOW FROM die_datacadastro) = 5 THEN 'Sexta-feira'
            WHEN EXTRACT(DOW FROM die_datacadastro) = 6 THEN 'Sabado'
       END AS semana,to_char(die_datacadastro,'dd') as dia,(ARRAY[
          'Janeiro',
          'Fevereiro',
          'Março',
          'Abril',
          'Maio',
          'Junho',
          'Julho',
          'Agosto',
          'Setembro',
          'Outubro',
          'Novembro',
          'Dezembro'])[ EXTRACT(MONTH FROM die_datacadastro)] as mes,to_char(die_datacadastro,'yyyy') as ano,* from diario where edi_codigo=".$edi_codigo) or die(pg_last_error());
	$edinew = pg_fetch_array($q);
	$ned = pg_fetch_array(pg_query("select *from edicao where edi_codigo=".$edi_codigo));
	$pageCount1 = $pdf->setSourceFile('diarios_prontos/'.trim($edinew['die_arquivo']));
	for ($pageNo1 = 1; $pageNo1 <= $pageCount1; $pageNo1++) {
		 $pag1 = $pageNo1;
		 $txt_ed11 = utf8_decode('EDIÇÃO Nº:');
		 $txt_ed21 = utf8_decode(trim($ned['edi_nome'])."/".$edinew['ano']);
		 $txt_ed31 = utf8_decode($pag1.' Pág(s) de '.$pageCount1);

		 $dtall = utf8_decode($edinew['semana']).", ".$edinew['dia']." de ".$edinew['mes']." de ".$edinew['ano'];

	     $templateId1 = $pdf->importPage($pageNo1);
	     $size1 = $pdf->getTemplateSize($templateId1);
			if ($size1[0] > $size1[1]) {
			    $pdf->AddPage('L', array($size1[0], $size1[1]));
			    $pdf->useTemplate($templateId1, 20, 3, 320); 
			//CABECARIO
			     $pdf -> Image('cabecario.png', 50, 2, 180);
			     $pdf->SetXY(50, 30);
			     $pdf->Cell(173, 0, '', 1, 1, 'R');
			     $pdf->SetXY(50, 36);
			     $pdf->Cell(173, 0, '', 1, 1, 'R');
			     $pdf->SetFont('Helvetica','B');
			     $pdf->SetFontSize(8);
			     $pdf->SetXY(69, 28);
			     $pdf->Cell(11, 10, $dtall, 0, 1, 'C');
			     $pdf->SetFont('Helvetica');
			     $pdf->SetXY(69, 28);
			     $pdf->Cell(220, 10, $txt_ed11, 0, 1, 'C');
			     $pdf->SetFont('Helvetica','B');
			     $pdf->SetXY(69, 28);
			     $pdf->Cell(250, 10, $txt_ed21, 0, 1, 'C');
			     $pdf->SetFont('Helvetica');
			     $pdf->SetXY(64, 28);
			     $pdf->Cell(299, 10, $txt_ed31, 0, 1, 'C');
			} else {
			    $pdf->AddPage('P', array($size1[0], $size1[1]));
			    $pdf->useTemplate($templateId1, 5, -2, 210); 
			//CABECARIO
			     $pdf -> Image('cabecario.png', 12, 2, 180);
			     $pdf->SetXY(15, 30);
			     $pdf->Cell(173, 0, '', 1, 1, 'R');
			     $pdf->SetXY(15, 36);
			     $pdf->Cell(173, 0, '', 1, 1, 'R');
			     $pdf->SetFont('Helvetica','B');
			     $pdf->SetFontSize(8);
			     $pdf->SetXY(34, 28);
			     $pdf->Cell(11, 10, $dtall, 0, 1, 'C');
			     $pdf->SetFont('Helvetica');
			     $pdf->SetXY(34, 28);
			     $pdf->Cell(220, 10, $txt_ed11, 0, 1, 'C');
			     $pdf->SetFont('Helvetica','B');
			     $pdf->SetXY(34, 28);
			     $pdf->Cell(250, 10, $txt_ed21, 0, 1, 'C');
			     $pdf->SetFont('Helvetica');
			     $pdf->SetXY(29, 28);
			     $pdf->Cell(299, 10, $txt_ed31, 0, 1, 'C');
			}


	}

	$pdf->Output('diarios_prontos/'.trim($edinew['die_arquivo']), 'F');	
}




	$pdfall = new \Clegginabox\PDFMerger\PDFMerger;
 	$pdf = new \setasign\Fpdi\Fpdi();

$sql = pg_query("select *from anexos_diario where edi_codigo=".$edi_codigo);
while($rr=pg_fetch_array($sql)) {
	$pageCount = $pdf->setSourceFile('anexos_tmp/'.trim($rr['anx_arquivo']).'.pdf');
	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
	     $templateId = $pdf->importPage($pageNo);
	     $size = $pdf->getTemplateSize($templateId);
			if ($size[0] > $size[1]) {
			    $pdf->AddPage('L', array($size[0], $size[1]));
			} else {
			    $pdf->AddPage('P', array($size[0], $size[1]));
			}
			     $pdf->useTemplate($templateId, 25, 38, 150); 
 	}
}
	$edi = pg_fetch_array(pg_query("select *from edicao where edi_codigo=".$edi_codigo));
	$nomeDiario = "diario_oficial_".trim($edi['edi_nome'])."_".time().".pdf";
	$sel = pg_query("select *from diario where edi_codigo=".$edi_codigo);
	
	if(pg_num_rows($sel)>0) {
		$r = pg_fetch_array($sel);
		$up = pg_query("update diario set die_dataatualizacao=now() where edi_codigo=".$edi_codigo);
	 	$pdf->Output('diarios_prontos/'.trim($r['die_arquivo']), 'F');
	} else {
		$ins = pg_query("insert into diario (die_arquivo,die_dataatualizacao,edi_codigo) values ('".$nomeDiario."',now(),$edi_codigo)");		
 		$pdf->Output('diarios_prontos/'.$nomeDiario, 'F');
	}
	//$pdfall->merge('file', 'diarios_prontos/'.$nomeDiario); 


geracabecario($edi_codigo);

$response = array("success" => true); 

echo json_encode($response); 
?>