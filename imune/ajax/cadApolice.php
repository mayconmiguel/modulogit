<?php
	require_once "../server/seguranca.php";
	$tabela = "Apolice";
?>
<div id="novoApolice">
	<div class="row">
		<div class="col-sm-7 col-xs-12">
			<h1 class="text-primary" id="nome"></h1>
		</div>
		<div class="col-sm-5 col-xs-12">
			<h1 class="text-primary text-right">
				<span id="cpf"></span>
			</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-xs-12" id="tipo">
			<?php
				if(!isset($_POST['id'])){
					?>
					<div class="row">
						<div class="col-sm-8 col-xs-12">
							Cliente<input class="form-control" id="cli_id" retorno="" situacao="1" />
						</div>
						<div class="col-sm-4 col-xs-12">
							Tipo<select class="form-control" id="tp">
									<option value="1">NOVO</option>
									<option value="2">ENDOSSO</option>
									<option value="3">RENOVAÇÃO</option>
									<option value="4">CANCELAMENTO</option>
								</select>
						</div>
					</div>
					<?php
				}
			?>
		</div>
		<div class="col-sm-2 col-xs-4">
			Nº: Pro.<input id="n_pro" class="form-control">
		</div>
		<div class="col-sm-2 col-xs-4">
			Nº: Apo.<input id="n_apo" class="form-control">
		</div>
		<div class="col-sm-2 col-xs-4">
			Nº: End.<input id="n_end" class="form-control">
		</div>
		<div class="col-sm-2 col-xs-12 text-center">
			<div class="radio">
				<label>
					<input class="radiobox style-0" type="radio" name="st" id="st" value="1" checked="checked">
					<span title='Proposta' class='label bg-color-pink font-xs text-center'>&nbsp;PROPOSTA&nbsp;</span>
				</label>
			</div><div class="radio">
				<label>
					<input class="radiobox style-0" type="radio" name="st" id="st" value="2">
					<span title='Apólice' class='label bg-color-magenta font-xs text-center'>&nbsp;APÓLICE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				</label>
			</div>
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px;">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			Descrição<input id="item" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-6">
			Placa<input id="placa" class="form-control">
		</div>
		<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
			Chassi<input id="chassi" class="form-control">
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
			Ano Fabric.<input id="ano_fab" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
			Ano Modelo<input id="ano_mod" class="form-control">
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			Combustivel<input id="combustivel" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
			Ini. Vig<input id="from" class="form-control datepicker">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
			Fim. Vig<input id="to" class="form-control datepicker">
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px">
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			Ramo<select id="ramo" class="form-control">
				<option value="0" valor="0" comissao="1">NENHUM RAMO SELECIONADO</option>
			</select>
		</div>
		<div class="col-sm-3 col-xs-12">
			Produtor<select class="form-control" id="produtor">
				<option value="0">NENHUM PRODUTOR SELECIONADO</option>
			</select>
		</div>
		<div class="col-sm-3 col-xs-12">
			Seguradora<select class="form-control" id="seguradora">
				<option value="0">NENHUMA SEGURADORA SELECIONADO</option>
			</select>
		</div>
		<div class="col-sm-3 col-xs-12">
			Empresa<select class="form-control" id="empresa">
				<option value="0">NENHUMA EMPRESA SELECIONADA</option>
			</select>
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px">
		<div class="col-sm-2 col-xs-12">
			DT. Fatura<input class="form-control datepicker" id="dt_fatura" data-dateformat="dd/mm/yy" value="<?php echo date('d/m/Y');?>"/>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-4">
			Qt. Parc.<input id="qtd_parcela" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-8">
			Vlr. Parc.<input id="vlr_parcela" class="form-control">
		</div>
		<div class="col-sm-3 col-xs-9">
			Form. Pag.<select class="form-control" id="pagamento">
				<option value="0">NENHUMA FORMA DE PAGAMENTO INFORMADA</option>
			</select>
		</div>
		<div class="col-sm-1 col-xs-3">
			Parc.<input class="form-control" id="parc"/>
		</div>
		<div class="col-sm-3 col-xs-12 text-align-center">
			Percentual de Repasse<br>
			<label class="label label-primary font-md" style="top:7px;position:relative; height: 40px;" id="perc_repasse">0%</label>
		</div>
	</div>
	<div class="row" style="margin-bottom: 5px" id="form-pagamentos">
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-7">
			Prêmio Total<input id="pr_total" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-5">
			IOF<input id="iof" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-7">
			Prêmio Líquido<input id="pr_liquido" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-5">
			Comiss. %<input id="comissao" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
			Comissão R$<input id="comissao_bruta" class="form-control">
		</div>
		<div class="col-sm-2 col-xs-12">
			Repasse <span id="l_repasse"></span><input class="form-control" id="repasse"/>
		</div>
	</div>
	<div class="row" id="form-obs">
		<div class="col-sm-12">
			<div class="clearfix">
				Observações:
				<textarea class="form-control" name="obs" id="obs" style="width:100%"></textarea>
			</div>
		</div>
	</div>
	<div class="row hidden text-primary" style="margin-bottom: 5px" id="form-cancelamentos">
		<div class="col-xs-12">
			<h3 class="">INFORMAÇÕES DE ENDOSSO / CANCELAMENTO</h3>
		</div>
		<div class="col-xs-12 text-align-left">
			<div class="radio">
				<label>
					<input class="radiobox style-0" type="radio" name="tptp" id="tptp" value="2" checked="checked">
					<span title='Endosso' class='label label-warning font-xs text-center'>&nbsp;ENDOSSO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				</label>
			</div><div class="radio">
				<label>
					<input class="radiobox style-0" type="radio" name="tptp" id="tptp" value="4">
					<span title='Cancelamento' class='label bg-color-redLight font-xs text-center'>&nbsp;CANCELAMENTO&nbsp;&nbsp;</span>
				</label>
			</div>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-7">
			Prêmio Total<input id="can_pr_total" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-5">
			IOF<input id="can_iof" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-7">
			Prêmio Líquido<input id="can_pr_liquido" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-5">
			Comiss. %<input id="can_comissao" class="form-control">
		</div>
		<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">
			Comissão R$<input id="can_comissao_bruta" class="form-control">
		</div>
		<div class="col-sm-2 col-xs-12">
			Repasse <span id="can_l_repasse"></span><input class="form-control" id="can_repasse"/>
		</div>
	</div>
	<!--<div class="row">
		<div class="col-sm-6 col-xs-12  font-md">
			Tipo de Pagamento:
			<div class="radio">
				<label>
					<input class="radiobox style-0" type="radio" name="tppag" id="tppag" value="1">
					<span title='SEGURADORA' class='label label-primary text-center'>&nbsp;SEGURADORA&nbsp;</span>
				</label>
			</div><div class="radio">
				<label>
					<input class="radiobox style-0" type="radio" name="tppag" id="tppag" value="2">
					<span title='FINANCIADO' class='label bg-color-red text-center'>&nbsp;FINANCIADO&nbsp;&nbsp;&nbsp;&nbsp;</span>
				</label>
			</div>
		</div>
	</div>-->
</div>
<br>
<div class="row">
	<div class="col-sm-12 center">
		<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
		<a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
		<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
		<a href="javascript:void(0);" id="cancelamento" class="btn btn-sm btn-primary hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CANCELAR PROPOSTA</a>
		<a href="javascript:void(0);" id="end_can" class="btn btn-sm btn-primary hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>ENDOSSO / CANCELAMENTO</a>
		<a href="javascript:void(0);" id="end_alt" class="btn btn-sm btn-info hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>ENDOSSO / ALTERAÇÃO</a>
		<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
		<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
		<a href="javascript:void(0);" id="salvar2" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CONFIRMAR</a>
		<a href="javascript:void(0);" id="salvar3" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CONFIRMAR</a>
		<a href="javascript:void(0);" id="salvar4" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CONFIRMAR</a>

	</div>
</div>
<script>
	var timer;
	var x;


	$("#novoApolice").find("#to,#from,#dt_fatura").datepicker({
		autoclose: true,
		todayHighlight: true,
		dateFormat: 'dd/mm/yy',
		prevText: '<i class="fa fa-chevron-left"></i>',
		nextText: '<i class="fa fa-chevron-right"></i>',
		language: 'pt-BR',
		currentText: 'Hoje',
		monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
			'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
			'Jul','Ago','Set','Out','Nov','Dez'],
		dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
		dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
		dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab']
	});
	$(document).on("focus", "#to,#from,#dt_fatura", function () {
		$(this).mask("00/00/0000");
	});
	// aplicando mascaras
	$('input[id="can_pr_liquido"],input[id="can_pr_total"],input[id="can_iof"],input[id="can_comissao_bruta"],input[id="pr_liquido"],input[id="pr_total"],input[id="iof"],input[id="comissao_bruta"],input[id="vlr_parcela"]').maskMoney({prefix:'R$ ', allowNegative: true, thousands:'', decimal:',', affixesStay: false});
	$('input[id="can_comissao"],input[id="comissao"]').maskMoney({thousands:'', decimal:',', affixesStay: false,suffix:' %'});

	$("#ano_mod,#ano_fab").mask('0000');



