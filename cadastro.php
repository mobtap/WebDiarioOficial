<?
  include 'superior.php';
  session_start();

?>
<div class="card-header col-xs-12">

<div class="btn-block">
Dados da entidade											
</div>
</div>
<?php
  if(empty($_REQUEST['acao'])) {
  	$rr = pg_fetch_array(pg_query("select *from entidade"));
?>
<form action="cadastro.php" method="POST" class="form-horizontal row">
	<input type=hidden name=acao value=letsgo>
	<input type=hidden name=id value='<?=trim($rr[id])?>'>
	<div class="col-md-6">
		<label for="cli_cliente" class="col-sm-9 control-label">Nome:</label>
		<input type="text" class="form-control" id="nome" value="<?=trim($rr[nome])?>" name="nome">
<br>
		<label for="cli_dtinicio" class="col-sm-9 control-label">CNPJ:</label>
		<input size="16" name="cnpj" type="text" value="<?=trim($rr[cnpj])?>"  maxlength="18" class="form-control round-input mask" rel="99.999.999/9999-99" data-mask="99.999.999/9999-99">
	<br>
		<label for="cli_cliente" class="col-sm-9 control-label">Endereco:</label>
		<input type="text" name="endereco" class="form-control" value="<?=trim($rr[endereco])?>" id="endereco" >
<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">Numero:</label>
		<input type="text" name="numero" class="form-control" value="<?=trim($rr[numero])?>" id="numero">
<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">Bairro:</label>
		<input type="text" name="bairro" class="form-control"value="<?=trim($rr[bairro])?>"  id="bairro">
	<br>	
			<label for="cli_numeroos" class="col-sm-9 control-label">E-mail:</label>
		<input type="text" name="email" class="form-control" value="<?=trim($rr[email])?>" id="email" >
		<br>
	<label for="cli_numeroos" class="col-sm-9 control-label">Data<small>(cadastro assinatura)</small>:</label>
		<input type="text" name="datacadastro" value="<?=trim($rr[datacadastro])?>" class="form-control" id="datacadastro" >
		<br>
			<label for="cli_numeroos" class="col-sm-9 control-label">Tipo<small>(assinatura)</small>:</label>
		<input type="text" name="tipo_assinatura" value="<?=trim($rr[tipo_assinatura])?>"  class="form-control" id="tipo_assinatura" >
<br>
</div>
<br>
	<div class="col-md-6">
		<label for="cli_numeroos" class="col-sm-9 control-label">CEP:</label>
		<input type="text" name="cep" value="<?=trim($rr[cep])?>" class="form-control" id="cep" >

<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">Cidade:</label>
		<input type="text" name="cidade" value="<?=trim($rr[cidade])?>" class="form-control" id="cidade">
<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">Estado:</label>
		<select id="estado" name="estado" class="form-control">
			<option value="AC">Acre</option>
			<option value="AL">Alagoas</option>
			<option value="AP">Amapá</option>
			<option value="AM">Amazonas</option>
			<option value="BA">Bahia</option>
			<option value="CE">Ceará</option>
			<option value="DF">Distrito Federal</option>
			<option value="ES">Espírito Santo</option>
			<option value="GO">Goiás</option>
			<option value="MA">Maranhão</option>
			<option value="MT">Mato Grosso</option>
			<option value="MS">Mato Grosso do Sul</option>
			<option value="MG">Minas Gerais</option>
			<option value="PA">Pará</option>
			<option value="PB">Paraíba</option>
			<option value="PR">Paraná</option>
			<option value="PE">Pernambuco</option>
			<option value="PI">Piauí</option>
			<option value="RJ">Rio de Janeiro</option>
			<option value="RN">Rio Grande do Norte</option>
			<option value="RS">Rio Grande do Sul</option>
			<option value="RO">Rondônia</option>
			<option value="RR">Roraima</option>
			<option value="SC">Santa Catarina</option>
			<option value="SP">São Paulo</option>
			<option value="SE">Sergipe</option>
			<option value="TO">Tocantins</option>
			<option value="EX">Estrangeiro</option>
		</select>
		<!-- <input type="text" name="uf_codigo" class="form-control" id="cli_numeroos"> -->
<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">Brasao:</label>
		<input type="file" name="brasao" value="<?=trim($rr[brasao])?>" class="form-control" id="brasap">
<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">Telefone:</label>
		<input type="text" name="telefone" value="<?=trim($rr[telefone])?>" class="form-control" id="telefone" data-mask="(99) 9 9999-9999">
<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">HASH<small>(assinatura)</small>:</label>
		<input type="text" name="hash" value="<?=trim($rr[hash])?>" class="form-control" id="hash" >
		<br>
		<label for="cli_numeroos" class="col-sm-9 control-label">Validade<small>(assinatura)</small>:</label>
		<input type="text" name="validade" value="<?=trim($rr[validade])?>" class="form-control" id="validade" >
		<br>
	</div>
	<div class="col-md-12">
		<button type="submit" class="btn btn-success btn-block btn-lg">Salvar cadastro</button>
	</div>
</form>
<?php
} else {
	$ent = pg_query("select *from entidade");
	$r = pg_fetch_array($ent);
  if(pg_num_rows($ent)=="") {
      pg_query("insert into entidade (nome,cnpj,endereco,numero,email,cep,cidade,estado,brasao,telefone,hash,validade,datacadastro,tipo_assinatura) values ('".$_REQUEST['nome']."','".$_REQUEST['cnpj']."','".$_REQUEST['endereco']."','".$_REQUEST['numero']."','".$_REQUEST['email']."','".$_REQUEST['cep']."','".$_REQUEST['cidade']."','".$_REQUEST['estado']."','".$_REQUEST['brasao']."','".$_REQUEST['telefone']."','".$_REQUEST['hash']."','".$_REQUEST['validade']."','".$_REQUEST['datacadastro']."','".$_REQUEST['tipo_assinatura']."')");
  } else {
      pg_query("update entidade set nome='".$_REQUEST['nome']."',cnpj='".$_REQUEST['cnpj']."',endereco='".$_REQUEST['endereco']."',numero='".$_REQUEST['numero']."',email='".$_REQUEST['email']."',cep='".$_REQUEST['cep']."',cidade='".$_REQUEST['cidade']."',estado='".$_REQUEST['estado']."',brasao='".$_REQUEST['brasao']."',telefone='".$_REQUEST['telefone']."',hash='".$_REQUEST['hash']."',validade='".$_REQUEST['validade']."',datacadastro='".$_REQUEST['datacadastro']."',tipo_assinatura='".$_REQUEST['tipo_assinatura']."' where id=".$_REQUEST['id']);
  }
  ?>
<script>
	alert("Alteracoes realizadas com sucesso.");
					setTimeout(function(){
					 window.location = 'cadastro.php';
					}, 20);
</script>
  <?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="js/mascaras.js"></script>
<script src="js/app.js"></script>

<? include 'inferior.php'; ?>