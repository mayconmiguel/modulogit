<div id="novoAluno">


	<div class="panel-group smart-accordion-default" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><a data-toggle="collapse" href="#collapseOne"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> Formulário de inscrição de alunos </a></h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							Nome Completo<span class="txt-color-red">*</span><input autofocus type="text" name="nome" id="nome" class=" inputs form-control wd100">
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
							Email<span class="txt-color-red">*</span><input type="text" name="email" id="email" class="form-control wd100">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4 col-xs-6">
							CPF<input type="text" name="cpf" id="cpf" class="inputs form-control wd100">
						</div>
						<div class="col-sm-4 col-xs-6">
							RG<input type="text" name="rg" id="rg" class="inputs form-control wd100">
						</div>
						<div class="col-sm-4 col-xs-12">
							DT. Nasc.<input type="text" name="nasc" id="nasc" class="form-control wd100">
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
					<div class="row">
						<div class="col-xs-12">
							Deseja concorrer com a nota do Enem? (o candidato que optar pela utilização das notas do ENEM está dispensado da realização das provas).
						</div>
						<div class="col-sm-4 col-xs-6">
							<div class="col-xs-12">
								<div class="col-xs-12">
									<br>
									<label class="radio-inline">
										<input class="radiobox style-0" type="radio" name="tp_enem" value="1">
										<span title='SIM' class='label label-success text-center'>&nbsp;SIM&nbsp;&nbsp;</span>
									</label>
									<label class="radio-inline">
										<input class="radiobox style-0" type="radio" name="tp_enem" value="0" checked>
										<span title='NÃO' class='label label-danger text-center'>&nbsp;NÃO&nbsp;&nbsp;</span>
									</label>
								</div>

							</div>
						</div>
						<div class="col-sm-8 col-xs-6">
							Nota Enem<input class="form-control" id="nota_enem" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							Necessita de atendimento especial para realização das provas?
						</div>
						<div class="col-sm-4 col-xs-6">
							<div class="col-xs-12">
								<div class="col-xs-12">
									<br>
									<label class="radio-inline">
										<input class="radiobox style-0" type="radio" name="tp_especial" value="1">
										<span title='SIM' class='label label-success text-center'>&nbsp;SIM&nbsp;&nbsp;</span>
									</label>
									<label class="radio-inline">
										<input class="radiobox style-0" type="radio" name="tp_especial" value="0" checked>
										<span title='NÃO' class='label label-danger text-center'>&nbsp;NÃO&nbsp;&nbsp;</span>
									</label>
								</div>
							</div>
						</div>
						<div class="col-sm-8 col-xs-6">
							Especifique<input class="form-control" id="especial" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-xs-12">
							Escolha a 1ª opção de curso:<select class="form-control" id="curso1"></select>
						</div>
						<div class="col-sm-6 col-xs-12">
							Escolha a 2ª opção de curso:<select class="form-control" id="curso2"></select>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
							<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="fa fa-times"></i></span>EXCLUIR</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	cep("#cep");
	$("#nota_enem").mask('0000.00',{reverse:true});
	$('input[name="tp_enem"]').change(function(){
		if($(this).val() == 1){
			$("#novoAluno").find("#nota_enem").prop('disabled',false);
		}else{
			$("#novoAluno").find("#nota_enem").prop('disabled',true);
		}
	});
	$('input[name="tp_especial"]').change(function(){
		if($(this).val() == 1){
			$("#novoAluno").find("#especial").prop('disabled',false);
		}else{
			$("#novoAluno").find("#especial").prop('disabled',true);
		}
	});
	$.post('server/recupera.php',{tabela:"curso"}).done(function(data){
		var obj = JSON.parse(data);
		for(i in obj){
			$("#curso1").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
			$("#curso2").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
		}
	});

	$("#cadastrar").click(function(){
		var nome 		= $("#novoAluno").find("#nome").val();
		var telefone 	= $("#novoAluno").find("#telefone").val();
		var email 		= $("#novoAluno").find("#email").val();
		var celular		= $("#novoAluno").find("#celular").val();
		var cpf			= $("#novoAluno").find("#cpf").val();
		var rg	 		= $("#novoAluno").find("#rg").val();
		var nasc 		= $("#novoAluno").find("#nasc").val();
		var cep 		= $("#novoAluno").find("#cep").val();
		var endereco	= $("#novoAluno").find("#endereco").val();
		var numero 		= $("#novoAluno").find("#numero").val();
		var complemento = $("#novoAluno").find("#complemento").val();
		var bairro      = $("#novoAluno").find("#bairro").val();
		var cidade		= $("#novoAluno").find("#cidade").val();
		var estado 		= $("#novoAluno").find("#estado").val();
		var enem 		= $("#novoAluno").find("input[name='tp_enem']:checked").val();
		var nota_enem	= $("#novoAluno").find("#nota_enem").val();
		var tp_especial	= $("#novoAluno").find("input[name='tp_especial']:checked").val();
		var especial	= $("#novoAluno").find("#especial").val();
		var curso1		= $("#novoAluno").find("#curso1 option:selected").val();
		var curso2		= $("#novoAluno").find("#curso2 option:selected").val();
		var obs			= $("#novoAluno").find("#obs").val();
		var data		= {
			nome:nome,
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
			enem:enem,
			nota_enem:nota_enem,
			especial:especial,
			tp_especial:tp_especial,
			curso1:curso1,
			curso2:curso2,
			origem:1,
			obs:especial
		};


		if(nome.length == 0){
			alerta("Alerta!","Favor informar o nome do candidato!","warning","warning");
			$("#nome").focus().select();
		}
		else if(telefone.length < 14){
			alerta("Alerta!","Favor informar o telefone do candidato!","warning","warning");
			$("#telefone").focus().select();
		}
		else{
			loading('show');
			envia("server/inscricoes.php",data);
			loading('hide');
		}
	});
</script>
<?php

	if(isset($_POST['id'])){
		?>
		<script>
			loading('hide');
			$("#novoAluno").find('input,select,textarea').each(function(){
				$(this).prop('disabled',true);
			});
			$("#excluir").removeClass('hidden');
			$("#cadastrar").addClass('hidden');
			$.post('server/recupera.php',{tabela:"inscricao where id = <?php echo $_POST['id'];?>"}).done(function(data){
				var obj = JSON.parse(data);
				obj = obj[0];
				$("#nome").val(obj.nome);
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
				$("#curso2").val(obj.curso2).change();
				$("#curso1").val(obj.curso1).change();
				$("#especial").val(obj.especial);
			});
		</script>
		<?php
	}

?>