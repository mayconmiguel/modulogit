<?php require_once "../server/seguranca.php"; $empresa = $_SESSION['imunevacinas']['usuarioEmpresa']?>
<div id="novoOrcamento">


	<div class="panel-group smart-accordion-default" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><a data-toggle="collapse" href="#collapseOne"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> Informações Básicas </a></h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in">
				<div class="panel-body">

					<div class="row">
						<div class="col-xs-12" style="margin-bottom:-20px;">
							Tipo
						</div>
						<div class="row">
							<div class="col-xs-12">
								<div class="col-xs-12">
									<br>
									<label class="radio-inline">
										<input  type="radio" name="tp_insc" value="0" checked>
										<span title='SIM' class='label label-warning text-center font-md'>Orçamento</span>
									</label>
									<label class="radio-inline">
										<input  type="radio" name="tp_insc" value="1">
										<span title='NÃO' class='label label-info text-center font-md'>Venda</span>
									</label>
								</div>
							</div>
						</div>
					</div>


					<div class="row">
						<div class="col-sm-12">
							Nome Completo<span class="txt-color-red">*</span><input retorno="0" cpf="0" autofocus type="text" name="nome" id="nome" class=" inputs form-control wd100">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 col-xs-6">
							Telefone<span class="txt-color-red">*</span><input type="text" name="telefone" id="telefone" class="form-control wd100">
						</div>
						<div class="col-sm-4 col-xs-6">
							Celular<input type="text" name="celular" id="celular" class="form-control wd100">
						</div>
						<div class="col-sm-4 col-xs-12">
							Email<span class="txt-color-red"></span><input type="text" name="email" id="email" class="form-control wd100">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							Como nos conheceu?<select class="form-control" name="indicacao" id="indicacao">
								<option value="0">SELECIONE UMA OPÇÃO!</option>
							</select>
						</div>
						<div class="col-sm-6 col-xs-12">
							Qual?<input id="ind_qual" name="ind_qual" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 col-xs-6">
							Profissional<select class="form-control" name="dentista" id="dentista">
								<option value="0">NÃO INFORMADO!</option>
							</select>
						</div>
						<div class="col-sm-4 col-xs-6">
							Especialidade<select class="form-control" name="especialidade" id="especialidade">
								<option value="0">NÃO INFORMADO!</option>
							</select>
						</div>
						<div class="col-sm-4 col-xs-12">
							Convenio<select class="form-control" name="convenio" id="convenio">
								<option value="0">NÃO INFORMADO!</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-2" href="#collapseTwo-1" class="collapsed"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> Informações Adicionais </a></h4>
			</div>
			<div id="collapseTwo-1" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							DT. Nasc.<input type="text" name="nasc" id="nasc" class="form-control wd100">
						</div>
						<div class="col-sm-4 col-xs-6">
							CPF<input type="text" name="cpf" id="cpf" class="inputs form-control wd100">
						</div>
						<div class="col-sm-4 col-xs-6">
							RG<input type="text" name="rg" id="rg" class="inputs form-control wd100">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-3 col-xs-12">
							CEP<input type="text" name="cep" id="cep" class="form-control wd100">
						</div>
						<div class="col-sm-7 col-xs-12">
							Endereço<input type="text" name="endereco" id="endereco" class="form-control wd100">
						</div>
						<div class="col-sm-2 col-xs-12">
							Nº<input type="text" name="numero" id="numero" class="form-control wd100">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							Complemento<input class="form-control" id="complemento" name="complemento">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 col-xs-12">
							Bairro<input type="text" name="bairro" id="bairro" class="form-control wd100">
						</div>
						<div class="col-sm-4 col-xs-6">
							Cidade<input type="text" name="cidade" id="cidade" class="form-control wd100">
						</div>
						<div class="col-sm-4 col-xs-6">
							Estado<input type="text" name="estado" id="estado" class="form-control wd100">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-4" href="#collapseTwo-4" class="collapsed"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> Procedimentos </a></h4>
			</div>
			<div id="collapseTwo-4" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12">
							<a href="javascript:void(0);" id="novoProc" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-plus"></i> INSERIR</a>
						</div>
					</div>
					<div class="row" id="tabProc"></div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-3" href="#collapseTwo-3" class="collapsed"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> Observações </a></h4>
			</div>
			<div id="collapseTwo-3" class="panel-collapse collapse">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12">
							OBS:
							<textarea class="form-control" id="obs" name="obs"></textarea>
						</div>
					</div>
					<div class="row hidden" id="adicionais">

					</div>

					<div class="row hidden" id="disse">
						<div class="col-xs-12">
							NOVA MENSAGEM<textarea class="form-control" id="newMessage"></textarea>
						</div>
					</div>
				</div>
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-xs-6 text-align-left font-xl">
				<label class="label label-primary" id="proc_total">R$ 0,00</label>
			</div>
			<div class="col-xs-6 text-align-right">
				<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
				<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
				<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="fa fa-times"></i></span>FINALIZAR ORÇAMENTO</a>
			</div>

		</div>
	</div>
