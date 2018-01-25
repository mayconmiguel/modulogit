

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
		<label>Nova Mensagem:</label><input id="n_camp" class="form-control" placeholder="Nome da Mensagem">
	</div>
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
</div>
<div class="space-6"></div>
<div class="row">
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
	<div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
		<label>Mensagem:</label><textarea maxlength="140" id="txt2" style="width: 100%" placeholder="Mensagem:"></textarea>
		<label id="chars" style="color: #AAA">140 Caracteres</label>
	</div>
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
</div>
<div class="space-6"></div>
<div class="row">
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
	<div class="col-lg-4 col-md-6  col-sm-8 col-xs-10">
		<button id="envia2" class="btn btn-primary dark btn-block">Criar Mensagem</button>
	</div>
	<div class="col-lg-4 col-md-3 col-sm-2 col-xs-1"></div>
</div>
<div class="space-6"></div>
<div class="row">
	<div class="col-xs-12">
		<div class="table-header" style="border:1px solid #CCCCCC;background:linear-gradient(#FFFFFF,#EEEEEE);color:#669FC7">
			MENSAGENS CRIADAS
		</div>


		<div style="border:1px solid #ccc">
			<table id="sample-table-55" class="table table-striped table-bordered table-hover"  >
				<thead>
				<tr>
					<th class=" hidden-xs center">TITULO</th>
					<th class=" hidden-sm hidden-xs center">MSG</th>
					<th class="center">AÇÕES</th>
				</tr>
				</thead>
				<tbody id="orctab2">
				<td id="campanha" class=" hidden-xs center"></td>
				<td id="msg" class=" hidden-sm hidden-xs center"></td>
				<td id="acoes" class="center"></td>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div id="dialog-confirm" class="hide">
	<div class="space-12"></div>
	<div class="alert alert-info bigger-110">
		Deseja executar esta campanha agora?
	</div>
</div><!-- #dialog-confirm -->

<script>
	//inicializações
	$("#n_camp").focus();

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


	// exibe campanhas ativas
	/*$.post("server/recupera.php",{tabela:'mensagem'}).done(function(data){
		var obj2 = JSON.parse(data);
		for(i in obj2){
			if(i == 0){
				$("#orctab2").empty();
			}
			$("#orctab2").append('' +
				'<tr id="tt'+i+'">' +
				'<td id="campanha" value="'+obj2[i].id+'" class="hidden-xs center">' +
				obj2[i].title +
				'</td>' +
				'<td id="msg" data-rel="tooltip" title="'+obj2[i].txt+'" class="popoverhidden-sm hidden-xs center">' +
				obj2[i].txt +
				'</td>' +
				'<td id="acoes" class="center">' +

				'<i class="fa fa-ban " onclick="apaga(tt'+i+')" style="margin-left:10px;cursor:pointer" title="Excluir" id="btn-a'+i+'"></i>' +
				'</td>' +
				'</tr>');

		}
	});*/

	function apaga(a){
		$(a).remove();
		var l_id      = $(a).find("#campanha").attr("value");
		$.post("server/mensagem.php",{funcao:3,tipo:l_id}).done(function(data){
			$("#dados").emtpy().html(data);

		});
	}
	function edita(a){

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
		var title = $("#n_camp").val();
		var txt   = $("#txt2").val();
		$.post("server/mensagem.php",{funcao:1,title:title,txt:txt}).done(function(data){
			$("#dados").empty().html(data);
			alerta("Mensagem Inserida com Sucesso!","","success");
			$.post("novoMensagem.php").done(function(data) {
				$("#centraldecontas").empty().html(data);
			});
		});



	});
</script>
