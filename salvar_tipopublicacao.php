<?php
include "db.inc.php"; 

	$acao = $_REQUEST['acao'];
	$id = $_REQUEST['id'];
	$tpo_nome = $_REQUEST['tpo_nome'];
	if($_REQUEST['tpo_see']!="") {
		$tpo_see = $_REQUEST['tpo_see'];
	} else {
		$tpo_see = 0;
	}
		if($acao=="busca") {
			$query = pg_query("select *from tipoedicao where tpo_codigo=".$id) or die(pg_last_error());
			$r = pg_fetch_array($query);
			$response = array("success" => true, $r);
			echo json_encode($response);  			
		 die();
		}
        if($acao=="del") {
            $sql = "DELETE from tipoedicao where tpo_codigo = '$id'";
        } else {
			if(empty($id)) {
						$sql = "INSERT INTO tipoedicao (tpo_nome,tpo_see) values ('$tpo_nome','$tpo_see')";
			} else {
						$sql = "UPDATE tipoedicao SET tpo_see=$tpo_see,tpo_nome='$tpo_nome' WHERE tpo_codigo='$id'";
			}
		} 
        pg_query($sql) or die(pg_last_error()); 

	$response = array("success" => true); 

echo json_encode($response); 
?>