<?php

	require_once("../server/seguranca.php");
	$final = date('Y-m-t H:i:s');
	$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
	$usuario = $_SESSION['imunevacinas']['usuarioNome'];
	$start = $_POST['start'];
	$den_id = $_POST['den_id'];
	$minTime = substr($_POST['minTime'],0,strlen($_POST['minTime']) - 3);
	if(substr($minTime,0,1) == 0){
		$minTime = substr($minTime,1);
	}
	$maxTime = $_POST['maxTime'];
	$slotDuration = minutes($_POST['slotDuration']);
	function minutes($time){
		$time = explode(':', $time);
		return ($time[0]*60) + ($time[1]);
	}
	$end   = new DateTime($start);
	$end->add(new DateInterval('PT' . $slotDuration . 'M'));
	$end = $end->format('Y-m-d H:i:s');

	$data = explode(" ",$start)[0];
	$start = explode(" ",$start)[1];
	$end = explode(" ",$end)[1];

?>
<style>
	.bootstrap-timepicker-widget.dropdown-menu.open {
		display: inline-block;
		z-index: 20000;
	}
</style>
<div id="novaConsulta">
	<div id="finfin" class="row"></div>
	<div class="row">
		<div class="col-xs-12">
			<i class="fa fa-user"></i> Paciente: <input id="cli_id" class="form-control">
		</div>
	</div>
	<div class="row hidden" id="hora_con">
		<div class="col-xs-12">
			Horário<select class="select2-selection select2-selection--single" style="width: 100%" id="horario"></select>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			Obs:<textarea class="form-control" id="obs"></textarea>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			Tipo de Consulta
			<select class="form-control" id="tipo">
				<option value="1">Normal</option>
				<option value="2">Manutenção</option>
				<option value="3">Retorno</option>
				<option value="4">Urgência</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			Status da Consulta:<br>
			<?php
				foreach($_SESSION['config']['statusAgenda'] as $statusAgenda){
					?>
					<div class="col-sm-2 col-xs-4">
						<label class="radio-inline">
							<input class="radiobox style-0" type="radio" color="<?php echo $statusAgenda['color'];?>" id="tp_consulta" name="tp_consulta" value="<?php echo $statusAgenda['id'];?>">
							<span title='<?php echo $statusAgenda['status'];?>' class='label text-center' style="background:<?php echo $statusAgenda['color'];?>">&nbsp;<?php echo $statusAgenda['status'];?>&nbsp;&nbsp;</span>
						</label>
					</div>
					<?php
				}
			?>
		</div>
	</div>
	<div class="row hidden" id="consulta_footer">
		<div class="col-xs-12 modal-footer">
			<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>AGENDAR</a>
			<a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
			<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
			<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
		</div>
	</div>
