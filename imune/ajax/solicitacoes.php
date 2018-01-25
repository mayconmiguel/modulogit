<div id="novoSolicitacao">


	<div class="panel-group smart-accordion-default" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><a data-toggle="collapse" href="#collapseOne"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> Solicitação #<?php echo @$_POST['id'];?> </a></h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-2 col-xs-12 hidden" id="stst">
							Status<select class="form-control" id="status">
								<option value="1">ABERTO</option>
								<option value="2">EM ANÁLISE</option>
								<option value="3">CONCLUÍDO</option>
								<option value="4">CANCELADO</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							Solicitante<span class="txt-color-red">*</span><input autofocus type="text" name="cli_id" id="cli_id" class=" inputs form-control wd100">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							Setor<span class="txt-color-red">*</span><select name="setor" id="setor" class="form-control wd100"></select>
						</div>
						<div class="col-sm-6 col-xs-12">
							Categoria<select name="categoria" id="categoria" class="form-control wd100">
								<option value="0"> SELECIONE UM SETOR</option>
							</select>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">
							Solicitação:<span class="txt-color-red">*</span><textarea class="form-control" id="obs"></textarea>
						</div>
					</div>

					<div class="row hidden" id="adicionais">

					</div>

					<div class="row hidden" id="disse">
						<div class="col-xs-12">
							Nova Mensagem<textarea class="form-control" id="newMessage"></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
							<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
							<a href="javascript:void(0);" id="inserir" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-question-sign"></i></span>RESPONDER</a>
							<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="fa fa-times"></i></span>CANCELAR</a>
							<a href="javascript:void(0);" id="finalizar" class="btn btn-sm btn-primary hidden"> <span class="btn-label"><i class="fa fa-check"></i></span>FINALIZAR</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>

	$.post('server/recupera.php',{tabela:"setor order by nome"}).done(function(data){
		var obj = JSON.parse(data);
		for(i in obj){
			if(i == 0){
				$("#setor").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
				$.post('server/recupera.php',{tabela:"setor_categoria where set_id = '"+obj[i].id+"'  order by nome"}).done(function(data){
					var obj2 = JSON.parse(data);
					for(i2 in obj2){
						if(i2 == 0){
							$("#categoria").empty().append('<option value="'+obj2[i2].id+'">'+obj2[i2].nome+'</option>');
						}else{
							$("#categoria").append('<option value="'+obj2[i2].id+'">'+obj2[i2].nome+'</option>');
						}
					}
				}).fail(function(){

				});
			}else{
				$("#setor").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
			}
		}
	}).fail(function(){

	});

	$("#setor").change(function(){
		$.post('server/recupera.php',{tabela:"setor_categoria where set_id = '"+$(this).find("option:selected").val()+"'  order by nome"}).done(function(data){
			var obj = JSON.parse(data);
			for(i in obj){
				if(i == 0){
					$("#categoria").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
				}else{
					$("#categoria").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
				}
			}
		}).fail(function(){

		});
	});


	$("#novoSolicitacao").find('input[id="cli_id"]').autocomplete({
		source: "ajax/busca.php",
		select: function(event,ui){
			$(this).attr("retorno",ui.item.id);
			$(this).attr("value",ui.item.nome);
			$.post('server/recupera.php',{tabela:"pessoa where id = "+ui.item.id}).done(function(data){
				var obj = JSON.parse(data)[0];
				if(obj.telefone.length <= 0 || obj.telefone == "" || obj.telefone == null){
					obj.telefone = "Telefone não cadastrado";
				}
				else if(obj.celular.length <= 0 || obj.celular == "" || obj.celular == null){
					obj.celular = "Celular não cadastrado";
				}
				else if(obj.email.length <= 0 || obj.email == "" || obj.email == null){
					obj.email = "Email não cadastrado";
				}
				$("#telefone").text(obj.telefone);
				$("#celular").text(obj.celular);
				$("#email").text(obj.email);
			});
			$("#dadosPaciente").removeClass('hidden');

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
	$("#novoSolicitacao").find('input[id="cli_id"]').autocomplete('option','appendTo',"div[id='novoSolicitacao']");


	$("#cadastrar").click(function(){
		var nome 		= $("#novoSolicitacao").find("#cli_id").attr('retorno');

		var setor		= $("#novoSolicitacao").find("#setor option:selected").val();
		var categoria	= $("#novoSolicitacao").find("#categoria option:selected").val();
		var obs			= $("#novoSolicitacao").find("#obs").val();
		var data		= {
			nome:nome,
			setor:setor,
			categoria:categoria,
			obs:obs,
			status:1,
			funcao:1
		};


		if(nome.length == 0 || nome == undefined){
			alerta("Alerta!","Favor informar o nome do candidato!","warning","warning");
			$("#nome").focus().select();
		}
		else if(obs.length <= 0){
			alerta("Alerta!","Favor informar a solicitação!","warning","warning");
			$("#obs").focus().select();
		}
		else{
			loading('show');
			envia("server/solicitacoes.php",data);
			loading('hide');
		}
	});
</script>
<?php
if(isset($_POST['id'])){
	?>
	<script>
		loading('hide');
		$("#novoSolicitacao").find('input,select,textarea').each(function(){
			$(this).prop('disabled',true);
		});
		$("#excluir,#stst").removeClass('hidden');
		$("#cadastrar").addClass('hidden');
		$.post('server/recupera2.php',{tabela:"select solicitacao.id,solicitacao.pes_id,solicitacao.set_id,solicitacao.cat_id,solicitacao,pessoa.nome as pessoa, solicitacao.status from solicitacao,pessoa where solicitacao.id = <?php echo $_POST['id'];?> and solicitacao.pes_id = pessoa.id"}).done(function(data){
			var obj = JSON.parse(data);
			obj = obj[0];
			$("#cli_id").attr('retorno',obj.pes_id);
			$("#cli_id").val(obj.pessoa);
			$("#setor").val(obj.set_id);
			$("#status").val(obj.status);
			$.post('server/recupera.php',{tabela:"setor_categoria where set_id = '"+obj.set_id+"'  order by nome"}).done(function(data){
				var obj2 = JSON.parse(data);
				for(i2 in obj2){
					if(obj2[i2].id == obj.cat_id){
						$("#categoria").append('<option selected value="'+obj2[i2].id+'">'+obj2[i2].nome+'</option>');
					}else{
						$("#categoria").append('<option value="'+obj2[i2].id+'">'+obj2[i2].nome+'</option>');
					}
				}
			}).fail(function(){

			});
			$("#obs").val(obj.solicitacao);



		});



		$.post('server/recupera2.php',{tabela:"select distinct sol.id,sol.sol_id,sol.obs,if(sol.tipo = 1,usuarios.nome,pessoa.nome) as pessoa from solicitacao_ext as sol,usuarios,pessoa where sol_id = <?php echo $_POST['id'];?> and if(sol.tipo = 1,usuarios.id = sol.ope_id,pessoa.id = sol.ope_id)"}).done(function(data){
			var obj = JSON.parse(data);
			$("#finalizar,#inserir").removeClass('hidden');
			if($("#status").val() == 3 || $("#status").val() == 4){
				$("#inserir,#finalizar").addClass('hidden');
			}
			if(obj.length > 0){
				$("#adicionais").removeClass('hidden');
				$("#cancelar").addClass('hidden');
				for(i in obj){
					$("#adicionais").append('<div class="col-xs-12">'+obj[i].pessoa+' disse:<textarea class="form-control"  disabled>'+obj[i].obs+'</textarea></div>');
				}
			}else{

			}
		});

		$("#inserir").click(function(){
			$("#disse,#salvar").removeClass('hidden');
			$("#newMessage").prop('disabled',false).focus();
			$(this).addClass('hidden');
			$("#cancelar,#finalizar").addClass('hidden');
		});


		$("#salvar").click(function(){
			var nome 		= $("#novoSolicitacao").find("#cli_id").attr('retorno');
			var sol_id		= "<?php echo $_POST['id'];?>";
			var categoria	= $("#novoSolicitacao").find("#categoria option:selected").val();
			var obs			= $("#novoSolicitacao").find("#newMessage").val();
			var data		= {
				nome:nome,
				sol_id:sol_id,
				obs:obs,
				status:2,
				funcao:2,
				tipo:1
			};
			if(obs.length <= 0){
				alerta("Alerta!","Favor informar a solicitação!","warning","warning");
				$("#obs").focus().select();
			}
			else{
				loading('show');
				envia("server/solicitacoes.php",data);
				loading('hide');
			}
		});

		$("#finalizar").click(function(){
			$.SmartMessageBox({
				title : "ATENÇÃO",
				content : "Deseja inserir alguma observação antes de finalizar esta solicitação?!",
				buttons : "[Cancelar][Continuar]",
				input : "text",
				inputValue: "",
				placeholder:""
			}, function(ButtonPress, Value) {

				if(ButtonPress == "Continuar"){
					var nome 		= $("#novoSolicitacao").find("#cli_id").attr('retorno');
					var sol_id		= "<?php echo $_POST['id'];?>";
					var categoria	= $("#novoSolicitacao").find("#categoria option:selected").val();
					var obs			= Value;
					var data		= {
						nome:nome,
						sol_id:sol_id,
						obs:obs,
						status:3,
						funcao:3,
						tipo:1
					};
					loading('show');
					envia("server/solicitacoes.php",data);
					loading('hide');
				}

			});
		});

	</script>
	<?php
}

?> 