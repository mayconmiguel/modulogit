<?php
require_once "../server/seguranca.php";
$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>
	<br>
	<div id="lancamentoConta" class="col-xs-12">
		<div class="row">
			<div class="col-sm-6 col-xs-12"><label class="label label-danger font-sm" id="saldo_origem"></label></div>
			<div class="col-sm-6 col-xs-12"><label class="label label-success font-sm" id="saldo_destino"></label></div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12 txt-color-red">EMP. ORIGEM
				<div class="icon-addon addon-sm">
					<select class="form-control txt-color-red" id="emp_origem">

					</select>
					<label class="glyphicon glyphicon-transfer txt-color-red" for="email" rel="tooltip" title="" data-original-title="email"></label>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12 txt-color-red">EMP. ORIGEM
				<div class="icon-addon addon-sm">
					<select class="form-control txt-color-red" id="emp_origem">

					</select>
					<label class="glyphicon glyphicon-transfer txt-color-red" for="email" rel="tooltip" title="" data-original-title="email"></label>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12 txt-color-greenDark">EMP. DESTINO
				<div class="icon-addon addon-sm">
					<select class="form-control txt-color-greenDark" id="emp_destino">

					</select>
					<label class="glyphicon glyphicon-transfer txt-color-greenDark" for="email" rel="tooltip" title="" data-original-title="email"></label>
				</div>

			</div>

		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12 txt-color-red">BANCO ORIGEM
				<div class="icon-addon addon-sm">
					<select class="form-control txt-color-red" id="ban_origem">
						<option value="0">SELECIONE A EMPRESA DE ORIGEM</option>
					</select>
					<label class="glyphicon glyphicon-transfer txt-color-red" for="email" rel="tooltip" title="" data-original-title="email"></label>
				</div>
			</div>
			<div class="col-sm-6 col-xs-12 txt-color-greenDark">BANCO DESTINO
				<div class="icon-addon addon-sm">
					<select class="form-control txt-color-greenDark" id="ban_destino">

					</select>
					<label class="glyphicon glyphicon-transfer txt-color-greenDark" for="email" rel="tooltip" title="" data-original-title="email"></label>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 col-xs-12">VALOR À TRANSFERIR
				<input class="form-control" id="valorliquido"/>
			</div>
			<div class="col-sm-6 col-xs-12">DATA TRANSF.
				<input class="form-control" id="dt_transf" value="<?php echo date('d/m/Y');?>"/>
			</div>
		</div>
	</div>

	<div class="col-xs-12 center">
		<div class="row">
			<div class="col-xs-12">
				<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>TRANSFERIR</a>
			</div>
		</div>
	</div>

	<script>
		$("#lancamentoConta").find("#qtd,#bx_qtd").mask("00");

		$(function(){


		});


		$("#lancamentoConta").find("#dt_transf").datepicker({
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
		$(document).on("focus", "#dt_transf", function () {
			$(this).mask("00/00/0000");
		});

		$("#lancamentoConta").find("#valorliquido").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});

		empresaBusca($("#emp_origem"),$("#ban_origem"),"<?php echo $empresa;?>");
		empresaBusca($("#emp_destino"),$("#ban_destino"),"<?php echo $empresa;?>");

		$("#cadastrar").click(function(){
			var emp_origem		= $("#lancamentoConta").find("#emp_origem option:selected").val();
			var ban_origem		= $("#lancamentoConta").find("#ban_origem option:selected").val();
			var emp_destino		= $("#lancamentoConta").find("#emp_destino option:selected").val();
			var ban_destino		= $("#lancamentoConta").find("#ban_destino option:selected").val();
			var valorTransf 	= parseFloat($("#lancamentoConta").find("#valorliquido").val().replace("R$ ","").replace(",","."));
			if(valorTransf.length == 0 || valorTransf == undefined || valorTransf == null || isNaN(valorTransf)){
				valorTransf = 0;
			}
			var dt_baixa		= $("#lancamentoConta").find("#dt_transf").val();
			var obs				= $("#lancamentoConta").find("#obs").val();

			if((emp_origem == emp_destino) && (ban_origem == ban_destino)){
				alerta("Aviso","Não é possivel realizar uma tranferência para a mesma empresa e mesmo banco!","warning","warning");
			}
			else if(valorTransf == 0){
				alerta("Aviso","Não é possível realizar uma tranferência com valores zerados","warning","warning");
			}
			else if(valorTransf > parseFloat($("#saldo_origem").attr('saldo'))){
				alerta("Aviso","O valor à transferir não pode ser superior ao saldo da conta de origem!","warning","warning");
			}
			else{
				confirma("Aviso!","Deseja realizar a transferência no valor de R$ "+valorTransf.toFixed(2).replace(".",","),function(){
					$.post('server/financeiro.php',{funcao:26,pr_liquido:valorTransf,emp_origem:emp_origem,ban_origem:ban_origem,emp_destino:emp_destino,ban_destino:ban_destino,obs:obs,dt_baixa:dt_baixa}).done(function(data){
						if(data == 0){
							alerta("Erro!","Não foi possivel realizar esta operação","danger","ban");
						}else{
							alerta("Transferência Realizada com sucesso!","","success","check");
							$("#cadastro").dialog('close');
						}
					});
				});
			}
		});



		function empresaBusca(a,e,d,c){
			$.post("server/recupera.php",{tabela:'empresa where grp_emp_id = '+d+' and tipo = 1'}).done(function(data){
				var obj = JSON.parse(data);
				for(o in obj){
					if(o == 0){
						$(a).empty().append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
						var banco2 = obj[o].bancos.split(',');
						var ban = "(";
						for(b in banco2){
							ban += 'id = '+banco2[b]+' or ';
						};
						ban = ban.substr(0,ban.length-4);
						ban = ban + ')';

						if(c){
							ban += " order by id desc";
						}
						$.post("server/recupera.php",{tabela:'banco where '+ban}).done(function(data2){
							var obj2 = JSON.parse(data2);
							for(o2 in obj2){
								if(o2 == 0){
									$(e).empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
								}else{
									$(e).append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
								}
							}
						}).fail(function(){

						});
					}else{
						$(a).append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
					}
				}
				setTimeout(function(){
					var valorTransf = parseFloat($("#valorliquido").val().replace("R$ ","").replace(",","."));
					if(valorTransf.length == 0 || valorTransf == undefined || valorTransf == null || isNaN(valorTransf)){
						valorTransf = 0;
					}
					$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_origem").find('option:selected').val()+" and ban_id = "+$("#ban_origem").find('option:selected').val()+" and conciliada = 1 and (status = 3)"}).done(function(data){
						var despesas = -Math.abs(parseFloat(JSON.parse(data)[0].valorliquido));
						if(despesas == null || despesas == undefined || despesas.length == 0 || isNaN(despesas)){
							despesas = 0;
						}
						$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_origem").find('option:selected').val()+" and ban_id = "+$("#ban_origem").find('option:selected').val()+" and conciliada = 1 and (status = 4)"}).done(function(data2){
							var receitas =  Math.abs(parseFloat(JSON.parse(data2)[0].valorliquido));
							if(receitas == null || receitas == undefined || receitas.length == 0 || isNaN(receitas)){
								receitas = 0;
							}
							var totalorigem = (receitas+despesas-valorTransf).toFixed(2);

							$("#saldo_origem").html('SALDO ORIGEM: R$ '+totalorigem.replace('.',","));
							$("#saldo_origem").attr('saldo',totalorigem);

						});
					});
					$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_destino").find('option:selected').val()+" and ban_id = "+$("#ban_destino").find('option:selected').val()+" and conciliada = 1 and (status = 3)"}).done(function(data){
						var despesas2 = -Math.abs(parseFloat(JSON.parse(data)[0].valorliquido));
						if(despesas2 == null || despesas2 == undefined || despesas2.length == 0 || isNaN(despesas2)){
							despesas2 = 0;
						}
						$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_destino").find('option:selected').val()+" and ban_id = "+$("#ban_destino").find('option:selected').val()+" and conciliada = 1 and (status = 4)"}).done(function(data2){
							var receitas2 =  Math.abs(parseFloat(JSON.parse(data2)[0].valorliquido));
							if(receitas2 == null || receitas2 == undefined || receitas2.length == 0 || isNaN(receitas2)){
								receitas2 = 0;
							}
							var totaldestino = (receitas2+despesas2+valorTransf).toFixed(2);

							$("#saldo_destino").html('SALDO DESTINO: R$ '+totaldestino.replace('.',","));
						});
					});
				},1000);
			}).fail(function(){

			});

			$(a).change(function(){
				var banco2 = $(this).find("option:selected").attr('bancos').split(',');
				var ban = "(";
				for(b in banco2){
					ban += 'id = '+banco2[b]+' or ';
				};
				ban = ban.substr(0,ban.length-4);
				ban = ban + ')';
				$.post("server/recupera.php",{tabela:'banco where '+ban}).done(function(data2){
					var obj2 = JSON.parse(data2);
					for(o2 in obj2){
						if(o2 == 0){
							$(e).empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

						}else{
							$(e).append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

						}
					};

					var valorTransf = parseFloat($("#valorliquido").val().replace("R$ ","").replace(",","."));
					if(valorTransf.length == 0 || valorTransf == undefined || valorTransf == null || isNaN(valorTransf)){
						valorTransf = 0;
					}
					$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_origem").find('option:selected').val()+" and ban_id = "+$("#ban_origem").find('option:selected').val()+" and conciliada = 1 and (status = 3)"}).done(function(data){
						var despesas = -Math.abs(parseFloat(JSON.parse(data)[0].valorliquido));
						if(despesas == null || despesas == undefined || despesas.length == 0 || isNaN(despesas)){
							despesas = 0;
						}
						$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_origem").find('option:selected').val()+" and ban_id = "+$("#ban_origem").find('option:selected').val()+" and conciliada = 1 and (status = 4)"}).done(function(data2){
							var receitas =  Math.abs(parseFloat(JSON.parse(data2)[0].valorliquido));
							if(receitas == null || receitas == undefined || receitas.length == 0 || isNaN(receitas)){
								receitas = 0;
							}
							var totalorigem = (receitas+despesas-valorTransf).toFixed(2);

							$("#saldo_origem").html('SALDO ORIGEM: R$ '+totalorigem.replace('.',","));
							$("#saldo_origem").attr('saldo',totalorigem);
						});
					});
					$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_destino").find('option:selected').val()+" and ban_id = "+$("#ban_destino").find('option:selected').val()+" and conciliada = 1 and (status = 3)"}).done(function(data){
						var despesas2 = -Math.abs(parseFloat(JSON.parse(data)[0].valorliquido));
						if(despesas2 == null || despesas2 == undefined || despesas2.length == 0 || isNaN(despesas2)){
							despesas2 = 0;
						}
						$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_destino").find('option:selected').val()+" and ban_id = "+$("#ban_destino").find('option:selected').val()+" and conciliada = 1 and (status = 4)"}).done(function(data2){
							var receitas2 =  Math.abs(parseFloat(JSON.parse(data2)[0].valorliquido));
							if(receitas2 == null || receitas2 == undefined || receitas2.length == 0 || isNaN(receitas2)){
								receitas2 = 0;
							}
							var totaldestino = (receitas2+despesas2+valorTransf).toFixed(2);

							$("#saldo_destino").html('SALDO DESTINO: R$ '+totaldestino.replace('.',","));
						});
					});
				}).fail(function(){

				});
			});
			$(e).change(function(){
				var valorTransf = parseFloat($("#valorliquido").val().replace("R$ ","").replace(",","."));
				if(valorTransf.length == 0 || valorTransf == undefined || valorTransf == null || isNaN(valorTransf)){
					valorTransf = 0;
				}
				$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_origem").find('option:selected').val()+" and ban_id = "+$("#ban_origem").find('option:selected').val()+" and conciliada = 1 and (status = 3)"}).done(function(data){
					var despesas = -Math.abs(parseFloat(JSON.parse(data)[0].valorliquido));
					if(despesas == null || despesas == undefined || despesas.length == 0 || isNaN(despesas)){
						despesas = 0;
					}
					$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_origem").find('option:selected').val()+" and ban_id = "+$("#ban_origem").find('option:selected').val()+" and conciliada = 1 and (status = 4)"}).done(function(data2){
						var receitas =  Math.abs(parseFloat(JSON.parse(data2)[0].valorliquido));
						if(receitas == null || receitas == undefined || receitas.length == 0 || isNaN(receitas)){
							receitas = 0;
						}
						var totalorigem = (receitas+despesas-valorTransf).toFixed(2);

						$("#saldo_origem").html('SALDO ORIGEM: R$ '+totalorigem.replace('.',","));
						$("#saldo_origem").attr('saldo',totalorigem);
					});
				});
				$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_destino").find('option:selected').val()+" and ban_id = "+$("#ban_destino").find('option:selected').val()+" and conciliada = 1 and (status = 3)"}).done(function(data){
					var despesas2 = -Math.abs(parseFloat(JSON.parse(data)[0].valorliquido));
					if(despesas2 == null || despesas2 == undefined || despesas2.length == 0 || isNaN(despesas2)){
						despesas2 = 0;
					}
					$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_destino").find('option:selected').val()+" and ban_id = "+$("#ban_destino").find('option:selected').val()+" and conciliada = 1 and (status = 4)"}).done(function(data2){
						var receitas2 =  Math.abs(parseFloat(JSON.parse(data2)[0].valorliquido));
						if(receitas2 == null || receitas2 == undefined || receitas2.length == 0 || isNaN(receitas2)){
							receitas2 = 0;
						}
						var totaldestino = (receitas2+despesas2+valorTransf).toFixed(2);

						$("#saldo_destino").html('SALDO DESTINO: R$ '+totaldestino.replace('.',","));
					});
				});
			});
		}
		var timer;
		var x;
		$("#valorliquido").keyup(function(){
			if(this.value.length > 2){
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = atual();
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}else{
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = atual();
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}
		});


		function atual(){
			var valorTransf = parseFloat($("#valorliquido").val().replace("R$ ","").replace(",","."));
			if(valorTransf.length == 0 || valorTransf == undefined || valorTransf == null || isNaN(valorTransf)){
				valorTransf = 0;
			}
			$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_origem").find('option:selected').val()+" and ban_id = "+$("#ban_origem").find('option:selected').val()+" and conciliada = 1 and (status = 3)"}).done(function(data){
				var despesas = -Math.abs(parseFloat(JSON.parse(data)[0].valorliquido));
				if(despesas == null || despesas == undefined || despesas.length == 0 || isNaN(despesas)){
					despesas = 0;
				}
				$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_origem").find('option:selected').val()+" and ban_id = "+$("#ban_origem").find('option:selected').val()+" and conciliada = 1 and (status = 4)"}).done(function(data2){
					var receitas =  Math.abs(parseFloat(JSON.parse(data2)[0].valorliquido));
					if(receitas == null || receitas == undefined || receitas.length == 0 || isNaN(receitas)){
						receitas = 0;
					}
					var totalorigem = (receitas+despesas-valorTransf).toFixed(2);

					$("#saldo_origem").html('SALDO ORIGEM: R$ '+totalorigem.replace('.',","));
				});
			});
			$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_destino").find('option:selected').val()+" and ban_id = "+$("#ban_destino").find('option:selected').val()+" and conciliada = 1 and (status = 3)"}).done(function(data){
				var despesas2 = -Math.abs(parseFloat(JSON.parse(data)[0].valorliquido));
				if(despesas2 == null || despesas2 == undefined || despesas2.length == 0 || isNaN(despesas2)){
					despesas2 = 0;
				}
				$.post('server/recupera2.php',{tabela:"select sum(valorliquido) as valorliquido from financeiro where emp_id = "+$("#emp_destino").find('option:selected').val()+" and ban_id = "+$("#ban_destino").find('option:selected').val()+" and conciliada = 1 and (status = 4)"}).done(function(data2){
					var receitas2 =  Math.abs(parseFloat(JSON.parse(data2)[0].valorliquido));
					if(receitas2 == null || receitas2 == undefined || receitas2.length == 0 || isNaN(receitas2)){
						receitas2 = 0;
					}
					var totaldestino = (receitas2+despesas2+valorTransf).toFixed(2);

					$("#saldo_destino").html('SALDO DESTINO: R$ '+totaldestino.replace('.',","));
				});
			});
		}
	</script>