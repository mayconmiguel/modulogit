<?php
require_once("inc/init.php");
require_once("../server/seguranca.php");
@$id = $_POST['id'];
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));
$mes_start = date('Y-m-01 00:00:00');
$mes_end = date('Y-m-t 23:59:59');



?>
<style>
	.ui-autocomplete { position: absolute; cursor: default;z-index:999999 !important;}
</style>
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
				<h2>CHEQUES À RECEBER</h2>
				<div class="widget-toolbar">
					<div class="btn-group">
						<button class="btn dropdown-toggle btn-xs btn-danger" data-toggle="dropdown" aria-expanded="false">
							Opções
							<i class="fa fa-caret-down"></i>
						</button>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="javascript:void(0);" id="devolucao">Efetuar Devolução de Cheques - Selecionados</a>
							</li>
						</ul>
					</div>
				</div>
			</header>

			<!-- widget div-->
			<div>
				<div class="widget-body no-padding">

					<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover font-xs" width="100%">
						<thead>
						<tr>
							<th class="hasinput"></th>
							<th class="hasinput">
								<input type="text" class="form-control" placeholder="ID" />
							</th>
							<th class="hasinput">
								<input type="text" class="form-control" placeholder="DT. BAIXA" />
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
								<input type="text" class="form-control" placeholder="Nº C/B" />
							</th>
							<th class="hasinput">
								<input type="text" class="form-control" placeholder="VALOR" />
							</th>
							<th class="hasinput">
								<input type="text" class="form-control" placeholder="OBS" />
							</th>
						</tr>
						<tr>
							<th>SEL</th>
							<th data-hide="minimo,phone,meio,tablet">ID</th>
							<th data-hide="minimo,phone,meio,tablet">DT. BAIXA</th>
							<th data-class="expand">NOME</th>
							<th data-hide="minimo,phone,meio">EMPRESA</th>
							<th data-hide="minimo,phone,meio">BANCO</th>
							<th data-hide="minimo,phone,meio,tablet">Nº C/B</th>
							<th data-hide="minimo,phone">VALOR</th>
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


<!-- end widget grid -->

<script type="text/javascript">
	var titulos = [];
	var nome = "";
	$('input[name="titulos"]').click(function(){
		if(nome == ""){
			nome = $(this).attr('nome');
		}else{
			if(nome != $(this).attr('nome')){
				alerta("Alerta!","Selecione apenas titulos de 1 cliente por vez!","warning","warning");
				$("input[name='titulos']:checked").each(function(){
					$(this).removeAttrs("checked");
					nome = "";
				});
			}
		}
	});

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

		$("#recebimento").click(function(e){
			$("input[name='titulos']:checked").each(function(){
				var target = $(this).attr('valor');
				titulos.push(target);
			});
			var retorno = titulos;
			if(titulos.length >= 1){
				try{
					$("#cadastro").dialog('close');
				}catch(e){

				}
				$.SmartMessageBox({
					title : "ATENÇÃO",
					content : "Digite o nome do produtor e clique em continuar!",
					buttons : "[Cancelar][Continuar]",
					input : "text",
					inputValue: "",
					placeholder:"Nome do produtor!"
				}, function(ButtonPress, Value) {
					if(ButtonPress == "Continuar"){
						var valor = $(".divMessageBox").find('input:text').attr("value");
						comprovante("server/comprovante.php","titulos="+retorno+"&funcao=2&produtor="+valor);
					}
					try{
						$("#cadastro").dialog('open');
					}catch(e){

					}
				});

				$(function(){
					$(".divMessageBox").find('input:text').autocomplete({
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
						minLength:3,
					});
					$(".divMessageBox").find('input:text').autocomplete('option','appendTo',"div[class='divMessageBox']");
				});

				e.preventDefault();

			}else{
				alerta("POR FAVOR, SELECIONE PELO MENOS 1 TÍTULO.","","warning","warning");
			}
			titulos = [];
			$("input[name='titulos']").each(function(){
				$(this).removeAttrs("checked");
				nome = "";
			});
		});

		$.fn.dataTable.ext.errMode = 'none';

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

		/* BASIC ;*/

		var responsiveHelper_datatable_col_reorder = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		/* COLUMN SHOW - HIDE */
		var table = $('#datatable_col_reorder').dataTable({
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"aLengthMenu": [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "TODOS"]
			],
			"ajax": "server/buscaDevCheque.php",
			"columns": [
				{ "data": "sel" },
				{ "data": "id" },
				{ "data": "dt_baixa" },
				{ "data": "nome" },
				{ "data": "empresa" },
				{ "data": "banco" },
				{ "data": "cb" },
				{ "data": "valor" },
				{ "data": "obs" }
			],
			"order":[[1,'asc']],
			oSearch: {"bRegex": true},
			"iDisplayLength": 25,
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
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
				var row = table.fnGetNodes(nRow);
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
					x = table.fnReloadAjax('server/buscaDevCheque.php?busca='+$("#buscaBanco").val());
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}else{
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = table.fnReloadAjax('server/buscaDevCheque.php');
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

		var titulos = [];
		$("#devolucao").click(function(){
			$("input[name='titulos']:checked").each(function(){
				var target = $(this).attr('valor');
				titulos.push(target);
			});
			var retorno = titulos;
			if(titulos.length >= 1){

				$.SmartMessageBox({
					title : "ATENÇÃO",
					content : "Selecione qual o motivo da devolução!",
					buttons : "[Cancelar][Continuar]",
					input : "select",
					options: "[11 - Cheque sem fundo][999 - Outros Motivos]",
					placeholder:"Nome do produtor!"
				}, function(ButtonPress, Value) {
					if(ButtonPress == "Continuar"){
						if(Value.split(' - ')[0] == 11){
							$.post('server/financeiro.php',{funcao:21,titulos:titulos}).done(function(data){
								if(data==1){
									alerta("Devolução realizada com sucesso!","","success","check");
								}else{
									alerta("Falha ao realizar a devolução de cheque","Verifique sua conexão ou contate o suporte técnico","danger","warning");
								}
								$("#datatable_col_reorder").dataTable().fnReloadAjax();
							});
							titulos = [];
							$("input[name='titulos']").each(function(){
								$(this).prop("checked",false);
							});
						}
					}
				});

			}
			else{
				alerta("FAVOR SELECIONAR PELO MENOS 1 CHEQUE A SER DEVOLVIDO!","","warning","warning");
				titulos = [];
				$("input[name='titulos']").each(function(){
					$(this).prop("checked",false);
				});
			}
		});

	};

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
