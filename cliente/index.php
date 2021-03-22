
<?php 
  include ('superior.php'); 
  include ('calendario.php'); 
?>

 <div class="content">
  <table cellpadding="0" cellpadding="0" border="0" width="70%" align="center">
    <tr>
      <td width="33%">
        <?php $cal = new PHPCalendar;
            echo $cal->getCalendarHTML(date(m),date(Y));
        ?>
    </td>
    <td width="66%">
      <div id="canvas-holder">
        <canvas id="chart-area" height="270"></canvas>
      </div>
    </td>
  </tr>
</table><br>
  <?php

 if(!empty($_REQUEST['p'])) {
   $wherepag = " LIMIT 10 OFFSET(".$_REQUEST['p']." - 1) * 10";
 } else {
   $wherepag = " LIMIT 10 OFFSET(1 - 1) * 10";  
 }

 if(!empty($_REQUEST['busca'])) {
  $busca = "AND edi_nome ilike '%".$_REQUEST['busca']."%' OR to_char(edi_datacriacao,'dd/mm/yyyy')='".$_REQUEST['busca']."'";
 } else {
	 $orderb = " order by edi_datapublicacao desc";
 }
    $sql = pg_query("select to_char(edi_datapublicacao,'dd/mm/yyyy') as data,* from edicao where edi_status='t'$orderb $busca ".$wherepag." ");
	
if(!empty($_REQUEST['busca'])) {
?>
  <table cellpadding="0" cellpadding="0" border="0" width="70%" align="center">
    <tr>
      <td>Encontrado/s <font color=red><b><?=pg_num_rows($sql)?></b> </font>Diário/s com <b><i><?=utf8_encode($_REQUEST['busca'])?>.<i></b></td>
    </tr>
  </table>
<?php
}
   echo "<table width=70% align='center' cellspacing=0 cellpadding=0>
    <tr>
    <td colspan=2 height='35' bgcolor='#C8EDF8' style='border-bottom:1px solid #0A63C6'>&nbsp;&nbsp;<font size=2>Publicação</font></td>
    <td style='border-bottom:1px solid #0A63C6' bgcolor='#C8EDF8'><font size=2>Edição</td>
    <td style='border-bottom:1px solid #0A63C6' bgcolor='#C8EDF8' align=center><font size=2>Data de Publicação</td>
    <td style='border-bottom:1px solid #0A63C6' bgcolor='#C8EDF8'>&nbsp;</td>
    </tr>";
$nametpo = '';


    while ($rr = pg_fetch_array($sql))  {

      $fl = pg_fetch_array(pg_query("select *from diario where edi_codigo=".$rr['edi_codigo']));
      $url = base64_encode("diarios_prontos/".trim($fl['die_arquivo']));
	  $y = base64_encode($rr[edi_codigo]);
      if(trim($fl['die_arquivo'])!='') {
          $link = "onclick=\"location.href='read_pdf.php?x=$url&k=$y'\" ";
      } else {
          $link = "onclick=\"alert('DOCUMENTO indisponivel no momento, tente novamente mais tarde');\" ";
      }

  echo "<tr class='tabelareg' $link>
          <td class='registro' width=23><img src=imgs/ico_doc.png></td>
      		<td class='registro'><span style='font-size:9px'>Diário Oficial</span> <font color=#BF2823 size='1'>";
       $qname = pg_query("select tpo_nome,edi_codigo from anexos_diario as a join tipoedicao as b on a.tpo_codigo=b.tpo_codigo where edi_codigo=$rr[edi_codigo] group by tpo_nome,edi_codigo order by tpo_nome desc") or die(pg_last_error());
       while($n=pg_fetch_array($qname)) {
		   $bg=($bg=='880808')?'FF0000':'880808';
		   echo "<font color=$bg>".strtoupper($n[tpo_nome])."</font>";
	   }
			echo "</font></td>
      		<td class='registro'></a>Nº <b>".$rr['edi_nome']."</b></td><td class='registro' align=center>".$rr['data']."</td>
      		<td class='registro' align='right'><button type='button' class='btn btn-primary btn-lg float-right' data-toggle='modal' data-target='#exampleModal'>Ver Diário</button>  </td>
      </tr>";
    }
  echo "</table>";
    $q_total = pg_query("select * from edicao where edi_status='t'");
  ?>
  <table cellpadding="0" cellpadding="0" border="0" width="70%" align="center">
    <tr>
      <td><b><?=pg_num_rows($q_total)?></b> Diários disponíveis no sistema.</td>
    </tr>
  </table><br>
  <table cellpadding="0" cellpadding="0" border="0" width="70%" align="center">
    <tr>
      <td>&nbsp;</td>
      <td align='center' width='10%'>