</div>
<script>
	$("#novaConsulta").find('#cli_id').each(function(){
		$(this).prop('disabled',true);
	});


	$.post('server/recupera.php',{tabela:"consulta where id = <?php echo $_POST['id'];?>"}).done(function(data2){
		var obj2 = JSON.parse(data2)[0];

		if(obj2.status > 2 && obj2.status < 7){
			$("#novaConsulta").find("#editar").remove();
		}

		$("#cli_id").attr('retorno',obj2.cli_id);
		$("#cli_id").attr('value',obj2.cli_nome);
		$("#obs").val(obj2.obs);

		$("#tp_consulta[value='1']").prop('checked',true);
		var st = obj2.dt_start.split(' ')[1];
		if(st.substr(0,1) == '0'){
			st = st.substr(1);
		}
		var en = obj2.dt_end.split(' ')[1];
		if(en.substr(0,1) == '0'){
			en = en.substr(1);
		}


		$.post('server/recupera2.php',{tabela:"select sum(fin.valorliquido) as apagar,(select sum(fin2.valorliquido) from financeiro as fin2 where fin2.status = 2 and pes_id = '"+$("#cli_id").attr('retorno')+"') as areceber,(select sum(fin2.valorliquido) from financeiro as fin2 where fin2.status = 3 and pes_id = '"+$("#cli_id").attr('retorno')+"') as pagas,(select sum(fin2.valorliquido) from financeiro as fin2 where fin2.status = 4 and pes_id = '"+$("#cli_id").attr('retorno')+"') as recebidas,(select sum(fin2.valorliquido) from financeiro as fin2 where (fin2.status = 3 or fin2.status = 1) and pes_id = '"+$("#cli_id").attr('retorno')+"') as tpagas,(select sum(fin2.valorliquido) from financeiro as fin2 where (fin2.status = 4 or fin2.status = 2) and pes_id = '"+$("#cli_id").attr('retorno')+"') as trecebidas from financeiro as fin where fin.status = 1 and pes_id = '"+$("#cli_id").attr('retorno')+"'"}).done(function(data){
			var obj = JSON.parse(data)[0];
			if(obj.areceber == null){obj.areceber = '0.00'};
			if(obj.recebidas == null){obj.recebidas = '0.00'};
			if(obj.trecebidas == null){obj.trecebidas = '0.00'};
			$("#finfin").html('<div class="col-xs-12"><i class="fa fa-money"></i> Financeiro </div> <div class="col-sm-4 col-xs-6 text-align-center text-center"><label class="label label-danger font-sm">TOTAL À PAGAR R$ '+obj.areceber+'</label></div><div class="col-sm-4 col-xs-6 text-align-center text-center"><label class="label bg-color-redLight font-sm">TOTAL PAGO: R$ '+obj.recebidas+'</label></div><div class="col-sm-4 col-xs-6 text-align-center text-center"><label class="label label-primary font-sm ">TOTAL GERAL R$ '+obj.trecebidas+'</label></div>');
		});

		$.post('server/recupera2.php',{tabela:"select pasta.esp_id, pasta.id, pasta.numero, especialidade.nome as especialidade from especialidade,pasta where pasta.esp_id = especialidade.id and  pasta.pes_id = " +$("#cli_id").attr('retorno')}).done(function(data){
			var obj = JSON.parse(data);
			for(i in obj){
				$("#pasta").append('<option value="'+obj[i].numero+'">'+obj[i].numero+' - '+obj[i].especialidade+'</option>')
			};

			$("#pasta option[value='"+obj2.ficha+"']").prop('selected',true);
		});
	});


	$("#cadastrar").click(function(){
		var start = '';
		var end = '';
		if($("#horario option:selected").val().split(' - ')[0].split(':')[0].length == 1){
			start = "0"+$("#horario option:selected").val().split(' - ')[0];
		}else{
			start = $("#horario option:selected").val().split(' - ')[0];
		};

		if($("#horario option:selected").val().split(' - ')[1].split(':')[0].length == 1){
			end = "0"+$("#horario option:selected").val().split(' - ')[1];
		}else{
			end = $("#horario option:selected").val().split(' - ')[1];
		};

		var data  = "<?php echo $data;?>";
		var ficha = $("#pasta option:selected").val();
		var cli_id = $("#cli_id").attr('retorno');
		var title = $("#cli_id").val();
		var obs   = $("#obs").val();
		var status= $("#tp_consulta:checked").val();
		var tipo  = $("#tipo option:selected").val();
		var color = $("#tp_consulta:checked").attr('color');
		var den_id= "<?php echo $den_id;?>";
		end = data + " " + end;
		start = data + " " + start;
		if(!status){
			status = 1;
			color = "#20202F";
		}

		if(!ficha) {
			alerta("Aviso!", "Você precisa cadastrar pelo menos uma pasta!", "warning", "warning");
		}

		else{

			$.ajax({
				url: 'server/recupera.php',
				type: 'POST',
				cache: false,
				data: {tabela:"consulta where cli_id = "+cli_id+" and (status <= 2) and dt_start between '<?php echo $data.' '.$end;?>' and '<?php echo $final;?>' limit 1"},
				success: function(data) {
					var obj = JSON.parse(data)[0];
					if(obj){
						$.SmartMessageBox({
							title : "AVISO IMPORTANTE!",
							content : "Já existe um evento agendado para "+title+" no dia: "+obj.dt_start.substr(8,2)+"/"+obj.dt_start.substr(5,2)+"/"+obj.dt_start.substr(0,4)+" às "+obj.dt_start.substr(10,6)+" horas. Escolha uma das seguintes opções:",
							buttons : "[3 - CANCELAR][2 - REMARCAÇÃO][1 - AGENDAR]"
						}, function(ButtonPress, Value) {
							if(ButtonPress == "1 - AGENDAR"){
								$.ajax({
									url: 'server/agendamento.php',
									type: 'POST',
									cache: false,
									data: {funcao:1,tipo:1,title:title,start:start,end:end,ficha:ficha,den_id:den_id,cli_id:cli_id,obs:obs+". Nova Consulta! Por: <?php echo $usuario;?>",status:status,color:color},
									success: function(data) {
										if(data == 1){
											sucesso();

											if(status == 1 || status == 2 || status == 4 || status == 6){
												var celular = $("#dadosPaciente").find("#celular").text().replace("(","").replace(")","").replace(" ","").replace("-","");
												if(celular.substr(2,1) == '9'){
													var dt = start.substr(8,2)+"/"+start.substr(5,2)+"/"+start.substr(0,4)+" "+start.substr(11,5);
													enviaSMS({funcao:2,numero:celular,data:dt,prof:den_id,status:status});
												}
											}

										}else{
											erro();
										}
										$('#calendar').fullCalendar('refetchEvents');
										$("#cadastro").dialog('close');
									}
								});
							}else if(ButtonPress == "2 - REMARCAÇÃO"){
								$.post('server/updateCampo.php',{tabela:"consulta",coluna:'status',valor:4,id:obj.id});
								$.post('server/updateCampo.php',{tabela:"consulta",coluna:'color',valor:'#D9A300',id:obj.id});
								$.post('server/updateCampo.php',{tabela:"consulta",coluna:'obs',valor:"Remarcado e Antecipado para: "+start.substr(8,2)+"/"+start.substr(5,2)+"/"+start.substr(0,4)+" às "+ start.substr(10,6)+" horas. Por: <?php echo $usuario;?>",id:obj.id});
								$.ajax({
									url: 'server/agendamento.php',
									type: 'POST',
									cache: false,
									data: {funcao:1,tipo:tipo,title:title,start:start,end:end,ficha:ficha,den_id:den_id,cli_id:cli_id,obs:obs+". Remarcação do dia "+obj.dt_start.substr(8,2)+"/"+obj.dt_start.substr(5,2)+"/"+obj.dt_start.substr(0,4)+" às "+obj.dt_start.substr(10,6)+" horas. Por: <?php echo $usuario;?>",status:status,color:color},
									success: function(data) {
										if(data == 1){
											sucesso();

											if(status == 1 || status == 2 || status == 4 || status == 6){
												var celular = $("#dadosPaciente").find("#celular").text().replace("(","").replace(")","").replace(" ","").replace("-","");
												if(celular.substr(2,1) == '9'){
													var dt = start.substr(8,2)+"/"+start.substr(5,2)+"/"+start.substr(0,4)+" "+start.substr(11,5);
													enviaSMS({funcao:2,numero:celular,data:dt,prof:den_id,status:status});
												}
											}

										}else{
											erro();
										}
										$('#calendar').fullCalendar('refetchEvents');
										$("#cadastro").dialog('close');
									}
								});
							}

						});
					}else{
						$.ajax({
							url: 'server/agendamento.php',
							type: 'POST',
							cache: false,
							data: {funcao:1,tipo:tipo,title:title,start:start,end:end,ficha:ficha,den_id:den_id,cli_id:cli_id,obs:obs,status:status,color:color},
							success: function(data) {
								if(data == 1){
									sucesso();

									if(status == 1 || status == 2 || status == 4 || status == 6){
										var celular = $("#dadosPaciente").find("#celular").text().replace("(","").replace(")","").replace(" ","").replace("-","");
										if(celular.substr(2,1) == '9'){
											var dt = start.substr(8,2)+"/"+start.substr(5,2)+"/"+start.substr(0,4)+" "+start.substr(11,5);
											enviaSMS({funcao:2,numero:celular,data:dt,prof:den_id,status:status});
										}
									}

								}else{
									erro();
								}
								$('#calendar').fullCalendar('refetchEvents');
								$("#cadastro").dialog('close');
							}
						});
					}
				}
			});
		}
	});

</script>
