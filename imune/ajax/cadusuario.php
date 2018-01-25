<?php
require_once "../server/seguranca.php";
$nome = "Usuário"; $tabela = "usuarios";
mysqli_set_charset($con,'utf8');
$menus = "select * from menus where mod_id = '".$_SESSION['config']['modalidade']."'";

?>

<form id="novoUsuario" class="smart-form client-form">

	<fieldset>
		<div class="row hidden" id="stst">
			<div class="col col-sm-2">
				<label class="toggle">
					<input type="checkbox" id="status" name="status" checked="checked">
					<i data-swchon-text="SIM" data-swchoff-text="NÃO"></i>Ativo</label>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col col-sm-6 col-xs-12">
				<label class="label">Nome Completo</label>
				<label class="input"> <i class="icon-append fa fa-user"></i>
					<input type="text" id="nome" name="nome">
					<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor, digite um endereço de email válido!</b></label>
			</div>
			<div class="col col-sm-6 col-xs-12">
				<label class="label">CPF</label>
				<label class="input"> <i class="icon-append fa fa-lock"></i>
					<input id="cpf" type="text" name="cpf">
					<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Digite sua senha!</b> </label>
			</div>
		</div>
		<div class="row">
			<div class="col col-sm-6 col-xs-12">
				<label class="label">Email</label>
				<label class="input"> <i class="icon-append fa fa-user"></i>
					<input type="text" id="usuario" name="usuario">
					<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor, digite um endereço de email válido!</b></label>
			</div>
			<div class="col col-sm-6 col-xs-12">
				<label class="label">Senha</label>
				<label class="input"> <i class="icon-append fa fa-lock"></i>
					<input id="senha" old="" type="password" name="senha">
					<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Digite sua senha!</b> </label>
			</div>
		</div>
		<br>
		<div class="row">
			<div class="col col-sm-12">
				<h4>Informações do Sistema</h4>
			</div>
		</div>

		<div class="row">
			<div class="col col-lg-4 col-md-4 col-sm-12 col-xs-12">
				<label class="label">Nível de acesso:</label>
				<label class="select">
					<select class="form-control" id="acesso">
						<option value="0">0</option>
						<option value="1">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
					</select>
				</label>
			</div>
			<div class=" col col-lg-8 col-md-8 col-sm-12 col-xs-12">
				<label class="label">
					Menus:
				</label>
				<label class="select">
					<select id="menu" multiple style="width: 100%; height: auto" class="select2">
						<option value="1">Cadastros</option>
						<option value="2">Clientes</option>
						<option value="3">Financeiro</option>
						<?php
						$valida = mysqli_query($con,$menus);

						while($row = mysqli_fetch_array($valida)){
							?>
							<option value="<?php echo $row['id'];?>"><?php echo $row['nome'];?></option>
							<?php
						}
						?>
						<option value="99">Relatórios</option>
						<option value="100">Auditoria</option>
					</select>
				</label>
			</div>
		</div>
	</fieldset>
	<footer>
		<button id="submit" type="submit" class="btn btn-primary hidden">
			Cadastrar
		</button>
		<button id="excluir" type="button" class="btn btn-danger hidden">
			Excluir
		</button>
		<button id="cancelar" type="button" class="btn btn-danger hidden">
			Cancelar
		</button>
		<button id="editar" type="button" class="btn btn-warning hidden">
			Editar
		</button>

	</footer>
</form>



