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
	<div class="row hidden" id="dadosPaciente">
		<div class="col-xs-12">
			Pasta <select class="form-control" id="pasta"></select>
		</div>
		<div class="col-sm-4 col-xs-12">
			<i class="fa fa-phone "></i> Telefone:
			<label class="editable" id="telefone">
		</div>
		<div class="col-sm-4 col-xs-12">
			<i class="fa fa-mobile"></i> Celular:
			<label class="editable" id="celular">
		</div>
		<div class="col-sm-4 col-xs-12">
			<i class="fa fa-envelope"></i> Email:
			<label class="editable" id="email">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			Obs:<textarea class="form-control" id="obs"></textarea>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			Tipo de Evento
			<select class="form-control" id="tipo">
				<option value="1">Consulta</option>
				<option value="2">Manutenção</option>
				<option value="3">Retorno</option>
				<option value="4">Urgência</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			Status do Evento:<br>
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
	var clickCount = 0;
</script>
<?php
if(isset($_POST['id'])){
	?>
	<script>



		$("#novaConsulta").find('input,select,textarea').each(function(){
			$(this).prop('disabled',true);
		});
		$("#cadastrar").addClass('hidden');
		$("#consulta_footer,#editar,#excluir,#dadosPaciente").removeClass('hidden');





		var slotDuration = parseInt("<?php echo $slotDuration;?>");
		var minTime			= "<?php echo minutes($minTime);?>";
		var maxTime			= parseInt("<?php echo minutes($maxTime);?>");
		var contador		= 0;
		var contador2		= 0;
		var contador3		= slotDuration;
		var h				= 0;
		var g				= 0;
		var min				= 0;
		var min2				= 0;
		contador2 = parseInt(minTime);
		if("<?php echo $slotDuration;?>" <= 60){
			while(contador2 < maxTime){

				if(contador3 == 60){
					g++;
					contador3 = 0;
				}
				min2 = parseInt(contador3);
				if(contador == 60){
					if(min2 == 0){
						min2 = '00';
					}
					else if(min2.length == 1){
						min2 = "0"+min2;
					}
					h++;
					$("#horario").append('<option value="'+(h+parseInt(<?php echo explode(":",$minTime)[0];?>))+'<?php echo substr($minTime,1);?>:00 - '+(g+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min2+':00">'+(h+parseInt(<?php echo explode(":",$minTime)[0];?>))+'<?php echo substr($minTime,1);?>:00 - '+(g+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min2+':00</option>');
					contador = 0;

				}else{
					min = parseInt(contador);

					if(min == 0){
						min = '00';
					}
					else if(min.length == 1){
						min = "0"+min;
					}

					if(min2 == 0){
						min2 = '00';
					}
					else if(min2.length == 1){
						min2 = "0"+min2;
					}

					$("#horario").append('<option value="'+(h+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min+':00 - '+(g+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min2+':00">'+(h+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min+':00 - '+(g+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min2+':00</option>');
				}
				contador += slotDuration;
				contador2 += slotDuration;
				contador3 += slotDuration;
			}

		}else{

		}


		$.post('server/recupera.php',{tabela:"consulta where id = <?php echo $_POST['id'];?>"}).done(function(data2){
			var obj2 = JSON.parse(data2)[0];

			if(obj2.status > 2 && obj2.status < 7){
				$("#novaConsulta").find("#editar").remove();
			}

			$("#cli_id").attr('retorno',obj2.cli_id);
			$("#cli_id").attr('antigo',obj2.ficha2);
			$("#cli_id").attr('value',obj2.cli_nome);
			$("#obs").val(obj2.obs);
			$("#tipo").val(obj2.tipo);
			$("#tp_consulta[value='"+obj2.status+"']").prop('checked',true);
			var st = obj2.dt_start.split(' ')[1];
			if(st.substr(0,1) == '0'){
				st = st.substr(1);
			}
			var en = obj2.dt_end.split(' ')[1];
			if(en.substr(0,1) == '0'){
				en = en.substr(1);
			}


			$("#horario").select2('val',st+" - "+en);

			$.post('server/recupera.php',{tabela:"pessoa where grp_emp_id = '<?php echo $empresa;?>' and id = "+$("#cli_id").attr('retorno')}).done(function(data){
				var obj = JSON.parse(data)[0];
				if(!obj.telefone){
					obj.telefone = "Telefone não cadastrado";
				}
				else if(!obj.celular){
					obj.celular = "Celular não cadastrado";
				}
				else if(!obj.email){
					obj.email = "Email não cadastrado";
				}
				$("#telefone").text(obj.telefone);
				$("#celular").text(obj.celular);
				$("#email").text(obj.email);
				$("#novaConsulta").find('#telefone').editable({
					type: 'text',
					name: 'telefone',
					emptytext:'Clique para Atualizar!',
					mode:"inline"
				});
				$("#novaConsulta").find('#celular').editable({
					type: 'text',
					name: 'celular',
					emptytext:'Clique para Atualizar!',
					mode:"inline"
				});
				$("#novaConsulta").find('#email').editable({
					type: 'text',
					name: 'email',
					emptytext:'Clique para Atualizar!',
					mode:"inline"
				});

				$("#novaConsulta").find('#telefone,#celular,#email').on('save', function(e, params) {
					$.post('server/updateCampo.php',{tabela:"pessoa",coluna:$(this).attr('id'),valor:params.newValue,id:$("#cli_id").attr('retorno')});
				});
			});
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






		$("#editar").click(function(){
			$("#obs,#tp_consulta,#pasta,#tipo").prop('disabled',false);
			$("#cancelar,#salvar").removeClass('hidden');
			$("#editar,#excluir").addClass('hidden');
		});


		$("#cancelar").click(function(){
			$.post('ajax/novaConsulta.php',{id:"<?php echo $_POST['id'];?>",den_id:"<?php echo $_POST['den_id'];?>",start:"<?php echo $_POST['start'];?>",end:"<?php echo $_POST['end'];?>",minTime:"<?php echo $_POST['minTime'];?>",maxTime:"<?php echo $_POST['maxTime'];?>",slotDuration:"<?php echo $_POST['slotDuration'];?>"}).done(function(data){
				$("#cadastro").empty().html(data).removeClass('hide').dialog({
					modal: true,
					autoOpen:true,
					//moveToTop:true,
					width:"70%",
					height:"auto",
					position:['center',20],
					title: "Novo Evento",
					title_html: true
				});
			});
		});

		$("#excluir").click(function(){
			confirma("Aviso!","Deseja Excluir esta marcação?",function(){
				$.post('server/agendamento.php',{funcao:3,id:"<?php echo $_POST['id'];?>"}).done(function(data){
					if(data == 1){
						sucesso();
					}else{
						erro();
					}
					$('#calendar').fullCalendar('refetchEvents');
					$("#cadastro").dialog('close');
				});
			});
		});
		$("#salvar").click(function(){
			clickCount++;
			if(clickCount == 1){
				setTimeout(function(){
					clickCount = 0;
				},2500);
				var start = '<?php echo $_POST["start"];?>';
				var end = '<?php echo $_POST["end"];?>';


				var data  = "<?php echo $data;?>";
				var ficha = $("#pasta").val();
				var cli_id = $("#cli_id").attr('retorno');
				var title = $("#cli_id").val();
				var obs   = $("#obs").val();
				var tipo  = $("#tipo option:selected").val();
				var status= $("#tp_consulta:checked").val();
				var color = $("#tp_consulta:checked").attr('color');
				var den_id= "<?php echo $den_id;?>";


				$.post('server/agendamento.php',{tipo:tipo,funcao:2,id:"<?php echo $_POST['id'];?>",title:title,start:start,end:end,ficha:ficha,den_id:den_id,cli_id:cli_id,obs:obs,status:status,color:color}).done(function(data){
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

				});
			}
		});

	</script>
	<?php
 }else{
	 ?>
	 <script>
		 if("<?php echo date('H',strtotime($start));?>" == '00'){
			$("#hora_con").removeClass('hidden');
			 var slotDuration = parseInt("<?php echo $slotDuration;?>");
			 var minTime			= "<?php echo minutes($minTime);?>";
			 var maxTime			= parseInt("<?php echo minutes($maxTime);?>");
			 var contador		= 0;
			 var contador2		= 0;
			 var contador3		= slotDuration;
			 var h				= 0;
			 var g				= 0;
			 var min				= 0;
			 var min2				= 0;
			 contador2 = parseInt(minTime);
			 if("<?php echo $slotDuration;?>" <= 60){
				 while(contador2 < maxTime){

					 if(contador3 == 60){
						 g++;
						 contador3 = 0;
					 }
					 min2 = parseInt(contador3);
					 if(contador == 60){
						 if(min2 == 0){
							 min2 = '00';
						 }
						 else if(min2.length == 1){
							 min2 = "0"+min2;
						 }
						 h++;
						 $("#horario").append('<option value="'+(h+parseInt(<?php echo explode(":",$minTime)[0];?>))+'<?php echo substr($minTime,1);?>:00 - '+(g+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min2+':00">'+(h+parseInt(<?php echo explode(":",$minTime)[0];?>))+'<?php echo substr($minTime,1);?>:00 - '+(g+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min2+':00</option>');
						 contador = 0;

					 }else{
						 min = parseInt(contador);

						 if(min == 0){
							 min = '00';
						 }
						 else if(min.length == 1){
							 min = "0"+min;
						 }

						 if(min2 == 0){
							 min2 = '00';
						 }
						 else if(min2.length == 1){
							 min2 = "0"+min2;
						 }

						 $("#horario").append('<option value="'+(h+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min+':00 - '+(g+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min2+':00">'+(h+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min+':00 - '+(g+parseInt(<?php echo explode(":",$minTime)[0];?>))+':'+min2+':00</option>');
					 }
					 contador += slotDuration;
					 contador2 += slotDuration;
					 contador3 += slotDuration;
				 }

			 }else{

			 }
		 }else{
			 $("#horario").append('<option value="<?php echo $start . ' - ' . $end;?>"><?php echo $start . ' - ' . $end;?></option>');

		 };



	 </script>
	<?php
 }
?>
<script>



	pageSetUp();

	var pagefunction = function() {

		$("#horario").select2();


		$("#novaConsulta").find('input[id="cli_id"]').autocomplete({
			source: "ajax/buscaCli.php",
			select: function(event,ui){
				$(this).attr("retorno",ui.item.id);
				$(this).attr("antigo",ui.item.ficha2);
				$(this).attr("value",ui.item.nome);
				$.post('server/recupera.php',{tabela:"pessoa where grp_emp_id = '<?php echo $empresa;?>' and id = "+ui.item.id}).done(function(data){
					var obj = JSON.parse(data)[0];
					if(!obj.telefone){
						obj.telefone = "Telefone não cadastrado";
					}
					else if(!obj.celular){
						obj.celular = "Celular não cadastrado";
					}
					else if(!obj.email){
						var email = "Email não cadastrado";
					}
					$("#telefone").text(obj.telefone);
					$("#celular").text(obj.celular);
					$("#email").text(obj.email);
					


					$("#novaConsulta").find('#telefone').editable({
						type: 'text',
						name: 'telefone',
						emptytext:'Clique para Atualizar!',
						mode:"inline"
					});
					$("#novaConsulta").find('#celular').editable({
						type: 'text',
						name: 'celular',
						emptytext:'Clique para Atualizar!',
						mode:"inline"
					});
					$("#novaConsulta").find('#email').editable({
						type: 'text',
						name: 'email',
						emptytext:'Clique para Atualizar!',
						mode:"inline"
					});

					$("#novaConsulta").find('#telefone,#celular,#email').on('save', function(e, params) {
						$.post('server/updateCampo.php',{tabela:"pessoa",coluna:$(this).attr('id'),valor:params.newValue,id:$("#cli_id").attr('retorno')});
					});
				});
				$.post('server/recupera2.php',{tabela:"select sum(fin.valorliquido) as apagar,(select sum(fin2.valorliquido) from financeiro as fin2 where fin2.status = 2 and pes_id = '"+ui.item.id+"') as areceber,(select sum(fin2.valorliquido) from financeiro as fin2 where fin2.status = 3 and pes_id = '"+ui.item.id+"') as pagas,(select sum(fin2.valorliquido) from financeiro as fin2 where fin2.status = 4 and pes_id = '"+ui.item.id+"') as recebidas,(select sum(fin2.valorliquido) from financeiro as fin2 where (fin2.status = 3 or fin2.status = 1) and pes_id = '"+ui.item.id+"') as tpagas,(select sum(fin2.valorliquido) from financeiro as fin2 where (fin2.status = 4 or fin2.status = 2) and pes_id = '"+ui.item.id+"') as trecebidas from financeiro as fin where fin.status = 1 and pes_id = '"+ui.item.id+"'"}).done(function(data){
					var obj = JSON.parse(data)[0];
					if(obj.areceber == null){obj.areceber = '0.00'};
					if(obj.recebidas == null){obj.recebidas = '0.00'};
					if(obj.trecebidas == null){obj.trecebidas = '0.00'};
					$("#finfin").html('<div class="col-xs-12"><i class="fa fa-money"></i> Financeiro </div> <div class="col-sm-4 col-xs-6 text-align-center text-center"><label class="label label-danger font-sm">TOTAL À PAGAR R$ '+obj.areceber+'</label></div><div class="col-sm-4 col-xs-6 text-align-center text-center"><label class="label bg-color-redLight font-sm">TOTAL PAGO: R$ '+obj.recebidas+'</label></div><div class="col-sm-4 col-xs-6 text-align-center text-center"><label class="label label-primary font-sm ">TOTAL GERAL R$ '+obj.trecebidas+'</label></div>');
				});

				$.post('server/recupera2.php',{tabela:"select pasta.esp_id, pasta.id, pasta.numero, especialidade.nome as especialidade from especialidade,pasta where pasta.esp_id = especialidade.id and  pasta.pes_id = " + ui.item.id}).done(function(data){
					var obj = JSON.parse(data);
					for(i in obj){
						if(i == 0){
							$("#pasta").append('<option selected especialidade="'+obj[i].esp_id+'" value="'+obj[i].numero+'">'+obj[i].numero+' - '+obj[i].especialidade+'</option>')
						}else{
							$("#pasta").append('<option value="'+obj[i].numero+'">'+obj[i].numero+' - '+obj[i].especialidade+'</option>')
						}
					};
				});

				$("#dadosPaciente,#consulta_footer").removeClass('hidden');

			},
			search:function(){
				loading('show');
			},
			response:function(){
				loading('hide')
			},
			delay:1000,
			minLength:3
		});
		$("#novaConsulta").find('input[id="cli_id"]').autocomplete('option','appendTo',"div[id='novaConsulta']");






	};


	/*var data = new FormData();
	$("#novoCliente").find('input:checkbox:checked,input:text,select,textarea').each(function(){
		data.append($(this).attr('id'),$(this).val());
	});
	$.ajax({
		url: 'server/cliente.php?funcao=2&id='+id,
		data: data,
		processData: false,
		contentType: false,
		type: 'POST',
		success: function ( data2 ) {
			if (data2.match(/[a-z]/i)) {
				alerta("Error!",data2,"danger","ban");
			}else{
				alerta("Sucesso!","Cadastro realizado com sucesso!","success","check");
				$.post("ajax/cadcliente.php",{id:data2}).done(function(data){
					$("#cadastro").empty().html(data);
				}).fail(function(){
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
				try{
					$("#datatable_col_reorder").dataTable().fnReloadAjax();
				}
				catch(e){}
			}
		}
	});*/


	$("#cadastrar").click(function(event){
		clickCount++;
		if(clickCount == 1){
			setTimeout(function(){
				clickCount = 0;
			},2500);
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
			var antigo = $("#cli_id").attr('antigo');
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
						var btcount = 0;
						if(obj){
							$.SmartMessageBox({
								title : "AVISO IMPORTANTE!",
								content : "Já existe um evento agendado para "+title+" no dia: "+obj.dt_start.substr(8,2)+"/"+obj.dt_start.substr(5,2)+"/"+obj.dt_start.substr(0,4)+" às "+obj.dt_start.substr(10,6)+" horas. Escolha uma das seguintes opções:",
								buttons : "[3 - CANCELAR][2 - REMARCAÇÃO][1 - AGENDAR]"
							}, function(ButtonPress, Value) {
								if(ButtonPress == "1 - AGENDAR"){
									btcount ++;
									if(btcount == 1){
										setTimeout(function(){
											btcount = 0;
										},2000);
										$.ajax({
											url: 'server/agendamento.php',
											type: 'POST',
											cache: false,
											data: {funcao:1,tipo:1,antigo:antigo,title:title,start:start,end:end,ficha:ficha,den_id:den_id,cli_id:cli_id,obs:obs+". Nova Consulta! Por: <?php echo $usuario;?>",status:status,color:color},
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
								}else if(ButtonPress == "2 - REMARCAÇÃO"){
									btcount ++;
									if(btcount == 1){
										setTimeout(function(){
											btcount = 0;
										},2000);
										$.post('server/updateCampo.php',{tabela:"consulta",coluna:'status',valor:4,id:obj.id});
										$.post('server/updateCampo.php',{tabela:"consulta",coluna:'color',valor:'#D9A300',id:obj.id});
										$.post('server/updateCampo.php',{tabela:"consulta",coluna:'obs',valor:"Remarcado e Antecipado para: "+start.substr(8,2)+"/"+start.substr(5,2)+"/"+start.substr(0,4)+" às "+ start.substr(10,6)+" horas. Por: <?php echo $usuario;?>",id:obj.id});
										$.ajax({
											url: 'server/agendamento.php',
											type: 'POST',
											cache: false,
											data: {funcao:1,tipo:tipo,antigo:antigo,title:title,start:start,end:end,ficha:ficha,den_id:den_id,cli_id:cli_id,obs:obs+". Remarcação do dia "+obj.dt_start.substr(8,2)+"/"+obj.dt_start.substr(5,2)+"/"+obj.dt_start.substr(0,4)+" às "+obj.dt_start.substr(10,6)+" horas. Por: <?php echo $usuario;?>",status:status,color:color},
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
						}else{
							$.ajax({
								url: 'server/agendamento.php',
								type: 'POST',
								cache: false,
								data: {funcao:1,tipo:tipo,antigo:antigo,title:title,start:start,end:end,ficha:ficha,den_id:den_id,cli_id:cli_id,obs:obs,status:status,color:color},
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
		}
	});


	loadScript("js/plugin/x-editable/x-editable.min.js", function(){
		loadScript("js/plugin/bootstrap-timepicker/bootstrap-timepicker.min.js", pagefunction);
	});
</script>