<?php
$nome = "nome"; $tabela = "pessoa";
require_once "../server/seguranca.php";
?>


<div id="tabs">
	<ul>
		<li>
			<a id="t_dad" href="#tabs-1">Gerais</a>
		</li>
		<li>
			<a id="t_pro" class="hidden" href="#tabs-2"><?php echo $_SESSION['config']['aba2'];?></a>
		</li>
		<li>
			<a id="t_fin" class="hidden" href="#tabs-3"><?php echo $_SESSION['config']['aba3'];?></a>
		</li>
		<li>
			<a id="t_sin" class="hidden" href="#tabs-4"><?php echo $_SESSION['config']['aba4'];?></a>
		</li>
	</ul>

	<div id="tabs-1">
		<div id="novoCliente">


			<div class="panel-group smart-accordion-default" id="accordion">
				<div class="panel panel-default">
					<div class="panel-heading txt-color-white">
						<h4 class="panel-title bg-color-green"><a data-toggle="collapse" href="#collapseOne"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i>  Dados Gerais</a></h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="row">
								<div class="col-lg-2 col-md-2 col-sm-4 col-xs-12 text-center">
									<img id="imgavatar" name="imagefile" class="avatarselector myimgdestination thumbnail img-btn" style="margin-top: 10%; cursor:pointer;display: inline !important; " src="" width="180px" height="180px"  data-destination="myimgdestination " data-source="imgavatar">
								</div>
								<div class="col-md-5 col-sm-4  col-xs-12">
									Usuario Cadastro:<input type="text" name="usuario" id="usuario" class="form-control wd100">
								</div>
								<div class="col-md-5 col-sm-4 col-xs-12">
									Unidade:<select type="text"  id="filial" class="form-control wd100"></select>
								</div>
								<div class=" col-md-5 col-sm-4 col-xs-12">
									Data Cadastro:<input  name="nasc" id="datacadastro" class="form-control wd100"">
								</div>
								<div class="col-md-5 col-sm-4 col-xs-12">
									Cadastro N°:<input " name="email" id="ncadastro" class="form-control wd100">
								</div>
                                <div class="col-lg-8 col-md-8 col-sm-5 col-xs-12">
                                    Nome Completo <span class="red">*</span> <input autofocus type="text" name="nome" id="nome" class=" inputs form-control wd100">
                                </div>
                                <label class="radio-inline col-lg-1 col-md-1  col-sm-1  col-xs-12" style="margin-right: -10px; padding-bottom: 10px; padding-top: 10px;">
                                    <input class="radiobox"  type="radio" id="sexo" name="sexo" value="1">
                                    <span title='SIM' class='label bg-color-blue txt-color-white text-center font-md'>MASCULINO</span>
                                </label>
                                <label class="radio-inline col-lg-1 col-md-1 col-sm-1 col-sm-pull-1 col-xs-12" style="margin-top: 40px;">
                                   <input class="radiobox" type="radio" id="sexo" name="sexo" value="2">
                                    <span title='NÃO' class='label bg-color-pink txt-color-white text-center font-md'>&nbsp;FEMININO&nbsp;&nbsp;</span>
                                </label>
								<div class="col-lg-4 col-md-4 col-sm-3 col-xs-6">
									<?php echo mb_strtoupper($_SESSION['config']['clienteDocumento']);?> <span class="red">*</span><input type="text" name="cpf" id="cpf" class="inputs form-control wd100">
								</div>
								<div class="col-lg-4 col-md-3 col-sm-3 col-xs-6">
									RG<input type="text" name="rg"  id="rg" class="inputs form-control wd100">
								</div>
								<div class="col-lg-2 col-md-3 col-sm-2 col-xs-12">
									DT. Nasc.<input type="text" name="nasc" id="nasc" class="form-control wd100">
								</div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    Nome mãe <input autofocus type="text" name="nome" id="nomemae" class=" inputs form-control wd100">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    Nome pai <input autofocus type="text" name="nome" id="nomepai" class=" inputs form-control wd100">
                                </div>

								<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									CEP<input type="text" name="cep" id="cep" class="form-control wd100">
								</div>
								<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
									Endereço<input type="text" name="endereco" id="endereco" class="form-control wd100">
								</div>
								<div class="col-lg-2 col-md-2 col-sm-3">
									Nº<input type="text" name="numero" id="numero" class="form-control wd100">
								</div>

								<div class="col-lg-7 col-md-6 col-sm-6">
									Complemento<input class="form-control" id="complemento" name="complemento">
								</div>

								<div class="col-lg-5 col-md-6 col-sm-6 col-xs-12">
									Bairro<input type="text" name="bairro" id="bairro" class="form-control wd100">
								</div>
								<div class="col-lg-6 col-sm-6 col-xs-6">
									Cidade<input type="text" name="cidade" id="cidade" class="form-control wd100">
								</div>
								<div class="col-lg-6 col-sm-6 col-xs-6">
									Estado<input type="text" name="estado" id="estado" class="form-control wd100">
								</div>
                                <div class="col-sm-6 col-md-6  col-xs-6">
                                    Telefone <span class="red">*</span><input type="text" name="telefone" id="telefone" class="form-control wd100">
                                </div>
                                <div class="col-sm-6 col-md-6  col-xs-6">
                                    Celular<input type="text" name="celular" id="celular" class="form-control wd100">
                                </div>
							</div>
							<div class="row">
								<div class="col-sm-6 col-xs-12">
									Email<input type="text" name="email" id="email" class="form-control wd100">
								</div>
                                <div class="col-sm-6 col-xs-6">
                                    Indicação Medica <span class="red">*</span><input type="text" name="nome" id="indicacao" class="form-control wd100">
                                </div>
                                <div class="col-sm-12">
                                    <div class="clearfix">
                                        Observações:
                                        <textarea class="form-control" name="obs" id="obs" style="width:100%"></textarea>
                                    </div>
                                </div>
							</div>
						</div>

					</div>
				</div>

				<div class="panel panel-default hidden" id="colapso2">
					<div class="panel-heading">
						<h4 class="panel-title"><a data-toggle="collapse"  href="#collapseTwo"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i>  Dados Bancários </a></h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse in">
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-4">
									Banco<input type="text" name="banco" id="banco" class="form-control wd100" disabled>
								</div>
								<div class="col-sm-4">
									Agencia<input type="text" name="agencia" id="agencia" class="form-control wd100" disabled>
								</div>
								<div class="col-sm-4">
									Conta<input type="text" name="conta" id="conta" class="form-control wd100" disabled>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="row" id="botoesCliente">
			<div class="col-sm-12 center">
				<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
				<a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
				<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
				<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
				<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
			</div>
		</div>
	</div>

	<div id="tabs-2">

	</div>
	<div id="tabs-3">

	</div>
	<div id="tabs-4">

	</div>
