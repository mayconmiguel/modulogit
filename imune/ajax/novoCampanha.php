

<?php
require_once "../server/seguranca.php";



$server = gethostbyaddr($_SERVER['SERVER_ADDR']);
$ip = $_SERVER['SERVER_ADDR'];
$us_nome = $_SESSION['usuarioNome'];
$us_id  = $_SESSION['usuarioID'];
$emp_id  = $_SESSION['usuarioEmpresa'];

?>

<div class="row">
	<div class="col-xs-1"></div>
	<div class="col-xs-10">
		Tipo:<select id="type" style="width:100%" class="form-control">
			<option value="1" selected >MANUAL</option>
			<option value="2">POR ARQUIVO</option>
		</select>
	</div>
	<div class="col-xs-1"></div>
</div>
<div class="space-6"></div>
<div class="row" id="linhaArquivo" hidden>
	<div class="col-xs-1"></div>
	<div class="col-xs-9">
		Selecione um arquivo
		<input id="my-file-input" class="btn btn-default" type="file" style="width:100%">
	</div>
	<div class="col-xs-2"></div>
</div>

<div class="space-6"></div>
<div class="row">
	<div class="col-xs-1"></div>
	<div class="col-xs-10">
		<label>Números:</label><textarea id="num2" style="width: 100%" placeholder="Digite um numero por linha"></textarea>
	</div>
	<div class="col-xs-1"></div>
</div>
<div class="space-6"></div>

<div class="row">
	<div class="col-xs-1"></div>
	<div class="col-xs-10">
		<label>Mensagem:</label><textarea onkeypress="return sem_acento(event);" id="txt2" maxlength="160" style="width: 100%" placeholder="Mensagem:"></textarea>
		<label id="chars" style="color: #AAA">160 Caracteres</label>
	</div>
	<div class="col-xs-1"></div>
</div>
<div class="space-6"></div>
<div class="row">
	<div class="col-xs-1"></div>
	<div class="col-xs-10">
		<button id="envia2" class="btn btn-primary dark btn-block">ENVIAR SMS</button>
	</div>
	<div class="col-xs-1"></div>
</div>