<?php
if(($_REQUEST['p']!="" AND $_REQUEST['p']!="0")) {
  echo "<div onClick=\"location.href='index.php?p=".($_REQUEST['p']-1)."'\" class='paginacao'><<</div>";
}
if(($_REQUEST['p']=="5")) {
 # echo "<div style='background-color: #909090' onClick=\"location.href='index.php?p=".($_REQUEST['p']-1)."'\" class='paginacao'>5</div>";
}
  $total = pg_num_rows($q_total);
  $divs = ceil($total/10);
  if(empty($_REQUEST['p'])) {
      $new_i = 1;      
      $qtdini = 5;      
  } else {
      if($divs>=6) {
          $qtdini = 6;      
        if(!empty($_REQUEST['p'])) {
          $new_i = $_REQUEST['p'];      
          $qtdini = ($new_i+6);      
        } else {
          $new_i = 1;      
        }
      } else {
        $qtdini = $divs;    
      }
      if($qtdini>=$divs) {
        $qtdini = $divs;
      }
      $inifor =intval($qtdini-$new_i);

      if($inifor<6) {
        $new_i = 6;
      } else {
        $new_i = 1;
        $qtdini = 6;
      }
    }
#  echo $new_i."---";
#  echo $qtdini."---";
#  echo $total."---";
# echo $divs."---";
#  echo "INTFOR:".$inifor;
  $k=0;
  for($i=$new_i;$i<=$qtdini;$i++) {
    if($i>=$qtdini) {
     # echo "<div class='paginacao' onClick=\"location.href='index.php?p=$divs'\">".$divs."</div>";
    } else {
       if($_REQUEST['p']==$i) { $color = "style='background-color: #909090'"; } else { $color=""; }
      #echo "<div class='paginacao' $color onclick=\"location.href='index.php?p=$i'\">".$i."</div>";
    }
  }
  echo "<div onClick=\"location.href='index.php?p=".($_REQUEST['p']+1)."'\" class='paginacao'>>></div>";
?>
</td>
      <td >&nbsp;</td>
</tr>
</table>
</div><br><br><br><br><br><br><br><br>
<?php
 $rel = pg_query("select tpo_nome,count(*) as total from anexos_diario as a join tipoedicao as b on a.tpo_codigo=b.tpo_codigo group by tpo_nome order by total desc limit 5");
 $result = '';
 while($tprel=pg_fetch_array($rel)) {
  $result_t .= $tprel['total'].",";
  $result_l .= "'".$tprel['tpo_nome']."',";
 }
?>
<script>
    var randomScalingFactor = function() {
      return Math.round(Math.random() * 100);
    };

    var config = {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [<?=substr($result_t,0,-1)?>],
          backgroundColor: [
            window.chartColors.red,
            window.chartColors.orange,
            window.chartColors.yellow,
            window.chartColors.green,
            window.chartColors.blue,
          ],
          label: 'Dataset 1'
        }],
        labels: [<?=trim(preg_replace('/\s\s+/', '', substr($result_l,0,-1)))?>]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'top',
        },        
        animation: {
          animateScale: true,
          animateRotate: true
        }
      }
    };

    window.onload = function() {
      var ctx = document.getElementById('chart-area').getContext('2d');
      window.myDoughnut = new Chart(ctx, config);
    };

    var colorNames = Object.keys(window.chartColors);
   
  </script>
<?php include ('inferior.php'); ?>