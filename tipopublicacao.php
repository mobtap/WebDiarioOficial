<?php include 'superior.php' ?>
    <script type="text/javascript">
     $(document).ready(function(){
        $('#salvarForm').click(function() {
            var dados = $('#form').serialize();
            var id = $('#id').val();
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'salvar_tipopublicacao.php?id='+id,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
									  'Sucesso!',
									  'Cadastrado com Sucesso!',
									  'success'
									)
					setTimeout(function(){
					 window.location = 'tipopublicacao.php';
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
				 url: 'salvar_tipopublicacao.php?acao=busca&id='+dados,
				 async: true,
				 data: dados,
				 success: function(r) {
                        $('#id').val(r[0].tpo_codigo);
						$('#tpo_nome').val(r[0].tpo_nome);
                        if(r[0].tpo_see==1) {
                            $( "#tpo_see" ).prop( "checked", true );
                        } else {
                            $( "#tpo_see" ).prop( "checked", false );                            
                        }
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
             url: 'salvar_tipopublicacao.php?acao=del&id='+dados,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
									  'Sucesso!',
									  'Excluido com Sucesso',
									  'success'
									)
					setTimeout(function(){
					 window.location = 'tipopublicacao.php';
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
                                                    Tipo de Publicação											
												</div>
			                                  <div class="btn-block">
                                                    <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#exampleModal">Adicionar Tipo de Publicação</button>												
												</div>
									</div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th class="text-center" width="10%">id</th>
                                                <th>Tipo de Publicação</th>
												<th colspan='2'>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
<?php
  $sql = pg_query("select *from tipoedicao order by tpo_nome");
  while($rr = pg_fetch_array($sql)) {
?>											
<tr>
	<td  class="text-center text-muted"><?=$rr[tpo_codigo]?></td>
	<td ><?=$rr[tpo_nome]?></td>
    <td width=80><button type='button' class='btn btn-warning' id='<?=$rr[tpo_codigo]?>' data-toggle="modal" data-target="#exampleModal">Editar</td> 
    <td width=80><button type='button' class='btn btn-danger icon-cancel' id='<?=$rr[tpo_codigo]?>'>Apagar</button></td>
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

<?php include 'inferior.php' ?>

		<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Adicionar Tipo de Publicação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
				<div class="modal-body">
  <div class="main-card mb-3 card">
  <form class="" id="form">
  <input type=hidden name='id' id='id'>

<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Tipo de Publicação:</label>
<div class="col-sm-7"><input name="tpo_nome" id="tpo_nome"  type="text" class="form-control"></div>
</div>
<div class="position-relative row form-group" align="right"><label for="exampleEmail" class="col-sm-4 col-form-label">Mostrar no Docs?:</label>
<div class="col-sm-2"><input name="tpo_see" id="tpo_see" value='1' type="checkbox" class="form-control"></div>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvarForm">Adicionar</button>
				</form>
            </div>
        </div>
    </div>
  </div>	
 </div>
</div>