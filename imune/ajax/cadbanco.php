<?php $cod = "Conta Bancária"; $tabela = "banco";?>

<div id="novo<?php echo $tabela;?>">
	<div class="row">
		<div class="col-sm-12">
			<h4>Dados Gerais</h4>
		</div>
		<div class="col-md-2 col-sm-2 col-xs-6">
			Cód <span class="red">*</span> <input type="text" name="cod" id="cod" class=" inputs form-control wd100" placeholder="">
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6"">
			Banco <span class="red">*</span> <input type="text" name="banco" id="banco" class=" inputs form-control wd100" placeholder="">
		</div>
		<div class="col-md-2 col-sm-3 col-xs-6"">
			Agencia <span class="red">*</span><input type="text" name="agencia" id="agencia" class="inputs form-control wd100" placeholder="">
		</div>
		<div class="col-md-2 col-sm-3 col-xs-6"">
			Conta<input type="text" name="conta" id="conta" class="form-control wd100" placeholder="">
		</div>
		<div class="col-md-2 col-sm-4 col-xs-12">
			Saldo Inicial<input type="text" name="saldo" id="saldo" class="form-control wd100" placeholder="">
		</div>
		<div class="col-md-2 col-sm-8 col-xs-12">
			Contato<input type="text" name="contato" id="contato" class="form-control wd100" placeholder="">
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">

		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="clearfix">
				Observações:
				<textarea class="form-control" name="obs" id="obs" style="width:100%"></textarea>
			</div>
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
	$("#tabs").tabs();
	cep("#conta");
</script>
<?php

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		?>
		<script>
			//mostrar tabs
			$("#t_pro,#t_sin").removeClass("hidden");

			// desabilita todos campos de entrada
			$("#novo<?php echo $tabela;?>").find("input,textarea,select").each(function(){
				$(this).attr("disabled","disabled");
			});

			//mostra botões ocultos;
			$("#editar, #excluir").removeClass("hidden");

			//oculta botões;
			$("#cadastrar").addClass("hidden");

			//busca campos no banco;
			$.post("server/recupera.php",{tabela:'<?php echo $tabela." where id = ".$id;?>'}).done(function(data){
				var obj = JSON.parse(data);

				//alimenta formulário;
				$("#cod").val(obj[0].cod);
				$("#cod").attr("cod",obj[0].id);
				$("#banco").val(obj[0].banco);
				$("#agencia").val(obj[0].agencia);
				$("#conta").val(obj[0].conta);
				$("#contato").val(obj[0].contato);
				$("#saldo").val(obj[0].saldo);
				$("#obs").val(obj[0].obs);
			});

			//editando formulário
			$("#editar").click(function(){
				//Liberar campos pra edição
				$("#novo<?php echo $tabela;?>").find("input,textarea,select").each(function(){
					$(this).removeAttrs("disabled");
				});

				//focar no primeiro campo
				$("#cod").focus().select();

				//esconde botões
				$("#excluir,#editar").addClass("hidden");

				//aparece botões
				$("#salvar,#cancelar").removeClass("hidden");
			});

			//excluindo item
			$("#excluir").click(function(){
				var cod = $("#cod").val();
				confirma("ATENÇÃO","Você deseja excluir este item?<br><?php echo $id;?>: " + cod,function(){
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
				var cod 	 = $("#cod").val();
				var id   	 = $("#cod").attr("cod");
				var banco  	 = $("#banco").val();
				var agencia = $("#agencia").val();
				var conta  	 = $("#conta").val();
				var contato = $("#contato").val();
				var saldo   = $("#saldo").val();
				var obs      = $("#obs").val();
				if(cod === ""){
					alerta("AVISO!","Favor preencher o campo cod!","warning","warning");
					focar($("#cod"));
				}
				else if(banco === ""){
					alerta("AVISO!","Favor preencher o campo banco!","warning","warning");
					focar($("#banco"));
				}
				else{
					loading('show');
					$.ajax({
						url: 'server/<?php echo $tabela;?>.php',
						type: 'POST',
						cache: false,
						data: {funcao:2,id:"<?php echo $id;?>",cod:cod,banco:banco,agencia:agencia,conta:conta,contato:contato,saldo:saldo,obs:obs},
						success: function(data) {
							if(data == 2){
								alerta("AVISO!","Já existe um <?php echo $cod;?> com o mesmo cod cadastrado no sistema!","warning","warning");
								focar($("#cod"));
								loading('hide');
							}
							else if(data == 1){
								alerta("SUCESSO!","<?php echo $cod;?> cadastrado com sucesso!","success","check");
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
								alerta("ERRO!","Erro ao cadastrar <?php echo $cod;?>!","danger","ban");
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
			//oculta tabs
			$("#t_pro,#t_sin").addClass("hidden");



			//inserir cadastro
			$("#cadastrar").click(function(){
				var cod 	 = $("#cod").val();
				var id   	 = $("#cod").attr("cod");
				var banco  	 = $("#banco").val();
				var agencia  = $("#agencia").val();
				var conta  	 = $("#conta").val();
				var contato  = $("#contato").val();
				var saldo    = $("#saldo").val();
				var obs      = $("#obs").val();
				if(cod==="")
				{
					alerta("AVISO!","Favor preencher o campo cod!","warning","warning");
					focar($("#cod"));
				}
				else if(banco ===""){
					alerta("AVISO!","Favor preencher o campo banco!","warning","warning");
					focar($("#banco"));
				}
				else
				{
					loading("show");
					$.ajax({
						url: 'server/<?php echo $tabela;?>.php',
						type: 'POST',
						cache: false,
						data: {funcao:1,cod:cod,banco:banco,agencia:agencia,conta:conta,contato:contato,saldo:saldo,obs:obs},
						success: function(data) {
							if(data == 2){
								alerta("AVISO!","Já existe um <?php echo $cod;?> com o mesmo cnpj cadastrado no sistema!","warning","warning");
								focar($("#cod"));
								loading('hide');
							}else if(data == 1){
								alerta("SUCESSO!","<?php echo $cod;?> cadastrado com sucesso!","success","check");
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
								alerta("ERRO!","Erro ao cadastrar <?php echo $cod;?>!","danger","ban");
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