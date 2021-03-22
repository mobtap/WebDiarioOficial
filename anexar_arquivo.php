<?php
 header("Access-Control-Allow-Origin: *");
include "db.inc.php"; 
session_start();
	$acao = $_REQUEST['acao'];
	$edi_nome = $_REQUEST['edi_nome'];
	$anx_codigo = $_REQUEST['anx_codigo'];
	$edi_codigo = $_REQUEST['edi_codigo'];
	$tpo_codigo = $_REQUEST['tpo_codigo'];
	$usu_id = $_SESSION['id'];

    $nameFile = $edi_codigo."_".time();
    $diretorio = "anexos_tmp/".$nameFile.".pdf";

		if($acao=="read") {
			$sql = pg_query("select *from edicao where edi_codigo=$edi_codigo");
			$r=pg_fetch_array($sql);
			$response = array("success" => true, $r);
			echo json_encode($response);  			
		 die();
		}
        if($acao=="del") {
            $sql = "DELETE from anexos_diario where anx_codigo = '$anx_codigo'";
        } else {
			if(empty($anx_codigo)) {
						$sql = "INSERT INTO anexos_diario (usu_id,anx_arquivo,tpo_codigo,edi_codigo) values ($usu_id,'$nameFile','$tpo_codigo','$edi_codigo')";

            	move_uploaded_file($_FILES['file']['tmp_name'], $diretorio);

			} else {
						$sql = "UPDATE mensagem SET usr_codigo_from='$usu_codigo',msg_titulo='$msg_titulo',msg_conteudo='$msg_conteudo' WHERE msg_codigo='$msg_codigo'";
			}
		} 
        pg_query($sql) or die(pg_last_error()); 

	$response = array("success" => true); 

echo json_encode($response); 
?>

