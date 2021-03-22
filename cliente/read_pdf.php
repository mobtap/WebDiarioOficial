<?php 
	include ('superior.php'); 
?>
<style type="text/css">
 @media (min-width: 300px) { 
	.frmall {
		position:relative;
		border:0px solid;
		top:0px ;
		width:100%;
		left:-3px;
		height:600px;
	}
}
 @media (min-width: 700px) {
.frmall {
		position:relative;
		border:0px;
		top:0px;
		width:100%;
		left:0px;
		height:402px;
	}
}
</style>
  <iframe frameborders="0" src="pdfview/web/viewer.html?file=/diariooficial/<?=base64_decode($_REQUEST['x'])?>" class="frmall"></iframe>
</body>
<?php include ('inferior.php'); ?>