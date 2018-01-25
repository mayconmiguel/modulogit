

<?php
require_once "../server/seguranca.php";
$server = gethostbyaddr($_SERVER['SERVER_ADDR']);
$ip = $_SERVER['SERVER_ADDR'];
$us_nome = $_SESSION['imunevacinas']['usuarioNome'];
$us_id  = $_SESSION['imunevacinas']['usuarioID'];
$emp_id  = $_SESSION['imunevacinas']['usuarioEmpresa'];

?>

<div class="row">
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
	<div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
		<label>Nº Telefone:</label><input id="teln" class="form-control" placeholder="Digite um número de telefone">
	</div>
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
</div>
<div class="space-6"></div>
<div class="row">
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
	<div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
		<label>Mensagem:</label><textarea id="txt" style="width: 100%" placeholder="Mensagem:"></textarea>
		<label id="chars" style="color: #AAA">140 Caracteres</label>
	</div>
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
</div>
<div class="space-6"></div>
<div class="row">
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
	<div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
		<button id="envia" class="btn btn-primary dark btn-block">Enviar SMS</button>
	</div>
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
</div>



<script>




	var maxLength = 140;
	$("#txt2").keyup(function(){
		var length = $(this).val().length;
		length = maxLength-length;

		if(length<=1){
			$("#chars").text(length+ " Caracter");
		}else{
			$("#chars").text(length+ " Caracteres");
		}
	});
	$("#teln").focus();

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
	$('[data-rel=tooltip]').tooltip();

	$("#txt").keydown(function(e){
		if(e.which == 13){
			return false;
		}else{
			return true;
		}
	});

	$("#envia").click(function(){

		var numero = [];
		var num = "55"+$("#teln").val().replace("(","").replace(")","").replace(" ","").replace("-","");
		var msg = $("#txt").val();
		numero.push(num);
		if(num.length <= 0){
			alerta("Favor Inserir um número de telefone!","","warning");
			$("#teln").focus();
		}else{
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
						var resultado = obj.messages[0].status.groupName;

						if(resultado === "SUCCESS" || resultado === "PENDING"){
							alerta("Mensagem enviada com sucesso!","","success");
						}else{
							alerta("Ocorreu um erro, tente novamente.","","error");
						}
						/*$.post("server/SMS.php",{tipo:1,us_id:"<?php echo $us_id;?>",emp_id:"<?php echo $emp_id;?>",us_nome:"<?php echo $us_nome;?>",num:num,msg:msg,dt_start:dataAtualFormatada(3),status:resultado}).done(function(data){
							$("#dados").empty().html(data);
						});*/
					}
				}
				loading("hide");
				//link('centralSMS.php');
			}).fail(function(){
				loading("hide");
				//link('centralSMS.php');
			});
		}


	});
</script>

<script type="text/javascript">


	var maxLength = 140;
	$("#txt").keyup(function(){
		var length = $(this).val().length;
		length = maxLength-length;

		if(length<=1){
			$("#chars").text(length+ " Caracter");
		}else{
			$("#chars").text(length+ " Caracteres");
		}
	});

	/* DO NOT REMOVE : GLOBAL FUNCTIONS!
	 *
	 * pageSetUp(); WILL CALL THE FOLLOWING FUNCTIONS
	 *
	 * // activate tooltips
	 * $("[rel=tooltip]").tooltip();
	 *
	 * // activate popovers
	 * $("[rel=popover]").popover();
	 *
	 * // activate popovers with hover states
	 * $("[rel=popover-hover]").popover({ trigger: "hover" });
	 *
	 * // activate inline charts
	 * runAllCharts();
	 *
	 * // setup widgets
	 * setup_widgets_desktop();
	 *
	 * // run form elements
	 * runAllForms();
	 *
	 ********************************
	 *
	 * pageSetUp() is needed whenever you load a page.
	 * It initializes and checks for all basic elements of the page
	 * and makes rendering easier.
	 *
	 */

	pageSetUp();

	/*
	 * ALL PAGE RELATED SCRIPTS CAN GO BELOW HERE
	 * eg alert("my home function");
	 *
	 * var pagefunction = function() {
	 *   ...
	 * }
	 * loadScript("js/plugin/_PLUGIN_NAME_.js", pagefunction);
	 *
	 */

	// PAGE RELATED SCRIPTS

	// pagefunction
	

</script>