</div>
<script>
	$ ('#dt_cad').datepicker();

	$("#tabs").tabs();
	cep("#cep");

</script>

<?php
if(isset($_POST['id'])){
	$id = $_POST['id'];
	?>
	<script>

		function Capturar() {

			$.ajax({

				url: 'http://localhost:9000/api/public/v1/captura/Capturar/1',
				type: 'GET',
				success: function (data) {
					if (data != "")
						$.ajax({
							async:false,
							url: 'server/comparacaoDigital.php',
							type: 'POST',
							data:{digital:data},
							success: function (data) {
								console.log(data);

							}
						});
				}
			})
		}

		function Comparar(a) {
			var digital = a;

			var retorno;
			if (digital != "") {
				$.ajax({
					async:false,
					url: 'http://localhost:9000/api/public/v1/captura?Digital=' + digital,
					type: 'GET',
					success: function (data) {
						retorno = data;

					}
				});
				return retorno;
			}
			else
				alert("Por favor registre a impress�o digital.")


		}


		function Enroll() {

			$.ajax({

				url: 'http://localhost:9000/api/public/v1/captura/Enroll/1',
				type: 'GET',
				success: function (data) {
					if (data != "") {
						$.post('server/updateCampo.php',{tabela:'pessoa',coluna:'biometria',valor:data,id:"<?php echo $id;?>"});
					}
				}
			})
		}
		//mostrar tabs
		$("#t_pro,#t_sin,#t_fin").removeClass("hidden");

		$("#novoCliente").find("#imgavatar").removeAttrs('data-destination');

		$("#t_pro").click(function(){

			$.post("<?php echo $_SESSION['config']['aba2url'];?>",{id:<?php echo $id;?>}).done(function(data){
				$("#tabs-2").empty().html(data);
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
			});
		});

		$("#t_fin").click(function(){

			$.post("<?php echo $_SESSION['config']['aba3url'];?>",{id:<?php echo $id;?>}).done(function(data){
				$("#tabs-3").empty().html(data);
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
			});
		});

        $("#t_sin").click(function(){

            $.post("<?php echo $_SESSION['config']['aba4url'];?>",{id:<?php echo $id;?>}).done(function(data){
                $("#tabs-4").empty().html(data);
            }).fail(function(){
                alerta("ERRO!","Função não encontrada!","danger","ban");
            });
        });

		// desabilita todos campos de entrada
		$("#novo<?php echo $nome;?>").find("input,textarea,select").each(function(){
			$(this).attr("disabled","disabled");
		});

		//mostra botões ocultos;
		$("#botoesCliente").find("#editar, #excluir").removeClass("hidden");

		//oculta botões;
		$("#botoesCliente").find("#cadastrar").addClass("hidden");

		setTimeout(function(){
			//busca campos no banco;
			$.post("server/recupera.php",{tabela:'<?php echo $tabela." where id = ".$id;?>'}).done(function(data){
				var obj = JSON.parse(data);

				//alimenta formulário;
				$("#novoCliente").find("#nome").val(obj[0].nome);
				$("#novoCliente").find("#nome").attr("cod",obj[0].id);
				$("#cpf").val(obj[0].cpf);
				$("#novoCliente").find("#rg").val(obj[0].rg);
				if(obj[0].nasc != null){
					$("#novoCliente").find("#nasc").val(obj[0].nasc.substr(8,2)+"/"+obj[0].nasc.substr(5,2)+"/"+obj[0].nasc.substr(0,4));
				}

				$("#novoCliente").find("#cep").val(obj[0].cep);
				$("#novoCliente").find("#endereco").val(obj[0].endereco);
				$("#novoCliente").find("#usuario").val(obj[0].usuario);
				$("#novoCliente").find("#filial").val(obj[0].filial);
				$("#novoCliente").find("#nomemae").val(obj[0].nomemae);
				$("#novoCliente").find("#nomepai").val(obj[0].nomepai);
				$("#novoCliente").find("#datacadastro").val(obj[0].datacadastro);
				$("#novoCliente").find("#ncadastro").val(obj[0].ncadastro);
				$("#novoCliente").find("#numero").val(obj[0].numero);
				$("#novoCliente").find("#bairro").val(obj[0].bairro);
				$("#novoCliente").find("#complemento").val(obj[0].complemento);
				$("#novoCliente").find("#cidade").val(obj[0].cidade);
				$("#novoCliente").find("#estado").val(obj[0].estado);
				$("#novoCliente").find("#telefone").val(obj[0].telefone);
				$("#novoCliente").find("#celular").val(obj[0].celular);
				$("#novoCliente").find("#email").val(obj[0].email);
				$("#novoCliente").find("#banco").val(obj[0].banco);
				$("#novoCliente").find("#agencia").val(obj[0].agencia);
				$("#novoCliente").find("#conta").val(obj[0].conta);
				$("#novoCliente").find("#obs").val(obj[0].obs);
				$("#novoCliente").find("#trabalho").val(obj[0].trabalho);
				$("#novoCliente").find("#futebol").val(obj[0].futebol);
				$("#novoCliente").find("#estcivil").val(obj[0].estcivil).change();
				$("#novoCliente").find("#informatica").val(obj[0].informatica).change();
				if("<?php echo $_SESSION['config']['modalidade'];?>" == 1){
					$("#novoCliente").find("#matricula").val(obj[0].matricula);
					$("#novoCliente").find("#curso").val(obj[0].curso).change();
					$("#novoCliente").find("#turno").val(obj[0].turno).change();
					$("#novoCliente").find("#turma").val(obj[0].turma).change();
					$("#novoCliente").find("#emp_id").val(obj[0].emp_id).change();
					$("#novoCliente").find("#modalidade").val(obj[0].modalidade).change();
					$("#novoCliente").find("#status").val(obj[0].status).change();
					$("#novoCliente").find("#convenio").val(obj[0].convenio).change();
					$("#novoCliente").find("#emp_id").val(obj[0].emp_id).change();


				}

				if(obj[0].cliente == 1){
					$("#novoCliente").find("#cliente").attr('checked','checked');
				}
				if(obj[0].produtor == 1){
					$("#novoCliente").find("#produtor").attr('checked','checked');
				}
				if(obj[0].fornecedor == 1){
					$("#novoCliente").find("#fornecedor").attr('checked','checked');
				}
				loading('hide');
			});
		},2000);

		//editando formulário
		$("#botoesCliente").find("#editar").click(function(){
			//Liberar campos pra edição
			$("#novo<?php echo $nome;?>").find("input,textarea,select").each(function(){
				$(this).removeAttrs("disabled");
			});
			$("#novoCliente").find("#imgavatar").attr('data-destination','myimgdestination');
			//focar no primeiro campo
			$("#novoCliente").find("#nome").focus().select();

			//esconde botões
			$("#botoesCliente").find("#excluir,#editar").addClass("hidden");

			//aparece botões
			$("#botoesCliente").find("#salvar,#cancelar").removeClass("hidden");
		});

		//excluindo item
		$("#botoesCliente").find("#excluir").click(function(){
			var nome = $("#novoCliente").find("#nome").val();
			confirma("ATENÇÃO","Você deseja excluir este item?<br><?php echo $id;?>: " + nome,function(){
				$.ajax({
					url: 'server/cliente.php',
					type: 'POST',
					cache: false,
					data: {funcao:3,id:"<?php echo $id;?>"},
					success: function(data) {

								if(data == 1){
							alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
							try{
								$("#datatable_col_reorder").dataTable().fnReloadAjax();
							}
							catch(e){

							}
							$("#cadastro").dialog('close');
						}else{
							alerta("AVISO!","Não foi possível excluir este item!","danger","ban");
						}
					}
				});
			});
		});

		// cancelando edição
		$("#botoesCliente").find("#cancelar").click(function(){
			$.post("ajax/cadcliente.php",{id:<?php echo $id;?>}).done(function(data){
				$("#cadastro").empty().html(data);
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","warning");
			});
		});

		//salvando edição
		$("#botoesCliente").find("#salvar").click(function(){
			var cliente	 		= $("#novoCliente").find("#nome");
			var id   	 		= $("#novoCliente").find("#nome").attr("cod");
			var cpf  	 		= $("#novoCliente").find("#cpf");
			var celular 		= $("#novoCliente").find("#celular");
			var email    		= $("#novoCliente").find("#email");

			var data = new FormData();
			$("#novoCliente").find('input:checkbox:checked,input:radio:checked,input:text,select,textarea').each(function(){
				data.append($(this).attr('id'),$(this).val());
			});
			if(cliente.val().length == 0 || cliente.val() == undefined){
				alerta("Aviso!","Favor preencher o campo "+cliente.attr('id')+".","warning","warning");
				cliente.focus().select();
			}
			else{
				var d = new Date();
				var n = d.getTime();
				$.ajax({
					xhr: function() {
						var xhr = new window.XMLHttpRequest();
						//Get upload progress
						xhr.upload.addEventListener("progress", function(evt) {
							if (evt.lengthComputable) {
								//Example showing how to calculate the percent complete
								console.log(Math.floor((evt.loaded / evt.total * 100)));
							}
						}, false);
						//Get upload progress
						xhr.addEventListener("progress", function(evt) {
							if (evt.lengthComputable) {
								//Example showing how to calculate the percent complete
								console.log(Math.floor((evt.loaded / evt.total * 100)));
							}
						}, false);
						return xhr;
					},
					type: 'POST',
					url: 'js/plugin/avatareffects/avatarupload.php',
					async:false,

					data: {
						imagefile: $("#imgavatar").get(0).src,//Image to be submitted to the server
						imagename: n,//Image name that will be saved on server
					},
					//There was no error when sending the image
					success: function(data3){
						console.log(data3);
						var img = data3;
						data.append('img',$("#imgavatar").val());
					},
					//There was an error when sending the image
					error: function(data) {
						console.log("error: "+ data);
					}
				});
				$.ajax({
					url: 'server/cliente.php?funcao=2&id='+id,
					data: data,
					async:false,
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
				});
			}
		});
	</script>
	<?php
}else{
	?>
	<script type="text/javascript">
		//oculta tabs

		$("#novoCliente").find("#imgavatar").attr('src',"js/plugin/avatareffects/img/repository/23.jpg");

		$("#botoesCliente").find("#cadastrar").click(function(){
			var url      = document.URL.split("#");
			var cliente  = $("#novoCliente").find("#nome");
			var cpf  	 = $("#novoCliente").find("#cpf");
			var telefone = $("#novoCliente").find("#telefone");
			var email    = $("#novoCliente").find("#email");
			url      = url[1];
			var data = new FormData();
			$("#novoCliente").find('input:radio:checked,input:checkbox:checked,input:text,select,textarea').each(function(){
				data.append($(this).attr('id'),$(this).val());
			});
			if(cliente.val().length == 0 || cliente.val() == undefined){
				alerta("Aviso!","Favor preencher o campo "+cliente.attr('id')+".","warning","warning");
				cliente.focus().select();
			}
			/*else if(cpf.val().length == 0 || cpf.val() == undefined){
				alerta("Aviso!","Favor preencher o campo "+cpf.attr('id')+".","warning","warning");
				cpf.focus().select();
			}
			else if(telefone.val().length == 0 || telefone.val() == undefined){
				alerta("Aviso!","Favor preencher o campo "+telefone.attr('id')+".","warning","warning");
				telefone.focus().select();
			}
			else if(email.val().indexOf("@") != 1 && email.val().indexOf(".") < 1 && email.val().length < 10){
				alerta("Aviso!","Favor preencher o campo "+email.attr('id')+".","warning","warning");
				email.focus().select();
			}*/
			else{
				$.ajax({
					url: 'server/cliente.php?funcao=1',
					data: data,
					processData: false,
					contentType: false,
					type: 'POST',
					success: function ( data2 ) {
						if (data2.match(/[a-z]/i)) {
							alerta("Error!",data2,"danger","ban");
						}else{
							alerta("Sucesso!","Cadastro realizado com sucesso!","success","check");
							loading("hide");
							$("#cadastro").dialog('close');

							try{
								$("#datatable_col_reorder").dataTable().fnReloadAjax();
							}
							catch(e){}
							setTimeout(function(){
								$("#t_pro").click();
							},1000);
						}
					}
				});
			}
		});




		//inserir cadastro
		/*$("#botoesCliente").find("#cadastrar").click(function(){
		 var url      = document.URL.split("#");
		 url      = url[1];
		 var nome 	 = $("#novoCliente").find("#nome").val();
		 var id   	 = $("#novoCliente").find("#nome").attr("cod");
		 var cpf  	 = $("#novoCliente").find("#cpf").val();
		 var rg   	 = $("#novoCliente").find("#rg").val();
		 var nasc 	 = $("#novoCliente").find("#nasc").val();
		 var cep  	 = $("#novoCliente").find("#cep").val();
		 var endereco = $("#novoCliente").find("#endereco").val();
		 var numero   = $("#novoCliente").find("#numero").val();
		 var bairro   = $("#novoCliente").find("#bairro").val();
		 var cidade   = $("#novoCliente").find("#cidade").val();
		 var estado   = $("#novoCliente").find("#estado").val();
		 var telefone = $("#novoCliente").find("#telefone").val();
		 var celular  = $("#novoCliente").find("#celular").val();
		 var email    = $("#novoCliente").find("#email").val();
		 var banco    = $("#novoCliente").find("#banco").val();
		 var agencia  = $("#novoCliente").find("#agencia").val();
		 var conta    = $("#novoCliente").find("#conta").val();
		 var obs      = $("#novoCliente").find("#obs").val();
		 var chk_cliente 	= $("#novoCliente").find("#cliente:checked").val();
		 var chk_fornecedor 	= $("#novoCliente").find("#fornecedor:checked").val();
		 var chk_produtor 	= $("#novoCliente").find("#produtor:checked").val();
		 if(nome==="")
		 {
		 alerta("AVISO!","Favor preencher o campo nome!","warning","warning");
		 focar($("#novoCliente").find("#nome"));
		 }
		 else if(cpf ==="" || cpf.length <=10){
		 alerta("AVISO!","Favor preencher o campo cpf! Caso o campo esteje preenchido confira a quantidade de caracteres digitada!","warning","warning");
		 focar($("#novoCliente").find("#cpf"));
		 }
		 else if($("#email").val().indexOf("@") != 1 && $("#email").val().length < 10){
		 alerta("Email incorreto!","Por favor, informe um endereço de email válido","warning","warning");
		 $("#email").focus();
		 }
		 else
		 {
		 loading("show");
		 $.ajax({
		 url: 'server/cliente.php',
		 type: 'POST',
		 cache: false,
		 data: {funcao:1,chk_cliente:chk_cliente,chk_fornecedor:chk_fornecedor,chk_produtor:chk_produtor,nome:nome,cpf:cpf,rg:rg,nasc:nasc,cep:cep,endereco:endereco,numero:numero,bairro:bairro,cidade:cidade,estado:estado,telefone:telefone,celular:celular,email:email,banco:banco,agencia:agencia,conta:conta,obs:obs},
		 success: function(data) {
		 if(data == 99999999999){

		 $("#cadastro").dialog('close');
		 $.ajax({
		 url: url,
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

		 $("#cadastro").empty().dialog('close');
		 }else{


		 loading('hide');
		 }
		 loading("hide");
		 }
		 });F
		 }
		 });*/

$("#cadastrar").click(function(){
    envia();
});


	</script>
	<?php
}

?>
<script src="js/plugin/avatareffects/js/avatareffects.js"></script>
<script src="js/plugin/avatareffects/js/avatareffects.langs.js"></script>
