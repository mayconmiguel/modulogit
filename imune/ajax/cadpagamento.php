<?php require_once "../server/seguranca.php"; $nome = "Forma de Pagamento"; $tabela = "pagamento"; $empresa = $_SESSION['imunevacinas']['usuarioEmpresa']?>
<div id="novo<?php echo $tabela;?>">
	<div class="row">
		<div class="col-xs-12">
			<label class="checkbox-inline">
				<input type="checkbox" class="checkbox style-0" name="tipo[]" value="2">
				<span title='RECEITAS' class='label label-success text-center'>&nbsp;RECEITAS&nbsp;&nbsp;</span>
			</label>
			<label class="radio-inline">
				<input type="checkbox" class="checkbox style-0" name="tipo[]" value="1">
				<span title='DESPESAS' class='label label-danger text-center'>&nbsp;DESPESAS&nbsp;&nbsp;</span>
			</label>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-xs-12">
			Descrição<input id="nome" type="text" name="nome" class="form-control wd100" placeholder="<?php echo $nome;?>">
		</div>
		<div class="col-sm-4 col-xs-6">
			Taxa<input id="taxa" type="text" name="taxa" class="form-control wd100" placeholder="00.00">
		</div>
		<div class="col-sm-4 col-xs-6">
			Condição<select class="form-control" id="condicao">
				<option value="1">À VISTA</option>
				<option value="2">PARCELADO</option>
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			Empresa
			<select class="form-control" id="emp_padrao"></select>
		</div>
		<div class="col-xs-6">
			Banco Pref.
			<select class="form-control" id="banco_padrao"></select>
		</div>
	</div>
</div>
<br>

<div class="row">
	<div class="col-sm-12 center">
		<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
		<a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
		<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
		<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
		<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
	</div>
</div>
<script>

	numero("#taxa");



	$.ajax({
		async:false,
		url: 'server/recupera.php',
		data:{tabela:'empresa where grp_emp_id = <?php echo $empresa;?>'},
		type: 'POST',
		success: function (data) {
			obj = JSON.parse(data);
			for(i in obj){
				if(i == 0){
					$("#emp_padrao").empty().append('<option bancos="'+obj[i].bancos+'" value="'+obj[i].id+'">'+obj[i].fantasia+'</option>');
					var bancos = obj[i].bancos.split(",");
					var banco ='(';
					for(b in bancos){
						banco += 'id = '+bancos[b]+" or ";
					}
					banco = banco.substr(0,banco.length-4)+")";
					$.ajax({
						async:false,
						url: 'server/recupera.php',
						data:{tabela:'banco where grp_emp_id = <?php echo $empresa;?> and '+banco},
						type: 'POST',
						success: function (data) {
							var ob = JSON.parse(data);
							for(c in ob){
								if(c == 0){
									$("#banco_padrao").empty().append('<option value="'+ob[c].id+'">'+ob[c].cod+'-'+ob[c].banco+'</option>');
								}else{
									$("#banco_padrao").append('<option value="'+ob[c].id+'">'+ob[c].cod+'-'+ob[c].banco+'</option>');
								}
							}
						}
					});
				}else{
					$("#emp_padrao").append('<option bancos="'+obj[i].bancos+'" value="'+obj[i].id+'">'+obj[i].fantasia+'</option>');
				}
			}

		}
	});

	$("#emp_padrao").change(function(){
		var bancos = $(this).find('option:selected').attr('bancos').split(",");
		var banco ='(';
		for(b in bancos){
			banco += 'id = '+bancos[b]+" or ";
		}
		banco = banco.substr(0,banco.length-4)+")";
		$.ajax({
			async:false,
			url: 'server/recupera.php',
			data:{tabela:'banco where grp_emp_id = <?php echo $empresa;?> and '+banco},
			type: 'POST',
			success: function (data) {
				var ob = JSON.parse(data);
				for(c in ob){
					if(c == 0){
						$("#banco_padrao").empty().append('<option value="'+ob[c].id+'">'+ob[c].cod+'-'+ob[c].banco+'</option>');
					}else{
						$("#banco_padrao").append('<option value="'+ob[c].id+'">'+ob[c].cod+'-'+ob[c].banco+'</option>');
					}
				}
			}
		});
	});