<script>
	$("#menu").select2();

	/*$("#cadastrar").click(function(){
		var url      	= document.URL.split("#");
		var cliente  	= $("#nome");
		var cpf  	 	= $("#cpf");
		var usuario  	= $("#usuario");
		var senha  		= $("#senha");
		var email    	= $("#email");
		var acesso    	= $("#acesso");
		var menus 		= [];
		$("#menu option:selected").each(function(){
			menus.push($(this).val());
		});
		url      = url[1];
		var data = new FormData();
		$("#novoUsuario").find('input:checkbox:checked,input:text,select,textarea').each(function(){
			data.append($(this).attr('id'),$(this).val());
		});
		if(cliente.val().length == 0 || cliente.val() == undefined){
			alerta("Aviso!","Favor preencher o campo "+cliente.attr('id')+".","warning","warning");
			cliente.focus().select();
		}
		else if(usuario.val().length == 0 || usuario.val() == undefined){
			alerta("Aviso!","Favor preencher o campo "+usuario.attr('id')+".","warning","warning");
			usuario.focus().select();
		}
		else if(senha.val().length == 0 || senha.val() == undefined){
			alerta("Aviso!","Favor preencher o campo "+senha.attr('id')+".","warning","warning");
			senha.focus().select();
		}
		else{
			$.ajax({
				url: 'server/usuario.php?funcao=1',
				data: data,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function ( data2 ) {
					if (data2.match(/[a-z]/i)) {
						alerta("Error!",data2,"danger","ban");
					}else{
						alerta("Sucesso!","Cadastro realizado com sucesso!","success","check");
						$("#cadastro").dialog('close');
						try{
							$("#datatable_col_reorder").dataTable().fnReloadAjax();
						}
						catch(e){}

						try{
							$.post('ajax/usuario.php').done(function(data){
								$("#content").html(data);
							});
						}
						catch(e){

						}
					}
				}
			});
		}
	});*/


	$("#novoUsuario").validate({
		// Rules for form validation
		rules : {
			usuario : {
				required : true,
				email:true
			},
			senha : {
				required : true,
				minlength : 3,
				maxlength : 100
			}
		},

		// Messages for form validation
		messages : {
			usuario : {
				required : 'Por favor, digite um endereço de email válido!',
				email : 'Por favor, digite um endereço de email válido!'
			},
			senha : {
				required : 'Por favor, digite uma senha'
			}
		},
		success: 'valid',

// This does the actual form submitting
		submitHandler: function (form) {
			var data = new FormData();
			$("#novoUsuario").find('input:checkbox:checked,input:radio:checked,input:text,select,textarea').each(function(){
				data.append($(this).attr('id'),$(this).val());
			});

			if($("#senha").val() == $("#senha").attr("old")){
				var senha = $("#senha").attr("old");
			}else{
				var senha = $.sha1($("#senha").val());
			}


			data.append("senha",senha);
			$.ajax({
				url: 'server/usuario.php?funcao=<?php echo $c = (isset($_POST['id'])) ? '2&id='.$_POST["id"] : '1'; ?>',
				data: data,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function ( data2 ) {
					if (data2.match(/[a-z]/i)) {
						alerta("Error!",data2,"danger","ban");
					}else{
						alerta("Sucesso!","Cadastro realizado com sucesso!","success","check");
						$("#cadastro").dialog('close');
						try{
							$("#datatable_col_reorder").dataTable().fnReloadAjax();
						}
						catch(e){}

						try{
							$.post('ajax/usuario.php').done(function(data){
								$("#content").html(data);
							});
						}
						catch(e){

						}
					}
				}
			});
			return false;
		},

		// Do not change code below
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		}
	});
</script>
<?php

	if(isset($_POST['id'])){
		?>
		<script>
			$.post('server/recupera.php',{tabela:"usuarios where id = <?php echo $_POST['id'];?>"}).done(function(data){
				var obj = JSON.parse(data)[0];
				$("#nome").val(obj.nome);
				$("#cpf").val(obj.cpf);
				$("#usuario").val(obj.email);
				$("#senha").val(obj.senha);
				$("#senha").attr("old",obj.senha);
				$("#acesso").val(obj.acesso);
				if(obj.status == 1){
					$("#status").prop('checked',true);
				}else{
					$("#status").prop('checked',false);
				}
				if(obj.menus){
					var menus = obj.menus.split(",");
					for(m in menus){
						$("#menu option[value='"+menus[m]+"']").attr("selected","selected");
					}
				}
				$("#menu").select2();
			});
			$("#novoUsuario").find('input:text,input:checkbox,input:password,textarea,select').each(function(){
				$(this).prop('disabled',true);
				$(this).parent().addClass('state-disabled');
			});
			$("#editar,#excluir,#stst").removeClass('hidden');


			//editar
			$("#editar").click(function(){
				$("#editar,#excluir").addClass('hidden');
				$("#submit,#cancelar").removeClass('hidden');
				$("#submit").html('Salvar');
				$("#novoUsuario").find('input:text,input:checkbox,input:password,textarea,select').each(function(){
					$(this).prop('disabled',false);
					$(this).parent().removeClass('state-disabled');
				});

			});
			// cancelando edição
			$("#cancelar").click(function(){
				$.post("ajax/cadusuario.php",{id:<?php echo $_POST['id'];?>}).done(function(data){
					$("#cadastro").empty().html(data);
				}).fail(function(){
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
			});
			//excluindo item
			$("#excluir").click(function(){
				var nome = $("#nome").val();
				confirma("ATENÇÃO","Você deseja excluir este item?<br><?php echo $_POST["id"];?>: " + nome,function(){
					$.ajax({
						url: 'server/usuario.php?funcao=3&id=<?php echo $_POST["id"];?>',
						type: 'POST',
						cache: false,
						success: function(data) {
							if(data == 1){
								alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								$.ajax({
									url: 'ajax/usuario.php',
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
		</script>
		<?php
	}else{
		?>
		<script>
			$("#submit").removeClass('hidden');
		</script>
		<?php
	}

?>