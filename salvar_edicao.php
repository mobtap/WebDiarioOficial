<?php
include "db.inc.php"; 
session_start();

	$acao = $_REQUEST['acao'];
	$edi_nome = $_REQUEST['edi_nome'];
	$edi_codigo = $_REQUEST['edi_codigo'];
	$edi_datapublicacao = $_REQUEST['edi_datapublicacao'];
	$usu_id = $_SESSION['id'];

		if($acao=="read") {
			$sql = pg_query("select to_char(edi_datapublicacao,'dd/mm/yyyy') as data,*from edicao where edi_codigo=$edi_codigo");
			$r=pg_fetch_array($sql);
			$response = array("success" => true, $r);
			echo json_encode($response);  			
		 die();
		}
        if($acao=="del") {
            $sql = "DELETE from edicao where edi_codigo = '$edi_codigo'";
        } else {
			if(empty($edi_codigo)) {
						$sql = "INSERT INTO edicao (usu_id,edi_nome,edi_datapublicacao) values ($usu_id,'$edi_nome','$edi_datapublicacao')";
			} else {
						$sql = "UPDATE edicao SET usu_id='$usu_id',edi_nome='$edi_nome',edi_datapublicacao='$edi_datapublicacao' WHERE edi_codigo='$edi_codigo'";
			}
		} 
        pg_query($sql) or die(pg_last_error()); 

	$response = array("success" => true); 

echo json_encode($response); 
?>

