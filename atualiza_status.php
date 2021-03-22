<?php
include "db.inc.php"; 
session_start();

	$edi_codigo = $_REQUEST['edi_codigo'];
	$tp = $_REQUEST['tp'];
	if($tp=='true') {
		$status = 'false';
	} else {
		$status = 'true';		
	}

            $sql = "UPDATE edicao set edi_status='$status',edi_dataatualizacao=now() where edi_codigo = '$edi_codigo'";

        pg_query($sql) or die(pg_last_error()); 

	$response = array("success" => true); 

echo json_encode($response); 
?>

