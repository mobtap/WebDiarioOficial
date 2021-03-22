<?php include 'superior.php' ?>

<div class="tab-content">
	<div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
		<div class="main-card mb-3 card">
			<div class="card-body">
				<div class="card-title">Agendamento de consulta</div>
				<div class="row">
					<div style="width:100%;margin:16px">
						<table cellpadding="6" width="50%">
							<tr>
								<td align=center width="10%">Datas Disponíveis</td>
								<td align=center>Horário</td>
								<td>&nbsp;</td>
							</tr>
							<?php for($i=0;$i<=10;$i++) { ?>
							<tr>
								<td width="6%"><span style="text-indent: 17px;display:flex;width:120px;text-align: center;padding:10px;border:1px solid;border-color:#ddd;border-radius:5px;font-size: 12px">06/04/2020</span></td>
								<td width="4%"><span style="text-align: center;padding:10px;border:1px solid;border-color:#ddd;border-radius:5px;font-size: 13px;color:#42b541"><b>18:00</b></span></td>
								<td><button class="btn btn-transition btn-outline-light" style="display:flex;width:100% !important;text-align:center !important;padding:10px;border:1px solid;border-color:#ddd;border-radius:5px;font-size: 12px;color:#0E8EAB"><b>AGENDAR</b></button></td>
							</tr>
							<?php } ?>
						</table>
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>


<?php include 'inferior.php' ?>