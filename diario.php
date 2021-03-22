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
            var dados = $('#form').serialize();
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'salvar_edicao.php',
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
									  'Sucesso!',
									  'Cadastrado com Sucesso!',
									  'success'
									)
					setTimeout(function(){
					 window.location = 'diario.php';
					}, 2000);
             }
             });
             return false;         
        });


        $('#assinarForm').click(function() {
            var dados = $('#formassinatura').serialize();
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'assinar.php',
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
                                      'Sucesso!',
                                      'Cadastrado com Sucesso!',
                                      'success'
                                    )
                    setTimeout(function(){
                     window.location = 'diario.php';
                    }, 2000);
             }
             });
             return false;         
        });


      $('.btn-alternate').on('click', function() {  
                var dados = $(this).attr('id');
             $.ajax({
                 type: 'POST',
                 dataType: 'json',
                 url: 'salvar_edicao.php?acao=read&edi_codigo='+dados,
                 async: true,
                 data: dados,
                 success: function(r) {
                        $('#edi_nome').val(r[0].edi_nome);
                        $('#edi_datapublicacao').val(r[0].data);
                        $('#edi_codigo').val(r[0].edi_codigo);
                 }
                 });
            });

      $('.btn-assinar').on('click', function() {  
                var dados = $(this).attr('id');
             $.ajax({
                 type: 'POST',
                 dataType: 'json',
                 url: 'read_diario.php?acao=read&edi_codigo='+dados,
                 async: true,
                 data: dados,
                 success: function(r) {
                        $('#die_arquivo').val(r[0].die_arquivo);
                        $('#die_codigo').val(r[0].die_codigo);
                 }
                 });
            });

$('.btn-del').on('click', function() {  
            var dados = $(this).attr('id');
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'salvar_edicao.php?acao=del&edi_codigo='+dados,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
                                      'Sucesso!',
                                      'Edicao Excluida com Sucesso',
                                      'success'
                                    )
                    setTimeout(function(){
                     window.location = 'diario.php';
                    }, 2000);
             }
             });
         return false; 
        });


