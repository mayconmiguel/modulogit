<?php
require_once "../server/seguranca.php";
$titulos = $_POST['titulos'];
$tipo = $_POST['tipo'];
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));
$total = 0;
$content = "";
foreach($titulos as $id){

	$select = "select pessoa.nome as pessoa,financeiro.emp_id, concat(financeiro.cheque,financeiro.boleto) as numero,financeiro.valorliquido from pessoa,financeiro where pessoa.id = financeiro.pes_id and financeiro.id = ".$id;
	$valida = mysqli_query($con,$select);
	if($row = mysqli_fetch_array($valida)){
		$total += $row['valorliquido'];
		$empresa = $row['emp_id'];
		$content .= "NOME: ".substr($row['pessoa'],0,20)."   |   NÚMERO: ".$row['numero']."   |   VALOR: ".$row['valorliquido']."\n";
	}

}

?>
<div id="baixaFinanceiro">
	<div class="row">
		<div class="col-sm-6 col-xs-12 font-lg">
			TOTAL À BAIXAR: R$ <?php echo number_format($total,2,",",".");?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-4 col-xs-6">
			Empresa
			<select class="form-control" id="empresa"></select>
		</div>
		<div class="col-sm-4 col-xs-6">
			Banco
			<select class="form-control" id="banco"></select>
		</div>
		<div class="col-sm-4 col-xs-6">
			Nat. Financeira
			<select class="form-control" id="natureza"></select>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3 col-xs-6">
			C. de Custo
			<select class="form-control" id="centrocusto"></select>
		</div>
		<div class="col-sm-3 col-xs-6">
			Form. Pagamento
			<select class="form-control" id="pagamento"></select>
		</div>
		<div class="col-sm-2 col-xs-6">
			Número
			<input class="form-control" id="numero">
		</div>
		<div class="col-sm-2 col-xs-6">
			Data Baixa
			<input class="form-control" id="dt_baixa" value="<?php echo date('d/m/Y');?>">
		</div>
		<div class="col-sm-2 col-xs-6">
			Vlr Baixa
			<input class="form-control" id="pr_baixa" value="<?php echo $total;?>">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			OBS<textarea class="form-control" id="obs"><?php echo $content;?></textarea>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<a href="javascript:void(0);" id="baixar" class="btn btn-sm btn-primary"> <span class="btn-label"><i class="glyphicon glyphicon-chevron-down"></i></span>EFETUAR BAIXAR</a>
		</div>
	</div>
</div>

