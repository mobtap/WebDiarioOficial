 <?php

     error_reporting(E_ALL);
     ini_set("display_errors", 1);

     require_once('library/fpdf/fpdf.php');
     require_once('library/fpdi/src/autoload.php');
     require_once('library/PDFMerger.php');


     $pdf = new \setasign\Fpdi\Fpdi();

$pageCount = $pdf->setSourceFile('relatorio.pdf');
for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
     $templateId = $pdf->importPage($pageNo);
     $size = $pdf->getTemplateSize($templateId);

if ($size[0] > $size[1]) {
    $pdf->AddPage('L', array($size[0], $size[1]));
} else {
    $pdf->AddPage('P', array($size[0], $size[1]));
}
     $pdf->useTemplate($templateId, 15, 30, 170);
     $pag = $pageNo;
     $txt_ed1 = utf8_decode('EDIÇÃO Nº:');
     $txt_ed2 = utf8_decode('712/2020');
     $txt_ed3 = utf8_decode($pag.' Pág(s) de '.$pageCount);
//CABECARIO
     $pdf -> Image('cabecario.png', 12, 2, 180);
     $pdf -> Image('assets/images/assinatura.png', 10, 245, 190);
     $pdf->SetXY(15, 30);
     $pdf->Cell(173, 0, '', 1, 1, 'R');
     $pdf->SetXY(15, 36);
     $pdf->Cell(173, 0, '', 1, 1, 'R');
     $pdf->SetFont('Helvetica','B');
     $pdf->SetFontSize(8);
     $pdf->SetXY(34, 28);
     $pdf->Cell(11, 10, 'Sexta-Feira, 14 de Dezembro de 2020', 0, 1, 'C');
     $pdf->SetFont('Helvetica');
     $pdf->SetXY(34, 28);
     $pdf->Cell(220, 10, $txt_ed1, 0, 1, 'C');
     $pdf->SetFont('Helvetica','B');
     $pdf->SetXY(34, 28);
     $pdf->Cell(250, 10, $txt_ed2, 0, 1, 'C');
     $pdf->SetFont('Helvetica');
     $pdf->SetXY(29, 28);
     $pdf->Cell(299, 10, $txt_ed3, 0, 1, 'C');
//RODAPE
    $pdf->Line(20, 273, 190, 273);
    $pdf->SetXY(20, 273);
    $pdf->SetFont("Arial", "", 7);
    $pdf->Cell(0, 3, utf8_decode(" endereco - Tahiti / Tél. : (689) 800 960 - Télécopie : (689) 834 890 - E-mail : mairiefaaa@mail.pf\n"), 0, 0, "C");

}

     $pdf->Output('sample.pdf', 'I');

 ?>