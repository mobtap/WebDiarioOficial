<?php include 'superior.php' ?>
    <script type="text/javascript">
function mascaraData( campo, e )
{
    var kC = (document.all) ? event.keyCode : e.keyCode;
    var data = campo.value;
    
    if( kC!=8 && kC!=46 )
    {
        if( data.length==2 )
        {
            campo.value = data += '/';
        }
        else if( data.length==5 )
        {
            campo.value = data += '/';
        }
        else
            campo.value = data;
    }
}

     $(document).ready(function(){
        $('#salvarForm').click(function() {
        var fileInput = document.getElementById('anx_arquivo');
        var file = fileInput.files[0];
        var formData = new FormData();
        formData.append('file', file);
    
        var dados = $('#form').serialize();
    
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'anexar_arquivo.php?'+dados,
             async: true,
             contentType: false,
             cache: false,
             processData: false,
             enctype: 'multipart/form-data',
             data: formData,
             success: function(response) {
                                 Swal.fire(
									  'Sucesso!',
									  'Cadastrado com Sucesso!',
									  'success'
									)
					setTimeout(function(){
					 window.location = 'anexar.php?edi_codigo='+$('#edi_codigo').val();
					}, 2000);
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
             url: 'anexar_arquivo.php?acao=del&anx_codigo='+dados,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
                                      'Sucesso!',
                                      'Anexo Excluida com Sucesso',
                                      'success'
                                    )
                    setTimeout(function(){
                     window.location = 'anexar.php?edi_codigo='+$('#edi_codigo').val();
                    }, 2000);
             }
             });
         return false; 
        });

$('.btn-merge').on('click', function() {  
            var dados = $(this).attr('id');
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'merge_anexos.php?edi_codigo='+dados,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
                                      'Sucesso!',
                                      'Edicao Gerada com Sucesso',
                                      'success'
                                    )
                    setTimeout(function(){
                     window.location = 'anexar.php?edi_codigo='+dados;
                    }, 2000);
             }
             });
         return false; 
        });
        });

</script>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="main-card mb-5 card">
                                    <div class="card-header col-xs-12" >
											
                                            <div class="btn-block">
                                                    Arquivos Anexados em Edição: 
                                                    <?php 
                                                      $n = pg_fetch_array(pg_query("select to_char(edi_datacriacao,'dd/mm/yyyy') as dt_criacao,* from edicao where edi_codigo=".$_REQUEST['edi_codigo']));
                                                      echo "<font color=red>".$n['edi_nome']."</font>";
                                                      echo " - Criado em: <font color=blue>".$n[dt_criacao]."</font>";
                                                    ?>											
												</div>
<div class="btn-block" style="width:200px">
<button type="button" class="btn btn-warning btn-lg float-right btn-merge" id="<?=$_REQUEST['edi_codigo']?>">Gerar Edição</button>												
</div>
<div class="btn-block" style="width:240px">
<button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#modalupload">Nova Arquivo do Diário</button>                                             
</div>

									</div>

                                             
<div class="table-responsive">
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
        <tr>
            <th>Id</th>
            <th>Tipo</th>
            <th>Arquivo</th>
            <th>Data Anexo</th>
			<th colspan='4'>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
<?php
$i=0;
  $sql = pg_query("select to_char(tpx_data,'dd/mm/yyyy - hh24:mi.ss') as datacriacao,*from anexos_diario as a join tipoedicao as b on a.tpo_codigo=b.tpo_codigo where edi_codigo=".$_REQUEST['edi_codigo']);
  while($rr = pg_fetch_array($sql)) {
    $i++;
?>											
		<tr>
			<td><?=$i?></td>
			<td><?=utf8_encode($rr[tpo_nome])?></td>
            <td><?=$rr[anx_arquivo]?></td>
            <td><?=$rr[datacriacao]?></td>
            <td width=60><button type='button' class='btn btn-danger icon-cancel' id='<?=$rr[anx_codigo]?>'>Apagar</button></td>
            <td width=100><button type='button' class='btn btn-warning' onClick="window.open('verpdf.php?arquivo=anexos_tmp/<?=trim($rr[anx_arquivo])?>.pdf', 'win', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,height=570,width=520');">Ver Pdf</button></td>
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


<div class="modal fade" id="modalupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Anexar Documentos a Edição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
  <div class="main-card mb-3 card">
  <form class="" id="form" method="POST" enctype="multipart/form-data">
  <input type=hidden name='edi_codigo' id='edi_codigo' value='<?=$_REQUEST['edi_codigo']?>'>


                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-4 col-form-label" style='text-align: right;'>Arquivo <small>(<font color=red>PDF</font>)</small>:</label>
                    <div class="col-sm-6"><input type="file" name="anx_arquivo" id="anx_arquivo"></div>
                </div>
                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-4 col-form-label" style='text-align: right;'>Tipo de Documento:</label>
                    <div class="col-sm-4">
                        <select name="tpo_codigo">
                        <?php
                         $q = pg_query("select *from tipoedicao order by tpo_nome");
                         while($tpo=pg_fetch_array($q)) {
                            echo "<option value='".$tpo['tpo_codigo']."'>".utf8_encode($tpo['tpo_nome'])."</option>";
                         }
                        ?>
                        </select>
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvarForm">Adicionar a Edição</button>
                </form>
            </div>
        </div>
    </div>
</div>  