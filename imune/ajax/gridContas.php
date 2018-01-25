<?php
require_once("inc/init.php");
require_once("../server/seguranca.php");
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));
$mes_start = date('01/m/Y');
$mes_start2 = date('Y-m-01', strtotime('-1 month'));
$mes_end = date('t/m/Y');
$mes_end2 = date('Y-m-t', strtotime('+1 month'));
$type       = $_POST['type'];
if($type == 1){
	$nome 		= "CONTAS À PAGAR";
	$dtdt		= "DT.VENC.";
}
else if($type == 2){
	$nome 		= "CONTAS À RECEBER";
	$dtdt		= "DT.VENC.";
}
else if($type == 3){
	$nome 		= "CONTAS PAGAS";
	$dtdt		= "DT.BAIXA";
}
else if($type == 4){
	$nome 		= "CONTAS RECEBIDAS";
	$dtdt		= "DT.BAIXA";
}
?>
<section id="widget-grid-cliente" class="well">
	<div class="row" style="margin-top: 10px;">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<!-- Widget ID (each widget will need unique ID)-->
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
					<h2><?php echo $nome;?></h2>
					<?php
						if($_POST['type'] == 1 || $_POST['type'] == 2){
							?>
							<div class="widget-toolbar" role="menu">
								<div class="btn-group">
									<button class="btn dropdown-toggle btn-xs btn-danger" data-toggle="dropdown" aria-expanded="false">
										Opções
										<i class="fa fa-caret-down"></i>
									</button>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="javascript:void(0);" id="marcar_todos">Marcar Todos</a>
										</li>
										<li>
											<a href="javascript:void(0);" id="desmarcar_todos">Desmarcar Todos</a>
										</li>
										<li>
											<a href="javascript:void(0);" id="baixar_selecionados">Baixar Títulos Selecionados</a>
										</li>
									</ul>
								</div>
							</div>
							<?php
						}else{
							?>
							<div class="widget-toolbar" role="menu">
								<div class="btn-group">
									<button class="btn dropdown-toggle btn-xs btn-danger" data-toggle="dropdown" aria-expanded="false">
										Opções
										<i class="fa fa-caret-down"></i>
									</button>
									<ul class="dropdown-menu pull-right">
										<li>
											<a href="javascript:void(0);" id="marcar_todos">Marcar Todos</a>
										</li>
										<li>
											<a href="javascript:void(0);" id="desmarcar_todos">Desmarcar Todos</a>
										</li>
										<li>
											<a href="javascript:void(0);" id="comprovante">Imprimir comprovantes - Selecionados</a>
										</li>
										<li>
											<a href="javascript:void(0);" id="cancelar_baixa">Cancelar Baixa - Selecionados</a>
										</li>
										<li>
											<a href="javascript:void(0);" id="conciliar">Conciliação Bancária - Selecionados</a>
										</li>
									</ul>
								</div>
							</div>
							<?php
						}
					?>

				</header>

				<!-- widget div-->
				<div>


					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">

						<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover font-xs" width="100%">
							<thead>
							<tr>
								<th class="hasinput"></th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="ID" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="NOME" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="EMPRESA" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="BANCO" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="DT. EMIS." />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="<?php echo $dtdt;?>" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="VALOR" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="Nº C/B" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="F.PAG" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="C.CUSTO" />
								</th>
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="OBS" />
								</th>
							</tr>
							<tr>
								<th>SEL</th>
								<th data-hide="minimo,phone,meio,tablet">ID</th>
								<th data-class="expand">NOME</th>
								<th data-hide="minimo,phone,meio">EMPRESA</th>
								<th data-hide="minimo,phone,meio">BANCO</th>
								<th data-hide="minimo,phone,meio,tablet">DT. EMIS.</th>
								<th data-hide="minimo,phone,meio"><?php echo $dtdt;?></th>
								<th data-hide="minimo,phone">VALOR</th>
								<th data-hide="minimo,phone,meio,tablet">Nº C/B</th>
								<th data-hide="minimo,phone,meio,tablet">F. PAG.</th>
								<th data-hide="minimo,phone,meio,tablet">C. CUSTO</th>
								<th data-hide="minimo,phone">OBS</th>
							</tr>
							</thead>
						</table>

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>
			<!-- end widget -->

		</article>
		<!-- WIDGET END -->

	</div>

	<!-- end row -->

	<!-- row -->

	<div class="row">

		<!-- a blank row to get started -->
		<div class="col-sm-12">
			<!-- your contents here -->
		</div>

	</div>

	<!-- end row -->

