<?php 
  include ('../db.inc.php'); 
  $r = pg_fetch_array(pg_query("select *from entidade"));
?>
<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=strtoupper($r[nome])?>  - Diário Oficial Eletrônico</title>
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="js/jquery.calendar.js"></script>
    <link rel="stylesheet" href="css/jquery.calendar.css" />
      <meta name = "viewport" content = "width = device-width, initial-scale = 1">
    <style>
    * { font-family: Verdana, Arial, Helvetica, sans-serif;}
    body { background-color: #fafafa; }
    pre {font-family: Courier New;}
    </style>

  <script src="js/chart.js"></script>
  <script src="js/util.js"></script>
<script>
<?php 
	$id = base64_decode($_REQUEST['k']);
	$diar = pg_fetch_array(pg_query("select to_char(die_datacadastro,'dd/mm/yyyy hh24:mi:ss') as dt from diario  where edi_codigo=".$id)); 
	$dt = $diar[dt];
?>
  function cert() {
        alert('<?=utf8_encode(trim($r['certificado']))?>\n\nCarimbo de Tempo\nServidor: SERVIDOR DE CARIMBO DO TEMPO ACT BRy 50111\nPolítica deRequisição: 2.16.76.1.6.6\nData: <?=$dt?>\n');

  }
</script>

<style>
body {
font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
color:#000000;
}

.registro {
  border-bottom:1px dotted #D9D9D9;
  height:40px;
  font-size:14px;
  cursor: pointer;
}

.tabelareg:hover {
  background-color: #F2F2F2;
}

.rodape {
position: fixed;
width: 100%;
left: 0px;
top: 90%;
height: 10%;
background-color: #eeeeee ;
border-top:1px solid #D9D9D9;
}

.header {
position: relative;
width: 101%;
left: -8px;
top: -8px;
height: 30%;
background-color: #eeeeee ;
border-bottom:1px solid #D9D9D9;
}
.content {
  position: relative;
  top:-15px !important;
}
.logo{
  border-radius: 10px;
  border-bottom:2px solid #D9D9D9;
}
.canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
  }
.busca {
 position: relative;
 top:-2px;
 width:100%;
 height: 25px;
 font-size:14px;
 border: 1px solid #C1C1C1;
 border-radius: 10px; 
 background-color: #F5F5F5;
 font-color:#909090;
 color: #909090;
}
.paginacao {
  width: 40px;
  height: 40px;
  background-color: #e9e9e9;
  float: left;
  text-align: center;
  border: 1px solid #e1e1e1;
  border-radius: 10px;
  margin-top: 10px;
  margin-left: 3px;
  line-height:40px;
  cursor:pointer;
}
.paginacao:hover {
  background-color: #CFCECE;
  border-color: #8F8F8F;
}
.menu {
  position: relative;
  border-radius: 10px;
  margin-top: 10px;
  margin-left: 3px;
  line-height:30px;
  height:35px;
  background-color: #CFCECE;
  border-color: #8F8F8F; 
  width:68%;
  left:15%;
  top:-10px;
}
a:hover {
  color:#ff0000;
  text-decoration: none;
}
a {
  color:#909090;
  text-decoration: none;
}
.btn {
  border-radius: 8px;
  background-color: #3F6AD8;
  width:120px;
  height: 35px;
  border:0px;
  color:#fff;
}
 @media (max-width: 500px) { 
  .cab {
    display: none;
  }
  .cabecario_cel {
    height:180px;
    display:block;
  }
    .menubtn {
      position: relative;
      top:120px;
      width:100%;
      background-color: #e1e1e1;
      height:30px;
      border-radius: 15px;
    }
   .divlogo {
      position:fixed;
      top:-10px;
      width:98%;
      height:600px !important;
      border-radius: 5px;
      margin:5px 5px 5px 5px;
      text-align: center;
    }
    .logo {
      position:relative;
      width:120px;
      left:30%;
      float: left;
      border-radius: 5px;
      margin:5px 5px 5px 5px;
    }
    .titulo {
      position: fixed;
      left:65px;
      top:100px;
      width:100%;
      font-size: 18px !important;
    }
    .subtitulo {
      position: fixed;
      top:125px;
      left:60px;
      width:80%;
    }
    .geral {
      width:100%;
    }
}
 @media (min-width: 500px) {
  .cab {
    display: block;
  }
  .cabecario_cel {
    display:none;
  }
}

