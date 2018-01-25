<?php
	require_once("inc/init.php");
	require_once "../server/seguranca.php";
	$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
	$id = $_POST['id'];
?>
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-233" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
	<header>
		<h2>Saldo Financeiro</h2>
	</header>

	<!-- widget div-->
	<div>

		<!-- widget edit box -->
		<div class="jarviswidget-editbox">
			<!-- This area used as dropdown edit box -->

		</div>
		<!-- end widget edit box -->

		<!-- widget content -->
		<div class="widget-body no-padding">

			<table id="dt_basic_fin" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
				<tr>
					<th>

					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="PROCEDIMENTO" />
					</th>

					<th class="hasinput">
						<input type="text" class="form-control" placeholder="DT. FAT." />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="DT. PAG." />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="VALOR" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="SITUAÇÃO" />
					</th>

				</tr>
				<tr>
					<th>SEL.</th>
					<th data-class="expand" style="text-align: center">PROCEDIMENTO</th>

					<th  style="text-align: center">DT. FAT.</th>
					<th  style="text-align: center">DT. PAG.</th>
					<th  style="text-align: center">VALOR</th>
					<th data-hide="phone,tablet" style="text-align: center">SITUAÇÃO</th>
				</tr>
				</thead>
			</table>

		</div>
		<div class="row hidden" id="pg_baixa">

		</div>
		<br>
		<div class="row">
			<div class="col-sm-6 col-xs-12" id="label_pagar"></div>
			<div class="col-sm-6 col-xs-12 text-align-right" id="label_pagamento"></div>
		</div>
		<br>

		<div class="row">
			<div class="col-sm-6 col-xs-12 text-align-left">
				<!--<button class="btn btn-warning btn-lg  hidden" type="button" id="btn_outro"> + INSERIR </button>-->
			</div>
			<div class="col-sm-6 col-xs-12 text-align-right">
				<button class="btn btn-danger btn-lg  hidden" type="button" id="btn_cancelar"> CANCELAR </button>
				<button class="btn btn-primary btn-lg hidden" type="button" id="btn_total_pagar"> REALIZAR PAGAMENTO </button>
				<button class="btn btn-success btn-lg  hidden" type="button" id="btn_pagar"> PAGAR </button>
			</div>
		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->
