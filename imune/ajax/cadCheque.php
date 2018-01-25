<?php
	require_once "../server/seguranca.php";
?>
<div id="lancamentoCheque">
	<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-23" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
		<!-- widget options:
        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

        data-widget-colorbutton="false"
        data-widget-editbutton="false"
        data-widget-togglebutton="false"
        data-widget-deletebutton="false"
        data-widget-fullscreenbutton="false"
        data-widget-custombutton="false"
        data-widget-collapsed="true"
        data-widget-sortable="false"

        -->
		<header>
			<h2>LANÇAMENTO DE CHEQUES E BOLETOS</h2>

		</header>

		<!-- widget div-->
		<div>
			<div class="widget-body">

				<div class="row">
					<div class="col-sm-6 col-xs-12">
						Nome<input class="form-control" id="cli_id" >
					</div>
					<div class="col-sm-3 col-xs-6">
						Empresa<select class="form-control" id="empresa"></select>
					</div>
					<div class="col-sm-3 col-xs-6">
						Banco<select class="form-control" id="banco"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 col-xs-6">
						Tipo<select class="form-control" id="tp">
							<option value="2">CHEQUE</option>
							<option value="1">BOLETO</option>
						</select>
					</div>
					<div class="col-sm-2 col-xs-6">
						Nat. Fin.<select class="form-control" id="natureza"></select>
					</div>
					<div class="col-sm-2 col-xs-6">
						Cen. Custo<select class="form-control" id="centrocusto"></select>
					</div>
					<div class="col-sm-2 col-xs-6">
						Dt.de Fatura<input class="form-control" id="dt_fat" value="<?php echo date('d/m/Y');?>">
					</div>
					<div class="col-sm-2 col-xs-6">
						Número C / B<input class="form-control" id="cheque">
					</div>
					<div class="col-sm-2 col-xs-6">
						VL. Liquido<input class="form-control" id="pr_bruto">
					</div>
					<div class="col-sm-12 col-xs-12">
						OBS:<textarea class="form-control" id="obs"></textarea>
					</div>
					<div class="col-sm-12 col-xs-12 text-align-right">
						<br>
						<a class="btn btn-primary" id="inserir" href="javascript:void(0);">
							<i class="glyphicon glyphicon-plus" style="margin-right: 5px;"></i>Inserir
						</a>
						<a class="btn btn-danger hidden" id="cancelar" href="javascript:void(0);">
							<i class="glyphicon glyphicon-erase" style="margin-right: 5px;"></i>Cancelar
						</a>
						<a class="btn btn-success hidden" id="salvar" href="javascript:void(0);">
							<i class="glyphicon glyphicon-check" style="margin-right: 5px;"></i>
						</a>
					</div>
				</div>

			</div>
			<!-- end widget content -->

		</div>
		<!-- end widget div -->

	</div>
</div>
<section id="gridCheque">

