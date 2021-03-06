<?php
$nome = "Modelo"; $tabela = "modelo";
require_once "../server/seguranca.php";
$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>
<div id="novo<?php echo $tabela;?>">

	<div class="row">
		<div class="col-sm-12">
			Descrição<input id="nome" type="text" name="nome" class="form-control wd100" placeholder="<?php echo $nome;?>">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			Modelo
			<select id="naturezas" style="width: 100%; height: auto" class="select2">
			</select>
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
	$.post("server/recupera.php",{tabela:'marca where grp_emp_id = <?php echo $empresa;?>'}).done(function(data){
		var obj = JSON.parse(data);
		for(c in obj) {
			$("#naturezas").append('<option value="'+obj[c].id+'">' +
				obj[c].nome +
				'</option>');
		}
		$("#naturezas").select2();
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
		$.post("server/recupera.php",{tabela:'<?php echo $tabela." where grp_emp_id = $empresa and id = ".$id;?>'}).done(function(data){
			var obj = JSON.parse(data);

			//alimenta formulário;
			$("#nome").val(obj[0].nome);

			$("#nome").attr("cod",obj[0].id);
			var naturezas = obj[0].mar_id.split(',');
			$("#naturezas option[value='"+naturezas+"']").attr("selected",true).change();
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
			var naturezas = [];
			
			$("#naturezas option:selected").each(function(){
				naturezas.push($(this).val());
			});
			if(nome==="")
			{
				alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
				focar($("#nome"));
			}
			else if(naturezas.length <= 0){
				alerta("AVISO","Favor selecionar um modelo para continuar","warning","warning");
				$("#naturezas").focus();
			}
			else
			{
				loading('show');
				$.ajax({
					url: 'server/<?php echo $tabela;?>.php',
					type: 'POST',
					cache: false,
					data: {funcao:2,id:"<?php echo $id;?>",nome:nome,naturezas:naturezas},
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
			var nome 		= $("#nome").val();
			var naturezas = [];
			$("#naturezas option:selected").each(function(){
				naturezas.push($(this).val());
			});
			if(nome==="")
			{
				alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
				focar($("#nome"));
			}

			else if(naturezas.length <= 0){
				alerta("AVISO","Favor selecionar pelo menos uma natureza financeira para continuar","warning","warning");
			}
			else
			{
				loading("show");
				$.ajax({
					url: 'server/<?php echo $tabela;?>.php',
					type: 'POST',
					cache: false,
					data: {funcao:1,nome:nome,naturezas:naturezas},
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

