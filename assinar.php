<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

$arquivo = trim($_REQUEST['die_arquivo']);
$id = $_REQUEST['die_codigo'];
$usu_id = $_SESSION['id'];

require_once('library/fpdf/fpdf.php');
require_once('library/fpdi/src/autoload.php');
require_once('library/PDFMerger.php');
include ('db.inc.php'); 

$pdf = new \setasign\Fpdi\Fpdi();

	 $pagecount = $pdf->setSourceFile("diarios_prontos/".$arquivo);
for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {
	    $tplIdx = $pdf->importPage($pageNo);
	 	//$pdf->AddPage();
	    $size = $pdf->getTemplateSize($tplIdx);
    if ($size[0] > $size[1]) {
	    $pdf->AddPage('L', array($size[0], $size[1]));
		$pdf->Image('assets/images/assinatura.png' , 50 ,180, 200 , 22,'PNG', 'http://www.novalondrina.pr.gov.br');
	} else {
	    $pdf->AddPage('P', array($size[0], $size[1]));
		$pdf->Image('assets/images/assinatura.png' , 5 ,250, 200 , 22,'PNG', 'http://www.novalondrina.pr.gov.br');
	}
	    $pdf->useTemplate($tplIdx);
}

$pdf->Output("diarios_prontos/".$arquivo, "F");


$up = pg_query("update diario set assinado='TRUE',usu_id_assinado=$usu_id where die_codigo=".$id);
$response = array("success" => true); 
echo json_encode($response); 
?>