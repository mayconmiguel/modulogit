<?php $nome = "Marcas"; $tabela = "marca";?>
<div id="novo<?php echo $tabela;?>">
	<div class="row">
		<div class="col-sm-12">
			Descrição<input id="nome" type="text" name="nome" class="form-control wd100" placeholder="<?php echo $nome;?>">
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
			$.post("server/recupera.php",{tabela:'marca where id = <?php echo $id;?>'}).done(function(data){
				var obj = JSON.parse(data);


				//alimenta formulário;
				$("#nome").val(obj[0].nome);
				$("#nome").attr("cod",obj[0].id);


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
				var nome = $("#nome").val();
				confirma("ATENÇÃO","Você deseja excluir este item?<br><?php echo $id;?>: " + nome,function(){
					$.ajax({
						url: 'server/marca.php',
						type: 'POST',
						cache: false,
						data: {funcao:3,id:"<?php echo $id;?>"},
						success: function(data) {
							if(data == 1){
								alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								$.ajax({
									url: 'ajax/marca.php',
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
				$.post("ajax/cadmarca.php",{id:<?php echo $id;?>}).done(function(data){
					$("#cadastro").empty().html(data);
				}).fail(function(){
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
			});

			//salvando edição
			$("#salvar").click(function(){
				var nome 		= $("#nome").val();

				if(nome==="")
				{
					alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
					focar($("#nome"));
				}
				else{
					loading('show');
					$.ajax({
						url: 'server/marca.php',
						type: 'POST',
						cache: false,
						data: {funcao:2,id:"<?php echo $id;?>",nome:nome},
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
									url: 'ajax/marca.php',
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
			$("input[name='tipo[]']").each(function(){
				$(this).attr('checked',true);
			});
			//inserir cadastro
			$("#cadastrar").click(function(){
				var nome 		= $("#nome").val();

				if(nome==="")
				{
					alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
					focar($("#nome"));
				}

				else
				{
					loading("show");
					$.ajax({
						url: 'server/marca.php',
						type: 'POST',
						cache: false,
						data: {funcao:1,nome:nome},
						success: function(data) {
							if(data == 2){
								alerta("AVISO!","Já existe um <?php echo $nome;?> com o mesmo nome cadastrado no sistema!","warning","warning");
								focar($("#nome"));
								loading('hide');
							}else if(data == 1){
								alerta("SUCESSO!","<?php echo $nome;?> cadastrado com sucesso!","success","check");
								$("#cadastro").dialog('close');
								$.ajax({
									url: 'ajax/marca.php',
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