<script>

	var pagefunction = function() {

	};


	$("#my-file-input").change(function(files){
		var fileToLoad = this.files[0];

		var fileReader = new FileReader();
		fileReader.onload = function(fileLoadedEvent){
			var textFromFileLoaded = fileLoadedEvent.target.result;
			document.getElementById("num2").value = textFromFileLoaded;
		};

		fileReader.readAsText(fileToLoad, "UTF-8");
	});


	loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js",function(){
						loadScript("js/plugin/x-editable/x-editable.min.js", pagefunction)
					});
				});
			});
		});
	});



	//inicializações
	$("#n_camp").focus();

	var smsTipo = "<?php echo $_SESSION['config']['sms'];?>";



	function sem_acento(e,args)
	{
		if (document.all){var evt=event.keyCode;} // caso seja IE
		else{var evt = e.charCode;}	// do contrário deve ser Mozilla
		var valid_chars = '0123456789abcdefghijlmnopqrstuvxzwykABCDEFGHIJLMNOPQRSTUVXZWYK-_.!?,()*@#$%&+;=: '+args;	// criando a lista de teclas permitidas
		var chr= String.fromCharCode(evt);	// pegando a tecla digitada
		if (valid_chars.indexOf(chr)>-1 ){return true;}	// se a tecla estiver na lista de permissão permite-a
		// para permitir teclas como <BACKSPACE> adicionamos uma permissão para
		// códigos de tecla menores que 09 por exemplo (geralmente uso menores que 20)
		if (valid_chars.indexOf(chr)>-1 || evt < 9){return true;}	// se a tecla estiver na lista de permissão permite-a
		return false;	// do contrário nega
	}








	var maxLength = 160;
	$("#txt2").keyup(function(){
		var length = $(this).val().length;
		length = maxLength-length;

		if(length<=1){
			$("#chars").text(length+ " Caracter");
		}else{
			$("#chars").text(length+ " Caracteres");
		}
	});

	$("#num2").keydown(function(e){
		if ($.inArray(e.which, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			// Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
			((e.which == 65 || e.which == 86 || e.which == 67 || e.which == 88) && (e.ctrlKey === true || e.metaKey === true)) ||
			// Allow: home, end, left, right, down, up
			(e.which >= 35 && e.which <= 40) || (e.which < 14)) {
			// let it happen, don't do anything
			return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.which < 48 || e.which > 57)) && (e.which < 96 || e.which > 105)) {
			e.preventDefault();
		}
	});


	//aplicando mascaras

	var SPMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
		},
		spOptions = {
			onKeyPress: function(val, e, field, options) {
				field.mask(SPMaskBehavior.apply({}, arguments), options);
			}
		};

	$('#teln').mask(SPMaskBehavior, spOptions);
	$('td[id="numero"]').mask(SPMaskBehavior, spOptions);

	//tooltips
	$('[data-rel=tooltip]').tooltip();

	// buscando mensagens no banco de dados
	/*$.post("server/recupera.php",{tabela:'mensagem'}).done(function(data){
	 $("#typemsg").empty().append('<option msg="" value="0">' +
	 'Nova Mensagem' +
	 '</option>');
	 var obj2 = JSON.parse(data);
	 for(i in obj2){
	 $("#typemsg").append('' +
	 '<option msg="'+obj2[i].txt+'" value="'+obj2[i].id+'">' +
	 obj2[i].title.toUpperCase() +
	 '</option>');
	 }
	 });*/

	//controlando alteração de mensagens
	$("#typemsg").change(function(){
		$("#txt2").val($("#typemsg option:selected").attr("msg"));
		var length = $("#txt2").val().length;
		length = 160-length;

		if(length<=1){
			$("#chars").text(length+ " Caracter");
		}else{
			$("#chars").text(length+ " Caracteres");
		}
	});

	// gerenciando tipos de envios de SMS
	$("#type").change(function(){
		if($(this).val() == 1){
			$("#linhaArquivo,#dentista").attr("hidden",true);
			$("#num2").removeAttr("disabled");
			$("#num2").val('');
		}
		else if($(this).val() == 2){
			$("#linhaArquivo").removeAttr("hidden");
			$("#dentista").attr("hidden",true);
			$("#num2").attr("disabled",true);
			$("#num2").val('');
		}
	});







	function apaga(a){
		$(a).remove();
		var l_id      = $(a).find("#campanha").attr("value");
		$.post("server/campanha.php",{funcao:3,tipo:l_id}).done(function(data){
			$("#dados").empty().html(data);

		});
	}


	//bloqueando quebra de linha no formulario de mensagem para evitar erros.
	$("#txt2").keydown(function(e){
		if(e.which == 13){
			return false;
		}else{
			return true;
		}
	});

	$("#envia2").click(function(){

		var numero = [];
		var camp_nome = $("#n_camp").val();
		var camp_tipo = $("#type option:selected").val();
		var num   = $("#num2").val().replace(/(?:\r\n|\r|\n)/g,"-").split('-');
		var msg       = $("#txt2").val();

		if(smsTipo == '2'){
			var prefixo = '';
		}else{
			var prefixo = "55";
		}

		for(i in num){
			numero.push(prefixo+num[i]);
		}

		confirma("Deseja fazer o envio desta mensagem para os seguintes números?","",function(){
			loading("show");
			var percent = 0;
			var contador = 1;
			loading("show");
			$.post("server/enviaSMS.php",{c:1,num:numero,msg:msg,dt_start:dataAtualFormatada(3)}).done(function(data){
				if(data === "error"){
					loading("hide");
					alerta("Ocorreu um erro, tente novamente.","","error");
				}else{
					var obj = JSON.parse(data);

					if(typeof obj != 'object'){
						loading("hide");
						alerta("O Servidor não respondeu.","","error");
					}else{

						if(smsTipo == '2'){
							if(obj.status == 1){
								alerta("Mensagem enviada com sucesso!","","success","check");
							}else{
								alerta("Ocorreu um erro, tente novamente.","","danger","ban");
							}
							$.ajax({
								url: 'server/SMS.php',
								type: 'POST',
								data:{data:obj.data,funcao:1},
								cache: false,
								async: false,
								success: function(data) {
									loading('hide');
								},
								error:function(){
									loading('hide');
								}
							});
							$.ajax({
								url: 'server/respostaSMS.php',
								type: 'POST',
								data:{funcao:2},
								cache: false,
								async: false,
								success: function(data) {
									loading('hide');
								},
								error:function(){
									loading('hide');
								}
							});
						}else{
							var resultado = obj.messages[0].status.groupName;

							if(resultado === "SUCCESS" || resultado === "PENDING"){
								alerta("Mensagem enviada com sucesso!","","success");
							}else{
								alerta("Ocorreu um erro, tente novamente.","","danger","ban");
							}
						}

						$('#datatable_col_reorder').dataTable().fnReloadAjax();
						$("#txt2,#num2").val('');
					}
				}
				loading("hide");
				//link('centralSMS.php');
			}).fail(function(){
				loading("hide");
				//link('centralSMS.php');
			});
		});
	});




</script>
