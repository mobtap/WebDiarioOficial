<?php
	include 'db.inc.php';
   	session_start();
   
	$sqlUsu = pg_query("SELECT * from usuario WHERE usuario='".$_REQUEST['usuario']."' AND senha=md5('".$_REQUEST['senha']."')") or die(pg_last_error());
	
	$qregistro = pg_num_rows($sqlUsu);
	
	if($qregistro == 0){
		unset($_SESSION['id']);
		unset($_SESSION['nome']);
		unset($_SESSION['usuario']);
		session_destroy();
		header("Location: login.php?e=".base64_encode('#*#1'));
	}

	if($qregistro >= 1){
		$rr = pg_fetch_array($sqlUsu);   
		$_SESSION['id']=$rr['id'];
		$_SESSION['usuario']=$rr['usuario'];
		$_SESSION['nome']=$rr['nome'];
		$_SESSION['logado']='ok';
		header("Location: index.php");

	}
	
?>