</div>
<script>
	pageSetUp();
	var pagefunction = function() {
		var total = 0;

		$("#add_especialidade").click(function(){

			var numero  	= $("#pastaCli").find("#numero").val();
			var especialidade= $("#pastaCli").find("#especialidade option:selected").val();

			var empresa		= $("#pastaCli").find("#emp_id option:selected").val();



			if(isNaN(numero) || numero == undefined || numero == null || numero.length == 0){
				numero = 0;
			};

			if(especialidade == 0){
				alerta("Selecione um especialidade!","","warning","warning");
			}
			else{
				confirma("Aviso","Deseja vincular este especialidade a este <?php echo $_SESSION['config']['cliente'];?>?",function(){
					$.post('server/pasta.php',{
						numero:numero,
						especialidade	  :especialidade,
						empresa   :empresa,
						id		  :<?php echo $id;?>
					}).done(function(data){
						if(data == 99999999999){
							alerta("especialidade não registrada!","Esta especialidade já existe para este <?php echo $_SESSION['config']['cliente'];?>","danger","ban");
						}
						else if(data > 0){
							alerta("Sucesso!","especialidade adicionado com sucesso!","success","check");
						}else{
							alerta("Não foi possível adicionar o especialidade!","","danger","ban");
						}
						$("#dt_basic_fin").dataTable().fnReloadAjax();
					}).fail(function(){

					});
				});
			}

		});


		$.post("server/recupera.php",{tabela:"especialidade where grp_emp_id = <?php echo $_SESSION['imunevacinas']['usuarioEmpresa'];?>"}).done(function(data){
			var obj = JSON.parse(data);
			for (i in obj){
				$("#pastaCli").find("#especialidade").append('<option disciplinas="'+obj[i].disciplinas+'" tipo="'+obj[i].tipo+'" periodos="'+obj[i].periodos+'" value="'+obj[i].id+'">'+obj[i].nome+'</option>');
			}
		}).fail(function(){

		});

		$.post("server/recupera.php",{tabela:"empresa where grp_emp_id = <?php echo $_SESSION['imunevacinas']['usuarioEmpresa'];?>"}).done(function(data){
			var obj = JSON.parse(data);
			for (i in obj){
				$("#pastaCli").find("#emp_id").append('<option value="'+obj[i].id+'">'+obj[i].fantasia+'</option>');
			}
		}).fail(function(){

		});



		$.fn.dataTable.ext.errMode = 'none';

		jQuery.extend( jQuery.fn.dataTableExt.oSort, {
			"date-uk-pre": function ( a ) {
				var ukDatea = a.split('/');
				return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
			},

			"date-uk-asc": function ( a, b ) {
				return ((a < b) ? -1 : ((a > b) ? 1 : 0));
			},

			"date-uk-desc": function ( a, b ) {
				return ((a < b) ? 1 : ((a > b) ? -1 : 0));
			}
		} );

		jQuery.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
		{
			// DataTables 1.10 compatibility - if 1.10 then `versionCheck` exists.
			// 1.10's API has ajax reloading built in, so we use those abilities
			// directly.
			if ( jQuery.fn.dataTable.versionCheck ) {
				var api = new jQuery.fn.dataTable.Api( oSettings );

				if ( sNewSource ) {
					api.ajax.url( sNewSource ).load( fnCallback, !bStandingRedraw );
				}
				else {
					api.ajax.reload( fnCallback, !bStandingRedraw );
				}
				return;
			}

			if ( sNewSource !== undefined && sNewSource !== null ) {
				oSettings.sAjaxSource = sNewSource;
			}

			// Server-side processing should just call fnDraw
			if ( oSettings.oFeatures.bServerSide ) {
				this.fnDraw();
				return;
			}

			this.oApi._fnProcessingDisplay( oSettings, true );
			var that = this;
			var iStart = oSettings._iDisplayStart;
			var aData = [];

			this.oApi._fnServerParams( oSettings, aData );

			oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
				/* Clear the old information from the table */
				that.oApi._fnClearTable( oSettings );

				/* Got the data - add it to the table */
				var aData =  (oSettings.sAjaxDataProp !== "") ?
					that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;

				for ( var i=0 ; i<aData.length ; i++ )
				{
					that.oApi._fnAddData( oSettings, aData[i] );
				}

				oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

				that.fnDraw();

				if ( bStandingRedraw === true )
				{
					oSettings._iDisplayStart = iStart;
					that.oApi._fnCalculateEnd( oSettings );
					that.fnDraw( false );
				}

				that.oApi._fnProcessingDisplay( oSettings, false );

				/* Callback user function - for event handlers etc */
				if ( typeof fnCallback == 'function' && fnCallback !== null )
				{
					fnCallback( oSettings );
				}
			}, oSettings );
		};

		var responsiveHelper_datatable_col_reorder = undefined;


		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		/* COLUMN SHOW - HIDE */
		var table = $('#dt_basic_fin').dataTable({

			oSearch: {"bRegex": true},
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"autoWidth" : true,
			"ajax": "server/buscaClienteFinanceiro.php?pes_id=<?php echo $id;?>",
			"columns": [
				{ "data": "sel" },
				{ "data": "procedimento" },
				{ "data": "dt_fat" },
				{ "data": "dt_baixa" },
				{ "data": "valor" },
				{ "data": "st"}
			],
			"order":[[1,'desc']],
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder) {
					responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#dt_basic_fin'), breakpointDefinition);
				}
			},"oLanguage": {
				"sEmptyTable": "Nenhum registro encontrado",
				"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
				"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
				"sInfoFiltered": "(Filtrados de _MAX_ registros)",
				"sInfoPostFix": "",
				"sInfoThousands": ".",
				"sLengthMenu": "Mostrar _MENU_ resultados por página",
				"sLoadingRecords": "Carregando...",
				"sProcessing": "Processando...",
				"sZeroRecords": "Nenhum registro encontrado",
				"sSearch": "Localizar: ",
				"oPaginate": {
					"sPrevious": "Anterior",
					"sNext": "Próximo",
					"sFirst": "Primeiro",
					"sLast": "Último"
				}
			},
			"colVis": {
				"buttonText": "Mostrar / Ocultar Colunas"
			},
			"rowCallback" : function(nRow,aData,iDisplayIndex) {
				responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);

				var row = table.fnGetNodes(nRow);
				//var ramal = aData.ramal.split("ramal'>");
				//var ramal = ramal[1].replace("</span></span>","");
				//$(row).attr('ramal', ramal);
				$(row).attr('style', 'especialidader:pointer');

				if(aData.status == 2){
					total += parseFloat(aData.valor);
					$("#label_pagar").html('<label class="label bg-color-blueDark font-md" style="height: 100%">TOTAL À PAGAR R$ '+ total.toFixed(2) +"</label>");
				}
			},
			"drawCallback" : function(oSettings,aData) {

				if(total < 0){
					$("#pg_baixa").find("#pr_liquido").attr('disabled',true);
				}else{
					$("#pg_baixa").find("#pr_liquido").removeAttr('disabled');
					$("#btn_total_pagar").removeClass('hidden');
				}

				$("#label_pagar").html('<label class="label bg-color-blueDark font-md" style="height: 100%">TOTAL À PAGAR R$ '+ total.toFixed(2) +"</label>");
				$("#label_pagamento").html('<label class="label bg-color-blueDark font-md" style="height: 100%">PAGAMENTO R$ 0.00</label>');

				responsiveHelper_datatable_col_reorder.respond();
				$("#dt_basic_fin").find('input[name="titulos"]').change(function(){
					total = 0;
					$("#dt_basic_fin").find('input[name="titulos"]:checked').each(function(){
						if($(this).attr('status') == 2){
							total += parseFloat($(this).attr('repasse'));
							data.push({id:$(this).attr('valor'),nat_id:$(this).attr('nat_id'),valor:$(this).attr('repasse'),ap:$(this).attr('ap'),porcentagem:$(this).attr('porcentagem'),apo_id:$(this).attr('apo_id'),obs:$(this).attr('obs')});
						}
					});
					if(total < 0){
						$("#pg_baixa").find("#pr_liquido").attr('disabled',true);
					}else{
						$("#pg_baixa").find("#pr_liquido").removeAttr('disabled');
					}
					$("#label_pagar").html('<label class="label bg-color-blueDark font-md" style="height: 100%">TOTAL À PAGAR R$ '+ total.toFixed(2) +"</label>");
					$("#label_pagamento").html('<label class="label bg-color-blueDark font-md" style="height: 100%">PAGAMENTO R$ 0.00</label>');
				});

			}
		});

		var timer;
		var x;

		$("#dt_basic_fin thead th input[type=text]").on( 'keyup change', function () {
			var campo = $(this);
			if (x) { x.abort() } // If there is an existing XHR, abort it.
			clearTimeout(timer); // Clear the timer so we don't end up with dupes.
			timer = setTimeout(function() { // assign timer a new timeout
				x = atuatu(campo);
				// run ajax request and store in x variable (so we can cancel)
			}, 500); // 2000ms delay, tweak for faster/slower



		} );

		function atuatu(a){
			$("#dt_basic_fin").dataTable().api().column( a.parent().index()+':visible' ).search( a.val() ).draw();
		};

		$('#dt_basic_fin tbody').on( 'dblclick', 'tr', function () {

		} );

		var pg = 1;
		var tudo = 0;
		/*$("#btn_outro").click(function(){
			loading('show');
			$('#pg_baixa').append('<div id="pg'+pg+'">' +
				'<div class="col-sm-3 col-xs-6">'+
				'Empresa'+
				'<select class="form-control" id="empresa"></select>'+
				'</div>'+
				'<div class="col-sm-3 col-xs-6">'+
				'Banco'+
				'<select class="form-control" id="banco"></select>'+
				'</div>'+
				'<div class="col-sm-2 col-xs-6">'+
				'Forma de Pagamento'+
				'<select class="form-control" id="pagamento"></select>'+
				'</div>'+
				'<div class="col-sm-2 col-xs-6">'+
				'Número'+
				'<input class="form-control" id="numero">'+
				'</div>'+
				'<div class="col-sm-2 col-xs-6">'+
				'Vlr. Pagar'+
				'<input class="form-control" id="pr_liquido">'+
				'</div>' +
				'</div>');


			$("#dt_basic_fin").find('input[name="titulos"]:checked').each(function(){
				if($(this).attr('nat_id') == 11 && $("#dt_basic_fin").find('input[name="titulos"]:checked').length == 1){
					$("#btn_pagar").prop("disabled",true);
				}
			});

			$("div[id='pg"+pg+"']").find("#empresa").change(function(){
				var idd = $(this).parent().parent().find('#banco');
				var banco2 = $(this).find("option:selected").attr('bancos').split(',');
				var ban = "(";
				for(b in banco2){
					ban += 'id = '+banco2[b]+' or ';
				};
				ban = ban.substr(0,ban.length-4)+')';

				$.post("server/recupera.php",{tabela:'banco where '+ban+' order by id desc'}).done(function(data2){
					console.log(idd);
					var obj2 = JSON.parse(data2);
					for(o2 in obj2){
						if(o2 == 0){
							idd.empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

						}else{
							idd.append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

						}
					}
				}).fail(function(){

				});
			});
			$("#pg_baixa").removeClass('hidden');
			$("#btn_total_pagar").addClass('hidden');
			$("#btn_pagar,#btn_cancelar,#btn_outro").removeClass('hidden');


			// busca formas de pagamento
			$.post("server/recupera.php",{tabela:'pagamento where grp_emp_id = "<?php echo $empresa;?>"'}).done(function(data){
				var obj2 = JSON.parse(data);
				for(o2 in obj2){
					if(o2 == 0){
						$("div[id='pg"+pg+"']").find("#pagamento").empty().append('<option condicao="'+obj2[o2].condicao+'" value="'+obj2[o2].id+'">'+obj2[o2].nome+'</option>');
					}else{
						if(obj2[o2].id == 2){
							$("div[id='pg"+pg+"']").find("#pagamento").append('<option selected condicao="'+obj2[o2].condicao+'" value="'+obj2[o2].id+'">'+obj2[o2].nome+'</option>');
						}
						else{
							$("div[id='pg"+pg+"']").find("#pagamento").append('<option condicao="'+obj2[o2].condicao+'" value="'+obj2[o2].id+'">'+obj2[o2].nome+'</option>');
						}
					}

				}
				$.post("server/recupera.php",{tabela:'empresa where tipo = 1 and  grp_emp_id = "<?php echo $empresa;?>"'}).done(function(data){

					var obj = JSON.parse(data);
					for(o in obj){
						if(o == 0){
							$("div[id='pg"+pg+"']").find("#empresa").empty().append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
							var banco2 = obj[o].bancos.split(',');
							var ban = "(";
							for(b in banco2){
								ban += 'id = '+banco2[b]+' or ';
							};
							ban = ban.substr(0,ban.length-4);
							ban = ban + ')';
							$.post("server/recupera.php",{tabela:'banco where '+ban+ ' order by id desc'}).done(function(data2){
								var obj2 = JSON.parse(data2);
								for(o2 in obj2){
									if(o2 == 0){
										$("div[id='pg"+pg+"']").find("#banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
									}else{
										$("div[id='pg"+pg+"']").find("#banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
									}
								}
								setTimeout(function(){
									loading('hide');
									pg ++;
								},1500);
							}).fail(function(){
								loading('hide');
							});
						}else{
							$("div[id='pg"+pg+"']").find("#empresa").append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
						}
					}
				}).fail(function(){

				});

			}).fail(function(){

			});
			$("div[id='pg"+pg+"']").find("input[id='pr_liquido']").keyup(function(){
				var tudo = 0;
				$("#pg_baixa").find("input[id='pr_liquido']").each(function(){
					tudo += parseFloat($(this).val().replace("R$ ","").replace(",","."));
				});
				$("#label_pagamento").html('<label class="label bg-color-blueDark font-md" style="height: 100%">PAGAMENTO R$ '+tudo.toFixed(2)+'</label>');
			});
			$("div[id='pg"+pg+"']").find("input[id='pr_liquido']").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'', decimal:',', affixesStay: false});

		});*/
		$("#btn_total_pagar").click(function(){

			loading('show');
			$('#pg_baixa').empty().append('<div id="pg'+pg+'">' +
				'<div class="col-sm-3 col-xs-6">'+
				'Empresa'+
				'<select class="form-control" id="empresa"></select>'+
				'</div>'+
				'<div class="col-sm-3 col-xs-6">'+
				'Banco'+
				'<select class="form-control" id="banco"></select>'+
				'</div>'+
				'<div class="col-sm-2 col-xs-6">'+
				'Forma de Pagamento'+
				'<select class="form-control" id="pagamento"></select>'+
				'</div>'+
				'<div class="col-sm-2 col-xs-6">'+
				'Número'+
				'<input class="form-control" id="numero">'+
				'</div>'+
				'<div class="col-sm-2 col-xs-6">'+
				'Vlr. Pagar'+
				'<input class="form-control" id="pr_liquido">'+
				'</div>' +
				'</div>');


			$("div[id='pg"+pg+"']").find("#empresa").change(function(){
				var idd = $(this).parent().parent().find('#banco');
				var banco2 = $(this).find("option:selected").attr('bancos').split(',');
				var ban = "(";
				for(b in banco2){
					ban += 'id = '+banco2[b]+' or ';
				};
				ban = ban.substr(0,ban.length-4)+')';

				$.post("server/recupera.php",{tabela:'banco where '+ban+' order by id desc'}).done(function(data2){
					console.log(idd);
					var obj2 = JSON.parse(data2);
					for(o2 in obj2){
						if(o2 == 0){
							idd.empty().append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

						}else{
							idd.append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');

						}
					}
				}).fail(function(){

				});
			});

			$("#pg_baixa").removeClass('hidden');
			$("#btn_total_pagar").addClass('hidden');
			$("#btn_pagar,#btn_cancelar,#btn_outro").removeClass('hidden');

			$("#dt_basic_fin").find('input[name="titulos"]:checked').each(function(){
				if($(this).attr('nat_id') == 11 && $("#dt_basic_fin").find('input[name="titulos"]:checked').length == 1){
					$("#btn_pagar").prop("disabled",true);
					$("#btn_outro").addClass('hidden');
				}
			});


			// busca formas de pagamento
			$.post("server/recupera.php",{tabela:'pagamento where  grp_emp_id = "<?php echo $empresa;?>"'}).done(function(data){
				var obj = JSON.parse(data);
				for(o in obj){
					if(o == 0){
						$("div[id='pg"+pg+"']").find("#pagamento").empty().append('<option condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
					}else{
						if(obj[o].id == 2){
							$("div[id='pg"+pg+"']").find("#pagamento").append('<option selected condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
						}
						else{
							$("div[id='pg"+pg+"']").find("#pagamento").append('<option condicao="'+obj[o].condicao+'" value="'+obj[o].id+'">'+obj[o].nome+'</option>');
						}
					}

				}
				$.post("server/recupera.php",{tabela:'empresa where tipo = 1 and  grp_emp_id = "<?php echo $empresa;?>"'}).done(function(data){

					var obj = JSON.parse(data);
					for(o in obj){
						if(o == 0){
							$("div[id='pg"+pg+"']").find("#empresa").empty().append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
							var banco2 = obj[o].bancos.split(',');
							var ban = "(";
							for(b in banco2){
								ban += 'id = '+banco2[b]+' or ';
							};
							ban = ban.substr(0,ban.length-4);
							ban = ban + ')';
							$.post("server/recupera.php",{tabela:'banco where '+ban+ ' order by id desc'}).done(function(data2){
								var obj2 = JSON.parse(data2);
								for(o2 in obj2){
									if(o2 == 0){
										$("div[id='pg"+pg+"']").find("#banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
									}else{
										$("div[id='pg"+pg+"']").find("#banco").append('<option value="'+obj2[o2].id+'">'+obj2[o2].cod+" - "+obj2[o2].banco+'</option>');
									}
								}
								setTimeout(function(){
									loading('hide');
									pg ++;
								},1500);
							}).fail(function(){
								loading('hide');
							});
						}else{
							$("div[id='pg"+pg+"']").find("#empresa").append('<option bancos="'+obj[o].bancos+'" value="'+obj[o].id+'">'+obj[o].razao+'</option>');
						}
					}
				}).fail(function(){

				});

			}).fail(function(){

			});
			$("div[id='pg"+pg+"']").find("input[id='pr_liquido']").keyup(function(){
				var tudo = 0;
				$("#pg_baixa").find("input[id='pr_liquido']").each(function(){
					tudo += parseFloat($(this).val().replace("R$ ","").replace(",","."));
				});
				$("#label_pagamento").html('<label class="label bg-color-blueDark font-md" style="height: 100%">PAGAMENTO R$ '+tudo.toFixed(2)+'</label>');
			});
			$("div[id='pg"+pg+"']").find("input[id='pr_liquido']").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'', decimal:',', affixesStay: false});
			var total = 0;
			$("#dt_basic_fin").find('input[name="titulos"]:checked').each(function(){
				total += parseFloat($(this).attr('repasse'));
			});
			if(total < 0){
				$("#pg_baixa").find("input[id='pr_liquido']").each(function(){
					$(this).prop('disabled',true);
					$("#btn_outro").addClass('hidden');
				});
			}else{
				$("#pg_baixa").find("#input[id='pr_liquido']").each(function(){
					$(this).prop('disabled',false);
					$("#btn_outro").removeClass('hidden');
				});
			}
		});

		$("#btn_pagar").click(function(){
			var dt = "<?php echo date('d/m/Y h:i:s');?>";
			var data = new Array();
			var valorLiquido = 0;
			$("#pg_baixa").find("input[id='pr_liquido']").each(function(){
				valorLiquido += parseFloat($(this).val().replace("R$ ","").replace(",","."));

			});
			valorLiquido = valorLiquido.toFixed(2);
			console.log(valorLiquido);
			if(valorLiquido.length == 0 || !valorLiquido || isNaN(valorLiquido)){
				valorLiquido = 0;
			}
			var total = 0;
			var texto = '';
			$("#dt_basic_fin").find('input[name="titulos"]:checked').each(function(){
				if($(this).attr('status') == 2){
					total += parseFloat($(this).attr('repasse'));
					data.push({id:$(this).attr('valor'),nat_id:$(this).attr('nat_id'),valor:$(this).attr('repasse'),ap:$(this).attr('ap'),porcentagem:$(this).attr('porcentagem'),apo_id:$(this).attr('apo_id'),obs:$(this).attr('obs')});
				}
			});




			if(valorLiquido == 0){
				alerta("Aviso!","Um valor deve ser informado!","warning","warning");
			}else if(valorLiquido < total){
				//alerta("Alerta","O valor à pagar não pode ser diferente do total à pagar","warning","warning");
				confirma("Aviso importante!","Você esta tentando efetuar um pagamento com um valor menor que o total à pagar, caso confirme esta ação, o valor restante será transportado para o próximo relatório e o valor não pago será descontado do relatório atual, você esta certo disso?",function(){
					var texto = "";
					var txt = "";
					var numero      = $("#pg_baixa").find("#numero").val();
					var empresa 	= $("#pg_baixa").find("#empresa option:selected").val();
					var banco 		= $("#pg_baixa").find("#banco option:selected").val();
					var pagamento 	= $("#pg_baixa").find("#pagamento option:selected").val();
					data = [];
					$("#dt_basic_fin").find('input[name="titulos"]:checked').each(function(){
						if($(this).attr('status') == 2){
							total += parseFloat($(this).attr('repasse'));
							data.push({id:$(this).attr('valor'),nat_id:$(this).attr('nat_id'),valor:$(this).attr('repasse'),ap:$(this).attr('ap'),porcentagem:$(this).attr('porcentagem'),apo_id:$(this).attr('apo_id'),obs:$(this).attr('obs')});
						}
					});
					for(i in data){
						texto += "Nº: "+ data[i].id + "/R$ "+data[i].valor+" - ";
					};
					$.ajax({
						url: 'server/financeiro.php',
						data:{funcao:14,dt_baixa:dt,cheque:numero,cli_id:<?php echo $id;?>,valor:pr_liquido,apo_id:apo_id,porcentagem:porcentagem,emp_id:empresa,ban_id:banco,pag_id:pagamento,tipo:3,obs:"Pagamento: "+texto},
						type: 'POST',
						async:true,
						success: function (retorno) {
							if(retorno > 0){
								for(i in data){

									if(data[i].apo_id != null || data[i].apo_id != undefined){
										var apo_id = data[i].apo_id;
										porcentagem = data[i].porcentagem;
									}else{
										var apo_id = null;
									}

									$.post('server/financeiro.php',{funcao:14,dt_baixa:dt,cli_id:<?php echo $id;?>,id:data[i].id,emp_id:empresa,ban_id:banco,pag_id:pagamento,tipo:1,obs:'Título aglutinado: Novo Título gerado ID: '+retorno});
								};
							}
						}
					})


					/*texto = texto.substr(texto,texto.length-3);
					$("#pg_baixa").find("[id^='pg']").each(function(){
						var pr_liquido = parseFloat($(this).find("#pr_liquido").val().replace("R$ ","").replace(",",".")).toFixed(2);
						var empresa    = $(this).find("#empresa").val();
						var banco      = $(this).find("#banco").val();
						var numero     = $(this).find("#numero").val();
						var pagamento  = $(this).find("#pagamento").val();
						var resto = parseFloat(-Math.abs(total - valorLiquido)).toFixed(2);
						if(pr_liquido == "" || isNaN(pr_liquido) || pr_liquido == null || pr_liquido == undefined){
							alerta("Valor de pagamento inválido","tente novamente ou contate o suporte técnico","warning","warning");
						}else{
							$.post('server/financeiro.php',{funcao:14,dt_baixa:dt,cheque:numero,cli_id:<?php echo $id;?>,valor:pr_liquido,apo_id:apo_id,porcentagem:porcentagem,emp_id:empresa,ban_id:banco,pag_id:pagamento,tipo:3,obs:"Pagamento: "+texto}).done(function(data){
								if(data > 0){
									alerta("PAGAMENTO REALIZADO COM SUCESSO!","Título: "+ data + " gerado com sucesso, com o valor total do pagamento!","success","check");
								}else{
									alerta("ERRO AO EFETUAR PAGAMENTO, FAVOR CONFIRA TODOS OS CAMPOS E TENTE NOVAMENTE!","","danger","ban");
								}
							}).fail(function(){
								alerta("ERRO AO EFETUAR PAGAMENTO, VERIFIQUE SUA CONEXÃO COM O SERVIDOR!","","danger","ban");
							});

							$.post('server/financeiro.php',{funcao:14,dt_baixa:dt,cheque:numero,cli_id:<?php echo $id;?>,valor:resto,apo_id:apo_id,porcentagem:porcentagem,emp_id:empresa,ban_id:banco,pag_id:pagamento,tipo:4,obs:"Desconto de pagamento arredondado, este valor será pago no próximo relatório. "}).done(function(data){
								if(data > 0){
									alerta("PAGAMENTO REALIZADO COM SUCESSO!","Título: "+ data + " gerado com sucesso, com o valor total do pagamento!","success","check");
								}else{
									alerta("ERRO AO EFETUAR PAGAMENTO, FAVOR CONFIRA TODOS OS CAMPOS E TENTE NOVAMENTE!","","danger","ban");
								}
							}).fail(function(){
								alerta("ERRO AO EFETUAR PAGAMENTO, VERIFIQUE SUA CONEXÃO COM O SERVIDOR!","","danger","ban");
							});
						}
					});*/
					$("#btn_cancelar").click();


				});
			}else{
				confirma("Deseja realmente efetuar os pagamentos abaixo?","<br>"+texto+
					"<br><label class='font-lg'><b>TOTAL À PAGAR: R$ "+total.toFixed(2)+"</b></label><br>" +
					"<label class='font-md'><b>EMPRESA: </b>"+$("#pg_baixa").find("#empresa option:selected").text()+"</label><br>" +
					"<label class='font-md'><b>BANCO: </b>"+$("#pg_baixa").find("#banco option:selected").text()+"</label><br>" +
					"<label class='font-md'><b>FORMA DE PAGAMENTO: </b>"+$("#pg_baixa").find("#pagamento option:selected").text()+"</label><br>" +
					"<br>Ao Confirmar este pagamento, será criado um único título com o valor total deste pagamento, que será inserido na conta bancária da empresa informada de acordo com a forma de pagamento e quantidade de parcelas informadas.<br>"+
					"",function(){
					//var texto = "Período: "+$("#pagamentoComissao").find("#dt_ini").val()+"  -  "+$("#pagamentoComissao").find("#dt_fim").val()+"  ";
					var texto = "";
					var txt = "";
					var numero      = $("#pg_baixa").find("#numero").val();
					var empresa 	= $("#pg_baixa").find("#empresa option:selected").val();
					var banco 		= $("#pg_baixa").find("#banco option:selected").val();
					var pagamento 	= $("#pg_baixa").find("#pagamento option:selected").val();
					data = [];
					$("#dt_basic_fin").find('input[name="titulos"]:checked').each(function(){
						if($(this).attr('status') == 2){
							total += parseFloat($(this).attr('repasse'));
							data.push({id:$(this).attr('valor'),nat_id:$(this).attr('nat_id'),valor:$(this).attr('repasse'),ap:$(this).attr('ap'),porcentagem:$(this).attr('porcentagem'),apo_id:$(this).attr('apo_id'),obs:$(this).attr('obs')});
						}
					});
					for(i in data){

						if(data[i].apo_id != null || data[i].apo_id != undefined){
							apo_id = data[i].apo_id;
							porcentagem = data[i].porcentagem;
						}
						texto += "Nº: "+ data[i].id + "/R$ "+data[i].valor+" - ";
						if(data[i].ap == 1){
							var tipo = 1;
						}else{
							var tipo = 2;
						};
						$.post('server/financeiro.php',{funcao:14,dt_baixa:dt,cli_id:<?php echo $id;?>,id:data[i].id,emp_id:empresa,ban_id:banco,pag_id:pagamento,tipo:tipo,obs:txt});
					};

					$("#btn_cancelar").click();
				});
			}

			$(".MessageBoxContainer").attr('style','top:0;left:0;width: 100%;height: 100%;overflow: auto;');
			$(".MessageBoxMiddle").attr('style','width: 90%;top:5%;left:5%');
		});

		$("#btn_cancelar").click(function(){
			loading("show");
			$.post("ajax/clienteFinanceiro.php",{id:<?php echo $id;?>}).done(function(data){
				$("#tabs-3").empty().html(data);

			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
			});
			loading("hide");
		});

	};



	// load related plugins

	loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js", pagefunction)
				});
			});
		});
	});
</script>