</section>
<script>
	$.post("server/recupera.php",{tabela:'natureza  where tipo like "%2%" order by nome asc'}).done(function(data){
		var obj = JSON.parse(data);
		for(o in obj){
			if(o == 0){
				$("#lancamentoCheque").find("#natureza").empty().append('<option selected value="'+obj[o].id+'">'+obj[o].nome+'</option>');
			}else{
				$("#lancamentoCheque").find("#natureza").append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
			}
		};
		//busca centro de custo
		var natureza = $("#lancamentoCheque").find("#natureza option:selected").val();
		var campoT   = natureza.length;
		var query = " (left(naturezas,"+campoT+") = '"+natureza+"' or naturezas like '%,"+natureza+"%')";
		$.post("server/recupera.php",{tabela:'centrocusto where '+query }).done(function(data){
			var obj = JSON.parse(data);
			for(o in obj){
				if(o == 0){
					$("#lancamentoCheque").find("#centrocusto").empty().append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}else{
					$("#lancamentoCheque").find("#centrocusto").append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}
			};
		}).fail(function(){

		});
	}).fail(function(){

	});

	$("#lancamentoCheque").find('#tp').change(function(){
		$.post("server/recupera.php",{tabela:'natureza  where tipo like "%'+this.value+'%" order by nome asc'}).done(function(data){
			var obj = JSON.parse(data);
			for(o in obj){
				if(o == 0){
					$("#lancamentoCheque").find("#natureza").empty().append('<option selected value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}else{
					$("#lancamentoCheque").find("#natureza").append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}
			};
			//busca centro de custo
			var natureza = $("#lancamentoCheque").find("#natureza option:selected").val();
			var campoT   = natureza.length;
			var query = " (left(naturezas,"+campoT+") = '"+natureza+"' or naturezas like '%,"+natureza+"%')";
			$.post("server/recupera.php",{tabela:'centrocusto where '+query }).done(function(data){
				var obj = JSON.parse(data);
				for(o in obj){
					if(o == 0){
						$("#lancamentoCheque").find("#centrocusto").empty().append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
					}else{
						$("#lancamentoCheque").find("#centrocusto").append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
					}
				};
			}).fail(function(){

			});
		}).fail(function(){

		});

	});

	$("#lancamentoCheque").find("#natureza").change(function(){
		var natureza = $(this).val();
		var campoT   = natureza.length;
		var query = " (left(naturezas,"+campoT+") = '"+natureza+"' or naturezas like '%,"+natureza+"%')";
		$.post("server/recupera.php",{tabela:'centrocusto where '+query }).done(function(data){
			var obj = JSON.parse(data);
			for(o in obj){
				if(o == 0){
					$("#lancamentoCheque").find("#centrocusto").empty().append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}else{
					$("#lancamentoCheque").find("#centrocusto").append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}
			};
		}).fail(function(){

		});
	});
	$.post('ajax/gridCheque.php').done(function(data){
		$("#gridCheque").html(data);
	});

	$(function(){
		$("#lancamentoCheque").find('input[id="cli_id"]').autocomplete({
			source: "ajax/busca.php",
			select: function(event,ui){
				$(this).attr("retorno",ui.item.id);
				$(this).attr("value",ui.item.nome);

			},
			search:function(){
				loading('show');
			},
			response:function(){
				loading('hide')
			},
			delay:1000,
			minLength:3
		});
		$("#lancamentoCheque").find('input[id="cli_id"]').autocomplete('option','appendTo',"div[id='lancamentoCheque']");
	});

	$("#lancamentoCheque").find("#inserir").click(function(){
		var cli_id    	= $("#lancamentoCheque").find("#cli_id").attr('retorno');
		var emp_id    	= $("#lancamentoCheque").find("#empresa option:selected").val();
		var ban_id     	= $("#lancamentoCheque").find("#banco option:selected").val();
		var pag_id  	= $("#lancamentoCheque").find("#tp option:selected").val();
		var obs        	= $("#lancamentoCheque").find("#obs").val();
		var dt_fat     	= $("#lancamentoCheque").find("#dt_fat").val();
		var numero     	= $("#lancamentoCheque").find("#cheque").val();
		var valor     	= $("#lancamentoCheque").find("#pr_bruto").val().replace("R$","").replace(",",".");
		var tipo    	= $("#lancamentoCheque").find("#tp option:selected").val();
		var cen_id  	= $("#lancamentoCheque").find("#centrocusto option:selected").val();
		var nat_id  	= $("#lancamentoCheque").find("#natureza option:selected").val();
		var quant       = 1;

		if(tipo == 1){
			var boleto = numero;
			var cheque = "";
		}else{
			var boleto = "";
			var cheque = numero;
		}
		if(cli_id == "" || isNaN(cli_id) || cli_id == null || cli_id == undefined){
			alerta("Alerta!", "Nome não informado!","warning","warning");
			$("#lancamentoCheque").find("#cli_id").focus().select();
		}
		else if(dt_fat == null || dt_fat == "00/00/0000"){
			alerta("Alerta!", "Data não informada!","warning","warning");
			$("#lancamentoCheque").find("#dt_fat").focus().select();
		}
		else if(numero == "" || numero.length <= 0){
			alerta("Alerta!", "Favor inserir o número do documento!","warning","warning");
			$("#lancamentoCheque").find("#cheque").focus().select();
		}
		else if(valor == "" || valor.length <= 0){
			alerta("Alerta!", "Valor não informado!","warning","warning");
			$("#lancamentoCheque").find("#pr_bruto").focus().select();
		}
		else{
			loading('show');
			$.post('server/financeiro.php',{funcao:1,cb:1,quant:quant,pr_bruto:valor,pr_liquido:valor,cli_id:cli_id,emp_id:emp_id,pag_id:pag_id,cen_id:cen_id,ban_id:ban_id,nat_id:nat_id,boleto:boleto,cheque:cheque,dt_fat:dt_fat,obs:obs,tipo:tipo }).done(function(data){
				if(data != 0){
					alerta("Sucesso!","Operação realizada com sucesso!","info","check");
					$("#lancamentoCheque").find('#pr_bruto,#cheque,#obs').val('');
					$.post('ajax/gridCheque.php').done(function(data){
						$("#gridCheque").html(data);
					});
				}else{
					alerta("Erro ao processar sua solicitação!","","danger","ban");
				}
			}).fail(function(){
				alerta("Erro ao processar sua solicitação!","","danger","ban");
			});
			loading('hide');
		}
	});

	$("#lancamentoCheque").find("#dt_fat").datepicker({
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
	$("#lancamentoCheque").find("#pr_bruto").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});
	$("#lancamentoCheque").find("#cheque").mask('000000000000000000000000000000000000000000000000000000000000000000000');

	empresaBanco($("#lancamentoCheque"));

	$("#lancamentoCheque").find("#cancelar").click(function(){
		loading("show");
		$("#lancamentoCheque").find("input,textarea").each(function(){
			$(this).val('');
		});
		$("#lancamentoCheque").find("#cli_id").attr('retorno','');
		$("#cancelar,#salvar").addClass('hidden');
		$("#inserir").removeClass('hidden');
		$("#lancamentoCheque").find("#cli_id").prop('disabled',false);
		loading("hide");
	});

	$("#lancamentoCheque").find("#salvar").click(function(){
		var id			= $("#lancamentoCheque").find("#cli_id").attr('financeiro');
		var cli_id    	= $("#lancamentoCheque").find("#cli_id").attr('retorno');
		var emp_id    	= $("#lancamentoCheque").find("#empresa option:selected").val();
		var ban_id     	= $("#lancamentoCheque").find("#banco option:selected").val();
		var pag_id  	= $("#lancamentoCheque").find("#tp option:selected").val();
		var obs        	= $("#lancamentoCheque").find("#obs").val();
		var dt_fat     	= $("#lancamentoCheque").find("#dt_fat").val();
		var numero     	= $("#lancamentoCheque").find("#cheque").val();
		var valor     	= $("#lancamentoCheque").find("#pr_bruto").val().replace("R$","").replace(",",".");
		var tipo    	= $("#lancamentoCheque").find("#tp option:selected").val();
		var cen_id  	= $("#lancamentoCheque").find("#centrocusto option:selected").val();
		var nat_id  	= $("#lancamentoCheque").find("#natureza option:selected").val();
		var quant       = 1;

		if(tipo == 1){
			var boleto = numero;
			var cheque = "";
		}else{
			var boleto = "";
			var cheque = numero;
		}
		if(cli_id == "" || isNaN(cli_id) || cli_id == null || cli_id == undefined){
			alerta("Alerta!", "Nome não informado!","warning","warning");
			$("#lancamentoCheque").find("#cli_id").focus().select();
		}
		else if(dt_fat == null || dt_fat == "00/00/0000"){
			alerta("Alerta!", "Data não informada!","warning","warning");
			$("#lancamentoCheque").find("#dt_fat").focus().select();
		}
		else if(numero == "" || numero.length <= 0){
			alerta("Alerta!", "Favor inserir o número do documento!","warning","warning");
			$("#lancamentoCheque").find("#cheque").focus().select();
		}
		else if(valor == "" || valor.length <= 0){
			alerta("Alerta!", "Valor não informado!","warning","warning");
			$("#lancamentoCheque").find("#pr_bruto").focus().select();
		}
		else{
			loading('show');
			$.post('server/financeiro.php',{id:id,funcao:22,cb:1,quant:quant,pr_bruto:valor,pr_liquido:valor,cli_id:cli_id,emp_id:emp_id,pag_id:pag_id,cen_id:cen_id,ban_id:ban_id,nat_id:nat_id,boleto:boleto,cheque:cheque,dt_fat:dt_fat,obs:obs,tipo:tipo }).done(function(data){
				if(data != 0){
					alerta("Sucesso!","Operação realizada com sucesso!","info","check");
					$("#lancamentoCheque").find('#pr_bruto,#cheque,#obs').val('');
					$.post('ajax/gridCheque.php').done(function(data){
						$("#gridCheque").html(data);
					});
				}else{
					alerta("Erro ao processar sua solicitação!","","danger","ban");
				}
			}).fail(function(){
				alerta("Erro ao processar sua solicitação!","","danger","ban");
			});

			loading('hide');
			$("#lancamentoCheque").find("#cancelar").click();
		}
	});

</script>
