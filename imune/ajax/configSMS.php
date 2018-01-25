<?php
require_once("inc/init.php");
require_once("../server/seguranca.php");


$tabelinha  = array("id","nome","mensagem","status");
?>

<!--
	The ID "widget-grid" will start to initialize all widgets below
	You do not need to use widgets if you dont want to. Simply remove
	the <section></section> and you can use wells or panels instead
	-->

<!-- widget grid -->
<section id="widget-grid-cliente" class="well">

	<table id="tabela_config_sms" class="table table-striped table-bordered table-hover" width="100%">
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
				}else if($tab == 'pasta'){
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

</section>


<!-- end widget grid -->

<script type="text/javascript">
	$("#cadastro").hide();


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
			{ "data": "nome" },
			{ "data": "msg" },
			{ "data": "status" }
		];

		/* COLUMN SHOW - HIDE */
		var table = $('#tabela_config_sms').dataTable({
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"aLengthMenu": [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "TODOS"]
			],
			"order":[[ 2, 'asc' ],[0,'asc']],
			"ajax": "server/buscaConfigSMS.php",
			"columns": cliente,
			oSearch: {"bRegex": true},
			"iDisplayLength": 10,
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder) {
					responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#tabela_config_sms'), breakpointDefinition);
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
			"rowCallback" : function(nRow,aData) {
				responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
				var row = table.fnGetNodes(nRow);




				$(row).find('#msg').editable({
					type: 'textarea',
					value:aData.msg.split('>')[1].split('<')[0],

					toggle:'click',
					send:"always",
				});
				$(row).find('#status').editable({
					type: 'select',
					value:aData.st,
					source:[{value:0,text:"Inativo"},{value:1,text:"Ativo"}],
					toggle:'click',
					send:"always",
				});

				$(row).find('#nome,#msg,#status').on('save', function(e, params) {
					$.post('server/updateCampo.php',{tabela:"config_sms",coluna:$(this).attr('id'),valor:params.newValue,id:aData.id});
					$("#tabela_config_sms").dataTable().fnReloadAjax();
				});



				$(row).attr('style', 'cursor:pointer');
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}
		});

		$("#wid-id-23").find(".dt-toolbar .col-sm-4:first").append('Localizar BD: <input class="form-control" id="buscaBanco">');

		var timer;
		var x;

		$("#tabela_config_sms thead th input[type=text]").on( 'keyup change', function () {
			var campo = $(this);
			if (x) { x.abort() } // If there is an existing XHR, abort it.
			clearTimeout(timer); // Clear the timer so we don't end up with dupes.
			timer = setTimeout(function() { // assign timer a new timeout
				x = atuatu(campo);
				// run ajax request and store in x variable (so we can cancel)
			}, 500); // 2000ms delay, tweak for faster/slower



		} );

		function atuatu(a){
			$("#tabela_config_sms").dataTable().api().column( a.parent().index()+':visible' ).search( a.val() ).draw();
		};

		$('#tabela_config_sms tbody').on( 'dblclick', 'tr', function () {

		} );

		/* END COLUMN SHOW - HIDE */



	};

	// load related plugins

	loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js",function(){
						loadScript("js/plugin/x-editable/x-editable.min.js", pagefunction)
					});
				});
			});
		});
	});

</script>