</script>
<?php

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		?>
		<script>
			//mostra botões ocultos;
			$("#editar, #excluir").removeClass("hidden");

			//oculta botões;
			$("#cadastrar").addClass("hidden");

			//bloqueia campos;
			// desabilita todos campos de entrada
			$("#novo<?php echo $tabela;?>").find("input,textarea,select").each(function(){
				$(this).attr("disabled","disabled");
			});

			//busca campos no banco;
			$.post("server/recupera.php",{tabela:'<?php echo $tabela." where id = ".$id;?>'}).done(function(data){
				var obj = JSON.parse(data);

				//alimenta formulário;
				$("#nome").val(obj[0].nome);
				$("#nome").attr("cod",obj[0].id);
				$("#taxa").val(obj[0].taxa);
				$('input:checkbox[value="'+obj[0].tipo+'"]').prop('checked',true);
				if(obj[0].tipo == 3){
					$('input:checkbox').prop('checked',true);
				}

				$("#condicao option[value='"+obj[0].condicao+"']").attr("selected",true);
			});

			//editando formulário
			$("#editar").click(function(){
				//Liberar campos pra edição
				$("#novo<?php echo $tabela;?>").find("input,textarea,select").each(function(){
					$(this).removeAttrs("disabled");
				});

				//focar no primeiro campo
				$("#nome").focus().select();

				//esconde botões
				$("#excluir,#editar").addClass("hidden");

				//aparece botões
				$("#salvar,#cancelar").removeClass("hidden");
			});

			//excluindo item
			$("#excluir").click(function(){
				var nome 	 = $("#nome").val();
				confirma("ATENÇÃO","Você deseja excluir este item?<br><?php echo $id;?>: " + nome,function(){
					$.ajax({
						url: 'server/<?php echo $tabela;?>.php',
						type: 'POST',
						cache: false,
						data: {funcao:3,id:"<?php echo $id;?>"},
						success: function(data) {
							if(data == 1){
								alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								$.ajax({
									url: 'ajax/<?php echo $tabela;?>.php',
									type: 'GET',
									cache: false,
									success: function(data) {
										$("#content").html(data);
									}
								});
								$("#cadastro").dialog('close');
							}else{
								alerta("AVISO!","Não foi possível excluir este item!","danger","ban");
							}
						}
					});
				});
			});

			// cancelando edição
			$("#cancelar").click(function(){
				$.post("ajax/cad<?php echo $tabela;?>.php",{id:<?php echo $id;?>}).done(function(data){
					$("#cadastro").empty().html(data);
				}).fail(function(){
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
			});

			//salvando edição
			$("#salvar").click(function(){
				var nome 		= $("#nome").val();
				var tipo        = [];
				var empresa	 	= $("#emp_padrao option:selected").val();
				var banco    	= $("#banco_padrao option:selected").val();
				$("#novopagamento").find("input:checkbox:checked").each(function(){
					tipo.push($(this).val());
				});

				if(tipo.length == 2){
					var tp = 3;
				}else{
					var tp = tipo[0];
				}

				var taxa 	 	= $("#taxa").val();
				var condicao	= $("#condicao option:selected").val();

				if(nome==="")
				{
					alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
					focar($("#nome"));
				}
				else if(tipo == undefined || tipo.length == 0){
					alerta("AVISO!","Favor definir se o centro de custo pertence as RECEITAS ou DESPESAS.","warning","warning");
				}
				else{
					loading('show');
					$.ajax({
						url: 'server/<?php echo $tabela;?>.php',
						type: 'POST',
						cache: false,
						data: {funcao:2,id:"<?php echo $id;?>",nome:nome,tipo:tp,taxa:taxa,condicao:condicao,banco:banco,empresa:empresa},
						success: function(data) {
							if(data == 2){
								alerta("AVISO!","Já existe um <?php echo $nome;?> com o mesmo nome cadastrado no sistema!","warning","warning");
								focar($("#nome"));
								loading('hide');
							}
							else if(data == 1){
								alerta("SUCESSO!","<?php echo $nome;?> cadastrado com sucesso!","success","check");
								$("#cadastro").dialog('close');
								$.ajax({
									url: 'ajax/<?php echo $tabela;?>.php',
									type: 'GET',
									cache: false,
									success: function(data) {
										$("#content").html(data);
									},
									error:function(){
										loading('hide');
									}
								});
							}else{
								alerta("ERRO!","Erro ao cadastrar <?php echo $nome;?>!","danger","ban");
								$("#cadastro").dialog('close');
							}
							loading('hide');
						},
						error:function(){
							loading('hide');
						}
					});
				}
			});
		</script>
		<?php
	}else{
		?>
		<script type="text/javascript">
			//inserir cadastro
			$("#cadastrar").click(function(){
				var nome 		 = $("#nome").val();
				var empresa	 = $("#emp_padrao option:selected").val();
				var banco    	 = $("#banco_padrao option:selected").val();
				var tipo        = [];
				$("#novopagamento").find("input:checkbox:checked").each(function(){
					tipo.push($(this).val());
				});

				if(tipo.length == 2){
					var tp = 3;
				}else{
					var tp = tipo[0];
				}
				var taxa 	     = $("#taxa").val();
				var condicao	 = $("#condicao option:selected").val();
				if(nome==="")
				{
					alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
					focar($("#nome"));
				}
				else if(tipo == undefined || tipo.length == 0){
					alerta("AVISO!","Favor definir se o centro de custo pertence as RECEITAS ou DESPESAS.","warning","warning");
				}
				else
				{
					loading("show");
					$.ajax({
						url: 'server/<?php echo $tabela;?>.php',
						type: 'POST',
						cache: false,
						data: {funcao:1,nome:nome,taxa:taxa,tipo:tp,condicao:condicao,banco:banco,empresa:empresa},
						success: function(data) {
							if(data == 2){
								alerta("AVISO!","Já existe um <?php echo $nome;?> com o mesmo nome cadastrado no sistema!","warning","warning");
								focar($("#nome"));
								loading('hide');
							}else if(data == 1){
								alerta("SUCESSO!","<?php echo $nome;?> cadastrado com sucesso!","success","check");
								$("#cadastro").dialog('close');
								$.ajax({
									url: 'ajax/<?php echo $tabela;?>.php',
									type: 'GET',
									cache: false,
									success: function(data) {
										$("#content").html(data);
									},
									error:function(){
										loading('hide');
									}
								});
							}else if(data == 0){
								alerta("ERRO!","Erro ao cadastrar <?php echo $nome;?>!","danger","ban");
								$("#cadastro").dialog('close');
							}
							loading("hide");
						}
					});
				}
			});
		</script>
		<?php
	}

?>

