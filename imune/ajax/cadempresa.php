<?php $nome = "Empresa"; $tabela = "empresa";
require_once "../server/seguranca.php";
$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>


<div class="jarviswidget jarviswidget-color-green"id="cadEmpresa">

	<header>

		<h2>Unidades - Cadastro</h2>
	</header>
	<div>
		<div class="widget-body">

			<div id="novo<?php echo $nome;?>">
				<div class="row">
					<div class="col-sm-12">
						<h4>Dados Gerais</h4>
					</div>
					<div class="col-sm-8">
						Est.de Saude <span class="red">*</span> <input type="text" name="nome" id="nome" class=" inputs form-control wd100" placeholder="Razão Social">
					</div>
					<div class="col-sm-4">
						CNPJ <span class="red">*</span> <input type="text" name="cpf" id="cpf" class=" inputs form-control wd100" placeholder="Digite o CNPJ da <?php echo $nome;?>">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						Nome <span class="red">*</span><input type="text" name="fantasia" id="fantasia" class="inputs form-control wd100" placeholder="Nome Fantasia">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						CEP<input type="text" name="cep" id="cep" class="form-control wd100" placeholder="CEP">
					</div>
					<div class="col-sm-7">
						Endereço<input type="text" name="endereco" id="endereco" class="form-control wd100" placeholder="Endereço">
					</div>
					<div class="col-sm-1">
						Nº<input type="text" name="numero" id="numero" class="form-control wd100" placeholder="Nº">
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						Bairro<input type="text" name="bairro" id="bairro" class="form-control wd100" placeholder="Bairro">
					</div>
					<div class="col-sm-4">
						Cidade<input type="text" name="cidade" id="cidade" class="form-control wd100" placeholder="Cidade">
					</div>
					<div class="col-sm-4">
						Estado<input type="text" name="estado" id="estado" class="form-control wd100" placeholder="Estado">
					</div>
				</div>
				<div class="row">
					<div class=" col-lg-4 col-sm-4">
						Telefone <span class="red">*</span><input type="text" name="telefone" id="telefone" class="form-control wd100" placeholder="Telefone">
					</div>
					<div class="col-lg-4 col-sm-4">
						Email<input type="text" name="email" id="email" class="form-control wd100" placeholder="Email">
					</div>
					<div class="col-lg-3 col-sm-4">
						Responsavel<input type="text" name="contato" id="contato" class="form-control wd100" placeholder="Contato">
					</div>
					<div class="col-lg-1 col-md-3">
						Ativa<select class="form-control" id="formapagamento">
						</select>
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

		</div>
	</div>
</div>
</div>


	<script>

		$("#tabs").tabs();
		cep("#cep");
		$('#pis,#cofins,#iss,#irrf').maskMoney({thousands:'', decimal:',', affixesStay: false,suffix:' %'});


		$.post("server/recupera.php",{tabela:'banco where grp_emp_id = <?php echo $empresa;?>'}).done(function(data){
			var obj = JSON.parse(data);
			for(i in obj){
				$("#bancos").append('<option value="'+obj[i].id+'">'+obj[i].cod+' - '+obj[i].banco+'</option>');
			}
			$("#bancos").select2();
		}).fail(function(){

		});
	</script>
<?php