</div>
<script>

	$("#novoOrcamento").find('#nome').autocomplete({
		source: "ajax/buscaCli2.php",
		select: function(event,ui){
			$(this).attr("retorno",ui.item.id);
			$(this).attr("cpf",ui.item.cpf);
			$(this).attr("value",ui.item.nome);
		},
		search:function(){
			loading('show');
		},
		response: function(event, ui) {
			//console.log(ui);
			if (ui.content.length === 0) {

			} else {

			}
			loading('hide');
		},
		delay:1000,
		minLength:3
	});
	$("#novoOrcamento").find('#nome').autocomplete('option','appendTo',"div[id='novoOrcamento']");

	cep("#cep");
	$("#nota_enem").mask('0000.00',{reverse:true});


	$.post('server/recupera.php',{tabela:"beneficio where grp_emp_id = <?php echo $empresa;?> group by nome"}).done(function(data){
		var obj = JSON.parse(data);
		for(i in obj){
			$("#convenio").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
		}
	});
	$.post('server/recupera2.php',{tabela:"select concat(pessoa.nome) as nome, pessoa.id from pessoa,agenda where agenda.pes_id = pessoa.id and agenda.grp_emp_id = <?php echo @$empresa;?> order by pessoa.nome"}).done(function(data){
		var obj = JSON.parse(data);
		for(i in obj){
			$("#dentista").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
		}
	});
	$.post('server/recupera.php',{tabela:"especialidade where grp_emp_id = <?php echo $empresa;?> group by nome"}).done(function(data){
		var obj = JSON.parse(data);
		for(i in obj){
			$("#especialidade").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
		}
	});

	$.ajax({
		url: 'server/recupera.php',
		type: 'POST',
		data:{tabela:'indicacao order by nome'},
		cache: false,
		async: false,
		success: function(data) {

			var obj = JSON.parse(data);
			for(i in obj){
				$("#novoOrcamento").find("#indicacao").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
			}
			$("#opcionais").select2();
			loading('hide');
		},
		error:function(){
			loading('hide');
		}
	});

	var dentes = ['11','12','13','14','15','16','17','18','21','22','23','24','25','26','27','28','31','32','33','34','35','36','37','38','41','42','43','44','45','46','47','48','A.I','A.S'];

	var dcount = 0;
	$("#novoProc").click(function(){
		if(dcount > 0 && ($("#novoOrcamento").find("[id='proc_valor']").eq(dcount-1).val().length == 0 || !$("#novoOrcamento").find("[id='proc_nome']").eq(dcount-1).val())){
			$("#novoOrcamento").find("[id='proc_valor']").eq(dcount-1).focus().select();
			alerta('Aviso','Antes de inserir um novo procedimento, favor informar o valor do procedimento anterior!','warning','warning');
		}else{
			$("#tabProc").append('<div id="tabtabProc"><div class="col-sm-4 col-xs-5">Procedimento<select class="form-control" id="proc_nome"></select></div><div class="col-sm-4 col-xs-5">Dente<select id="proc_dente" class="form-control"></select></div><div class="col-sm-4 col-xs-2">Valor<input id="proc_valor" onkeyup="calculo()" class="form-control"></div></div>');
			for(d in dentes){
				if(d == 0){
					$("#novoOrcamento").find('[id="proc_dente"]').eq(dcount).empty().append('<option value="'+dentes[d]+'">'+dentes[d]+'</option>');
				}else{
					$("#novoOrcamento").find('[id="proc_dente"]').eq(dcount).append('<option value="'+dentes[d]+'">'+dentes[d]+'</option>');
				}
			}
			$.ajax({
				url: 'server/recupera.php',
				type: 'POST',
				data:{tabela:'procedimento where grp_emp_id = <?php echo $empresa;?> order by id'},
				cache: false,
				async: false,
				success: function(data) {

					var obj = JSON.parse(data);
					for(i in obj){
						if(i == 0){
							$("#novoOrcamento").find('[id="proc_nome"]').eq(dcount).empty().append('<option value="'+obj[i].id+'">'+obj[i].id+' - '+obj[i].nome+'</option>');
						}else{
							$("#novoOrcamento").find('[id="proc_nome"]').eq(dcount).append('<option value="'+obj[i].id+'">'+obj[i].id+' - '+obj[i].nome+'</option>');
						}
					}
					$("#opcionais").select2();
					loading('hide');
				},
				error:function(){
					loading('hide');
				}
			});
			$("#novoOrcamento").find("[id='proc_valor']").eq(dcount).maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});
			$("#novoOrcamento").find("[id='proc_valor']").eq(dcount).focus().select();
			dcount++;
		}
	});



	$("#cadastrar").click(function(){
		loading("show");
		var nome 		= $("#novoOrcamento").find("#nome").val();
		var cli_id		= $("#novoOrcamento").find("#nome").attr('retorno');
		var telefone 	= $("#novoOrcamento").find("#telefone").val();
		var email 		= $("#novoOrcamento").find("#email").val();
		var celular		= $("#novoOrcamento").find("#celular").val();
		var cpf			= $("#novoOrcamento").find("#cpf").val();
		var rg	 		= $("#novoOrcamento").find("#rg").val();
		var nasc 		= $("#novoOrcamento").find("#nasc").val();
		var cep 		= $("#novoOrcamento").find("#cep").val();
		var endereco	= $("#novoOrcamento").find("#endereco").val();
		var numero 		= $("#novoOrcamento").find("#numero").val();
		var complemento = $("#novoOrcamento").find("#complemento").val();
		var bairro      = $("#novoOrcamento").find("#bairro").val();
		var cidade		= $("#novoOrcamento").find("#cidade").val();
		var estado 		= $("#novoOrcamento").find("#estado").val();
		var indicacao	= $("#novoOrcamento").find("#indicacao").val();
		var qual		= $("#novoOrcamento").find("#ind_qual").val();

		var tp_especial	= $("#novoOrcamento").find("input[name='tp_insc']:checked").val();

		var dentista	= $("#novoOrcamento").find("#dentista option:selected").val();
		var convenio	= $("#novoOrcamento").find("#convenio option:selected").val();
		var especialidade	= $("#novoOrcamento").find("#especialidade option:selected").val();
		var obs			= $("#novoOrcamento").find("#obs").val();

		var procedimentos = [];

		$("#novoOrcamento").find('[id="tabtabProc"]').each(function(){
			if($(this).find("#proc_nome option:selected").val()){
				procedimentos.push({pro_nome:$(this).find('#proc_nome option:selected').html(),pro_id:$(this).find('#proc_nome option:selected').val(),dente:$(this).find('#proc_dente option:selected').val(),valor:$(this).find('#proc_valor').val().replace('R$ ','').replace(',','.')});
			}else{
				return false;
			}
		});
		var total = 0;

		$("#novoOrcamento").find('[id="proc_valor"]').each(function(){
			total = total+parseFloat($(this).val().replace('R$ ','').replace(',','.'));
		});

		var data		= {
			funcao:1,
			nome:nome,
			cli_id:cli_id,
			telefone:telefone,
			cpf:cpf,
			celular:celular,
			rg:rg,
			nasc:nasc,
			cep:cep,
			endereco:endereco,
			numero:numero,
			complemento:complemento,
			bairro:bairro,
			cidade:cidade,
			estado:estado,
			procedimentos:JSON.stringify(procedimentos),
			tp_especial:tp_especial,
			dentista:dentista,
			convenio:convenio,
			especialidade:especialidade,
			contato:indicacao,
			qual:qual,
			obs:obs,
			valor:total
		};


		if(nome.length == 0){
			alerta("Alerta!","Favor informar o nome!","warning","warning");
			$("#nome").focus().select();
			loading('hide');
		}else if(procedimentos.length <= 0){
			alerta("Alerta!","Favor inserir pelo menos 1 procedimento","warning","warning");
			loading('hide');
		}
		else if(dentista == 0){
			alerta("Alerta!","Favor informar o dentista!","warning","warning");
			$("#dentista").focus().select();
			loading('hide');
		}else if(convenio == 0){
			 alerta("Alerta!","Favor informar o convenio!","warning","warning");
			 $("#convenio").focus().select();
			 loading('hide');
		 }
		else if(especialidade == 0){
			alerta("Alerta!","Favor informar a especialidade!","warning","warning");
			$("#convenio").focus().select();
			loading('hide');
		}
		else{
			if(tp_especial == 1){
				$.extend(data,{
					venda:'1'
				});
			}
			envia("server/orcamento.php",data);
			loading('hide');
		}
	});


	function calculo(){

		var total = 0;

		$("#novoOrcamento").find('[id="proc_valor"]').each(function(){
			total = total+parseFloat($(this).val().replace('R$ ','').replace(',','.'));
		});
		$("#proc_total").html("R$ "+total.toFixed(2).replace('.',','));
	}
