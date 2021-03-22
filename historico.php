<?php 
include 'superior.php';
?>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Diários Por <?=$nom['nome']?>
            </div>
            <div class="table-responsive">
                
 <table class="align-middle mb-0 table table-borderless table-striped table-hover">
        <thead>
        <tr>
            <th>Edição</th>
            <th>Data Publicação</th>
            <th>Data Criação</th>
            <th>Última Atualização</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
 <?php
  $sql = pg_query("select to_char(edi_datacriacao,'dd/mm/yyyy') as datacriacao,to_char(edi_datapublicacao,'dd/mm/yyyy') as datapublicacao,to_char(edi_dataatualizacao,'dd/mm/yyyy') as atualizacao,*from edicao where  usu_id=".$nom['id']." order by edi_datacriacao desc");
  while($rr = pg_fetch_array($sql)) {
   $ver = pg_query("select *from diario where edi_codigo=".$rr['edi_codigo']);
   $edi = pg_fetch_array($ver);
?>

<tr>
            <td><?=$rr[edi_nome]?></td>
            <td><?=$rr[datapublicacao]?></td>
            <td><?=$rr[datacriacao]?></td>
            <td><?=$rr['atualizacao']?></td>
<?php
  if($edi[die_arquivo]) {
?>
            <td width=100><button type='button' class='btn btn-warning' onClick="window.open('verpdf.php?arquivo=diarios_prontos/<?=$edi[die_arquivo]?>', 'win', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,height=570,width=520');">Ver Pdf</button></td>            
<?php } else { echo '<td width=100><font color=red size=1><b>Sem Arquivo</b></font></td>'; }?>            
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