if(isset($_POST['id'])){
	$id = $_POST['id'];
	?>
	<script>
		//mostrar tabs
		$("#t_pro,#t_sin").removeClass("hidden");

		// desabilita todos campos de entrada
		$("#novo<?php echo $nome;?>").find("input,textarea,select").each(function(){
			$(this).attr("disabled","disabled");
		});

		//mostra botões ocultos;
		$("#editar, #excluir").removeClass("hidden");

		//oculta botões;
		$("#cadastrar").addClass("hidden");

		//busca campos no banco;
		$.post("server/recupera.php",{tabela:'<?php echo $tabela." where grp_emp_id = $empresa and id = ".$id;?>'}).done(function(data){
			var obj = JSON.parse(data);

			//alimenta formulário;
			$("#nome").val(obj[0].razao);
			$("#nome").attr("cod",obj[0].id);
			$("#cpf").val(obj[0].cnpj);
			$("#fantasia").val(obj[0].fantasia);
			$("#susep").val(obj[0].susep);
			$("#cep").val(obj[0].cep);
			$("#endereco").val(obj[0].endereco);
			$("#numero").val(obj[0].numero);
			$("#bairro").val(obj[0].bairro);
			$("#cidade").val(obj[0].cidade);
			$("#estado").val(obj[0].estado);
			$("#telefone").val(obj[0].telefone);
			$("#contato").val(obj[0].contato);
			$("#email").val(obj[0].email);
			$("#obs").val(obj[0].obs);
			$("#iss").val(obj[0].iss);
			$("#irrf").val(obj[0].irrf);
			$("#pis").val(obj[0].pis);
			$("#cofins").val(obj[0].cofins);

			if(obj[0].bancos){
				var bancos = obj[0].bancos.split(",");
				for(d in bancos){
					$("#bancos option[value='"+bancos[d]+"']").attr("selected","selected");
				}
			}
			$("#bancos").select2();
		});

		//editando formulário
		$("#editar").click(function(){
			//Liberar campos pra edição
			$("#novo<?php echo $nome;?>").find("input,textarea,select").each(function(){
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
			var nome 	 = $("#nome").val();
			var id   	 = $("#nome").attr("cod");
			var cpf  	 = $("#cpf").val();
			var fantasia = $("#fantasia").val();
			var susep    = $("#susep").val();
			var nasc 	 = $("#nasc").val();
			var cep  	 = $("#cep").val();
			var endereco = $("#endereco").val();
			var numero   = $("#numero").val();
			var bairro   = $("#bairro").val();
			var cidade   = $("#cidade").val();
			var estado   = $("#estado").val();
			var telefone = $("#telefone").val();
			var contato  = $("#contato").val();
			var email    = $("#email").val();
			var obs      = $("#obs").val();
			var iss      = $("#iss").val();
			var irrf     = $("#irrf").val();
			var pis      = $("#pis").val();
			var cofins   = $("#cofins").val();

			var bancos = [];
			$("#bancos option:selected").each(function(){
				bancos.push($(this).val());
			});
			if(nome === ""){
				alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
				focar($("#nome"));
			}
			else if(cpf === ""){
				alerta("AVISO!","Favor preencher o campo cpf!","warning","warning");
				focar($("#cpf"));
			}
			else{
				loading('show');
				$.ajax({
					url: 'server/<?php echo $tabela;?>.php',
					type: 'POST',
					cache: false,
					data: {funcao:2,bancos:bancos,iss:iss,irrf:irrf,pis:pis,cofins:cofins,id:"<?php echo $id;?>",nome:nome,cnpj:cpf,susep:susep,fantasia:fantasia,cep:cep,endereco:endereco,numero:numero,bairro:bairro,cidade:cidade,estado:estado,telefone:telefone,contato:contato,email:email,obs:obs},
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
		//oculta tabs
		$("#t_pro,#t_sin").addClass("hidden");



		//inserir cadastro
		$("#cadastrar").click(function(){
			var nome 	 = $("#nome").val();
			var id   	 = $("#nome").attr("cod");
			var cpf  	 = $("#cpf").val();
			var fantasia = $("#fantasia").val();
			var susep    = $("#susep").val();
			var nasc 	 = $("#nasc").val();
			var cep  	 = $("#cep").val();
			var endereco = $("#endereco").val();
			var numero   = $("#numero").val();
			var bairro   = $("#bairro").val();
			var cidade   = $("#cidade").val();
			var estado   = $("#estado").val();
			var telefone = $("#telefone").val();
			var contato  = $("#contato").val();
			var email    = $("#email").val();
			var obs      = $("#obs").val();
			var iss      = $("#iss").val();
			var irrf     = $("#irrf").val();
			var pis      = $("#pis").val();
			var cofins   = $("#cofins").val();

			var bancos = [];
			$("#bancos option:selected").each(function(){
				bancos.push($(this).val());
			});
			if(nome==="")
			{
				alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
				focar($("#nome"));
			}
			else if(cpf ===""){
				alerta("AVISO!","Favor preencher o campo cpf!","warning","warning");
				focar($("#cpf"));
			}
			else
			{
				loading("show");
				$.ajax({
					url: 'server/<?php echo $tabela;?>.php',
					type: 'POST',
					cache: false,
					data: {funcao:1,bancos:bancos,iss:iss,irrf:irrf,pis:pis,cofins:cofins,nome:nome,cnpj:cpf,fantasia:fantasia,susep:susep,nasc:nasc,cep:cep,endereco:endereco,numero:numero,bairro:bairro,cidade:cidade,estado:estado,telefone:telefone,contato:contato,email:email,obs:obs},
					success: function(data) {
						if(data == 2){
							alerta("AVISO!","Já existe um <?php echo $nome;?> com o mesmo cnpj cadastrado no sistema!","warning","warning");
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

