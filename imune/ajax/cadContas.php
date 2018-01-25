<?php
require_once "../server/seguranca.php";
$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>
	<br>
	<div id="lancamentoConta" class="col-xs-12">
		<div class="row" id="tptp">
			<div class="col-xs-12">
				<div class="col-xs-12">
					<div class="col-xs-12">
						<label class="radio">
							<input class="radiobox style-0" type="radio" name="tp_conta" value="1">
							<span title='CONTAS À PAGAR' class='label label-danger text-center'>&nbsp;À PAGAR / DESPESAS&nbsp;&nbsp;</span>
						</label>
						<label class="radio">
							<input class="radiobox style-0" type="radio" name="tp_conta" value="2">
							<span title='CONTAS À RECEBER' class='label label-success text-center'>&nbsp;À RECEBER / RECEITAS&nbsp;&nbsp;</span>
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				Nome<input class="form-control" id="cli_id">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 col-xs-6">
				Dt.de Emissão<input class="form-control" id="dt_cad" value="<?php echo date('d/m/Y');?>">
			</div>
			<div class="col-sm-3 col-xs-6">
				Dt.de Fatura<input class="form-control" id="dt_fat" value="<?php echo date('d/m/Y');?>">
			</div>
			<div class="col-sm-5 col-xs-9">
				Forma Pag.<select class="form-control" style="width: 100%" id="pagamento">
					<option>
						ESCOLHA UMA TIPO de CONTA
					</option>
				</select>
			</div>
			<div class="col-sm-1 col-xs-3" id="qtdqtd">
				Parc.<input class="form-control" id="qtd" value="1">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 col-xs-6">
				Empresa<select class="form-control" style="width: 100%" id="empresa"></select>
			</div>
			<div class="col-sm-3 col-xs-6">
				Banco<select class="form-control" style="width: 100%" id="banco"></select>
			</div>
			<div class="col-sm-3 col-xs-6">
				Centro de Custo<select class="form-control" style="width: 100%" id="centrocusto">
					<option>
						ESCOLHA UMA TIPO de CONTA
					</option>
				</select>
			</div>
			<div class="col-sm-3 col-xs-6">
				Nat. Financeira<select class="form-control" style="width: 100%" id="natureza">
					<option>ESCOLHA UM CENTRO DE CUSTO</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				Boleto:<input class="form-control" id="boleto">
			</div>
			<div class="col-sm-6 col-xs-12">
				Cheque:<input class="form-control" id="cheque">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2 col-xs-6">
				VL. Bruto<input class="form-control" id="pr_bruto">
			</div>
			<div class="col-sm-2 col-xs-6">
				Juros %<input class="form-control" id="juros_per">
			</div>
			<div class="col-sm-2 col-xs-6">
				Juros R$<input class="form-control" id="juros_real">
			</div>
			<div class="col-sm-2 col-xs-6">
				Desc %<input class="form-control" id="desc_per">
			</div>
			<div class="col-sm-2 col-xs-6">
				Desc R$<input class="form-control" id="desc_real">
			</div>
			<div class="col-sm-2 col-xs-6">
				VL. Liquido<input class="form-control" id="pr_liquido" disabled>
			</div>
		</div>
		<div class="row hidden" id="baixando">
			<div class="col-sm-2 col-xs-6">
				Dt. Baixa<input class="form-control" id="dt_baixa" value="<?php echo date('d/m/Y');?>">
			</div>
			<div class="col-sm-2 col-xs-6">
				Vlr. Baixa<input class="form-control" id="pr_baixa">
			</div>
		</div>
		<div class="row hidden" id="replicando">
			<div class="col-sm-3 col-xs-12">
				Período:<br>
				<label class="radio-inline">
					<input type="radio" id="repTipo" value="1">
					SEMANA </label>
				<label class="radio-inline">
					<input type="radio" checked id="repTipo" value="2">
					MÊS </label>
			</div>
			<div class="col-sm-3 col-xs-12">
				Banco. Rep.<select class="form-control" id="re_banco"></select>
			</div>
			<div class="col-sm-4 col-xs-9">
				Forma Pag. Rep.<select class="form-control" id="re_pagamento"></select>
			</div>
			<div class="col-sm-2 col-xs-3" id="qtdqtd">
				Parc. Rep.<select class="form-control" id="re_qtd">
					<option value="1">1</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4">4</option>
					<option value="5">5</option>
					<option value="6">6</option>
					<option value="7">7</option>
					<option value="8">8</option>
					<option value="9">9</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				OBS:<textarea class="form-control" id="obs"></textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">
				Opções Especiais<br>
				<label class="radio radio-inline" style="top:-5px">
					<input type="radio" checked class="radiobox style-3" value="1" name="sp">
					<span>Nenhuma</span>
				</label>

				<label class="radio radio-inline">
					<input type="radio" class="radiobox style-3" value="2" name="sp">
					<span>Baixar Conta</span>
				</label>
				<label class="radio radio-inline">
					<input type="radio" class="radiobox style-3" value="3" name="sp">
					<span>Conciliar Conta</span>
				</label>
			</div>
		</div>
	</div>

	<div class="col-xs-12 center">
		<div class="row">
			<div class="col-xs-12">
				<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
				<a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
				<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
				<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="fa fa-times"></i></span>EXCLUIR</a>
				<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
				<a href="javascript:void(0);" id="salvar2" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
				<a href="javascript:void(0);" id="salvar3" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
				<a href="javascript:void(0);" id="baixar" class="btn btn-sm btn-primary hidden"> <span class="btn-label"><i class="glyphicon glyphicon-chevron-down"></i></span>BAIXAR</a>
				<a href="javascript:void(0);" id="replicar" class="btn btn-sm bg-color-redLight txt-color-white  hidden"> <span class="btn-label"><i class="glyphicon glyphicon-random"></i></span>REPLICAR</a>
				<a href="javascript:void(0);" id="cancelar2" class="btn btn-sm btn-info hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>CANCELAR BAIXA</a>
				<a href="javascript:void(0);" id="cancelar3" class="btn btn-sm btn-info hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>DESFAZER AGLUTINAÇÃO</a>
			</div>
		</div>
	</div>

	<script>
		$("#lancamentoConta").find("#qtd,#bx_qtd").mask("00");

		$(function(){

			$("#lancamentoConta").find('input[id="cli_id"]').autocomplete({
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
			$("#lancamentoConta").find('input[id="cli_id"]').autocomplete('option','appendTo',"div[id='lancamentoConta']");
		});


		$("#lancamentoConta").find("#dt_fat,#dt_cad,#dt_baixa").datepicker({
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
		$(document).on("focus", "#dt_fat,#dt_cad,#dt_baixa", function () {
			$(this).mask("00/00/0000");
		});

		$("#lancamentoConta").find("#pr_bruto,#desc_real,#juros_real,#pr_baixa").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'', decimal:',', affixesStay: false});

		$("#lancamentoConta").find("#desc_per,#juros_per").maskMoney({thousands:'', decimal:',', affixesStay: false,suffix:' %'});


		$('input[name="tp_conta"]').change(function(){

			$.post("server/recupera.php",{tabela:'pagamento where grp_emp_id = <?php echo $empresa;?> and (tipo = 3 or tipo = '+$(this).val()+') order by nome'}).done(function(data){
				var obj = JSON.parse(data);
				for(o in obj){
					if(o == 0){
						$("#lancamentoConta").find("#pagamento").empty().append('<option checked condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
					}else{
						$("#lancamentoConta").find("#pagamento").append('<option condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
					}
				}

				var condicao       = $("#lancamentoConta").find("#pagamento option:selected").attr('condicao');
				if(condicao == 2){
					$("#lancamentoConta").find("#qtd").removeAttr("disabled");
				}else{
					$("#lancamentoConta").find("#qtd").attr("disabled",true);
				};
			}).fail(function(){

			});

			$.post('server/recupera.php',{tabela:"centrocusto where grp_emp_id = <?php echo $empresa;?> and tipo = "+$(this).val()+" order by nome"}).done(function(data){
				var obj = JSON.parse(data);
				for(i in obj){
					if(i == 0){
						$("#lancamentoConta").find("#centrocusto").empty().append('<option naturezas="'+obj[i].naturezas+'" value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}else{
						$("#lancamentoConta").find("#centrocusto").append('<option naturezas="'+obj[i].naturezas+'" value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}
				}
				var naturezas = obj[0].naturezas.split(',');
				var nat = "(";
				for(n in naturezas){
					nat += " id = "+naturezas[n]+" or ";
				}
				nat = nat.substr(0,nat.length-3)+")";
				$.post('server/recupera.php',{tabela:"natureza where grp_emp_id = <?php echo $empresa;?> and "+nat+" order by nome"}).done(function(data){
					var obj = JSON.parse(data);
					for(i in obj){
						if(i == 0){
							$("#lancamentoConta").find("#natureza").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
						}else{
							$("#lancamentoConta").find("#natureza").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
						}
					}
				}).fail(function(){

				});
			}).fail(function(){

			});

		});

		$("#centrocusto").change(function(){
			var naturezas = $(this).find("option:selected").attr('naturezas').split(',');
			var nat = "(";
			for(n in naturezas){
				nat += " id = "+naturezas[n]+" or ";
			}
			nat = nat.substr(0,nat.length-3)+")";
			$.post('server/recupera.php',{tabela:"natureza where grp_emp_id = <?php echo $empresa;?> and "+nat+" order by nome"}).done(function(data){
				var obj = JSON.parse(data);
				for(i in obj){
					if(i == 0){
						$("#lancamentoConta").find("#natureza").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}else{
						$("#lancamentoConta").find("#natureza").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}
				}
			}).fail(function(){

			});
		});

		empresaBanco($("#lancamentoConta"),"<?php echo $empresa;?>");



		$("#lancamentoConta").find("#pagamento").change(function(){
			var condicao       = $("#lancamentoConta").find("#pagamento option:selected").attr('condicao');
			if(condicao == 2){
				$("#lancamentoConta").find("#qtd").removeAttr("disabled");
			}else{
				$("#lancamentoConta").find("#qtd").attr("disabled",true);
			};
		});

		zerar("#lancamentoConta","#desc_per","#desc_real");
		zerar("#lancamentoConta","#desc_real","#desc_per");
		zerar("#lancamentoConta","#juros_per","#juros_real");
		zerar("#lancamentoConta","#juros_real","#juros_per");

		$("#lancamentoConta").find("#pr_bruto,#desc_per,#desc_real,#juros_per,#juros_real").keyup(function(){
			var a1 = parseFloat($("#lancamentoConta").find("#pr_bruto"  ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var b1 = parseFloat($("#lancamentoConta").find("#juros_per" ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var c1 = parseFloat($("#lancamentoConta").find("#juros_real").val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var d1 = parseFloat($("#lancamentoConta").find("#desc_per"  ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var e1 = parseFloat($("#lancamentoConta").find("#desc_real" ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));


			if(isNaN(a1) || (a1 ==="") || (a1 ==="0.00")){
				a1 = 0;
			};

			if(isNaN(b1) || (b1 ==="") || (b1 ==="0.00")){
				b1 = 0;
			};

			if(isNaN(c1) || (c1 ==="") || (c1 ==="0.00")){
				c1 = 0;
			};

			if(isNaN(d1) || (d1 ==="") || (d1 ==="0.00")){
				d1 = 0;
			};

			if(isNaN(e1) || (e1 ==="") || (e1 ==="0.00")){
				e1 = 0;
			}


			var total = parseFloat((a1 + c1 - e1) + (a1 * b1 / 100) - (a1 * d1 / 100)).toFixed(2);
			$("#lancamentoConta").find("#pr_liquido").val("R$ "+total.replace(".",","));
			//console.log("(" + a1 + "+" + c1 + "-"+ e1 + ")+" + "("+a1 + "*"+b1+"/100)-"+"("+a1+"*"+d1+"/100)="+total);

		});

		$("#cadastrar").click(function(){
			var tipo 		= $("#lancamentoConta").find("input[name='tp_conta']:radio:checked").val();
			var cli_id 		= $("#lancamentoConta").find("#cli_id").attr('retorno');
			var dt_cad		= $("#lancamentoConta").find("#dt_cad").val();
			var dt_fat		= $("#lancamentoConta").find("#dt_fat").val();
			var centrocusto	= $("#lancamentoConta").find("#centrocusto option:selected").val();
			var natureza	= $("#lancamentoConta").find("#natureza option:selected").val();
			var empresa 	= $("#lancamentoConta").find("#empresa option:selected").val();
			var banco   	= $("#lancamentoConta").find("#banco option:selected").val();
			var pagamento	= $("#lancamentoConta").find("#pagamento option:selected").val();
			var qtd  		= $("#lancamentoConta").find("#qtd").val();
			var boleto 		= $("#lancamentoConta").find("#boleto").val();
			var cheque		= $("#lancamentoConta").find("#cheque").val();
			var sp			= $("#lancamentoConta").find("input:radio[name='sp']:checked").val();

			var pr_bruto   = parseFloat($("#lancamentoConta").find("#pr_bruto"  ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var juros_per  = parseFloat($("#lancamentoConta").find("#juros_per" ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var juros_real = parseFloat($("#lancamentoConta").find("#juros_real").val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var desc_per   = parseFloat($("#lancamentoConta").find("#desc_per"  ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var desc_real  = parseFloat($("#lancamentoConta").find("#desc_real" ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var pr_liquido = parseFloat($("#lancamentoConta").find("#pr_liquido" ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));

			if(isNaN(juros_per) || (juros_per ==="") || (juros_per ==="0.00")){
				juros_per = 0;
			};

			if(isNaN(juros_real) || (juros_real ==="") || (juros_real ==="0.00")){
				juros_real = 0;
			};

			if(isNaN(desc_per) || (desc_per ==="") || (desc_per ==="0.00")){
				desc_per = 0;
			};

			if(isNaN(desc_real) || (desc_real ==="") || (desc_real ==="0.00")){
				desc_real = 0;
			}

			var obs     	= $("#lancamentoConta").find("#obs").val();

			if(!tipo || tipo == null || tipo == undefined){
				alerta("Favor Escolher o tipo de lançamento!","Você não definiu se deseja fazer um lançamento de contas à pagar ou a receber, escolha uma opção antes de continuar.","warning","warning");
			}else if(isNaN(cli_id) || cli_id == null || cli_id == "" || cli_id == 0){
				alerta("Favor informar um cliente!","","warning","warning");
				$("#lancamentoConta").find("#cli_id").focus().select();
			}else if(isNaN(pr_bruto) || pr_bruto == null || pr_bruto == "" || pr_bruto == 0){
				alerta("O Valor Bruto precisa ser preenchido!","","warning","warning");
				$("#lancamentoConta").find("#pr_bruto").focus().select();
			}else if(natureza == 0){
				alerta("O Valor Bruto precisa ser preenchido!","","warning","warning");
				$("#lancamentoConta").find("#pr_bruto").focus().select();
			}else if(centrocusto == 0){
				alerta("O Valor Bruto precisa ser preenchido!","","warning","warning");
				$("#lancamentoConta").find("#pr_bruto").focus().select();
			}else{
				loading('show');
				$.post('server/financeiro.php',{
					funcao		:1,
					tipo		:tipo,
					cli_id		:cli_id,
					dt_emi		:dt_cad,
					dt_fat		:dt_fat,
					cen_id		:centrocusto,
					nat_id		:natureza,
					emp_id		:empresa,
					ban_id		:banco,
					pag_id		:pagamento,
					quant		:qtd,
					pr_bruto	:pr_bruto,
					juros_per	:juros_per,
					juros_real	:juros_real,
					desc_per	:desc_per,
					desc_real	:desc_real,
					pr_liquido	:pr_liquido,
					boleto      :boleto,
					cheque      :cheque,
					obs			:obs,
					sp			:sp,
				}).done(function(data){
					if(data != 0){
						loading('hide');
						alerta("Sucesso!","Conta Cadastrada com sucesso!","success","check");
						$.post('ajax/cadContas.php').done(function(data){
							$("#cadastro").empty().html(data);
							$("#cadastro").dialog({
								autoOpen : true,
								width : '95%',
								resizable : false,
								modal : true,
								title : "Nova Conta"
							});
							loading('hide');
						}).fail(function(){
							alerta("ERRO!","Função não encontrada!","danger","ban");
							loading('hide');
						});
						$("#datatable_col_reorder").dataTable().fnReloadAjax('server/buscaFinanceiro.php?type='+tipo);
					}else{
						loading('hide');
						alerta("Erro ao cadastrar conta!","Favor verifique todos os campos e tente novamente, se o problema continuar, contate o suporte técnico!","danger","warning");
					}
				}).fail(function(){
					loading('hide');
					alerta("Erro!","Verifique sua conexão e tente novamente!","danger","ban");
				});
			}
		});

		function zerar(a,b,c){
			$(a).find(b).keyup(function(e){
				var v = parseFloat($(this).val().replace("R$ ","").replace(" %","").replace(",",".")).toFixed(2);
				if(isNaN(v) || v == '0.00'){
					$(a).find(c).removeAttr("disabled");
				}else{
					$(a).find(c).attr("disabled",true);
				}
			})
		}
	</script>
<?php
if(isset($_POST['id'])){
	$id = $_POST['id'];
	if($_POST['tipo'] == 1 || $_POST['tipo'] == 3){
		$tipo = 1;
	}else{
		$tipo = 2;
	}

	?>
	<script>

		$.post("server/recupera.php",{tabela:'pagamento where grp_emp_id = <?php echo $empresa;?> and (tipo = <?php echo $tipo;?> or tipo = 3) order by nome'}).done(function(data){
			var obj = JSON.parse(data);
			for(o in obj){
				if(o == 0){
					$("#lancamentoConta").find("#pagamento").empty().append('<option checked condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}else{
					$("#lancamentoConta").find("#pagamento").append('<option condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}
			}
			var condicao       = $("#lancamentoConta").find("#pagamento option:selected").attr('condicao');
			if(condicao == 2){
				$("#lancamentoConta").find("#qtd").removeAttr("disabled");
			}else{
				$("#lancamentoConta").find("#qtd").attr("disabled",true);
			};
		}).fail(function(){

		});

		$.post('server/recupera.php',{tabela:"centrocusto where grp_emp_id = <?php echo $empresa;?> and tipo = <?php echo $tipo;?> order by nome"}).done(function(data){
			var obj = JSON.parse(data);
			for(i in obj){
				if(i == 0){
					$("#lancamentoConta").find("#centrocusto").empty().append('<option naturezas="'+obj[i].naturezas+'" value="'+obj[i].id+'">'+obj[i].nome+'</option>');
				}else{
					$("#lancamentoConta").find("#centrocusto").append('<option naturezas="'+obj[i].naturezas+'" value="'+obj[i].id+'">'+obj[i].nome+'</option>');
				}
			}
			var naturezas = obj[0].naturezas.split(',');
			var nat = "(";
			for(n in naturezas){
				nat += " id = "+naturezas[n]+" or ";
			}
			nat = nat.substr(0,nat.length-3)+")";
			$.post('server/recupera.php',{tabela:"natureza where grp_emp_id = <?php echo $empresa;?> and "+nat+" order by nome"}).done(function(data){
				var obj = JSON.parse(data);
				for(i in obj){
					if(i == 0){
						$("#lancamentoConta").find("#natureza").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}else{
						$("#lancamentoConta").find("#natureza").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}
				}
			}).fail(function(){

			});
		}).fail(function(){

		});
		loading('show');
		$("#tptp").addClass('hidden');
		// desabilita todos campos de entrada
		$("#lancamentoConta").find("input,textarea,select").each(function(){
			$(this).attr("disabled","disabled");
		});

		//oculta botões;
		$("#cadastrar").addClass("hidden");

		//busca campos no banco;
		$.post('server/recupera.php',{tabela:"empresa where grp_emp_id = <?php echo $empresa;?> and tipo = 1"}).done(function(data){
			var obj = JSON.parse(data);
			for(o in obj){
				if(o == 0){
					$("#lancamentoConta").find("#empresa").empty().append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
				}else{
					$("#lancamentoConta").find("#empresa").append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
				}
			};
			$.post('server/recupera.php',{tabela:"banco where grp_emp_id = <?php echo $empresa;?>"}).done(function(data){
				var obj = JSON.parse(data);
				for(o in obj){
					if(o == 0){
						$("#lancamentoConta").find("#banco").empty().append('<option  value="'+obj[o].id+'">'+obj[o].banco+'</option>');
					}else{
						$("#lancamentoConta").find("#banco").append('<option  value="'+obj[o].id+'">'+obj[o].banco+'</option>');
					}
				};
				setTimeout(function(){
					$.post("server/recupera2.php",{
						tabela:'select pessoa.id as id,financeiro.aglutinado, pessoa.nome as nome,financeiro.cheque,financeiro.apo_id,financeiro.boleto, financeiro.cb, financeiro.dt_emi as dt_emi, financeiro.dt_fat as dt_fat, financeiro.ban_id as ban_id, financeiro.cen_id as cen_id, financeiro.emp_id as emp_id, financeiro.nat_id as nat_id, financeiro.pag_id as pag_id, financeiro.valorbruto as valorbruto, financeiro.descper as descper, financeiro.descreal as descreal, financeiro.jurosper as jurosper, financeiro.jurosreal as jurosreal, financeiro.valorliquido as valorliquido, financeiro.status as status, financeiro.obs as obs from financeiro,pessoa where pessoa.id = financeiro.pes_id and financeiro.id = <?php echo $id;?>'
					}).done(function(data){
						var obj = JSON.parse(data);
						//alimenta formulário;


						if(obj[0].status == 3 || obj[0].status == 4){
							if(obj[0].aglutinado == 1){
								$("#cancelar3").removeClass('hidden');
							}else{
								$("#cancelar2").removeClass('hidden');
							}
						}else{

						}
						$("#cli_id").val(obj[0].nome);
						$("#cli_id").attr("retorno",obj[0].id);
						$("#cli_id").attr("apolice",obj[0].apo_id);
						$("#cli_id").attr("status",obj[0].status);
						$("#cli_id").attr("cb",obj[0].cb);
						$("#dt_cad").val(obj[0].dt_emi.substr(8,2)+"/"+obj[0].dt_emi.substr(5,2)+"/"+obj[0].dt_emi.substr(0,4));
						$("#dt_fat").val(obj[0].dt_fat.substr(8,2)+"/"+obj[0].dt_fat.substr(5,2)+"/"+obj[0].dt_fat.substr(0,4));
						$("#pr_bruto").val(obj[0].valorbruto);
						$("#juros_per").val(obj[0].jurosper);
						$("#juros_real").val(obj[0].jurosreal);
						$("#desc_per").val(obj[0].descper);
						$("#desc_real").val(obj[0].descreal);
						$("#pr_liquido").val(obj[0].valorliquido);
						$("#boleto").val(obj[0].boleto);
						$("#cheque").val(obj[0].cheque);
						$("#obs").val(obj[0].obs);
						$("#lancamentoConta").find("#qtd").attr("disabled",true);


						$("#centrocusto").val(obj[0].cen_id).change();
						$("#empresa").val(obj[0].emp_id).change();
						setTimeout(function(){
							$("#bx_pagamento").val(obj[0].pag_id);
							$("#bx_banco").val(obj[0].ban_id);
							$("#pagamento").val(obj[0].pag_id).change();
							$("#natureza").val(obj[0].nat_id);
							$("#banco").val(obj[0].ban_id);
							loading('hide');
						},1500);
					});
				},2000);
			});
		});
		//editando formulário
		$("#editar").click(function(){
			//Liberar campos pra edição
			$("#lancamentoConta").find("input,textarea,select").each(function(){
				$(this).removeAttrs("disabled");
			});

			//focar no primeiro campo
			$("#nome").focus().select();

			//esconde botões
			$("#editar,#baixar,#replicar,#excluir").addClass("hidden");

			//aparece botões
			$("#salvar,#cancelar").removeClass("hidden");

			$("#cli_id,#pr_bruto,#pr_liquido,#desc_per,#desc_real,#juros_per,#juros_real,#qtd").attr("disabled",true);
		});

		// cancelando edição
		$("#cancelar").click(function(){
			loading('show');
			$.post("ajax/cadContas.php",{id:<?php echo $id;?>,tipo:tipo}).done(function(data){
				loading('hide');
				$("#cadastro").empty().html(data);
				try{
					table.fnReloadAjax();
				}
				catch(err){

				}
			}).fail(function(){
				loading('hide');
				alerta("ERRO!","Função não encontrada!","danger","warning");
			});
		});

		//excluir
		$("#excluir").click(function(){
			confirma("Alerta!","Deseja excluir esta conta?",function(){
				loading('show');
				$.post("server/financeiro.php",{funcao:10, id:<?php echo $id;?>}).done(function(data){
					loading('hide');
					if(data == 1){
						alerta("Conta excluida com sucesso!","","success","check");
						$.post("ajax/centraldecontas.php").done(function(data){
							$("#content").empty().html(data);
							$("#cadastro").empty().dialog('close');
						}).fail(function(){
							alerta("ERRO!","Função não encontrada!","danger","warning");
						});
					}else{
						loading('hide');
						alerta("Erro!","Não foi possível excluir a conta selecionada!","danger","ban");
					}
				}).fail(function(){
					loading('hide');
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
			});
		});



		$("#salvar").click(function(){
			var tipo 		= $("#lancamentoConta").find("#cli_id").attr('status');
			var cli_id 		= $("#lancamentoConta").find("#cli_id").attr('retorno');
			var dt_cad		= $("#lancamentoConta").find("#dt_cad").val();
			var dt_fat		= $("#lancamentoConta").find("#dt_fat").val();
			var centrocusto	= $("#lancamentoConta").find("#centrocusto option:selected").val();
			var natureza	= $("#lancamentoConta").find("#natureza option:selected").val();
			var empresa 	= $("#lancamentoConta").find("#empresa option:selected").val();
			var banco   	= $("#lancamentoConta").find("#banco option:selected").val();
			var pagamento	= $("#lancamentoConta").find("#pagamento option:selected").val();
			var quant  		= $("#lancamentoConta").find("#qtd").val();
			var boleto      = $("#lancamentoConta").find("#boleto").val();
			var cheque      = $("#lancamentoConta").find("#cheque").val();

			var pr_bruto   = parseFloat($("#lancamentoConta").find("#pr_bruto"  ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var juros_per  = parseFloat($("#lancamentoConta").find("#juros_per" ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var juros_real = parseFloat($("#lancamentoConta").find("#juros_real").val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var desc_per   = parseFloat($("#lancamentoConta").find("#desc_per"  ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var desc_real  = parseFloat($("#lancamentoConta").find("#desc_real" ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));
			var pr_liquido = parseFloat($("#lancamentoConta").find("#pr_liquido" ).val().replace("R$ ","").replace(" %","").replace(",",".").replace(" ",""));

			if(isNaN(juros_per) || (juros_per ==="") || (juros_per ==="0.00")){
				juros_per = 0;
			};

			if(isNaN(juros_real) || (juros_real ==="") || (juros_real ==="0.00")){
				juros_real = 0;
			};

			if(isNaN(desc_per) || (desc_per ==="") || (desc_per ==="0.00")){
				desc_per = 0;
			};

			if(isNaN(desc_real) || (desc_real ==="") || (desc_real ==="0.00")){
				desc_real = 0;
			}

			var obs     	= $("#lancamentoConta").find("#obs").val();

			if(isNaN(cli_id) || cli_id == null || cli_id == "" || cli_id == 0){
				alerta("Favor informar um cliente!","","warning","warning");
				$("#lancamentoConta").find("#cli_id").focus().select();
			}else if(isNaN(pr_bruto) || pr_bruto == null || pr_bruto == "" || pr_bruto == 0){
				alerta("O Valor Bruto precisa ser preenchido!","","warning","warning");
				$("#lancamentoConta").find("#pr_bruto").focus().select();
			}else{
				loading('show');
				$.post('server/financeiro.php',{
					funcao		:2,
					tipo		:tipo,
					id			:'<?php echo $id;?>',
					dt_emi		:dt_cad,
					dt_fat		:dt_fat,
					cen_id		:centrocusto,
					nat_id		:natureza,
					emp_id		:empresa,
					ban_id		:banco,
					pag_id		:pagamento,
					cheque      :cheque,
					boleto      :boleto,
					obs			:obs
				}).done(function(data){
					loading('hide');
					if(data == 1){
						alerta("Sucesso!","Conta Cadastrada com sucesso!","success","check");
						$("#cadastro").dialog('close');
						$("#datatable_col_reorder").dataTable().fnReloadAjax('server/buscaFinanceiro.php?type='+tipo);
					}else{
						loading('hide');
						alerta("Erro ao cadastrar conta!","Favor verifique todos os campos e tente novamente, se o problema continuar, contate o suporte técnico!","danger","warning");
					}
				}).fail(function(){
					loading('hide');
					alerta("ERRO","Verifique sua conexão e tente novamente!","danger","ban");
				});
			}
		});
	</script>
	<?php
}else{
	?>
	<script>
		$('#replicar,#baixar,#editar,#cancelar').addClass('hidden');
	</script>
	<?php
};

if(isset($_POST['tipo'])){
	$tipo = $_POST['tipo'];
	?>
	<script>
		var tipo = "<?php echo $tipo?>";
		$("#lancamentoConta").find("#tp_conta").val(tipo);
		if(tipo == 2 || tipo == 1){
			$('#baixar,#replicar,#editar,#excluir').removeClass('hidden');
			if(tipo == 2){
				$("#lancamentoConta").find("#tp_conta").css("color","green");
			}
		}



		$("#baixar").click(function(){
			loading('show');
			$("#pagamento").change();
			$("#editar,#replicar,#baixar,#excluir").addClass("hidden");
			$("#cancelar,#salvar2,#baixando").removeClass("hidden");
			$("#lancamentoConta").find("#empresa,#pagamento,#banco,#dt_baixa,#pr_baixa,#obs").removeAttrs('disabled');
			$("#pr_baixa").val($("#pr_liquido").val());

			setTimeout(function(){
				loading('hide');
			},2000);

			$("#salvar2").click(function(){
				var ban_id     = $("#lancamentoConta").find("#banco").val();
				var apo_id 		= $("#lancamentoConta").find("#cli_id").attr('apolice');
				var pag_id     = $("#lancamentoConta").find("#pagamento").val();
				var qtd        = $("#lancamentoConta").find("#qtd").val();
				var dt_baixa   = $("#lancamentoConta").find("#dt_baixa").val();
				var liquido    = parseFloat($("#lancamentoConta").find("#pr_liquido").val().replace("R$ ","").replace(",",".")).toFixed(2);
				var pr_liquido = parseFloat($("#lancamentoConta").find("#pr_baixa").val().replace("R$ ","").replace(",",".")).toFixed(2);
				var pr_bruto   = parseFloat($("#lancamentoConta").find("#pr_baixa").val().replace("R$ ","").replace(",",".")).toFixed(2);
				var tipo       = $("#lancamentoConta").find("#cli_id").attr('status');
				var cb		   = $("#lancamentoConta").find("#cli_id").attr('cb');

				if(cb == 1 && (liquido != pr_liquido)){
					alerta("AVISO!","Boletos e cheques não podem ter baixa diferente do valor do titulo!","warning","warning");
					$("#pr_baixa").focus().select();
				}
				else if(qtd == "" || isNaN(qtd) || qtd == "0"){
					alerta("Favor preencher o campo de parcelas","","warning","warning");
					$("#bx_qtd").focus().select();
				}
				else if(dt_baixa.length <= 0){
					alerta("Favor preencher o campo de data da baixa","","warning","warning");
					$("#dt_baixa").focus().select();
				}
				else if(pr_liquido == "" || isNaN(pr_liquido) || pr_liquido == 0){
					alerta("Favor preencher o campo de valor da baixa","","warning","warning");
					$("#pr_baixa").focus().select();
				}
				else if(pr_liquido > liquido){
					alerta("AVISO!","O valor da baixa não pode ser maior que o valor do título.","warning","warning");
					$("#pr_baixa").focus().select();
				}
				else{
					confirma("ATENÇÃO","Deseja baixar este titulo?<br>Nome: "+$('#cli_id').val()+"<br>Número: <?php echo @$id;?><br>Valor: R$ "+pr_liquido.replace(".",","),function(){
						$.ajax({
							url: 'server/financeiro.php',
							type: 'POST',
							cache: false,
							data: {
								funcao		:4,
								id			:"<?php echo @$id;?>",
								ban_id  	:ban_id,
								apo_id		:apo_id,
								dt_baixa 	:dt_baixa,
								pag_id  	:pag_id,
								quant   	:qtd,
								pr_liquido	:pr_liquido,
								pr_bruto	:pr_bruto,
								tipo        :tipo
							},
							success: function(data) {
								if(data != 0){
									var retorno = data;
									alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
									$("#datatable_col_reorder").dataTable().fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $tipo;?>');
									$("#cadastro").dialog('close');
									loading("show");
									setTimeout(function(){
										confirma("Atenção!","Deseja imprimir o comprovante desta operação?",function(){
											comprovante("server/comprovante.php","titulos="+retorno+"&funcao=1&tipo=1");
										});
										loading("hide");
									},2000);
								}else{
									alerta("AVISO!","Não foi possível concluir esta operação!","danger","ban");
								}
							}
						});
					});
				}
			});
		});

		$("#replicar").click(function(){
			$("#editar,#replicar,#baixar,#excluir").addClass("hidden");
			$("#cancelar,#salvar3,#replicando").removeClass("hidden");
			$("#lancamentoConta").find("#re_pagamento,#re_banco,#re_qtd,#repTipo").removeAttrs('disabled');
			//busca bancos
			$.post("server/recupera.php",{tabela:'banco where grp_emp_id = <?php echo $empresa;?>'}).done(function(data){
				var obj = JSON.parse(data);
				for(o in obj){
					if(o == 0){
						$("#lancamentoConta").find("#re_banco").empty().append('<option value="'+obj[o].id+'">'+obj[o].cod+" - "+obj[o].banco+'</option>');
					}else{
						$("#lancamentoConta").find("#re_banco").append('<option value="'+obj[o].id+'">'+obj[o].cod+" - "+obj[o].banco+'</option>');
					}
				}
			}).fail(function(){

			});
			// busca formas de pagamento
			$.post("server/recupera.php",{tabela:'pagamento where grp_emp_id = <?php echo $empresa;?>'}).done(function(data){
				var obj = JSON.parse(data);
				for(o in obj){
					if(o == 0){
						$("#lancamentoConta").find("#re_pagamento").empty().append('<option checked condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
					}else{
						$("#lancamentoConta").find("#re_pagamento").append('<option condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
					}
				}
				var condicao       = $("#lancamentoConta").find("#re_pagamento option:selected").attr('condicao');
				if(condicao == 2){
					$("#lancamentoConta").find("#re_qtd").removeAttr("disabled");
				}else{
					$("#lancamentoConta").find("#re_qtd").attr("disabled",true);
				};
			}).fail(function(){

			});

			$("#lancamentoConta").find("#re_pagamento").change(function(){
				var condicao       = $("#lancamentoConta").find("#re_pagamento option:selected").attr('condicao');
				if(condicao == 2){
					$("#lancamentoConta").find("#re_qtd").removeAttr("disabled");
				}else{
					$("#lancamentoConta").find("#re_qtd").attr("disabled",true);
				};
			});

			$("#salvar3").click(function(){
				var id			= "<?php echo $id;?>";
				var banco 		= $("#lancamentoConta").find("#re_banco option:selected").val();
				var pagamento	= $("#lancamentoConta").find("#re_pagamento option:selected").val();
				var qtd			= $("#lancamentoConta").find("#re_qtd option:selected").val();
				var repTipo     = $("#lancamentoConta").find("#repTipo:checked").val();
				$.post("server/financeiro.php",{funcao:3,id:id,ban_id:banco,pag_id:pagamento,quant:qtd,repTipo:repTipo}).done(function(data){
					if(data == 1){
						alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
						$("#datatable_col_reorder").dataTable().fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $tipo;?>');
						$("#cadastro").dialog('close');
					}else{
						alerta("AVISO!","Não foi possível concluir esta operação!","danger","ban");
					}
				}).fail(function(){
					alerta("FUNÇÃO NÃO ENCONTRADA!","","danger","warning");
				});
			});
		});

		//cancelando baixa
		$("#cancelar2").click(function(){
			confirma("ATENÇÃO","Você deseja cancelar esta baixa?",function(){
				$.ajax({
					url: 'server/financeiro.php',
					type: 'POST',
					cache: false,
					data: {funcao:5,id:"<?php echo $id;?>",tipo:"<?php echo $tipo;?>"},
					success: function(data) {
						if(data == 1){
							alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
							$("#datatable_col_reorder").dataTable().fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $tipo;?>');
							$("#cadastro").dialog('close');
						}else{
							alerta("AVISO!","Não foi possível cancelar a baixa deste item!","danger","ban");
						}
					}
				});
			});
		});


		$("#cancelar3").click(function(){
			confirma("DESEJA DESFAZER ESTA AGLUTINAÇÃO?","Caso sim, este título será excluído permanentemente do sistema e todos os títulos aglutinados voltarão ao seu estado aguardando baixa, esta certo disso?",function(){
				$.ajax({
					url: 'server/financeiro.php',
					type: 'POST',
					cache: false,
					data: {funcao:25,id:"<?php echo $id;?>",tipo:"<?php echo $tipo;?>"},
					success: function(data) {
						if(data == 1){
							alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
							$("#datatable_col_reorder").dataTable().fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $tipo;?>');
							$("#cadastro").dialog('close');
						}else{
							alerta("AVISO!","Não foi possível cancelar a baixa deste item!","danger","ban");
						}
					}
				});
			});
		});
	</script>
	<?php
};

?>