<?php
require_once("inc/init.php");
require_once("../server/seguranca.php");

$nome 		= $_SESSION['config']['cliente'];

$tabelinha  = array("id","Data Solic.","SOLICITAÇÃO","setor","solicitante","Data Concl.","status");
?>

<!--
	The ID "widget-grid" will start to initialize all widgets below
	You do not need to use widgets if you dont want to. Simply remove
	the <section></section> and you can use wells or panels instead
	-->

<!-- widget grid -->
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
					<h2>SOLICITAÇÕES</h2>
					<div class="widget-toolbar" role="menu">
						<a class="btn btn-primary" id="novo" href="javascript:void(0);">Novo</a>
					</div>
				</header>

				<!-- widget div-->
				<div>


					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">

						<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
							<tr>
								<?php
								foreach($tabelinha as $tab){
									?>
									<th class="hasinput">
										<input type="text" class="form-control" placeholder="<?php echo mb_strtoupper($tab);?>" />
									</th>
									<?php
								}
								?>
							</tr>
							<tr>
								<?php
								foreach($tabelinha as $tab){
									if($tab == 'nome'){
										?>
										<th data-class="expand"><?php echo mb_strtoupper($tab);?></th>
										<?php
									}else if($tab == 'id'){
										?>
										<th><?php echo mb_strtoupper($tab);?></th>
										<?php
									}else{
										?>
										<th data-hide="phone,tablet"><?php echo mb_strtoupper($tab);?></th>
										<?php
									}
									?>
									<?php
								}
								?>
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
	$("#cadastro").hide();
	$("td[id='tdcpf']").each(function(){
		var cpf = $(this).html().replace(/\D/g, '').length;
		if(cpf == 11){
			$(this).mask('000.000.000-00');
		}
		else if(cpf == 14){
			$(this).mask('00.000.000/0000-00');
		}
	});


	$("td[id='tdrg']").mask("000.000.000",{reverse:true});
	var SPMaskBehavior = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
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
		limpa("#cadastro");

		// Dialog click
		$('#novo').click(function() {
			$.post('ajax/solicitacoes.php').done(function(data){
				$("#cadastro").empty().html(data);
				$("#cadastro").dialog({
					autoOpen : true,
					width : '95%',
					resizable : false,
					modal : true,
					title : "Novo Interessado"
				});
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
			});
		});

		$.fn.dataTable.ext.errMode = 'none';


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

		/* BASIC ;*/

		var responsiveHelper_datatable_col_reorder = undefined;


		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		var cliente = [
			{ "data": "id" },
			{ "data": "dt_cad" },
			{ "data": "solicitacao" },
			{ "data": "setor" },
			{ "data": "solicitante" },
			{ "data": "dt_end" },
			{ "data": "status" }
		];

		/* COLUMN SHOW - HIDE */
		var table = $('#datatable_col_reorder').dataTable({
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"aLengthMenu": [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "TODOS"]
			],
			"order":[[0,'asc']],
			"ajax": "server/buscaSolicitacoes.php",
			"columns": cliente,
			oSearch: {"bRegex": true},
			"iDisplayLength": 10,
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

		$("#wid-id-23").find(".dt-toolbar .col-sm-4:first").append('Localizar BD: <input class="form-control" id="buscaBanco">');


		var timer;
		var x;

		$("#buscaBanco").keyup(function () {
			if(this.value.length > 2){
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = table.fnReloadAjax('server/buscaCliente.php?busca='+$("#buscaBanco").val());
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}else{
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = table.fnReloadAjax('server/buscaCliente.php');
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
			$.post("ajax/solicitacoes.php",{id:$(this).find('td:first').text()}).done(function(data){
				$("#cadastro").empty().html(data);
				$("#cadastro").dialog({
					autoOpen : true,
					width : '95%',
					resizable : false,
					modal : true,
					title : "Editar Solicitação"
				});
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
			});
		} );

		/* END COLUMN SHOW - HIDE */



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
