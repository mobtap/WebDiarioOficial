<?php include 'superior.php' ?>
    <script type="text/javascript">
     $(document).ready(function(){
        $('#salvarForm').click(function() {
            var dados = $('#form').serialize();
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'salvar_mensagem.php?msg_codigo=<?=$_GET[msg_codigo]?>',
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
									  'Sucesso!',
									  'Cadastrado com Sucesso!',
									  'success'
									)
					setTimeout(function(){
					 window.location = 'chat.php';
					}, 2000);
             }
             });
         return false;         
        });
        });

$(document).ready(function(){

  $('.btn-alternate').on('click', function() {  
				var dados = $(this).attr('id');
			 $.ajax({
				 type: 'POST',
				 dataType: 'json',
				 url: 'salvar_mensagem.php?acao=busca&msg_codigo='+dados,
				 async: true,
				 data: dados,
				 success: function(response) {
					$('#exampleModal').on('shown.bs.modal', function () {
						$('#msg_titulo').val('aaaaaaaaaaaaaaa');
						$('#msg_conteudo').val('bbbbbbb');
					});
				 }
				 });
			 return false;         
			});
});        
        
$(document).ready(function(){ 
$('.icon-cancel').on('click', function() {  
            var dados = $(this).attr('id');
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'salvar_mensagem.php?acao=del&msg_codigo='+dados,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
									  'Sucesso!',
									  'Mensagem Excluida com Sucesso',
									  'success'
									)
					setTimeout(function(){
					 window.location = 'chat.php';
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
                                                    Recado para o médico											
												</div>
			                                  <div class="btn-block">
                                                    <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#exampleModal">Adicionar mensagem</button>												
												</div>
									</div>
                                    <div class="table-responsive">
                                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th class="text-center" width="10%">Data/Hr Consulta</th>
                                                <th>Assunto</th>
                                                <th>Mensagem</th>
												<th colspan='2'>&nbsp;</th>
                                            </tr>
                                            </thead>
                                            <tbody>
<?php
  $sql = pg_query("select to_char(msg_dt_envio,'dd/mm/yyyy - hh24:mi') as data,*from mensagem where usr_codigo_from=".$_SESSION['usu_codigo']." order by msg_dt_envio,msg_lida");
  while($rr = pg_fetch_array($sql)) {
	  if($rr[msg_lida]=="") {
	  $newstatus = "<td >
				<div class='badge badge-warning'>Aguardando leitura...</div>
			</td>";
		} else {
	  $newstatus = "<td >
				<div class='badge badge-success'>recebido</div>
			</td>";
		}
?>											
		<tr>
			<td  class="text-center text-muted"><?=$rr[data]?></td>
			<td ><?=$rr[msg_titulo]?></td>
			<td ><?=$rr[msg_conteudo]?></td>
			<?=$newstatus?>
			<td width='5%'><button type='button' class='btn btn-danger icon-cancel' id='<?=$rr[msg_codigo]?>'>Apagar</button></td>
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
                <h5 class="modal-title" id="exampleModalLabel">Enviar recado para o médico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
				<div class="modal-body">
  <div class="main-card mb-3 card">
  <form class="" id="form">
  <input type=hidden name='usu_codigo' id='usu_codigo' value='<?=$_SESSION['usu_codigo']?>'>
				<div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-3 col-form-label">Assunto:</label>
					<div class="col-sm-9"><input name="msg_titulo" id="msg_titulo"  type="text" class="form-control"></div>
				</div>
				<div class="position-relative row form-group"><label for="exampleText" class="pull-right col-sm-3 col-form-label">Mensagem:</label>
					<div class="col-sm-9"><textarea id="msg_conteudo" name="msg_conteudo" class="form-control"></textarea></div>
				</div>
			</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvarForm">Enviar mensagem</button>
				</form>
            </div>
        </div>
    </div>
</div>	