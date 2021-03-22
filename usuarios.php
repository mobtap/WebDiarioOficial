<?php include 'superior.php' ?>
    <script type="text/javascript">
     $(document).ready(function(){
        $('#salvarForm').click(function() {
            var dados = $('#form').serialize();
            var id = $('#id').val();
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'salvar_usuario.php?id='+id,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
									  'Sucesso!',
									  'Cadastrado com Sucesso!',
									  'success'
									)
					setTimeout(function(){
					 window.location = 'usuarios.php';
					}, 2000);
             }
             });
         return false;         
        });
        });

$(document).ready(function(){

  $('.btn-warning').on('click', function() {  
				var dados = $(this).attr('id');
			 $.ajax({
				 type: 'POST',
				 dataType: 'json',
				 url: 'salvar_usuario.php?acao=busca&id='+dados,
				 async: true,
				 data: dados,
				 success: function(r) {
                        $('#id').val(r[0].id);
						$('#nome').val(r[0].nome);
                        $('#email').val(r[0].email);
                        $('#usuario').val(r[0].usuario);
                        $('#cpf').val(r[0].cpf);
                        $('#rg').val(r[0].rg);
                        $('#datanascimento').val(r[0].datanascimento);
				 }
				 });
			});
});        
        
$(document).ready(function(){ 
$('.icon-cancel').on('click', function() {  
            var dados = $(this).attr('id');
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'salvar_usuario.php?acao=del&id='+dados,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
									  'Sucesso!',
									  'Excluido com Sucesso',
									  'success'
									)
					setTimeout(function(){
					 window.location = 'usuarios.php';
					}, 2000);
             }
             });
         return false; 
        });
        });
</script>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-3 card">
                                    <div class="card-header col-xs-12">
											
                                            <div class="btn-block">
                                                    Usuarios											
												</div>
			                                  <div class="btn-block">
                                                    <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#exampleModal">Adicionar Usuario</button>												
												</div>
									</div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th class="text-center" width="10%">id</th>
                                                <th>Nome</th>
                                                <th>Usuario</th>
												<th colspan='2'>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
<?php
  $sql = pg_query("select *from usuario order by nome");
  while($rr = pg_fetch_array($sql)) {
?>											
<tr>
	<td  class="text-center text-muted"><?=$rr[id]?></td>
	<td ><?=$rr[nome]?></td>
	<td ><?=$rr[usuario]?></td>
    <td width=80><button type='button' class='btn btn-warning' id='<?=$rr[id]?>' data-toggle="modal" data-target="#exampleModal">Editar</td> 
    <td width=80><button type='button' class='btn btn-danger icon-cancel' id='<?=$rr[id]?>'>Apagar</button></td>
</tr>
<?php
 }
?>											
												
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


		<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
				<div class="modal-body">
  <div class="main-card mb-3 card">
  <form class="" id="form">
  <input type=hidden name='id' id='id'>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Nome:</label>
<div class="col-sm-7"><input name="nome" id="nome"  type="text" class="form-control"></div>
</div>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">E-mail:</label>
<div class="col-sm-7"><input name="email" id="email"  type="text" class="form-control"></div>
</div>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Usuario:</label>
<div class="col-sm-5"><input name="usuario" id="usuario"  type="text" class="form-control"></div>
</div>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Senha:</label>
<div class="col-sm-5"><input name="senha" id="senha"  type="password" class="form-control"></div>
</div>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Departamento:</label>
<div class="col-sm-5"><select name=dep_codigo class="form-control">

<?php 
  $qu = pg_query("select *from departamento order by dep_nome");
  while($dep=pg_fetch_array($qu)) {
    echo "<option value=$dep[dep_codigo]>$dep[dep_nome]</option>";
  }
?>
</select></div>
</div>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Cpf:</label>
<div class="col-sm-5"><input name="cpf" id="cpf"  type="text" class="form-control"></div>
</div>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Rg:</label>
<div class="col-sm-5"><input name="rg" id="rg"  type="text" class="form-control"></div>
</div>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Data Nascimento:</label>
<div class="col-sm-4"><input name="datanascimento" id="datanascimento"  type="text" class="form-control"></div>
</div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvarForm">Adicionar</button>
				</form>
            </div>
        </div>
    </div>
</div>	
<?php include 'inferior.php' ?>
