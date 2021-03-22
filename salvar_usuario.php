<?php
include "db.inc.php"; 

	$acao = $_REQUEST['acao'];
	$id = $_REQUEST['id'];
	$nome = $_REQUEST['nome'];
	$email = $_REQUEST['email'];
	$usuario = $_REQUEST['usuario'];
	$senha = $_REQUEST['senha'];
	$dep_codigo = $_REQUEST['dep_codigo'];
	$cpf = $_REQUEST['cpf'];
	$rg = $_REQUEST['rg'];
	$datanascimento = $_REQUEST['datanascimento'];

		if($acao=="busca") {
			$query = pg_query("select *from usuario where id=".$id);
			$r = pg_fetch_array($query);
			$response = array("success" => true, $r);
			echo json_encode($response);  			
		 die();
		}
        if($acao=="del") {
            $sql = "DELETE from usuario where id = '$id'";
        } else {
			if(empty($id)) {
						$sql = "INSERT INTO usuario (nome,email,usuario,senha,dep_codigo,cpf,rg,datanascimento) values ('$nome','$email','$usuario',md5('$senha'),'$dep_codigo','$cpf','$rg','$datanascimento')";
			} else {
						$pass = (empty($senha))?"":"senha=md5('$senha'),";
						$sql = "UPDATE usuario SET $pass nome='$nome',email='$email',usuario='$usuario',dep_codigo='$dep_codigo',cpf='$cpf',rg='$rg',datanascimento='$datanascimento' WHERE id='$id'";
			}
		} 
        pg_query($sql) or die(pg_last_error()); 

	$response = array("success" => true); 

echo json_encode($response); 
?>