</script>
<?php
	if(isset($_POST['id'])){
		@$id = $_POST['id'];
		?>
		<script>
			loading('show');
			// desabilita todos campos de entrada
			$("#novoApolice").find("input,textarea,select").each(function(){
				$(this).attr("disabled","disabled");
			});

			//mostra botões ocultos;
			$("#editar, #excluir").removeClass("hidden");

			//oculta botões;
			$("#cadastrar").addClass("hidden");

			//busca campos no banco;
			$.post("server/recupera2.php",{tabela:'select pessoa.id as cli_id, pessoa.nome,pessoa.cpf,apolice.id as id,apolice.financeiro as financeiro, apolice.tppag as tppag, apolice.ban_id as ban_id, apolice.situacao, apolice.dt_fatura,apolice.item, apolice.porcentagem, apolice.placa, apolice.chassi, apolice.ano_fab, apolice.ano_mod, apolice.combustivel, apolice.dt_start, apolice.dt_end, apolice.qtd_parcel,apolice.parc, apolice.pr_total, apolice.iof, apolice.pr_liquido, apolice.comissao, apolice.comissao_bruta, apolice.repasse, apolice.seg_id, apolice.pro_id, apolice.emp_id, apolice.ram_id, apolice.pag_id, apolice.obs as obs, apolice.tipo,apolice.status, apolice.n_pro, apolice.n_apo from apolice,pessoa where apolice.cli_id = pessoa.id and apolice.id = <?php echo $id;?>'}).done(function(data){
				var obj = JSON.parse(data);
				obj = obj[0];
				if(obj.status == 2){
					$("#cancelamento").addClass('hidden');
					$("#end_can,#end_alt").removeClass('hidden');
				}else{
					$("#end_can,#end_alt").addClass('hidden');
					$("#cancelamento").removeClass('hidden');
				};



				if(obj.tipo == 4){
					$("#cancelamento,#end_alt,#end_can").addClass('hidden');
				}else if(obj.tipo == 5){
					$("#cancelamento,#end_alt,#end_can,#editar,#excluir").addClass('hidden');
				};

				$("#novoApolice").find("#nome").html('<i class="ace-icon glyphicon glyphicon-user"></i><span id="status" tipo="'+obj.tipo+'" retorno="'+obj.cli_id+'" valor="'+obj.status+'" situacao="'+obj.situacao+'">'+obj.nome +'</span>');
				$("#novoApolice").find("#cpf").html('<b>CPF / CNPJ : </b>'+obj.cpf);
				$("#novoApolice").find("#n_pro").val(obj.n_pro);
				$("#novoApolice").find("#n_apo").val(obj.n_apo);
				$("#novoApolice").find("#item").val(obj.item);
				$("#novoApolice").find("#item").val(obj.item);
				$("#novoApolice").find("#placa").val(obj.placa);
				$("#novoApolice").find("#chassi").val(obj.chassi);
				$("#novoApolice").find("#ano_fab").val(obj.ano_fab);
				$("#novoApolice").find("#ano_mod").val(obj.ano_mod);
				$("#novoApolice").find("#combustivel").val(obj.combustivel);
				$("#novoApolice").find("#from").val(obj.dt_start.substr(8,2)+"/"+obj.dt_start.substr(5,2)+"/"+obj.dt_start.substr(0,4));
				$("#novoApolice").find("#to").val(obj.dt_end.substr(8,2)+"/"+obj.dt_end.substr(5,2)+"/"+obj.dt_end.substr(0,4));

				$("#novoApolice").find("#dt_fatura").val(obj.dt_fatura.substr(8,2)+"/"+obj.dt_fatura.substr(5,2)+"/"+obj.dt_fatura.substr(0,4));

				$.post("server/recupera.php",{tabela:'empresa'}).done(function(data){
					var obj2 = JSON.parse(data);
					for(i in obj2){
						if(obj2[i].id == obj.emp_id){
							$("#novoApolice").find("#empresa").append('<option selected bancos="'+obj2[i].bancos+'" value="'+obj2[i].id+'">'+obj2[i].razao.toUpperCase()+'</option>');
						}else{
							$("#novoApolice").find("#empresa").append('<option bancos="'+obj2[i].bancos+'" value="'+obj2[i].id+'">'+obj2[i].razao.toUpperCase()+'</option>');
						}
					};
					$.post("server/recupera.php",{tabela:'pessoa where seg = 1'}).done(function(data){
						var obj2 = JSON.parse(data);
						for(i in obj2){
							if(obj2[i].id == obj.seg_id){
								$("#novoApolice").find("#seguradora").append('<option selected valor="'+obj2[i].comissao+'" value="'+obj2[i].id+'">'+obj2[i].nome.toUpperCase()+'</option>');
							}else{
								$("#novoApolice").find("#seguradora").append('<option valor="'+obj2[i].comissao+'" value="'+obj2[i].id+'">'+obj2[i].nome.toUpperCase()+'</option>');
							}
						};
					});
					$.post("server/recupera.php",{tabela:'pessoa where produtor = 1'}).done(function(data){
						var obj2 = JSON.parse(data);
						for(i in obj2){
							if(obj2[i].id == obj.pro_id) {
								$("#novoApolice").find("#produtor").append('<option selected comissao="'+obj2[i].comissao+'" valor="'+obj2[i].repasse1+'" especial="'+obj2[i].especial+'" value="'+obj2[i].id+'">'+obj2[i].nome.toUpperCase()+'</option>');
							}else{
								$("#novoApolice").find("#produtor").append('<option comissao="'+obj2[i].comissao+'" valor="'+obj2[i].repasse1+'" especial="'+obj2[i].especial+'" value="'+obj2[i].id+'">'+obj2[i].nome.toUpperCase()+'</option>');
							}
						};
						$("#novoApolice").find("#qtd_parcela").val(obj.qtd_parcel);
						$("#novoApolice").find("#parc").val(obj.parc);
						$("#novoApolice").find("#vlr_parcela").val(parseFloat(parseFloat(obj.pr_total).toFixed(2) / parseInt(obj.qtd_parcel)).toFixed(2));
						$("#novoApolice").find("#pr_total").val(obj.pr_total);
						$("#novoApolice").find("#iof").val(obj.iof);
						$("#novoApolice").find("#pr_liquido").val(obj.pr_liquido);
						$("#novoApolice").find("#comissao").val(obj.comissao);
						$("#novoApolice").find("#repasse").val(obj.repasse);
						$("#novoApolice").find("#can_pr_total").val(obj.pr_total);
						$("#novoApolice").find("#can_iof").val(obj.iof);
						$("#novoApolice").find("#can_pr_liquido").val(obj.pr_liquido);
						$("#novoApolice").find("#can_comissao").val(obj.comissao);
						$("#novoApolice").find("#can_comissao_bruta").val(obj.comissao_bruta);
						$("#novoApolice").find("#can_repasse").val(obj.repasse);
						$("#novoApolice").find("#can_repasse").attr('porcentagem',obj.porcentagem);
						$("#novoApolice").find("#perc_repasse").text(obj.porcentagem+"%");
						$("#novoApolice").find("#repasse").attr('porcentagem',obj.porcentagem);
						$("#novoApolice").find("#comissao_bruta").val(obj.comissao_bruta);
						loading('hide');
					});
				});
				$.post("server/recupera.php",{tabela:'pagamento'}).done(function(data){
					var obj2 = JSON.parse(data);
					for(i in obj2){
						if(obj2[i].id == obj.pag_id){
							$("#novoApolice").find("#pagamento").append('<option selected taxa="'+obj2[i].taxa+'" condicao="'+obj2[i].condicao+'" value="'+obj2[i].id+'">'+obj2[i].nome.toUpperCase()+'</option>');

						}else{
							$("#novoApolice").find("#pagamento").append('<option taxa="'+obj2[i].taxa+'" condicao="'+obj2[i].condicao+'" value="'+obj2[i].id+'">'+obj2[i].nome.toUpperCase()+'</option>');

						}
					};
				});
				$.post("server/recupera.php",{tabela:'ramo'}).done(function(data){
					var obj2 = JSON.parse(data);
					for(i in obj2){
						if(obj2[i].id == obj.ram_id){
							$("#novoApolice").find("#ramo").append('<option selected value="'+obj2[i].id+'">'+obj2[i].nome.toUpperCase()+'</option>');

						}else{
							$("#novoApolice").find("#ramo").append('<option value="'+obj2[i].id+'">'+obj2[i].nome.toUpperCase()+'</option>');

						}
					};
				});

				$("#novoApolice").find("#obs").val(obj.obs);
				var tipo;
				if(obj.tipo == '1'){
					tipo = '<span title="Novo" class="label bg-color-blueLight font-sm text-center">NOVO</span>';
				}
				else if(obj.tipo == '2'){
					tipo = '<span title="Endosso" class="label bg-color-orange font-sm text-center">ENDOSSO</span>';
				}
				else if(obj.tipo == '3'){
					tipo = '<span title="Renovação" class="label  bg-color-blue  font-sm text-center">RENOVAÇÃO</span>';
				}
				else if(obj.tipo == '4'){
					tipo = '<span title="Cancelamento" class="label bg-color-redLight font-sm text-center">CANCELAMENTO</span>';
				}
				else if(obj.tipo == '5'){
					tipo = '<span title="Inativa" class="label bg-color-blueLight font-sm text-center">INATIVA</span>';
				}
				$("#novoApolice").find("#tipo").html('<b>TIPO: </b>'+tipo);
				$("#novoApolice").find("input:radio[name='st'][value='"+obj.status+"']").attr("checked",true);
				$("#novoApolice").find("input:radio[name='tppag'][value='"+obj.tppag+"']").attr("checked",true);
				$("#novoApolice").find("input:radio[name='financeiro'][value='"+obj.financeiro+"']").attr("checked",true);
				var tp_comissao    = $("#novoApolice").find("#produtor option:selected").attr("comissao");
				var comissao_bruta = parseFloat($("#comissao_bruta").val().replace("R$ ","").replace(",",".")).toFixed(2);
				if(comissao_bruta == 0){
					comissao_bruta = parseFloat(parseFloat($("#novoApolice").find("#pr_liquido").val()) / parseFloat($("#novoApolice").find("#comissao").val())).toFixed(2);
					$("#novoApolice").find("#comissao_bruta").val(comissao_bruta);
				}

			});

			//editando formulário
			$("#editar").click(function(){
				//Liberar campos pra edição
				$("#novoApolice").find("input,textarea,select").each(function(){
					$(this).removeAttrs("disabled");
				});

				//esconde botões
				$("#excluir,#editar,#cancelamento,#end_alt,#end_can").addClass("hidden");

				//aparece botões
				$("#salvar,#cancelar").removeClass("hidden");

				//desabilita alguns campos
				$("#novoApolice").find("#repasse,#pr_liquido,#vlr_parcela,#comissao_bruta").attr("disabled",true);

				var condicao       = $("#pagamento option:selected").attr('condicao');
				if(condicao == 2){
					$("#parc").removeAttr("disabled");
				}else{
					$("#parc").attr("disabled",true);
				};

				if($('input[name="financeiro"]:checked').val() == 1){
					$('input[name="financeiro"]').attr('disabled',true);
				}

				//$("#repasse").val(parseFloat(tt).toFixed(2));

				//desabilita campos que não podem ser alterados;
				if($("#status").attr('valor') == 2){
					$("#n_pro,#placa,#chassi,#ano_fab,#ano_mod,#combustivel,#vigencia,#pr_liquido,#iof,#pr_total,#comissao_bruta,#st,#qtd_parcela").attr("disabled",true);
				}

				//focar no primeiro campo
				$("#novoApolice").find(':text,:radio,:checkbox,select,textarea').each(function(){
					if(!this.readOnly && !this.disabled &&
						$(this).parentsUntil('form', 'div').css('display') != "none") {
						this.focus();  //Dom method
						this.select(); //Dom method
						return false;
					}
				});
			});

			//excluindo item
			$("#excluir").click(function(){
				var nome = $("#item").val();
				confirma("ATENÇÃO","Você deseja excluir este item?<br><?php echo $id;?>: " + nome,function(){
					$.ajax({
						url: 'server/apolice.php',
						type: 'POST',
						cache: false,
						data: {funcao:3,id:"<?php echo $id;?>"},
						success: function(data) {
							if(data == 1){
								alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								$.ajax({
									url: 'ajax/impPropostas.php',
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
				loading('show');
				$.post("ajax/cad<?php echo $tabela;?>.php",{id:<?php echo $id;?>}).done(function(data){
					$("#cadastro").empty().html(data);

				}).fail(function(){
					loading('hide');
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
			});

			//salvando edição
			$("#salvar").click(function(){
				var cli_id 		= $("#novoApolice").find("#status").attr('retorno');
				var tipo   	 	= $("#novoApolice").find("#status").attr('tipo');
				var situacao	= $("#novoApolice").find("#status").attr('situacao');
				enviar(2,cli_id,situacao,tipo);
			});

			// confirma cancelamento de proposta
			$("#salvar2").click(function(){
				var cli_id 		= $("#novoApolice").find("#status").attr('retorno');
				var situacao	= $("#novoApolice").find("#status").attr('situacao');
				confirma("Deseja cancelar esta proposta?","",function(){
					cancelamentoProposta(2,cli_id,situacao,4);
					setTimeout(function(){
						confirma("Gostaria de gerar algum valor de improdutividade referente à esta proposta?","Caso sim, será criado um título negativo referente ao valor de improdutividade, que será descontado do produtor/corretor.",function(){

						});
					},1000);
				});
			});

			//
			$("#salvar3").click(function(){
				var cli_id 		= $("#novoApolice").find("#status").attr('retorno');
				var tipo   	 	= $("#novoApolice").find("#status").attr('tipo');
				var situacao	= $("#novoApolice").find("#status").attr('situacao');
				confirma("Deseja cancelar esta proposta?","",function(){
					cancelamentoProposta(3,cli_id,situacao,5);
					cancelamentoProposta(4,cli_id,situacao,2);
				});
			});

			// confirma cancelamento de proposta
			$("#salvar4").click(function(){
				var cli_id 		= $("#novoApolice").find("#status").attr('retorno');
				var situacao	= $("#novoApolice").find("#status").attr('situacao');
				confirma("Deseja cancelar esta apólice?","",function(){
					//cancelamentoProposta(3,cli_id,situacao,4);
					//endossoCancelamento(2,cli_id,situacao,4);
				});
			});

			$("#end_can").click(function(){
				$("#novoApolice").find("input,textarea,select").each(function(){
					$(this).prop("disabled",false);
				});

				//esconde botões
				$("#excluir,#editar,#cancelamento,#end_can,#end_alt").addClass("hidden");

				//aparece botões
				$("#salvar4,#cancelar,#form-cancelamentos").removeClass("hidden");

				//desabilita alguns campos
				$("#novoApolice").find("#ramo,#produtor,#seguradora,#pr_total,#iof,#repasse,#pr_liquido,#comissao_bruta,#can_comissao_bruta,#can_repasse,#can_pr_liquido,#can_comissao").prop("disabled",true);

				var condicao       = $("#pagamento option:selected").attr('condicao');


				if($('input[name="financeiro"]:checked').val() == 1){
					$('input[name="financeiro"]').attr('disabled',true);
				}

				//$("#repasse").val(parseFloat(tt).toFixed(2));



				//focar no primeiro campo
				$("#novoApolice").find(':text,:radio,:checkbox,select,textarea').each(function(){
					if(!this.readOnly && !this.disabled &&
						$(this).parentsUntil('form', 'div').css('display') != "none") {
						this.focus();  //Dom method
						this.select(); //Dom method
						return false;
					}
				});
				$("#novoApolice").find('#status').attr('tipo','4');
				$("#excluir,#editar,#cancelamento,#end_can,#end_can").addClass("hidden");
			});

			$("#end_alt").click(function(){
				$("#novoApolice").find("input,textarea,select").each(function(){
					$(this).prop("disabled",true);
				});

				//esconde botões
				$("#excluir,#editar,#cancelamento,#end_can,#end_alt").addClass("hidden");

				//aparece botões
				$("#salvar3,#cancelar").removeClass("hidden");

				//desabilita alguns campos
				$("#novoApolice").find("#to,#from,#obs,#item,#placa,#chassi,#ano_fab,#ano_mod,#combustivel,#ramo").prop("disabled",false);

				$("#novoApolice").find("#pr_liquido,#pr_total,#iof,#comissao,#comissao_bruta,#repasse,#vlr_parcela").val(0);

				var condicao       = $("#pagamento option:selected").attr('condicao');


				//focar no primeiro campo
				$("#novoApolice").find(':text,:radio,:checkbox,select,textarea').each(function(){
					if(!this.readOnly && !this.disabled &&
						$(this).parentsUntil('form', 'div').css('display') != "none") {
						this.focus();  //Dom method
						this.select(); //Dom method
						return false;
					}
				});
				$("#novoApolice").find('#status').attr('tipo','4');
				$("#excluir,#editar,#cancelamento,#end_can,#end_can").addClass("hidden");
			});

			$("#cancelamento").click(function(){
				$("#novoApolice").find("input,textarea,select").each(function(){
					$(this).removeAttrs("disabled");
				});

				//esconde botões
				$("#excluir,#editar,#cancelamento,#end_can,#end_alt").addClass("hidden");

				//aparece botões
				$("#salvar2,#cancelar").removeClass("hidden");

				//desabilita alguns campos
				$("#novoApolice").find("#repasse,#pr_liquido,#vlr_parcela,#comissao_bruta").attr("disabled",true);

				var condicao       = $("#pagamento option:selected").attr('condicao');
				if(condicao == 2){
					$("#parc").removeAttr("disabled");
				}else{
					$("#parc").attr("disabled",true);
				};

				if($('input[name="financeiro"]:checked').val() == 1){
					$('input[name="financeiro"]').attr('disabled',true);
				}

				//$("#repasse").val(parseFloat(tt).toFixed(2));

				//desabilita campos que não podem ser alterados;
				if($("#status").attr('valor') == 2){
					$("#n_pro,#placa,#chassi,#ano_fab,#ano_mod,#combustivel,#vigencia,#pr_liquido,#comissao,#comissao_bruta,#st,#qtd_parcela").attr("disabled",true);
				}

				//focar no primeiro campo
				$("#novoApolice").find(':text,:radio,:checkbox,select,textarea').each(function(){
					if(!this.readOnly && !this.disabled &&
						$(this).parentsUntil('form', 'div').css('display') != "none") {
						this.focus();  //Dom method
						this.select(); //Dom method
						return false;
					}
				});
				$("#novoApolice").find('#status').attr('tipo','4');
				$("#excluir,#editar,#cancelamento,#end_can,#end_can").addClass("hidden");
			});
		</script>
		<?php
	}else{
		if(isset($_POST['cli_id'])){
			$cli_id = $_POST['cli_id'];
			?>
			<script>
				// buscando cliente
				$.post("server/recupera.php",{tabela:'pessoa where cliente = 1 and id = <?php echo @$cli_id;?>'}).done(function(data){
					var obj = JSON.parse(data);
					for(i in obj){
						$("#novoApolice").find('input[id="cli_id"]').attr('retorno',obj[i].id);
						$("#novoApolice").find('input[id="cli_id"]').val(obj[i].nome);
					}
				});

				//desabilitando o campo do cliente
				$("#novoApolice").find('#cli_id').attr('disabled',true);
			</script>
			<?php
		}
		?>
		<script>

			$.post("server/recupera.php",{tabela:'pagamento order by nome'}).done(function(data){
				var obj = JSON.parse(data);
				for(i in obj){
					if(obj[i].id == 2){
						$("#novoApolice").find("#pagamento").append('<option selected taxa="'+obj[i].taxa+'" condicao="'+obj[i].condicao+'" value="'+obj[i].id+'">'+obj[i].nome.toUpperCase()+'</option>');
					}else{
						$("#novoApolice").find("#pagamento").append('<option taxa="'+obj[i].taxa+'" condicao="'+obj[i].condicao+'" value="'+obj[i].id+'">'+obj[i].nome.toUpperCase()+'</option>');
					}
				}
			});
			$.post("server/recupera.php",{tabela:'ramo order by nome'}).done(function(data){
				var obj = JSON.parse(data);
				for(i in obj){
					$("#novoApolice").find("#ramo").append('<option value="'+obj[i].id+'">'+obj[i].nome.toUpperCase()+'</option>');
				}
			});

			$.post("server/recupera.php",{tabela:'empresa order by razao'}).done(function(data){
				var obj = JSON.parse(data);
				for(i in obj){
					$("#novoApolice").find("#empresa").append('<option bancos="'+obj[i].bancos+'" value="'+obj[i].id+'">'+obj[i].razao.toUpperCase()+'</option>');
				}
			});

			$.post("server/recupera.php",{tabela:'pessoa where seg = 1 order by nome'}).done(function(data){
				var obj = JSON.parse(data);
				for(i in obj){
					$("#novoApolice").find("#seguradora").append('<option valor="'+obj[i].comissao+'" value="'+obj[i].id+'">'+obj[i].nome.toUpperCase()+'</option>');
				}
			});

			$.post("server/recupera.php",{tabela:'pessoa where produtor = 1 order by nome'}).done(function(data){
				var obj = JSON.parse(data);
				for(i in obj){
					$("#novoApolice").find("#produtor").append('<option comissao="'+obj[i].comissao+'" valor="'+obj[i].repasse1+'" especial="'+obj[i].especial+'" value="'+obj[i].id+'">'+obj[i].nome.toUpperCase()+'</option>');
				}
			});
			//salvando nova apolice
			$("#cadastrar").click(function(){
				var cli_id = $("#novoApolice").find('#cli_id').attr('retorno');
				var tipo   = $("#novoApolice").find("#tp option:selected").val();
				enviar(1,cli_id,0,tipo);
			});
		</script>
		<?php
	}
?>
<script>



	//desabilitando campos
	$("#novoApolice").find("#repasse,#comissao_bruta,#pr_liquido,#vlr_parcela").attr("disabled",true);

	//evento ao mudar a forma de pagamento libera a quantidade
	$("#pagamento").change(function(){
		var condicao       = $("#pagamento option:selected").attr('condicao');
		if(condicao == 2){
			$("#parc").removeAttr("disabled");
		}else{
			$("#parc").attr("disabled",true);
		};
	});

	//evento para controlar calculo do repasse
	$("#produtor,#seguradora,#ramo").change(function(){



		var tp_comissao    = $("#novoApolice").find("#produtor option:selected").attr("comissao");
		var comissao_bruta = parseFloat($("#comissao_bruta").val().replace("R$ ","").replace(",",".")).toFixed(2);

		//teste
		/*if(comissao_bruta == 0){
			comissao_bruta = parseFloat(parseFloat($("#novoApolice").find("#pr_liquido").val()) / parseFloat($("#novoApolice").find("#comissao").val())).toFixed(2);
			$("#novoApolice").find("#comissao_bruta").val(comissao_bruta);
		}*/
		if(tp_comissao == 1){
			var repasse        = parseFloat($("#novoApolice").find("#produtor option:selected").attr("valor")).toFixed(2);
			var tt             = comissao_bruta * repasse / 100;
			if(isNaN(tt)){
				tt = 0.00
			}
			$("#repasse").val(parseFloat(tt).toFixed(2));
			$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
			$("#novoApolice").find("#perc_repasse").text(parseFloat($("#novoApolice").find("#produtor option:selected").attr("valor")).toFixed(2)+"%");
		}else{
			if($("#novoApolice").find("#seguradora option:selected").val() != 0 && $("#novoApolice").find("#ramo option:selected").val() != 0 && $("#novoApolice").find("#produtor option:selected").val() != 0){
				$.post('server/recupera.php',{tabela:"tabelaRepasse where (seg_id = '"+$("#novoApolice").find("#seguradora option:selected").val()+"' and ram_id = '"+$("#novoApolice").find("#ramo option:selected").val()+"') limit 1"}).done(function(data){
					var obj = JSON.parse(data);
					if(obj.length == 1){
						var repasse = obj[0].repasse;
						var tt             = comissao_bruta * repasse / 100;
						if(isNaN(tt)){
							tt = 0.00
						}
						$("#repasse").val(parseFloat(tt).toFixed(2));
						$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
						$("#novoApolice").find("#perc_repasse").text(repasse+"%");
					}else{
						$.post('server/recupera.php',{tabela:"tabelaRepasse where (seg_id = '"+$("#novoApolice").find("#seguradora option:selected").val()+"' and ram_id = '"+999999+"') limit 1"}).done(function(data){
							var obj2 = JSON.parse(data);
							if(obj2.length == 1){
								var repasse = obj2[0].repasse;
								var tt             = comissao_bruta * repasse / 100;
								if(isNaN(tt)){
									tt = 0.00
								}
								$("#repasse").val(parseFloat(tt).toFixed(2));
								$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
								$("#novoApolice").find("#perc_repasse").text(repasse+"%");
							}else{
								$.post('server/recupera.php',{tabela:"tabelaRepasse where (ram_id = '"+$("#novoApolice").find("#ramo option:selected").val()+"' and seg_id = '"+999999+"') limit 1"}).done(function(data){
									var obj3 = JSON.parse(data);
									if(obj3.length == 1){
										var repasse = obj3[0].repasse;
										var tt             = comissao_bruta * repasse / 100;
										if(isNaN(tt)){
											tt = 0.00
										}
										$("#repasse").val(parseFloat(tt).toFixed(2));
										$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
										$("#novoApolice").find("#perc_repasse").text(repasse+"%");
									}else{
										$.post('server/recupera.php',{tabela:"tabelaRepasse where (seg_id = '"+999999+"' and ram_id = '"+999999+"') limit 1"}).done(function(data){
											var obj4 = JSON.parse(data);
											if(obj4.length == 1){
												var repasse = obj4[0].repasse;
												var tt             = comissao_bruta * repasse / 100;
												if(isNaN(tt)){
													tt = 0.00
												}
												$("#repasse").val(parseFloat(tt).toFixed(2));
												$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
												$("#novoApolice").find("#perc_repasse").text(repasse+"%");
											}else{

											}
										}).fail(function(){

										});
									}
								}).fail(function(){

								});
							}
						}).fail(function(){

						});
					}
				}).fail(function(){

				});
			}
		}

	});

	$("#novoApolice").find("#parc").keyup(function(){
		var parc  = $("#novoApolice").find("#parc").val();
		if(isNaN(parc) || parc == null || parc == "" || parc == 0){
			parc = 1;
			$("#novoApolice").find("#parc").val(parc);
			setTimeout(function(){
				$("#novoApolice").find("#parc").focus().select();
			},100);
		}
	});

	$("#novoApolice").find("#pr_total,#iof,#qtd_parcela").keyup(function(e){
		if(e.which == 13 || e.which == 8 || e.which == 9){
			if (x) { x = function(){};} // If there is an existing XHR, abort it.
			clearTimeout(timer); // Clear the timer so we don't end up with dupes.
			timer = setTimeout(function() { // assign timer a new timeout
				x = tabelaRepasse();
				// run ajax request and store in x variable (so we can cancel)
			}, 1000); // 2000ms delay, tweak for faster/slower
		}
	});

	$("#novoApolice").find("#comissao").keyup(function(e){
		tabelaRepasse();
		if (x) { x = function(){};} // If there is an existing XHR, abort it.
		clearTimeout(timer); // Clear the timer so we don't end up with dupes.
		timer = setTimeout(function() { // assign timer a new timeout
			x = tabelaRepasse();
			// run ajax request and store in x variable (so we can cancel)
		}, 1000);
	});

	$("#novoApolice").find("#can_pr_total,#can_iof,#qtd_parcela").keyup(function(e){
		if(e.which == 13 || e.which == 8 || e.which == 9){
			if (x) { x = function(){};} // If there is an existing XHR, abort it.
			clearTimeout(timer); // Clear the timer so we don't end up with dupes.
			timer = setTimeout(function() { // assign timer a new timeout
				x = tabelaRepasse2();
				// run ajax request and store in x variable (so we can cancel)
			}, 1000); // 2000ms delay, tweak for faster/slower
		}
	});

	$("#novoApolice").find("#can_comissao").keyup(function(e){
		tabelaRepasse();
		if (x) { x = function(){};} // If there is an existing XHR, abort it.
		clearTimeout(timer); // Clear the timer so we don't end up with dupes.
		timer = setTimeout(function() { // assign timer a new timeout
			x = tabelaRepasse2();
			// run ajax request and store in x variable (so we can cancel)
		}, 1000);
	});

	function tabelaRepasse(){
		var tt  = 0;
		var pr_total 		= parseFloat($("#novoApolice").find("#pr_total").val().replace("R$ ","").replace(",",".")).toFixed(2);
		if(isNaN(pr_total) || pr_total == null || pr_total == ""){
			pr_total = 0;
		}
		var qtd_parcela = parseInt($("#qtd_parcela").val());

		if(isNaN(qtd_parcela) || qtd_parcela == null || qtd_parcela == "" || qtd_parcela == 0){
			qtd_parcela = 1;
			$("#novoApolice").find("#qtd_parcela").val(qtd_parcela);
			setTimeout(function(){
				$("#novoApolice").find("#qtd_parcela").focus().select();
			},100);
		}

		var vlr_parcela = parseFloat(parseFloat(pr_total).toFixed(2) / qtd_parcela).toFixed(2);

		$("#vlr_parcela").val('R$ '+ parseFloat(vlr_parcela).toFixed(2));

		var iof				= parseFloat($("#novoApolice").find("#iof").val().replace("R$ ","").replace(",",".")).toFixed(2);
		if(isNaN(iof) || iof == null || iof == ""){
			iof = 0;
		}
		var pr_liquido 		= parseFloat(pr_total - iof).toFixed(2);
		$("#novoApolice").find("#pr_liquido").val("R$ "+pr_liquido.replace(".",","));

		var comissao 		= parseFloat($("#novoApolice").find("#comissao").val().replace(" %","").replace(",",".")).toFixed(2);
		if(isNaN(comissao) || comissao == null || comissao == ""){
			comissao = 0;
		}
		var comissao_bruta 	=  parseFloat((pr_liquido * parseFloat(comissao).toFixed(2)) / 100).toFixed(2);
		$("#novoApolice").find("#comissao_bruta").val("R$ "+comissao_bruta.replace(".",","));

		var tp_comissao     = $("#novoApolice").find("#produtor option:selected").attr("comissao");
		if(tp_comissao == 1){
			var repasse        = parseFloat($("#novoApolice").find("#produtor option:selected").attr("valor")).toFixed(2);
			comissao_bruta = parseFloat($("#comissao_bruta").val().replace("R$ ","").replace(",",".")).toFixed(2);
			tt             = comissao_bruta * repasse / 100;
			if(isNaN(tt)){
				tt = 0.00
			}
			$("#novoApolice").find("#repasse").val(parseFloat(tt).toFixed(2));
			$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
		}else{
			$.post('server/recupera.php',{tabela:"tabelaRepasse where (seg_id = '"+$("#novoApolice").find("#seguradora option:selected").val()+"' and ram_id = '"+$("#novoApolice").find("#ramo option:selected").val()+"') limit 1"}).done(function(data){
				var obj = JSON.parse(data);
				if(obj.length == 1){
					var repasse = obj[0].repasse;
					var tt             = comissao_bruta * repasse / 100;
					if(isNaN(tt)){
						tt = 0.00
					}
					$("#repasse").val(parseFloat(tt).toFixed(2));
					$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
				}else{
					$.post('server/recupera.php',{tabela:"tabelaRepasse where (ram_id = '"+$("#novoApolice").find("#ramo option:selected").val()+"' and seg_id = '"+999999+"') limit 1"}).done(function(data){
						var obj3 = JSON.parse(data);
						if(obj3.length == 1){
							var repasse = obj3[0].repasse;
							var tt             = comissao_bruta * repasse / 100;
							if(isNaN(tt)){
								tt = 0.00
							}
							$("#repasse").val(parseFloat(tt).toFixed(2));
							$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
						}else{
							$.post('server/recupera.php',{tabela:"tabelaRepasse where (seg_id = '"+999999+"' and ram_id = '"+999999+"') limit 1"}).done(function(data){
								var obj4 = JSON.parse(data);
								if(obj4.length == 1){
									var repasse = obj4[0].repasse;
									var tt             = comissao_bruta * repasse / 100;
									if(isNaN(tt)){
										tt = 0.00
									}
									$("#repasse").val(parseFloat(tt).toFixed(2));
									$("#novoApolice").find("#repasse").attr('porcentagem',repasse);
								}else{

								}
							}).fail(function(){

							});
						}
					}).fail(function(){

					});
				}
			}).fail(function(){

			});
		}
	};

	function tabelaRepasse2(){
		var tt  = 0;
		var pr_total 		= parseFloat($("#novoApolice").find("#can_pr_total").val().replace("R$ ","").replace(",",".")).toFixed(2);
		if(isNaN(pr_total) || pr_total == null || pr_total == ""){
			pr_total = 0;
		}
		var qtd_parcela = parseInt($("#qtd_parcela").val());

		if(isNaN(qtd_parcela) || qtd_parcela == null || qtd_parcela == "" || qtd_parcela == 0){
			qtd_parcela = 1;
			$("#novoApolice").find("#qtd_parcela").val(qtd_parcela);
			setTimeout(function(){
				$("#novoApolice").find("#qtd_parcela").focus().select();
			},100);
		}

		var vlr_parcela = parseFloat(parseFloat(pr_total).toFixed(2) / qtd_parcela).toFixed(2);

		$("#vlr_parcela").val('R$ '+ parseFloat(vlr_parcela).toFixed(2));

		var iof				= parseFloat($("#novoApolice").find("#can_iof").val().replace("R$ ","").replace(",",".")).toFixed(2);
		if(isNaN(iof) || iof == null || iof == ""){
			iof = 0;
		}
		var pr_liquido 		= parseFloat(pr_total - iof).toFixed(2);
		$("#novoApolice").find("#can_pr_liquido").val("R$ "+pr_liquido.replace(".",","));

		var comissao 		= parseFloat($("#novoApolice").find("#can_comissao").val().replace(" %","").replace(",",".")).toFixed(2);
		if(isNaN(comissao) || comissao == null || comissao == ""){
			comissao = 0;
		}
		var comissao_bruta 	=  parseFloat((pr_liquido * parseFloat(comissao).toFixed(2)) / 100).toFixed(2);
		$("#novoApolice").find("#can_comissao_bruta").val("R$ "+comissao_bruta.replace(".",","));

		var tp_comissao     = $("#novoApolice").find("#produtor option:selected").attr("comissao");
		if(tp_comissao == 1){
			var repasse        = parseFloat($("#novoApolice").find("#produtor option:selected").attr("valor")).toFixed(2);
			comissao_bruta = parseFloat($("#can_comissao_bruta").val().replace("R$ ","").replace(",",".")).toFixed(2);
			tt             = comissao_bruta * repasse / 100;
			if(isNaN(tt)){
				tt = 0.00
			}
			$("#novoApolice").find("#can_repasse").val(parseFloat(tt).toFixed(2));
			$("#novoApolice").find("#can_repasse").attr('porcentagem',repasse);
		}else{
			$.post('server/recupera.php',{tabela:"tabelaRepasse where (seg_id = '"+$("#novoApolice").find("#seguradora option:selected").val()+"' and ram_id = '"+$("#novoApolice").find("#ramo option:selected").val()+"') limit 1"}).done(function(data){
				var obj = JSON.parse(data);
				if(obj.length == 1){
					var repasse = obj[0].repasse;
					var tt             = comissao_bruta * repasse / 100;
					if(isNaN(tt)){
						tt = 0.00
					}
					$("#can_repasse").val(parseFloat(tt).toFixed(2));
					$("#novoApolice").find("#can_repasse").attr('porcentagem',repasse);
				}else{
					$.post('server/recupera.php',{tabela:"tabelaRepasse where (ram_id = '"+$("#novoApolice").find("#ramo option:selected").val()+"' and seg_id = '"+999999+"') limit 1"}).done(function(data){
						var obj3 = JSON.parse(data);
						if(obj3.length == 1){
							var repasse = obj3[0].repasse;
							var tt             = comissao_bruta * repasse / 100;
							if(isNaN(tt)){
								tt = 0.00
							}
							$("#can_repasse").val(parseFloat(tt).toFixed(2));
							$("#novoApolice").find("#can_repasse").attr('porcentagem',repasse);
						}else{
							$.post('server/recupera.php',{tabela:"tabelaRepasse where (seg_id = '"+999999+"' and ram_id = '"+999999+"') limit 1"}).done(function(data){
								var obj4 = JSON.parse(data);
								if(obj4.length == 1){
									var repasse = obj4[0].repasse;
									var tt             = comissao_bruta * repasse / 100;
									if(isNaN(tt)){
										tt = 0.00
									}
									$("#can_repasse").val(parseFloat(tt).toFixed(2));
									$("#novoApolice").find("#can_repasse").attr('porcentagem',repasse);
								}else{

								}
							}).fail(function(){

							});
						}
					}).fail(function(){

					});
				}
			}).fail(function(){

			});
		}
	};

	//funcao de envio
	function enviar(a,b,c,d){
		var funcao          = a;
		var id				= "<?php echo @$id;?>";
		var cli_id			= b;
		var situacao		= c;
		var tipo			= d;
		var status			= $("#novoApolice").find("input:radio[name='st']:checked").val();
		var item        	= $("#novoApolice").find("#item").val();
		var n_apo       	= $("#novoApolice").find("#n_apo").val();
		var n_pro        	= $("#novoApolice").find("#n_pro").val();
		var n_end        	= $("#novoApolice").find("#n_end").val();
		var cpf         	= $("#novoApolice").find("#cli_id").attr('cpf');
		var placa       	= $("#novoApolice").find("#placa").val();
		var chassi      	= $("#novoApolice").find("#chassi").val();
		var ano_fab     	= $("#novoApolice").find("#ano_fab").val();
		var ano_mod     	= $("#novoApolice").find("#ano_mod").val();
		var combustivel 	= $("#novoApolice").find("#combustivel").val();
		var dt_start    	= $("#novoApolice").find("#from").val();
		var dt_end      	= $("#novoApolice").find("#to").val();
		var qtd_parcela 	= $("#novoApolice").find("#qtd_parcela").val();
		var vlr_parcela 	= $("#novoApolice").find("#vlr_parcela").val().replace("R$ ","").replace(",",".");
		var pr_total    	= $("#novoApolice").find("#pr_total").val().replace("R$ ","").replace(",",".");
		var iof         	= $("#novoApolice").find("#iof").val().replace("R$ ","").replace(",",".");
		var pr_liquido  	= $("#novoApolice").find("#pr_liquido").val().replace("R$ ","").replace(",",".");
		var comissao    	= $("#novoApolice").find("#comissao").val().replace("R$ ","").replace(",",".");
		var comissao_bruta  = $("#novoApolice").find("#comissao_bruta").val().replace("R$ ","").replace(",",".");
		var repasse         = $("#novoApolice").find("#repasse").val();
		var porcentagem     = $("#novoApolice").find("#repasse").attr('porcentagem');
		var dt_fatura       = $("#novoApolice").find("#dt_fatura").val();
		var dt_emissao      = "<?php echo date('d/m/Y')?>";
		var parcela		    = $("#novoApolice").find("#parc").val();
		var obs 		    = $("#novoApolice").find("#obs").val();
		var ramo        	= $("#novoApolice").find("#ramo option:selected").val();
		var produtor 		= $("#novoApolice").find("#produtor option:selected").val();
		var seguradora 		= $("#novoApolice").find("#seguradora option:selected").val();
		var empresa 		= $("#novoApolice").find("#empresa option:selected").val();
		var pagamento 		= $("#novoApolice").find("#pagamento option:selected").val();
		var centrocusto		= 1;
		var natureza		= 5;
		var vigencia		= dt_start + " - " + dt_end;
		var tppag			= 1;
		//var tppag			= $("#tppag:checked").val();

		if(situacao == 1){
			situacao = 0;
		}

		if(cli_id.length == 0 || cli_id == 0 || cli_id == null || cli_id == "" || cli_id == undefined){
			alerta("CLIENTE NÃO SELECIONADO!","Favor selecionar um cliente","warning","warning");
		}
		else if(item.length <= 5 || item == "" || item == null){
			alerta("DESCRIÇÃO NÃO INFORMADA!","A descrição deve ser informada e conter mais de 5 caracteres!","warning","warning");
			$("#item").focus();
		}
		else if(ramo == 0){
			alerta("RAMO NÃO INFORMADO!","","warning","warning");
			$("#ramo").focus();
		}
		else if(vigencia.length == 0 || vigencia == null || vigencia == ""){
			alerta("VIGÊNCIA NÃO INFORMADA!","","warning","warning");
			$("#vigencia").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}else if(seguradora == 0){
			alerta("SEGURADORA NÃO INFORMADA!","","warning","warning");
			$("#seguradora").focus();
		}else if(empresa == 0 || empresa == '' || isNaN(empresa)){
			alerta("EMPRESA NÃO INFORMADA!","","warning","warning");
			$("#empresa").focus();
		}else if(pagamento == 0 || pagamento == '' || isNaN(pagamento)){
			alerta("PAGAMENTO NÃO INFORMADO!","","warning","warning");
			$("#empresa").focus();
		}else if(dt_fatura == "00/00/0000" || dt_fatura.length <= 0){
			alerta("Favor Informar a data de faturamento!","","warning","warning");
			$("#dt_fatura").focus().select();
		}else if(!tppag || tppag == null || tppag == undefined){
			alerta("Escolha um tipo de pagamento!","","warning","warning");
			$("#dt_fatura").focus().select();
		}else{

			if(pr_total.length == 0 || pr_total == null || pr_total == ""){
				var vlr_parcela 	= 0;
				var pr_total    	= 0;
				var iof         	= 0;
				var pr_liquido  	= 0;
				var comissao    	= 0;
				var comissao_bruta  = 0;
				var repasse         = 0;
			};

			if(comissao == 0 || comissao.length == 0 || isNaN(comissao) || comissao == null || comissao == undefined){
				comissao = 0;
			}

			if(repasse == null || isNaN(repasse) || repasse == undefined){
				repasse = 0;
			}
			loading("show");
			$.post("server/impApolice.php",{
				tipo:			funcao,
				emp_id:			empresa,
				id:				id,
				cli_id:			cli_id,
				seguradora:		seguradora,
				segurado:		cli_id,
				cpf:			cpf,
				seg_id:			seguradora,
				ram_id:			ramo,
				dt_fatura:  	dt_fatura,
				dt_emissao: 	dt_emissao,
				vigencia:   	dt_start + " - " + dt_end,
				type:       	tipo,
				item:			item,
				descricao:  	item,
				placa:			placa,
				chassi:			chassi,
				combustivel:    combustivel,
				iof:			iof,
				qtd_parcela:    qtd_parcela,
				parcela:		parcela,
				pr_liquido:		pr_liquido,
				pr_total:		pr_total,
				comissao:		comissao,
				comissao_bruta: comissao_bruta,
				ano_fab:		ano_fab,
				ano_mod:		ano_mod,
				n_apo:			n_apo,
				n_pro:			n_pro,
				n_end:			n_end,
				obs:			obs,
				status:			status,
				repasse:		repasse,
				porcentagem:	porcentagem,
				pro_id:			produtor,
				pag_id:			pagamento,
				situacao:		parseInt(situacao)+1,
				tppag:			tppag
			}).done(function(data){
				if(data != 0){
					if(tipo == 4){
						var obs         = "Estorno de comissão referente ao cancelamento da apólice de código interno nº: "+data+"!";
					}else{
						var obs         = "Repasse de comissão referente a apólice de código interno nº: "+data+"!";
					};
					if(status == 2){
						if(tppag == 1){
							$.post("server/financeiro.php",{
								funcao:11,
								cli_id:produtor,
								apo_id:data,
								dt_fat:dt_fatura,
								dt_baixa:"<?php echo date('d/m/Y H:i:s');?>",
								dt_cad:"<?php echo date('d/m/Y H:i:s');?>",
								dt_emi:"<?php echo date('d/m/Y H:i:s');?>",
								ban_id:1,
								pag_id:pagamento,
								cen_id:centrocusto,
								nat_id:natureza,
								emp_id:empresa,
								quant:parcela,
								porcentagem:porcentagem,
								pr_bruto:comissao_bruta,
								pr_liquido:repasse,
								tipo:1,
								type:tipo,
								obs:obs
							}).done(function(data){
								if(data != 0){
									alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								}else{
									alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
								}
								atualiza();



							});
							alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
						}else if(tppag == 2){
							$.post("server/financeiro.php",{
								funcao:11,
								cli_id:produtor,
								apo_id:data,
								dt_fat:dt_fatura,
								dt_baixa:"<?php echo date('d/m/Y H:i:s');?>",
								dt_cad:"<?php echo date('d/m/Y H:i:s');?>",
								dt_emi:"<?php echo date('d/m/Y H:i:s');?>",
								ban_id:1,
								pag_id:pagamento,
								cen_id:centrocusto,
								nat_id:natureza,
								emp_id:empresa,
								quant:parcela,
								porcentagem:porcentagem,
								pr_bruto:comissao_bruta,
								pr_liquido:repasse,
								tipo:1,
								type:tipo,
								obs:"Repasse de comissão referente a apólice de código interno nº: "+data+"!"
							}).done(function(data){
								if(data == 1){
									alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								}else{
									alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
								}
							});
							$.post("server/financeiro.php",{
								funcao:1,
								cli_id:seguradora,
								apo_id:data,
								dt_fat:dt_fatura,
								dt_baixa:"<?php echo date('d/m/Y H:i:s');?>",
								dt_cad:"<?php echo date('d/m/Y H:i:s');?>",
								dt_emi:"<?php echo date('d/m/Y H:i:s');?>",
								ban_id:1,
								pag_id:pagamento,
								cen_id:centrocusto,
								nat_id:natureza,
								emp_id:empresa,
								quant:qtd_parcel,
								pr_bruto:pr_liquido,
								pr_liquido:pr_liquido,
								tipo:1,
								obs:"Financeiro Gerado através da apólice: " + data + " financiada para o cliente, favor conferir o pagamento do cliente!"
							}).done(function(data){
								if(data != 0){
									alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								}else{
									alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
								}
								atualiza();
							});
							alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
						}
					}else{
						if(data != 0){
							alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
						}else{
							alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
						}

					}
				}else{
					alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
				}
				atualiza();
			}).fail(function(){
				alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
				atualiza();
			});
		}
	}

	function cancelamentoProposta(a,b,c,d){
		var funcao          = a;
		var id				= "<?php echo @$id;?>";
		var cli_id			= b;
		var situacao		= c;
		var tipo			= d;
		var status			= $("#novoApolice").find("input:radio[name='st']:checked").val();
		var item        	= $("#novoApolice").find("#item").val();
		var n_apo       	= $("#novoApolice").find("#n_apo").val();
		var n_pro        	= $("#novoApolice").find("#n_pro").val();
		var n_end        	= $("#novoApolice").find("#n_end").val();
		var cpf         	= $("#novoApolice").find("#cli_id").attr('cpf');
		var placa       	= $("#novoApolice").find("#placa").val();
		var chassi      	= $("#novoApolice").find("#chassi").val();
		var ano_fab     	= $("#novoApolice").find("#ano_fab").val();
		var ano_mod     	= $("#novoApolice").find("#ano_mod").val();
		var combustivel 	= $("#novoApolice").find("#combustivel").val();
		var dt_start    	= $("#novoApolice").find("#from").val();
		var dt_end      	= $("#novoApolice").find("#to").val();
		var qtd_parcela 	= $("#novoApolice").find("#qtd_parcela").val();
		var vlr_parcela 	= $("#novoApolice").find("#vlr_parcela").val().replace("R$ ","").replace(",",".");
		var pr_total    	= $("#novoApolice").find("#pr_total").val().replace("R$ ","").replace(",",".");
		var iof         	= $("#novoApolice").find("#iof").val().replace("R$ ","").replace(",",".");
		var pr_liquido  	= $("#novoApolice").find("#pr_liquido").val().replace("R$ ","").replace(",",".");
		var comissao    	= $("#novoApolice").find("#comissao").val().replace("R$ ","").replace(",",".");
		var comissao_bruta  = $("#novoApolice").find("#comissao_bruta").val().replace("R$ ","").replace(",",".");
		var repasse         = $("#novoApolice").find("#repasse").val();
		var porcentagem     = $("#novoApolice").find("#repasse").attr('porcentagem');
		var dt_fatura       = $("#novoApolice").find("#dt_fatura").val();
		var dt_emissao      = "<?php echo date('d/m/Y')?>";
		var parcela		    = $("#novoApolice").find("#parc").val();
		var obs 		    = $("#novoApolice").find("#obs").val();
		var ramo        	= $("#novoApolice").find("#ramo option:selected").val();
		var produtor 		= $("#novoApolice").find("#produtor option:selected").val();
		var seguradora 		= $("#novoApolice").find("#seguradora option:selected").val();
		var empresa 		= $("#novoApolice").find("#empresa option:selected").val();
		var pagamento 		= $("#novoApolice").find("#pagamento option:selected").val();
		var centrocusto		= 1;
		var natureza		= 5;
		var vigencia		= dt_start + " - " + dt_end;
		var tppag			= 1;
		//var tppag			= $("#tppag:checked").val();

		if(situacao == 1){
			situacao = 0;
		}

		if(cli_id.length == 0 || cli_id == 0 || cli_id == null || cli_id == "" || cli_id == undefined){
			alerta("CLIENTE NÃO SELECIONADO!","Favor selecionar um cliente","warning","warning");
		}
		else if(item.length <= 5 || item == "" || item == null){
			alerta("DESCRIÇÃO NÃO INFORMADA!","A descrição deve ser informada e conter mais de 5 caracteres!","warning","warning");
			$("#item").focus();
		}
		else if(ramo == 0){
			alerta("RAMO NÃO INFORMADO!","","warning","warning");
			$("#ramo").focus();
		}
		else if(vigencia.length == 0 || vigencia == null || vigencia == ""){
			alerta("VIGÊNCIA NÃO INFORMADA!","","warning","warning");
			$("#vigencia").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}else if(seguradora == 0){
			alerta("SEGURADORA NÃO INFORMADA!","","warning","warning");
			$("#seguradora").focus();
		}else if(empresa == 0 || empresa == '' || isNaN(empresa)){
			alerta("EMPRESA NÃO INFORMADA!","","warning","warning");
			$("#empresa").focus();
		}else if(pagamento == 0 || pagamento == '' || isNaN(pagamento)){
			alerta("PAGAMENTO NÃO INFORMADO!","","warning","warning");
			$("#empresa").focus();
		}else if(dt_fatura == "00/00/0000" || dt_fatura.length <= 0){
			alerta("Favor Informar a data de faturamento!","","warning","warning");
			$("#dt_fatura").focus().select();
		}else if(!tppag || tppag == null || tppag == undefined){
			alerta("Escolha um tipo de pagamento!","","warning","warning");
			$("#dt_fatura").focus().select();
		}else{

			if(pr_total.length == 0 || pr_total == null || pr_total == ""){
				var vlr_parcela 	= 0;
				var pr_total    	= 0;
				var iof         	= 0;
				var pr_liquido  	= 0;
				var comissao    	= 0;
				var comissao_bruta  = 0;
				var repasse         = 0;
			};

			if(comissao == 0 || comissao.length == 0 || isNaN(comissao) || comissao == null || comissao == undefined){
				comissao = 0;
			}

			if(repasse == null || isNaN(repasse) || repasse == undefined){
				repasse = 0;
			}
			loading("show");
			$.post("server/impApolice.php",{
				tipo:			funcao,
				emp_id:			empresa,
				id:				id,
				cli_id:			cli_id,
				seguradora:		seguradora,
				segurado:		cli_id,
				cpf:			cpf,
				seg_id:			seguradora,
				ram_id:			ramo,
				dt_fatura:  	dt_fatura,
				dt_emissao: 	dt_emissao,
				vigencia:   	dt_start + " - " + dt_end,
				type:       	tipo,
				item:			item,
				descricao:  	item,
				placa:			placa,
				chassi:			chassi,
				combustivel:    combustivel,
				iof:			iof,
				qtd_parcela:    qtd_parcela,
				parcela:		parcela,
				pr_liquido:		pr_liquido,
				pr_total:		pr_total,
				comissao:		comissao,
				comissao_bruta: comissao_bruta,
				ano_fab:		ano_fab,
				ano_mod:		ano_mod,
				n_apo:			n_apo,
				n_pro:			n_pro,
				n_end:			n_end,
				obs:			obs,
				status:			status,
				repasse:		repasse,
				porcentagem:	porcentagem,
				pro_id:			produtor,
				pag_id:			pagamento,
				situacao:		parseInt(situacao)+1,
				tppag:			tppag
			}).done(function(data){
				if(data != 0){
					alerta("Sucesso!","Proposta Cancelada com Sucesso!","success","check");
				}else{
					alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
				}
				atualiza();
			}).fail(function(){
				alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
				atualiza();
			});
		}
	}

	function endossoCancelamento(a,b,c,d){
		var funcao          = a;
		var id				= "<?php echo @$id;?>";
		var cli_id			= b;
		var situacao		= c;
		var tipo			= d;
		var status			= $("#novoApolice").find("input:radio[name='st']:checked").val();
		var item        	= $("#novoApolice").find("#item").val();
		var n_apo       	= $("#novoApolice").find("#n_apo").val();
		var n_pro        	= $("#novoApolice").find("#n_pro").val();
		var n_end        	= $("#novoApolice").find("#n_end").val();
		var cpf         	= $("#novoApolice").find("#cli_id").attr('cpf');
		var placa       	= $("#novoApolice").find("#placa").val();
		var chassi      	= $("#novoApolice").find("#chassi").val();
		var ano_fab     	= $("#novoApolice").find("#ano_fab").val();
		var ano_mod     	= $("#novoApolice").find("#ano_mod").val();
		var combustivel 	= $("#novoApolice").find("#combustivel").val();
		var dt_start    	= $("#novoApolice").find("#from").val();
		var dt_end      	= $("#novoApolice").find("#to").val();
		var qtd_parcela 	= $("#novoApolice").find("#qtd_parcela").val();
		var vlr_parcela 	= $("#novoApolice").find("#vlr_parcela").val().replace("R$ ","").replace(",",".");
		var pr_total    	= $("#novoApolice").find("#pr_total").val().replace("R$ ","").replace(",",".");
		var iof         	= $("#novoApolice").find("#iof").val().replace("R$ ","").replace(",",".");
		var pr_liquido  	= $("#novoApolice").find("#pr_liquido").val().replace("R$ ","").replace(",",".");
		var comissao    	= $("#novoApolice").find("#comissao").val().replace("R$ ","").replace(",",".");
		var comissao_bruta  = $("#novoApolice").find("#comissao_bruta").val().replace("R$ ","").replace(",",".");
		var repasse         = $("#novoApolice").find("#repasse").val();
		var porcentagem     = $("#novoApolice").find("#repasse").attr('porcentagem');
		var dt_fatura       = $("#novoApolice").find("#dt_fatura").val();
		var dt_emissao      = "<?php echo date('d/m/Y')?>";
		var parcela		    = $("#novoApolice").find("#parc").val();
		var obs 		    = $("#novoApolice").find("#obs").val();
		var ramo        	= $("#novoApolice").find("#ramo option:selected").val();
		var produtor 		= $("#novoApolice").find("#produtor option:selected").val();
		var seguradora 		= $("#novoApolice").find("#seguradora option:selected").val();
		var empresa 		= $("#novoApolice").find("#empresa option:selected").val();
		var pagamento 		= $("#novoApolice").find("#pagamento option:selected").val();
		var centrocusto		= 1;
		var natureza		= 5;
		var vigencia		= dt_start + " - " + dt_end;
		var tppag			= 1;
		//var tppag			= $("#tppag:checked").val();

		if(situacao == 1){
			situacao = 0;
		}

		if(cli_id.length == 0 || cli_id == 0 || cli_id == null || cli_id == "" || cli_id == undefined){
			alerta("CLIENTE NÃO SELECIONADO!","Favor selecionar um cliente","warning","warning");
		}
		else if(item.length <= 5 || item == "" || item == null){
			alerta("DESCRIÇÃO NÃO INFORMADA!","A descrição deve ser informada e conter mais de 5 caracteres!","warning","warning");
			$("#item").focus();
		}
		else if(ramo == 0){
			alerta("RAMO NÃO INFORMADO!","","warning","warning");
			$("#ramo").focus();
		}
		else if(vigencia.length == 0 || vigencia == null || vigencia == ""){
			alerta("VIGÊNCIA NÃO INFORMADA!","","warning","warning");
			$("#vigencia").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}
		else if(produtor == 0){
			alerta("PRODUTOR NÃO INFORMADO!","","warning","warning");
			$("#produtor").focus();
		}else if(seguradora == 0){
			alerta("SEGURADORA NÃO INFORMADA!","","warning","warning");
			$("#seguradora").focus();
		}else if(empresa == 0 || empresa == '' || isNaN(empresa)){
			alerta("EMPRESA NÃO INFORMADA!","","warning","warning");
			$("#empresa").focus();
		}else if(pagamento == 0 || pagamento == '' || isNaN(pagamento)){
			alerta("PAGAMENTO NÃO INFORMADO!","","warning","warning");
			$("#empresa").focus();
		}else if(dt_fatura == "00/00/0000" || dt_fatura.length <= 0){
			alerta("Favor Informar a data de faturamento!","","warning","warning");
			$("#dt_fatura").focus().select();
		}else if(!tppag || tppag == null || tppag == undefined){
			alerta("Escolha um tipo de pagamento!","","warning","warning");
			$("#dt_fatura").focus().select();
		}else{

			if(pr_total.length == 0 || pr_total == null || pr_total == ""){
				var vlr_parcela 	= 0;
				var pr_total    	= 0;
				var iof         	= 0;
				var pr_liquido  	= 0;
				var comissao    	= 0;
				var comissao_bruta  = 0;
				var repasse         = 0;
			};

			if(comissao == 0 || comissao.length == 0 || isNaN(comissao) || comissao == null || comissao == undefined){
				comissao = 0;
			}

			if(repasse == null || isNaN(repasse) || repasse == undefined){
				repasse = 0;
			}
			loading("show");
			$.post("server/impApolice.php",{
				tipo:			funcao,
				emp_id:			empresa,
				id:				id,
				cli_id:			cli_id,
				seguradora:		seguradora,
				segurado:		cli_id,
				cpf:			cpf,
				seg_id:			seguradora,
				ram_id:			ramo,
				dt_fatura:  	dt_fatura,
				dt_emissao: 	dt_emissao,
				vigencia:   	dt_start + " - " + dt_end,
				type:       	tipo,
				item:			item,
				descricao:  	item,
				placa:			placa,
				chassi:			chassi,
				combustivel:    combustivel,
				iof:			iof,
				qtd_parcela:    qtd_parcela,
				parcela:		parcela,
				pr_liquido:		pr_liquido,
				pr_total:		pr_total,
				comissao:		comissao,
				comissao_bruta: comissao_bruta,
				ano_fab:		ano_fab,
				ano_mod:		ano_mod,
				n_apo:			n_apo,
				n_pro:			n_pro,
				n_end:			n_end,
				obs:			obs,
				status:			status,
				repasse:		repasse,
				porcentagem:	porcentagem,
				pro_id:			produtor,
				pag_id:			pagamento,
				situacao:		parseInt(situacao)+1,
				tppag:			tppag
			}).done(function(data){
				if(data != 0){
					alerta("Sucesso!","Proposta Cancelada com Sucesso!","success","check");
				}else{
					alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
				}
				atualiza();
			}).fail(function(){
				alerta("Erro!","Não foi possível executar esta operação!","danger","ban");
				atualiza();
			});
		}
	}

	function atualiza (){
		loading("hide");
		$("#cadastro").empty().dialog('close');
		try{
			$('#datatable_col_reorder').dataTable().fnReloadAjax();
		}catch(e){

		}
	};
</script>