</section>


<!-- end widget grid -->

<script type="text/javascript">

	var SPMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 00000-0009';
		},
		spOptions = {
			onKeyPress: function(val, e, field, options) {
				field.mask(SPMaskBehavior.apply({}, arguments), options);
			}
		};
	$('td[id="tdtelefone"]').mask(SPMaskBehavior, spOptions);
	$('td[id="tdcelular"]').mask(SPMaskBehavior, spOptions);

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
	var pagefunction = function() {


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
			always : 2560,
			tablet : 1024,
			meio   : 720,
			phone  : 480,
			minimo : 300,
		};

		var table = $('#datatable_col_reorder').dataTable({
			aLengthMenu: [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "TODOS"]
			],
			"ajax": "server/buscaFinanceiro.php?type=<?php echo $type;?>",
			"columns": [
				{ "data": "sel" },
				{ "data": "id" },
				{ "data": "nome" },
				{ "data": "empresa" },
				{ "data": "banco" },
				{ "data": "dt_emi","sType":"date-uk" },
				{ "data": "dt_fat" ,"sType":"date-uk"},
				{ "data": "valor" },
				{ "data": "cb" },
				{ "data": "pagamento" },
				{ "data": "centrocusto" },
				{ "data": "obs" },
			],
			"order":[[ 6, 'asc' ],[1,'asc']],
			oSearch: {"bRegex": true},
			iDisplayLength: 25,
			// "sDom": '<"top"f>t<"clear">',
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder) {
					responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
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

				if(aData.aglutinado == 1){
					$(row).attr({
						'style'					:'cursor:pointer',
						'rel'  					:"popover-hover"
					}).popover({
						container: "body",
						animated: true,
						title: "TÍTULOS AGLUTINADOS",
						content:aData.content,
						placement: "bottom",
						trigger: "hover",
						html:true
					}).on("show.bs.popover", function(e){
						$(this).data("bs.popover").tip().css({"max-width": "500px"});
					});
				}

				$(row).attr('style', 'cursor:pointer');



			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}
		});

		$(".dt-toolbar .col-sm-4:first").append('Localizar BD: <input class="form-control" id="buscaBanco">');


		var timer;
		var x;

		$("#buscaBanco").keyup(function () {
			if(this.value.length > 2){
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = table.fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $type;?>&busca='+$("#buscaBanco").val());
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}else{
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = table.fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $type;?>');
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}
		});


		$("#datatable_col_reorder thead th input[type=text]").on( 'keyup change', function () {
			var campo = $(this);
			if (x) { x.abort() } // If there is an existing XHR, abort it.
			clearTimeout(timer); // Clear the timer so we don't end up with dupes.
			timer = setTimeout(function() { // assign timer a new timeout
				x = atuatu(campo);
				// run ajax request and store in x variable (so we can cancel)
			}, 500); // 2000ms delay, tweak for faster/slower



		} );

		function atuatu(a){
			$("#datatable_col_reorder").dataTable().api().column( a.parent().index()+':visible' ).search( a.val() ).draw();
		};

		$('#datatable_col_reorder tbody').on( 'dblclick', 'tr', function () {
			loading("show");
			$.post("ajax/cadContas.php",{id:$(this).find('input[name="titulos"]').attr('valor'),tipo:$(this).find('input[name="titulos"]').attr('status'),retorno:2}).done(function(data){
				$("#cadastro").empty().html(data);
				$("#cadastro").dialog({
					autoOpen : true,
					width : '95%',
					resizable : false,
					modal : true,
					title : "Editar <?php echo $nome;?>"
				});
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
			});
		} );

		var titulos = [];
		$("#comprovante").click(function(){
			$("input[name='titulos']:checked").each(function(){
				var target = $(this).attr('valor');
				titulos.push(target);
			});
			var retorno = titulos;
			if(titulos.length == 1){
				if(table.find('input[name="titulos"][valor="'+titulos[0]+'"]').attr('aglutinado') == 1){
					retorno = table.find('input[name="titulos"][valor="'+titulos[0]+'"]').attr('titulos');
					var banco = table.find('input[name="titulos"][valor="'+titulos[0]+'"]').attr('banco');
					confirma("ATENÇÃO!","Deseja imprimir os comprovantes dos títulos selecionados?",function(){
						comprovante("server/comprovante.php","banco="+banco+"&titulos="+retorno+"&funcao=3&tipo="+"<?php echo $type;?>");
						titulos = [];
						$("input[name='titulos']").each(function(){
							$(this).prop("checked",false);
						});
					});
				}else{
					var banco = table.find('input[name="titulos"][valor="'+titulos[0]+'"]').attr('banco');
					confirma("ATENÇÃO!","Deseja imprimir os comprovantes dos títulos selecionados?",function(){
						comprovante("server/comprovante.php","banco="+banco+"&titulos="+retorno+"&funcao=3&tipo="+"<?php echo $type;?>");
						titulos = [];
						$("input[name='titulos']").each(function(){
							$(this).prop("checked",false);
						});
					});
				}
				titulos = [];
				$("input[name='titulos']").each(function(){
					$(this).prop("checked",false);
				});
			}
			else if(titulos.length > 1){
				confirma("ATENÇÃO!","Deseja imprimir os comprovantes dos títulos selecionados?",function(){
					comprovante("server/comprovante.php","titulos="+retorno+"&funcao=1&tipo="+"<?php echo $type;?>");
					titulos = [];
					$("input[name='titulos']").each(function(){
						$(this).prop("checked",false);
					});
				});
			}else{
				alerta("FAVOR SELECIONAR PELO MENOS 1 TÍTULO À SER BAIXADO!","","warning","warning");
				titulos = [];
				titulos = [];
				$("input[name='titulos']").each(function(){
					$(this).prop("checked",false);
				});
			}
		});
		$("#baixar_selecionados").click(function(){
			$("input[name='titulos']:checked").each(function(){
				var target = $(this).attr('valor');
				titulos.push(target);
			});
			var retorno = titulos;
			if(titulos.length == 1){
				loading("show");
				$.post("server/financeiro.php",{funcao:7,titulos:titulos,tipo:"<?php echo $type;?>"}).done(function(data){
					if(data == 1){
						alerta("Sucesso!","Baixa realizada com sucesso","success","check");
					}else if(data == 2){
						alerta("Alerta!","Não existem titulos a serem baixados neste período.","info","success");
					}else{
						alerta("ERRO!","Não foi possível concluir a operação solicitada!","danger","warning");
					}
					table.fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $type;?>');
				}).fail(function(){
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
				titulos = [];
				$("input[name='titulos']").each(function(){
					$(this).prop("checked",false);
				});
				setTimeout(function(){
					loading("hide");
				},1500);
			}
			else if(titulos.length > 1){
				$.SmartMessageBox({
					title : "ATENÇÃO",
					content : "POR FAVOR, ESCOLHA COMO DESEJA REALIZAR A BAIXA DOS TÍTULOS SELECIONADOS.",
					buttons : "[SAIR DESTA OPERAÇÃO][UNIFICADA][SEPARADAMENTE]"
				}, function(ButtonPress, Value) {
					if(ButtonPress == "SEPARADAMENTE"){
						loading("show");
						$.post("server/financeiro.php",{funcao:7,titulos:titulos,tipo:"<?php echo $type;?>"}).done(function(data){
							if(data == 1){
								alerta("Sucesso!","Baixa realizada com sucesso","success","check");
							}else if(data == 2){
								alerta("Alerta!","Não existem titulos a serem baixados neste período.","info","success");
							}else{
								alerta("ERRO!","Não foi possível concluir a operação solicitada!","danger","warning");
							}
							table.fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $type;?>');
						}).fail(function(){
							alerta("ERRO!","Função não encontrada!","danger","warning");
						});
						titulos = [];
						$("input[name='titulos']").each(function(){
							$(this).prop("checked",false);
						});
						setTimeout(function(){
							loading("hide");
						},1500);
					}else if(ButtonPress == "UNIFICADA"){
						loading('show');
						$.post("ajax/baixaFinanceiro.php",{titulos:titulos,tipo:"<?php echo $type;?>"}).done(function(data){
							$("#cadastro").empty().html(data);
							$("#cadastro").dialog({
								autoOpen : true,
								width : '95%',
								resizable : false,
								modal : true,
								title : "BAIXA DE CONTA"
							});
						}).fail(function(){
							alerta("ERRO!","Função não encontrada!","danger","ban");
						});
						titulos = [];
						$("input[name='titulos']").each(function(){
							$(this).prop("checked",false);
						});
					}else if(ButtonPress == "SAIR DESTA OPERAÇÃO"){
						titulos = [];
						$("input[name='titulos']").each(function(){
							$(this).prop("checked",false);
						});
					}

				});


				/*confirma("ATENÇÃO!","Deseja baixar os títulos selecionados?",function(){
					loading("show");
					$.post("server/financeiro.php",{funcao:7,titulos:titulos,tipo:"<?php echo $type;?>"}).done(function(data){
						if(data == 1){
							alerta("Sucesso!","Baixa realizada com sucesso","success","check");
							loading("show");
							setTimeout(function(){
								confirma("Atenção!","Deseja imprimir o comprovante desta operação?",function(){
									comprovante("server/comprovante.php","titulos="+retorno+"&funcao=1&tipo="+"<?php echo $type;?>");
								});
								loading("hide");
							},2000);
						}else if(data == 2){
							alerta("Alerta!","Não existem titulos a serem baixados neste período.","info","success");
						}else{
							alerta("ERRO!","Não foi possível concluir a operação solicitada!","danger","warning");
						}
						table.fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $type;?>');
					}).fail(function(){
						alerta("ERRO!","Função não encontrada!","danger","warning");
					});
					titulos = [];
					$("input[name='titulos']").each(function(){
						$(this).removeAttrs("checked");
					});
				});*/
			}else{
				alerta("FAVOR SELECIONAR PELO MENOS 1 TÍTULO À SER BAIXADO!","","warning","warning");
				titulos = [];
				$("input[name='titulos']").each(function(){
					$(this).prop("checked",false);
				});
			}
		});

		$("#cancelar_baixa").click(function(){
			$("input[name='titulos']:checked").each(function(){
				var target = $(this).attr('valor');
				titulos.push(target);
			});
			var retorno = titulos;
			if(titulos.length >= 1){
				confirma("ATENÇÃO!","Deseja cancelar a baixa dos títulos selecionados?",function(){
					$.post("server/financeiro.php",{funcao:8,titulos:titulos,tipo:"<?php echo $type;?>"}).done(function(data){
						if(data == 1){
							alerta("Sucesso!","Cancelamento realizado com sucesso","success","check");
						}else{
							alerta("ERRO!","Não foi possível concluir a operação solicitada!","danger","warning");
						}
						table.fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $type;?>');
					}).fail(function(){
						alerta("ERRO!","Função não encontrada!","danger","warning");
					});
					titulos = [];
					$("input[name='titulos']").each(function(){
						$(this).removeAttrs("checked");
					});
				});
			}else{
				alerta("FAVOR SELECIONAR PELO MENOS 1 TÍTULO À SER BAIXADO!","","warning","warning");
				titulos = [];
				$("input[name='titulos']").each(function(){
					$(this).removeAttrs("checked");
				});
			}
		});
		$("#conciliar").click(function(){
			$("input[name='titulos']:checked").each(function(){
				var target = $(this).attr('valor');
				titulos.push(target);
			});
			var retorno = titulos;
			if(titulos.length >= 1){
				confirma("ATENÇÃO <?php echo $_SESSION['imunevacinas']['usuarioNome'];?>!","<b>Aviso importante!</b><br>Esta operação atualizará seu saldo e extrato Bancário, após efetuar a conciliação bancária, não será possível reverter esta operação!<br>Deseja efetuar a conciliação bancária do(s) título(s) selecionado(s)?<br>",function(){
					$.post("server/financeiro.php",{funcao:13,titulos:titulos}).done(function(data){
						if(data == 1){
							alerta("Sucesso!","Operação realizada com sucesso!<br>Os títulos conciliados podem ser vistos clicando no botão Contas Conciliadas na Central de Contas.","success","check");
						}else{
							alerta("ERRO!","Não foi possível concluir a operação solicitada!","danger","warning");
						}
						table.fnReloadAjax('server/buscaFinanceiro.php?type=<?php echo $type;?>');
					}).fail(function(){
						alerta("ERRO!","Função não encontrada!","danger","warning");
					});
					titulos = [];
					$("input[name='titulos']").each(function(){
						$(this).removeAttrs("checked");
					});
				});
			}else{
				alerta("FAVOR SELECIONAR PELO MENOS 1 TÍTULO À SER BAIXADO!","","warning","warning");
				titulos = [];
				$("input[name='titulos']").each(function(){
					$(this).removeAttrs("checked");
				});
			}
		});
		$("#marcar_todos").click(function(){
			$("input[name='titulos']").each(function(){
				$(this).prop('checked',true);
			});
		});
		$("#desmarcar_todos").click(function(){
			$("input[name='titulos']").each(function(){
				$(this).prop("checked",false);
			});
		});
		/*$("#esta_semana").click(function(){
			confirma("ATENÇÃO!","Deseja baixar todos os títulos com data de vencimento/recebimento prevista para esta semana?<br><b>DE:</b> <?php echo $week_start;?><br><b>ATÉ:</b> <?php echo $week_end;?>",function(){
				var dt_ini = "<?php echo $week_start;?>";
				var dt_fim = "<?php echo $week_end;?>";
				baixaPeriodo(dt_ini,dt_fim,"<?php echo $type;?>");
			});
		});
		$("#este_mes").click(function(){
			confirma("ATENÇÃO!","Deseja baixar todos os títulos com data de vencimento/recebimento prevista para este mês?<br><b>DE:</b> <?php echo $mes_start;?><br><b>ATÉ:</b> <?php echo $mes_end;?>",function(){
				var dt_ini = "<?php echo $mes_start;?>";
				var dt_fim = "<?php echo $mes_end;?>";
				baixaPeriodo(dt_ini,dt_fim,"<?php echo $type;?>");
			});
		});*/

	};

	function baixaPeriodo(dt_ini,dt_fim,tipo){
		loading("show");
		$.post("server/financeiro.php",{funcao:6,dt_ini:dt_ini,dt_fim:dt_fim,tipo:tipo}).done(function(data){
			if(data == 1){
				alerta("Sucesso!","Baixa realizada com sucesso","success","check");
				comprovante("../server/comprovante.php","titulos="+dt_ini+" | "+dt_fim+"&funcao=2&tipo="+tipo);
			}else if(data == 2){
				alerta("Alerta!","Não existem titulos a serem baixados neste período.","info","success");
			}else{
				alerta("ERRO!","Não foi possível concluir a operação solicitada!","danger","warning");
			}
			$.post("ajax/gridContas.php",{type:tipo}).done(function(data){
				$("#fin_content").html(data);
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","warning");
			});
		}).fail(function(){
			alerta("ERRO!","Função não encontrada!","danger","warning");
		});
		loading("hide");
	}
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
