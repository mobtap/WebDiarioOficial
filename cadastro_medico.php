<?
  include 'superior.php';
  session_start();
?>

          <div class="box box-default color-palette-box">
            <div class="box-header with-border">
              <h3 class="box-title">
                <i class="fas fa-user-md"></i> Médico:
              </h3>
            </div>
            <div class="box-body">
              <div class="row" >
                <div class="row-sm-4 row-md-2" style="margin-left:10px;" >
                  <div class="color-palette-set">


<?
 if($_REQUEST['acao']=="") {
?>

		<form action="cadastro.php" method="POST" class="form-horizontal">
		<input type=hidden name='acao' value='add'>
                  <div class="box-body">
                    <div class="form-group">
                      <label for="cli_cliente" class="col-sm-2 control-label">Nome Completo:</label>
                      <div class="col-sm-5">
                        <input type="text" class="form-control" id="cli_cliente" name="usu_nome" required>
                      </div>
                    </div>
					
					
					<div class="form-group">
					<label for="cli_dtinicio" class="col-sm-2 control-label">Data de Nascimento:</label>
					<div class="col-sm-2">
					<input size="16" name="usu_datanasc" type="text" value="<?=$rr[cli_dtinicio]?>" class="form-control round-input" data-mask="99/99/9999" required>
					</div>
					</div>	

                 <div class="form-group">
                      <label for="cli_cliente" class="col-sm-2 control-label">CRM:</label>
                      <div class="col-sm-5">
                        <input type="text" name="usu_mae" class="form-control" id="cli_cliente" >
                      </div>
                    </div>
					
					<div class="form-group">
                      <label for="cli_numeroos" class="col-sm-2 control-label">Cartão SUS:</label>
                      <div class="col-sm-4">
                        <input type="text" name="usu_cartao_sus" class="form-control" id="cli_numeroos">
                      </div>
                    </div>
					
					<div class="form-group">
                      <label for="cli_numeroos" class="col-sm-2 control-label">CPF:</label>
                      <div class="col-sm-2">
                        <input type="text" name="usu_cpf" class="form-control" id="cli_numeroos" data-mask="999.999.999-99" required>
                      </div>
                    </div>

					<div class="form-group">
                      <label for="cli_numeroos" class="col-sm-2 control-label">Cidade:</label>
                      <div class="col-sm-2">
                        <input type="text" name="cid_codigo" class="form-control" id="cli_numeroos" required>
                      </div>
                    </div>

					<div class="form-group">
                      <label for="cli_numeroos" class="col-sm-2 control-label">Estado:</label>
                      <div class="col-sm-2">
                        <input type="text" name="uf_codigo" class="form-control" id="cli_numeroos" required>
                      </div>
                    </div>

					<div class="form-group">
                      <label for="cli_numeroos" class="col-sm-2 control-label">Bairro:</label>
                      <div class="col-sm-4">
                        <input type="text" name="bai_nome" class="form-control" id="cli_numeroos" required>
                      </div>
                    </div>

					<div class="form-group">
                      <label for="cli_numeroos" class="col-sm-2 control-label">Telefone:</label>
                      <div class="col-sm-2">
                        <input type="text" name="usu_fone" class="form-control" id="cli_numeroos" data-mask="(99) 9 9999-9999" required>
                      </div>
                    </div>

					<div class="form-group">
                      <label for="cli_numeroos" class="col-sm-2 control-label">E-mail:</label>
                      <div class="col-sm-4">
                        <input type="text" name="usu_email" class="form-control" id="cli_numeroos" required>
                      </div>
                    </div>

					 <div class="form-group">
                      <label for="com_categoria" class="col-sm-2 control-label">Gênero:</label>
                        <div class="col-sm-3">
					<select class="form-control round-input" name="usu_sexo">
					<option value='1'>Não Informado</option>
					<option value='2'>Masculino</option>
					<option value='3'>Feminino</option>					
					</select>
                      </div>
                    </div>				
					
					
			<br>		
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-default">Cancelar</button>&nbsp;&nbsp;&nbsp;
                    <button type="submit" class="btn btn-success">Salvar</button>
                      </div>
                    </div>
					</div>
                </form>
 
<?
 }
 
 if($_REQUEST['acao']=="add") { 
 
	 if($_REQUEST['usu_sexo']==2) {
		 $usu_sexo='M';
	 } 
	 if($_REQUEST['usu_sexo']==3) {
		 $usu_sexo='F';
	 } 
	 if($_REQUEST['usu_sexo']==1) {
		 $usu_sexo='I';
	 } 
	 $cpf = str_replace(".","",str_replace("-","",$_REQUEST['usu_cpf']));
	 $fone = str_replace("(","",str_replace(")","",str_replace(" ","",$_REQUEST['usu_fone'])));
	 $usu = pg_fetch_array(pg_query("select nextval('seq_usu_codigo') as usu_codigo"));
	 $sel = pg_query("select *from usuario where usu_nome='".$_REQUEST['usu_nome']."' and usu_datanasc='".$_REQUEST['usu_datanasc']."' and usu_mae='".$_REQUEST['usu_mae']."'");
	 if(pg_num_rows($sel)==0) {
	 $sql = pg_query("insert into usuario (usu_fone,usu_email,usu_cpf,usu_codigo,usu_nome,usu_datanasc,usu_mae,usu_cartao_sus,cid_nome,bai_nome,usu_sexo) 
						values ('".$fone."','".$_REQUEST['usu_email']."','".$cpf."',$usu[usu_codigo],'".$_REQUEST['usu_nome']."','".$_REQUEST['usu_datanasc']."','".$_REQUEST['usu_mae']."','".$_REQUEST['usu_cartao_sus']."',
						'".$_REQUEST['cid_nome']."','".$_REQUEST['bai_nome']."','".$usu_sexo."')") or die(pg_last_error());
	$hr = date("H:s");					
	$age = pg_fetch_array(pg_query(" select nextval('seq_age_codigo') as age_codigo"));
	$Sqlage = pg_query("insert into agendamento(age_codigo,age_data,age_paciente,usu_codigo,age_tipo,uni_codigo,esp_codigo,age_hora,med_codigo,age_atendido,age_item) 
					values ($age[age_codigo],CURRENT_DATE,'".$_REQUEST['usu_nome']."',$usu[usu_codigo],'ES','3','1054','$hr','355','P','AL')") or die(pg_last_error());

	 }
						
     echo "<br><br><br><br><br><br><center><font color=blue>Cadastro Realizado com Sucesso.</font><br>
			<i>Quando proxima vez em que for entrar, digite seu </i><b>CPF</b> <i>ou</i> <b>Cartao SUS</b> <i>e a</i> <b>senha</b> <i>sera sua</i> <b>data de nascimento</b></i></center><br><br><br><Br><br><br><br><Br>";						

		 $_SESSION['usu_codigo']=$usu[usu_codigo];
		 $_SESSION['dados']=$_REQUEST['usu_nome'];
	?><script>
		setTimeout("window.location.href='index.php';",9000);
	</script><?

	}
?>       
                
             
            
                  </div>
                </div>
              </div><!-- /.row -->
            </div><!-- /.box-body -->
          </div><!-- /.box -->

		  
<?
 include 'inferior.php';
?>		  
