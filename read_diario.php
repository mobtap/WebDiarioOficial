<?php
include "db.inc.php"; 
session_start();

	$acao = $_REQUEST['acao'];
	$edi_codigo = $_REQUEST['edi_codigo'];
	$usu_id = $_SESSION['id'];

		if($acao=="read") {
			$sql = pg_query("select *from diario where edi_codigo=$edi_codigo");
			$r=pg_fetch_array($sql);
			$response = array("success" => true, $r);
			echo json_encode($response);  			
		 die();
		}
        pg_query($sql) or die(pg_last_error()); 

	$response = array("success" => true); 

echo json_encode($response); 
?>