<script>
	loading('show');
	$("#baixaFinanceiro").find("#pr_bruto,#desc_real,#juros_real,#pr_baixa").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});

	$("#baixaFinanceiro").find("#dt_fat,#dt_cad,#dt_baixa").datepicker({
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

	$("#baixaFinanceiro").find("#empresa").change(function(){
		var banco2 = $("#baixaFinanceiro").find("#empresa option:selected").attr('bancos').split(',');
		var ban = "(";
		for(b in banco2){
			ban += 'id = '+banco2[b]+' or ';
		};
		ban = ban.substr(0,ban.length-4);
		ban = ban + ')';
		$.post("server/recupera.php",{tabela:'banco where '+ban+' order by cod asc'}).done(function(data2){
			var obj2 = JSON.parse(data2);
			for(o2 in obj2){
				if(o2 == 0){
					$("#baixaFinanceiro").find("#banco").empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

				}else{
					$("#baixaFinanceiro").find("#banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

				}
			}
		}).fail(function(){

		});
	});

	$.post("server/recupera.php",{tabela:'empresa where tipo = 1'}).done(function(data){
		var obj = JSON.parse(data);
		for(o in obj){
			if(o == 0){
				if(obj[o].id == <?php echo $empresa;?>){
					$("#baixaFinanceiro").find("#empresa").empty().append('<option selected bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
				}else{
					$("#baixaFinanceiro").find("#empresa").empty().append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
				}
				var banco2 = obj[o].bancos.split(',');
				var ban = "(";
				for(b in banco2){
					ban += 'id = '+banco2[b]+' or ';
				};
				ban = ban.substr(0,ban.length-4);
				ban = ban + ')';

				$.post("server/recupera.php",{tabela:'banco where '+ban+ ' order by cod asc'}).done(function(data2){
					var obj2 = JSON.parse(data2);
					for(o2 in obj2){
						if(o2 == 0){
							$("#baixaFinanceiro").find("#banco").empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
							$("#baixaFinanceiro").find("#bx_banco").empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

						}else{
							$("#baixaFinanceiro").find("#banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
							$("#baixaFinanceiro").find("#bx_banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

						}
					}
				}).fail(function(){

				});
			}else{
				if(obj[o].id  == <?php echo $empresa;?>){
					$("#baixaFinanceiro").find("#empresa").append('<option selected bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
				}else{
					$("#baixaFinanceiro").find("#empresa").append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
				}
			}
		}

	}).fail(function(){

	});



	$.post("server/recupera.php",{tabela:'pagamento order by nome'}).done(function(data){
		var obj = JSON.parse(data);
		for(o in obj){
			if(o == 0){
				$("#baixaFinanceiro").find("#pagamento").empty().append('<option checked condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
			}else{
				$("#baixaFinanceiro").find("#pagamento").append('<option condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
			}
		}
		var condicao       = $("#baixaFinanceiro").find("#pagamento option:selected").attr('condicao');
		if(condicao == 2){
			$("#baixaFinanceiro").find("#qtd").removeAttr("disabled");
		}else{
			$("#baixaFinanceiro").find("#qtd").attr("disabled",true);
		};
	}).fail(function(){

	});
	var natureza;
	$.post("server/recupera.php",{tabela:'natureza  where tipo like "%<?php echo $tipo;?>%" order by nome asc'}).done(function(data){
		var obj = JSON.parse(data);
		for(o in obj){
			if(o == 0){
				$("#baixaFinanceiro").find("#natureza").empty().append('<option selected value="'+obj[o].id+'">'+obj[o].nome+'</option>');
			}else{
				$("#baixaFinanceiro").find("#natureza").append('<option value="'+obj[o].id+'">'+obj[o].nome+'</option>');
			}
		};
		//busca centro de custo
		var natureza = $("#baixaFinanceiro").find("#natureza option:selected").val();
		var campoT   = natureza.length;
		var query = " (left(naturezas,"+campoT+") = '"+natureza+"' or naturezas like '%,"+natureza+"%') order by nome";
		$.post("server/recupera.php",{tabela:'centrocusto where '+query }).done(function(data){
			var obj = JSON.parse(data);
			for(o in obj){
				if(o == 0){
					$("#baixaFinanceiro").find("#centrocusto").empty().append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}else{
					$("#baixaFinanceiro").find("#centrocusto").append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}
			};
		}).fail(function(){

		});
	}).fail(function(){

	});

	$("#baixaFinanceiro").find("#natureza").change(function(){
		var natureza = $(this).val();
		var campoT   = natureza.length;
		var query = " (left(naturezas,"+campoT+") = '"+natureza+"' or naturezas like '%,"+natureza+"%')";
		$.post("server/recupera.php",{tabela:'centrocusto where '+query }).done(function(data){
			var obj = JSON.parse(data);
			for(o in obj){
				if(o == 0){
					$("#baixaFinanceiro").find("#centrocusto").empty().append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}else{
					$("#baixaFinanceiro").find("#centrocusto").append('<option naturezas="'+obj[o].naturezas+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
				}
			};
		}).fail(function(){

		});
	});

	$("#baixaFinanceiro").find("#baixar").click(function(){
		var titulos     = "<?php echo implode(',',$titulos);?>".split(",");
		var total       = parseFloat("<?php echo $total;?>");
		var empresa 	= $("#baixaFinanceiro").find("#empresa option:selected").val();
		var banco	 	= $("#baixaFinanceiro").find("#banco option:selected").val();
		var centrocusto = $("#baixaFinanceiro").find("#centrocusto option:selected").val();
		var natureza	= $("#baixaFinanceiro").find("#natureza option:selected").val();
		var pagamento	= $("#baixaFinanceiro").find("#pagamento option:selected").val();
		var numero		= $("#baixaFinanceiro").find("#numero").val();
		var dt_baixa	= $("#baixaFinanceiro").find("#dt_baixa").val();
		var valorliquido= parseFloat($("#baixaFinanceiro").find("#pr_baixa").val().replace(",","."));
		var obs   		= $("#baixaFinanceiro").find("#obs").val();
		var tipo		= "<?php echo $tipo+2;?>";
		var aglutinado  = 1;

		if(dt_baixa.length != 10){
			alerta("Verifique a data da baixa!","A data da baixa está incorreta ou o campo não foi preenchido!","warning","warning");
			$("#baixaFinanceiro").find("#dt_baixa").focus().select();
		}else if(valorliquido.length <=0){
			alerta("Aviso","O valor líquido deve ser maior que 0.","warning","warning");
		}else{
			if(valorliquido > total){
				valorliquido = total;
			}
			confirma("Aviso!","Deseja realizar esta baixa no valor de R$ "+valorliquido.toFixed(2)+"?",function(){
				loading("show");

				if(valorliquido >= total){
					valorliquido = total;

					if(titulos.length == 1){
						for(i in titulos){
							$.post('server/financeiro.php',{funcao:18,id:titulos[i],dt_baixa:dt_baixa,tipo:<?php echo $tipo+2;?>});
						}
						$.post('server/financeiro.php',{funcao:2,id:titulos[0],pr_liquido:total,emp_id:empresa,quant:1,ban_id:banco,cen_id:centrocusto,nat_id:natureza,pag_id:pagamento,dt_emi:dt_baixa,dt_fat:dt_baixa,dt_baixa:dt_baixa,cheque:numero,obs:obs,tipo:tipo}).done(function(data){
							if(data != 0){
								alerta("Sucesso!","Operação realizada com sucesso!","success","check");
							}else{
								alerta("Erro!","Não foi possível executar esta operação!","danger","danger");
							}
						}).fail(function(){

						});
					}else{

						$.post('server/financeiro.php',{aglutinado:aglutinado,funcao:1,cli_id:42624,pr_liquido:total,emp_id:empresa,quant:1,ban_id:banco,cen_id:centrocusto,nat_id:natureza,pag_id:pagamento,dt_emi:dt_baixa,dt_fat:dt_baixa,dt_baixa:dt_baixa,cheque:numero,obs:obs,tipo:tipo}).done(function(data){
							if(data != 0){
								for(i in titulos){
									$.post('server/financeiro.php',{aglu_id:data,funcao:18,id:titulos[i],dt_baixa:dt_baixa,tipo:<?php echo $tipo+2;?>});
								}
								alerta("Sucesso!","Operação realizada com sucesso!","success","check");
							}else{
								alerta("Erro!","Não foi possível executar esta operação!","danger","danger");
							}
						}).fail(function(){

						});
					}

					//criar um único título com o valor total baixado e deleta todos os outros títulos.
				}else{

					/*for(i in titulos){
						$.post('server/financeiro.php',{funcao:10,id:titulos[i]});
					}
					$.post('server/financeiro.php',{funcao:1,cli_id:42624,pr_liquido:valorliquido,emp_id:empresa,quant:1,ban_id:banco,cen_id:centrocusto,nat_id:natureza,pag_id:pagamento,dt_emi:dt_baixa,dt_fat:dt_baixa,dt_baixa:dt_baixa,cheque:numero,obs:obs,tipo:tipo}).done(function(data){
						if(data != 0){

							alerta("Sucesso!","Operação realizada com sucesso!","success","check");
						}else{
							alerta("Erro!","Não foi possível executar esta operação!","danger","danger");
						}
					}).fail(function(){

					});
					$.post('server/financeiro.php',{funcao:1,cli_id:42624,pr_liquido:(total-valorliquido),emp_id:empresa,quant:1,ban_id:banco,cen_id:centrocusto,nat_id:natureza,pag_id:pagamento,dt_emi:dt_baixa,dt_fat:dt_baixa,dt_baixa:dt_baixa,cheque:numero,obs:obs,tipo:"<?php echo $tipo;?>"}).done(function(data){
						if(data != 0){

							alerta("Sucesso!","Operação realizada com sucesso!","success","check");
						}else{
							alerta("Erro!","Não foi possível executar esta operação!","danger","danger");
						}
					}).fail(function(){

					});
					*/

					//cria um único título com o valor informado baixado;
					//gera outro título sem baixar com o restante do valor;
				}

				setTimeout(function(){
					confirma("Atenção!","Deseja imprimir o comprovante desta operação?",function(){
						comprovante("server/comprovante.php","banco="+banco+"&titulos=<?php echo implode(',',$titulos);?>&funcao=3&tipo="+"<?php echo $tipo;?>");
					});
					$('#datatable_col_reorder').dataTable().fnReloadAjax();
					$("#cadastro").dialog('close');
					loading("hide");
				},1000);

			});
		}
	});
	setTimeout(function(){
		loading('hide');
		$("#baixaFinanceiro").find("#empresa").change();
	},1000);


</script>