<?php 
  include 'superior.php';
$rel1 = pg_fetch_array(pg_query("select count(*) as total from edicao where to_char(edi_datacriacao,'mm/yyyy')=to_char(now(),'mm/yyyy')"));
$rel2 = pg_fetch_array(pg_query("select count(*) as total from edicao where to_char(edi_datacriacao,'mm/yyyy')=to_char(now(),'mm/yyyy') and edi_statua='t'"));
$rel3 = pg_fetch_array(pg_query("select sum(click) as total from acessos where to_char(data,'mm/yyyy')=to_char(now(),'mm/yyyy')"));
?>
<div class="row">
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-midnight-bloom">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Total Publicações</div>
                    <div class="widget-subheading">Mensal</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span><?=(empty($rel1['total']))?"0":$rel1['total']?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-arielle-smile">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Publicações não aprovadas</div>
                    <div class="widget-subheading">Mensal</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span><?=(empty($rel2['total']))?"0":$rel2['total']?></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-4">
        <div class="card mb-3 widget-content bg-grow-early">
            <div class="widget-content-wrapper text-white">
                <div class="widget-content-left">
                    <div class="widget-heading">Acessos nas publicações</div>
                    <div class="widget-subheading">Mensal</div>
                </div>
                <div class="widget-content-right">
                    <div class="widget-numbers text-white"><span><?=(empty($rel3['total']))?"0":$rel3['total']?></span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">Diários Publicados
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
  $sql = pg_query("select to_char(edi_datacriacao,'dd/mm/yyyy') as datacriacao,to_char(edi_datapublicacao,'dd/mm/yyyy') as datapublicacao,to_char(edi_dataatualizacao,'dd/mm/yyyy') as atualizacao,*from edicao where edi_status='t' order by edi_datacriacao desc");
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