</script>
<?php

if(isset($_POST['id'])){
	?>
	<script>

		var id 	   = "<?php echo @$_POST['id'];?>";
		loading('hide');

		$("#excluir,#salvar").removeClass('hidden');
		$("#cadastrar").addClass('hidden');
		$('a[href="#collapseTwo-1"]').removeClass('collapsed');
		$('a[href="#collapseTwo-3"]').removeClass('collapsed');
		$('a[href="#collapseTwo-4"]').removeClass('collapsed');
		$('a[href="#collapseTwo-1"]').prop('aria-expanded','true');
		$('a[href="#collapseTwo-3"]').prop('aria-expanded','true');
		$('a[href="#collapseTwo-4"]').prop('aria-expanded','true');

		$("#collapseTwo-1").addClass('in');
		$("#collapseTwo-1").prop('aria-expanded','true');
		$("#collapseTwo-3").addClass('in');
		$("#collapseTwo-4").addClass('in');
		$("#collapseTwo-3").prop('aria-expanded','true');
		$("#collapseTwo-4").prop('aria-expanded','true');

		$("#novoAluno").find("#obs").prop("disabled",true);

		$("#novoAluno").find("#disse").removeClass('hidden');

		$.ajax({
			url: 'server/recupera.php',
			type: 'POST',
			data:{tabela:"orcamento where id = <?php echo $_POST['id'];?>"},
			cache: false,
			async: false,
			success: function(data) {

				var obj = JSON.parse(data);
				obj = obj[0];




				$("#nome").val(obj.nome);
				$("#nome").attr('retorno',obj.cli_id);

				$("[name='tp_insc'][value='"+obj.status+"']").prop('checked',true);
				$("#telefone").val(obj.telefone);
				$("#celular").val(obj.celular);
				$("#email").val(obj.email);
				$("#cpf").val(obj.cpf);
				$("#rg").val(obj.rg);
				$("#cep").val(obj.cep);
				$("#endereco").val(obj.endereco);
				$("#numero").val(obj.numero);
				$("#bairro").val(obj.bairro);
				$("#cidade").val(obj.cidade);
				$("#estado").val(obj.estado);

				$("#complemento").val(obj.complemento);
				$("input[name='tp_enem'][value='"+obj.enem+"']").prop('checked',true);
				$("#nota_enem").val(obj.nota_enem);
				$("input[name='tp_especial'][value='"+obj.tp_especial+"']").prop('checked',true);
				$("#indicacao").val(obj.contato).change();
				$("#ind_qual").val(obj.qual).change();
				$("#dentista").val(obj.dentista).change();
				$("#convenio").val(obj.convenio).change();
				$("#especialidade").val(obj.especialidade).change();

				$("#situacao").val(obj.situacao).change();
				$("#proc_total").html("R$ "+parseFloat(obj.valor).toFixed(2).replace(".",","));
				$("#obs").val(obj.obs);
				try{
					$("#nasc").val(obj.nasc.substr(8,2)+"/"+obj.nasc.substr(5,2)+"/"+obj.nasc.substr(0,4));
				}catch(e){

				}
				
				
				var procedimentos = JSON.parse(obj.procedimentos);
				//console.log(procedimentos);

				for(p in procedimentos){
					$("#tabProc").append('<div id="tabtabProc"><div class="col-sm-4 col-xs-5">Procedimento<select class="form-control" id="proc_nome"></select></div><div class="col-sm-4 col-xs-5">Dente<select id="proc_dente" class="form-control"></select></div><div class="col-sm-4 col-xs-2">Valor<input id="proc_valor" value="'+procedimentos[p].valor+'" onkeyup="calculo()" class="form-control"></div></div>');
					for(d in dentes){
						if(d == 0){
							$("#novoOrcamento").find('[id="proc_dente"]').eq(dcount).empty().append('<option value="'+dentes[d]+'">'+dentes[d]+'</option>');
						}else{
							$("#novoOrcamento").find('[id="proc_dente"]').eq(dcount).append('<option value="'+dentes[d]+'">'+dentes[d]+'</option>');
						}
					}

					$.ajax({
						url: 'server/recupera.php',
						type: 'POST',
						data:{tabela:'procedimento order by nome'},
						cache: false,
						async: false,
						success: function(data) {

							var obj = JSON.parse(data);
							for(i in obj){
								if(i == 0){
									$("#novoOrcamento").find('[id="proc_nome"]').eq(dcount).empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
								}else{
									$("#novoOrcamento").find('[id="proc_nome"]').eq(dcount).append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
								}
							}
							$("#opcionais").select2();
							loading('hide');
						},
						error:function(){
							loading('hide');
						}
					});
					$("#novoOrcamento").find("[id='proc_valor']").eq(dcount).maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});
					$("#novoOrcamento").find("[id='proc_valor']").eq(dcount).focus().select();
					$("#novoOrcamento").find('[id="proc_dente"]').eq(dcount).val(procedimentos[p].dente);
					$("#novoOrcamento").find('[id="proc_nome"]').eq(dcount).val(procedimentos[p].pro_id);
					dcount++;
				}


				if(obj.status > 0){
					$("#salvar,#excluir,#novoProc").addClass('hidden');
					$("#novoOrcamento").find('input,textarea,select').each(function(){
						$(this).prop('disabled',true);
					});
				}
				loading('hide');
			},
			error:function(){
				loading('hide');
			}
		});

		$("#excluir").click(function(){

			confirma("Deseja finalizar este orçamento?","",function(){
				$.ajax({
					url: 'server/updateCampo.php',
					type: 'POST',
					data:{tabela:"orcamento",coluna:"status",valor:2,id:id},
					cache: false,
					async: false,
					success: function(data) {

						$("#cadastro").dialog('close');
						$("#datatable_col_reorder").dataTable().fnReloadAjax();
						loading('hide');
						alerta("Sucesso!","Orçamento Finalizado com sucesso!","success","success");
					},
					error:function(){
						loading('hide');
					}
				});
			});
		});

		$("#salvar").click(function(){

			loading("show");
			var id			= "<?php echo $_POST['id'];?>";
			var nome 		= $("#novoOrcamento").find("#nome").val();
			var cli_id		= $("#novoOrcamento").find("#nome").attr('retorno');
			var telefone 	= $("#novoOrcamento").find("#telefone").val();
			var email 		= $("#novoOrcamento").find("#email").val();
			var celular		= $("#novoOrcamento").find("#celular").val();
			var cpf			= $("#novoOrcamento").find("#cpf").val();
			var rg	 		= $("#novoOrcamento").find("#rg").val();
			var nasc 		= $("#novoOrcamento").find("#nasc").val();
			var cep 		= $("#novoOrcamento").find("#cep").val();
			var endereco	= $("#novoOrcamento").find("#endereco").val();
			var numero 		= $("#novoOrcamento").find("#numero").val();
			var complemento = $("#novoOrcamento").find("#complemento").val();
			var bairro      = $("#novoOrcamento").find("#bairro").val();
			var cidade		= $("#novoOrcamento").find("#cidade").val();
			var estado 		= $("#novoOrcamento").find("#estado").val();
			var indicacao	= $("#novoOrcamento").find("#indicacao").val();
			var qual		= $("#novoOrcamento").find("#ind_qual").val();

			var tp_especial	= $("#novoOrcamento").find("input[name='tp_insc']:checked").val();

			var dentista	= $("#novoOrcamento").find("#dentista option:selected").val();
			var convenio	= $("#novoOrcamento").find("#convenio option:selected").val();
			var especialidade	= $("#novoOrcamento").find("#especialidade option:selected").val();
			var obs			= $("#novoOrcamento").find("#obs").val();

			var procedimentos = [];

			$("#novoOrcamento").find('[id="tabtabProc"]').each(function(){
				procedimentos.push({pro_nome:$(this).find('#proc_nome option:selected').html(),pro_id:$(this).find('#proc_nome option:selected').val(),dente:$(this).find('#proc_dente option:selected').val(),valor:$(this).find('#proc_valor').val().replace('R$ ','').replace(',','.')});
			});
			var total = 0;

			$("#novoOrcamento").find('[id="proc_valor"]').each(function(){
				total = total+parseFloat($(this).val().replace('R$ ','').replace(',','.'));
			});



			var data		= {
				nome:nome,
				cli_id:cli_id,
				telefone:telefone,
				cpf:cpf,
				celular:celular,
				rg:rg,
				nasc:nasc,
				cep:cep,
				endereco:endereco,
				numero:numero,
				complemento:complemento,
				bairro:bairro,
				cidade:cidade,
				estado:estado,
				procedimentos:JSON.stringify(procedimentos),
				tp_especial:tp_especial,
				dentista:dentista,
				convenio:convenio,
				especialidade:especialidade,
				contato:indicacao,
				qual:qual,
				obs:obs,
				valor:total,
				funcao:1
			};


			if(nome.length == 0){
				alerta("Alerta!","Favor informar o nome do candidato!","warning","warning");
				$("#nome").focus().select();
				loading('hide');
			}else if(procedimentos.length <= 0){
				alerta("Alerta!","Favor inserir pelo menos 1 procedimento","warning","warning");
				loading('hide');
			}else if(dentista == 0){
				alerta("Alerta!","Favor informar o dentista!","warning","warning");
				$("#dentista").focus().select();
				loading('hide');
			}else if(convenio == 0){
				alerta("Alerta!","Favor informar o convenio!","warning","warning");
				$("#convenio").focus().select();
				loading('hide');
			}
			else if(especialidade == 0){
				alerta("Alerta!","Favor informar a especialidade!","warning","warning");
				$("#convenio").focus().select();
				loading('hide');
			}
			/*else if(telefone.length < 14){
			 alerta("Alerta!","Favor informar o telefone do candidato!","warning","warning");
			 $("#telefone").focus().select();
			 loading('hide');
			 }*/
			else{

				if(tp_especial == 1){
					$.extend(data,{
						venda:'1'
					});
				}

				var data2		= {
					id:id,
					funcao:3
				};
				envia("server/orcamento.php",data2);
				envia("server/orcamento.php",data);
				loading('hide');
			}
		});



	</script>
	<?php
}else{
	?>

	<?php
}
?>