</style>
<div id="geral">
    <div class="header cab">
      <table width=70% align="center">
        <tr>
          <td><a href="index.php"><img src="imgs/logo.png" width="120" class="logo" border="0"></a></td>
          <td align=center>
              <span style="font-size: 40px"><b>Diário Oficial Eletrônico</b></span><br>
            <span style="font-size: 14px;color:#0119AC"><b><?=strtoupper($r[nome])?></font></b></span>
          </td>
        </tr>
      </table>
            <div class='menu'>
      <table width=99% align="center" border=0>
        <tr>
          <?php if(base64_decode($_REQUEST['x'])) { ?>
          <td width='80' valign='absmiddle'><a href='index.php'><img src='imgs/voltar.png' width=25 valign='middle' border=0>&nbsp;<font size=1>VOLTAR</font></a></td>
        <?php } ?>
          <td  width='120'  valign='absmiddle'><a href='index.php'><img src='imgs/doc.png' width=25 valign='middle' border="0">&nbsp;<font size=1>PUBLICAÇÕES</font></a></td>
          <?php if(base64_decode($_REQUEST['x'])) { ?>
          <td width="120" valign='absmiddle'><a href='#' onclick='cert()'><img src='imgs/key.png' width=25 valign='middle' border="0">&nbsp;<font size=1>CERTIFICADO</font></a></td>
        <?php } ?>
          <td width="140" valign='absmiddle'><a href='/diariooficial/login.php' target="_blank"><img src='imgs/key.png' width=25 valign='middle' border="0">&nbsp;<font size=1>ACESSAR SISTEMA</font></a></td>
          <td width="3%">&nbsp;<form method="post" action="index.php" id="buscaform"></td>
          <td valign='top' align="right"><font size=1><span style="position:relative;top:-2px">LOCALIZAR:</span></font></td>
          <td><input type=text name=busca class='busca'></td>
          <td width=25 valign='top'><span style="cursor:pointer;position:relative;top:-2px"><img src='imgs/busca.png' width=25 valign='middle' border="0" valign='top' onclick="document.getElementById('buscaform').submit()"></span></td></form>
        </tr>
      </table>

            </div>
    </div>

<div class='cabecario_cel'>
        <div class="divlogo"><a href="index.php"><img src="imgs/logo.png" height="100" class="logo" border="0"></a></div>
      <span class="titulo" style="font-size: 34px"><b>Diário Oficial Eletrônico</b></span><br>
      <span class="subtitulo" style="font-size: 14px"><b><i>Município de <font color=E1271B><?=$r[cidade]?></font></i></b></span>
    <div class="menubtn">
      <table width=99% align="center" border=0>
        <tr>
          <?php if(base64_decode($_REQUEST['x'])) { ?>
          <td width='80' valign='absmiddle'><a href='index.php'><img src='imgs/voltar.png' width=25 valign='middle' border=0>&nbsp;<font size=1>VOLTAR</font></a></td>
        <?php } ?>
          <td  width='120'  valign='absmiddle'><a href='index.php'><img src='imgs/doc.png' width=25 valign='middle' border="0">&nbsp;<font size=1>PUBLICAÇÕES</font></a></td>
          <?php if(base64_decode($_REQUEST['x'])) { ?>
          <td width="120" valign='absmiddle'><a href='#' onclick='cert()'><img src='imgs/key.png' width=25 valign='middle' border="0">&nbsp;<font size=1>CERTIFICADO</font></a></td>
        <?php } ?>
        </tr>
      </table>    
    </div>
    </div>
