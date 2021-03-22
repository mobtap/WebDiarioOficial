<?
  include 'superior.php';
  session_start();

?>
<div class="card-header col-xs-12">

<div class="btn-block">
Meus dados de usuario do sistema											
</div>
</div>
<?php
  if(empty($_REQUEST['acao'])) {
  	$rr = pg_fetch_array(pg_query("select *from usuario where id=".$_SESSION['id']));
?>
<form action="dadosusuario.php" method="POST" class="form-horizontal row">
	<input type=hidden name=acao value=letsgo>
	<input type=hidden name=id value='<?=trim($rr[id])?>'>
	<div class="col-md-6">
		<label for="cli_cliente" class="col-sm-9 control-label">Nome:</label>
		<input type="text" class="form-control" id="nome" value="<?=trim($rr[nome])?>" name="nome">
<br>
		<label for="cli_dtinicio" class="col-sm-9 control-label">E-Mail:</label>
		<input size="16" name="email" type="text" value="<?=trim($rr[email])?>"  maxlength="18" class="form-control round-input mask" rel="99.999.999/9999-99" data-mask="99.999.999/9999-99">
	<br>
		<label for="cli_cliente" class="col-sm-9 control-label">Usuario:</label>
		<input type="text" name="usuario" class="form-control" value="<?=trim($rr[usuario])?>" id="endereco" >
<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">Departamento:</label>
		<select name=dep_codigo class="form-control">

<?php 
  $qu = pg_query("select *from departamento order by dep_nome");
  while($dep=pg_fetch_array($qu)) {
    echo ($rr[dep_codigo]==$dep[dep_codigo])?"<option selected value=$dep[dep_codigo]>$dep[dep_nome]</option>":"<option value=$dep[dep_codigo]>$dep[dep_nome]</option>";
  }
?>
</select>
<br>
</div>
<br>
	<div class="col-md-6">
		<label for="cli_numeroos" class="col-sm-9 control-label">Cpf:</label>
		<input type="text" name="cpf" class="form-control"value="<?=trim($rr[cpf])?>"  id="bairro">
	<br>	
			<label for="cli_numeroos" class="col-sm-9 control-label">Rg:</label>
		<input type="text" name="rg" class="form-control" value="<?=trim($rr[rg])?>" id="email" >
		<br>
	<label for="cli_numeroos" class="col-sm-9 control-label">Data Nascimento:</label>
		<input type="text" name="datanascimento" value="<?=trim($rr[datanascimento])?>" class="form-control" id="datacadastro" >
		<br>
	</div>
	<div class="col-md-12">
		<button type="submit" class="btn btn-success btn-block btn-lg">Salvar cadastro</button>
	</div>
</form>
<?php
} else {
  	$sql = "UPDATE usuario SET $pass nome='".$_REQUEST['nome']."',email='".$_REQUEST['email']."',usuario='".$_REQUEST['usuario']."',dep_codigo='".$_REQUEST['dep_codigo']."',cpf='".$_REQUEST['cpf']."',rg='".$_REQUEST['rg']."',datanascimento='".$_REQUEST['datanascimento']."' WHERE id=".$_REQUEST['id'];
  	pg_query($sql) or die(pg_last_error());
  ?>
<script>
	alert("Alteracoes realizadas com sucesso.");
					setTimeout(function(){
					 window.location = 'dadosusuario.php';
					}, 20);
</script>
  <?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="js/mascaras.js"></script>
<script src="js/app.js"></script>

<? include 'inferior.php'; ?>