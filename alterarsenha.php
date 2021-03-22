<?
  include 'superior.php';
  session_start();

?>
<div class="card-header col-xs-12">

<div class="btn-block">
Alterar sua senha											
</div>
</div>
<script>
	function conf() {
		if(document.getElementById('senha').value!=document.getElementById('conf_senha').value) {
			alert('Senha nao confere com a conferencia de senha');
			document.getElementById('senha').value = '';
			document.getElementById('conf_senha').value = '';
			document.getElementById('senha').focus();
		}		
	}
</script>
<?php
  if(empty($_REQUEST['acao'])) {
?>
<form id="form" action="alterarsenha.php" method="POST" class="form-horizontal row">
	<input type=hidden name=acao value=letsgo>
	<input type=hidden name=id value='<?=$_SESSION['id']?>'>
	<div class="col-md-6">
		<label for="cli_cliente" class="col-sm-9 control-label">Nova Senha:</label>
		<input onf type="password" class="form-control" id="senha" name="senha">
<br>
</div>
	<div class="col-md-6">
		<label for="cli_dtinicio" class="col-sm-9 control-label">Confirmar Senha:</label>
		<input size="16" name="conf_senha" id="conf_senha" type="password" onBlur='conf()' maxlength="18" class="form-control round-input">
	<br>
</div>
	<div class="col-md-12">
		<button type="submit" class="btn btn-success btn-block btn-lg">Salvar cadastro</button>
	</div>
</form>
<?php
} else {
  	$sql = "UPDATE usuario SET senha=md5('".$_REQUEST['senha']."') WHERE id=".$_REQUEST['id'];
  	pg_query($sql) or die(pg_last_error());
  ?>
<script>
	alert("Alteracoes realizadas com sucesso.");
					setTimeout(function(){
					 window.location = 'alterarsenha.php';
					}, 20);
</script>
  <?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="js/mascaras.js"></script>
<script src="js/app.js"></script>

<? include 'inferior.php'; ?>