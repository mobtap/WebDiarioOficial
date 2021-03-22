

   <div class="rodape">
    <table width=90% cellspacing="0" cellpadding="0" border=0>
      <tr>
        <td>
<?php
  echo "<table width=60% cellspacing=0 cellpadding=0 border=0 align=center>
        <tr>
         <td><span style='font-size:14px;color:#09256B'><b>".strtoupper($r[nome])."</b></td>
        </tr>
        <tr>
          <td><span style='font-size:9px'>";
            echo strtoupper($r[endereco]).", ".strtoupper($r[numero])." - ".strtoupper($r[cidade])." ".strtoupper($r[estado])." - <b>".strtoupper($r[telefone])."</b>";
    echo "</span></td>
        </tr>
      </table>";
?>
   </td>
     <td><img src="imgs/icp.png" width="50"></td>
     </tr>
   </table>
    </div>
  </div>
 