$('.btn-status').on('click', function() {  
            var dados = $(this).attr('id');
            var tp = $(this).attr('data-target');
         $.ajax({
             type: 'POST',
             dataType: 'json',
             url: 'atualiza_status.php?acao=del&edi_codigo='+dados+'&tp='+tp,
             async: true,
             data: dados,
             success: function(response) {
                                 Swal.fire(
                                      'Sucesso!',
                                      'Status trocado com Sucesso',
                                      'success'
                                    )
                    setTimeout(function(){
                     window.location = 'diario.php';
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
                                                    Diários Eletrônicos											
												</div>
			                                  <div class="btn-block">
                                                    <button type="button" class="btn btn-primary btn-lg float-right" data-toggle="modal" data-target="#exampleModal">Nova Edição do Diário</button>												
												</div>
									</div>

                                             
<div class="table-responsive">
    <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
        <tr>
            <th>&nbsp;</th>
            <th>Edição</th>
            <th>Data Publicação</th>
            <th>Data Criação</th>
            <th>Última Atualização</th>
            <th>Qtd Anexos</th>
			<th colspan='4'>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
<?php
  $sql = pg_query("select to_char(edi_datacriacao,'dd/mm/yyyy') as datacriacao,to_char(edi_datapublicacao,'dd/mm/yyyy') as datapublicacao,*from edicao order by edi_datacriacao desc");
  while($rr = pg_fetch_array($sql)) {
    if($rr[edi_status]==t) {
        $status = "1CF12B";
        $st = 'true';
    } else {
        $status = "E41B0B";        
        $st = 'false';
    }
    $qtd = pg_fetch_array(pg_query("select count(*) as total,to_char(tpx_data,'dd/mm/yyyy') as ultimo from anexos_diario where edi_codigo=".$rr['edi_codigo']." group by ultimo"));
   $ver = pg_query("select *from diario where edi_codigo=".$rr['edi_codigo']);
   $edi = pg_fetch_array($ver);
      if(pg_num_rows($ver)>0) {
        if($edi['assinado']!='t') {
            $bg = '';
        } else {
            $bg = 'red';
        }
    }
?>											
		<tr>
			<td><div class='btn-status' data-target='<?=$st?>' id='<?=$rr[edi_codigo]?>' style='border-radius: 50%;width:20px;height:20px;background-color:#<?=$status?>'></div></td>
			<td><font color='<?=$bg?>'> <?=$rr[edi_nome]?></font></td>
			<td><font color='<?=$bg?>'> <?=$rr[datapublicacao]?></font></td>
            <td><font color='<?=$bg?>'> <?=$rr[datacriacao]?></font></td>
            <td align='center'><font color='<?=$bg?>'><?=$qtd['ultimo']?></font></td>
            <td align='center'><font color='<?=$bg?>'><b><?=$qtd['total']?></font></b></td>
            <?php 
             #if($edi['assinado']!='t') {
            ?>
			<td width=120><button type='button' class='btn btn-info icon-cancel' onClick="location.href='anexar.php?edi_codigo=<?=$rr['edi_codigo']?>'" >Anexos</button></td>
            <td width=120><button type='button' class='btn btn-primary btn-alternate' id='<?=$rr[edi_codigo]?>' data-toggle='modal' data-target='#exampleModal'>Editar Edição</button></td>
<?php
#}
 if($qtd['total']<1) {
?>
            <td width=80><button type='button' class='btn btn-danger btn-del' id='<?=$rr[edi_codigo]?>' >Excluir</button></td>
<?php
    }
?>
            <td width=140><button type='button' class='btn btn-danger btn-assinar' id='<?=$rr[edi_codigo]?>' data-toggle='modal' data-target='#assinatura'>Assinar e Fechar</button></td>
<?php
# } else {
 #   echo "<td width=140 colspan=3><font color=green><b>Arquivo assinado e fechado</b></font></td>";
 #}
#} 
   if(pg_num_rows($ver)>0) {
?>

            <td width=100><button type='button' class='btn btn-warning' onClick="window.open('verpdf.php?arquivo=diarios_prontos/<?=$edi[die_arquivo]?>', 'win', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,height=570,width=520');">Ver Pdf</button></td>            
<?
    } else {
        echo "<td colspan=3 align=center><font color=red><b>Não Gerado</b></font></td>";
    }
?>
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
                <h5 class="modal-title" id="exampleModalLabel">Cadastro de Edição</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
				<div class="modal-body">
  <div class="main-card mb-3 card">
  <form class="" id="form">
  <input type=hidden name='edi_codigo' id='edi_codigo'>

				<div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-4 col-form-label" style='text-align: right;'>Edição:</label>
					<div class="col-sm-6"><input name="edi_nome" id="edi_nome"  type="text" class="form-control" ></div>
				</div>
                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-4 col-form-label" style='text-align: right;'>Data de Publicação:</label>
                    <div class="col-sm-4"><input name="edi_datapublicacao" id="edi_datapublicacao"  type="text" class="form-control"  maxlength="10" onkeypress="mascaraData( this, event )"><small>(dd/mm/yyyy)</small></div>
                </div>
          <div class="position-relative form-check" style='text-align: center;'><label class="form-check-label"><input type="checkbox" name="edi_auto" id="edi_auto" class="form-check-input "> Publicação Automática</label></div>
            	</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="salvarForm">Cadastrar</button>
				</form>
            </div>
        </div>
    </div>
</div>	

<!-- MODAL UPLOAD -->


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
  <form class="" id="form">
  <input type=hidden name='usu_codigo' id='usu_codigo' value='<?=$_SESSION['usu_codigo']?>'>


                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-4 col-form-label" style='text-align: right;'>Arquivo <small>(<font color=red>PDF</font>)</small>:</label>
                    <div class="col-sm-6"><input type="file" name="files[]" multiple id="gallery-photo-add"></div>
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

<!-- MODAL ASSINATURA -->

<div class="modal fade" id="assinatura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Assinar e publicar documentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
  <div class="main-card mb-3 card">
  <form class="" id="formassinatura">
  <input type=hidden name='die_arquivo' id='die_arquivo'>
  <input type=hidden name='die_codigo' id='die_codigo'>


                <div class="position-relative row form-group"><label for="exampleEmail" class="col-sm-4 col-form-label" style='text-align: right;'>Certificado :</label>
                    <div class="col-sm-8"><select class="form-control">
					<option>MUNICIPIO DE NOVA LONDRINA:81044984000104 Emitido por: AC Certisign RFB G5</option>
					</select>
					</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" id="assinarForm">Assinar e Publicar</button>
                </form>
            </div>
        </div>
    </div>
</div>  
    <script src="cliente-master/js/jquery-3.2.1.min.js"></script>
    <script src="cliente-master/js/bootstrap.min.js"></script>
    <script src="cliente-master/js/script-customizavel.js"></script>