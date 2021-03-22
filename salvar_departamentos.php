<?php
include "db.inc.php"; 

	$acao = $_REQUEST['acao'];
	$id = $_REQUEST['id'];
	$dep_nome = $_REQUEST['dep_nome'];

		if($acao=="busca") {
			$query = pg_query("select *from departamento where dep_codigo=".$id);
			$r = pg_fetch_array($query);
			$response = array("success" => true, $r);
			echo json_encode($response);  			
		 die();
		}
        if($acao=="del") {
            $sql = "DELETE from departamento where dep_codigo = '$id'";
        } else {
			if(empty($id)) {
						$sql = "INSERT INTO departamento (dep_nome) values ('$dep_nome')";
			} else {
						$sql = "UPDATE departamento SET dep_nome='$dep_nome' WHERE dep_codigo='$id'";
			}
		} 
        pg_query($sql) or die(pg_last_error()); 

	$response = array("success" => true); 

echo json_encode($response); 
?>

