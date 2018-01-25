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
$nome = "CONTAS CONCILIADAS";

$colunas	= "financeiro.id,pessoa.nome,empresa.razao as empresa,concat(banco.cod,'-',banco.banco) as banco,financeiro.dt_emi,financeiro.dt_baixa,financeiro.valorliquido,financeiro.cheque as cheque,pagamento.nome as pagamento,centrocusto.nome as centrocusto,financeiro.obs,financeiro.status as status";
$tabn		= "id,nome,empresa,banco,Dt. Emis.,Dt. Baixa.,valor,Nº C/B,f.pag,c. custo,obs,p/r";


$tabela		= "financeiro,pessoa,centrocusto,pagamento,empresa,banco where financeiro.ban_id = banco.id and financeiro.emp_id = empresa.id and financeiro.pag_id = pagamento.id and financeiro.cen_id = centrocusto.id and pessoa.id = financeiro.pes_id and financeiro.conciliada = 1 ";



$colunas = $tabn;
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
					<div class="widget-toolbar" role="menu">
						<a class="btn btn-primary" id="n_con" href="javascript:void(0);">Inserir</a>
					</div>
				</header>

				<!-- widget div-->
				<div>


					<!-- end widget edit box -->

					<!-- widget content -->
					<div class="widget-body no-padding">

						<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover font-xs" width="100%">
							<thead>
							<tr>
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
									<input type="text" class="form-control" placeholder="DT. BAIXA." />
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
								<th class="hasinput">
									<input type="text" class="form-control" placeholder="P/R" />
								</th>
							</tr>
							<tr>
								<?php
								$explode = explode(",",$colunas);
								for($i=0;$i<count($explode);$i++){
									if($explode[$i] == "nome"){
										?>
										<th data-class="expand">
											<?php echo strtoupper($explode[$i]);?>
										</th>
										<?php
									}else if($explode[$i] == "obs"){
										?>
										<th data-class="phone">
											<?php echo "OBS";?>
										</th>
										<?php
									}elseif(count($explode) > 3){
										?>
										<th data-hide="phone,tablet">
											<?php echo strtoupper($explode[$i]);?>
										</th>
										<?php
									}else{
										?>
										<th data-hide="phone">
											<?php echo strtoupper($explode[$i]);?>
										</th>
										<?php
									}
								}
								?>
								<!--
									<th>Phone</th>
									<th data-hide="phone">Company</th>
									<th data-hide="phone,tablet">Zip</th>
									<th data-hide="phone,tablet">City</th>
									<th data-hide="phone,tablet">Date</th>
								-->
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
			"order":[[ 5, 'asc' ],[0,'asc']],
			"ajax": "server/buscaConciliacao.php",
			"columns": [
				{ "data": "id" },
				{ "data": "nome" },
				{ "data": "empresa" },
				{ "data": "banco" },
				{ "data": "dt_emi","sType":"date-uk" },
				{ "data": "dt_fat","sType":"date-uk" },
				{ "data": "valor" },
				{ "data": "cb" },
				{ "data": "pagamento" },
				{ "data": "centrocusto" },
				{ "data": "obs" },
				{ "data": "pr" }
			],
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
				$(row).attr('style', 'cursor:pointer');
				$(row).find('#dt_baixa').editable({
					type: 'text',
					name: 'dt_baixa',
					tpl: '<input type="text" id ="zipiddemo" class="mask form-control    input-sm dd" style="padding-right: 24px;">'
				});

				$(row).find('#dt_baixa').on('save', function(e, params) {
					$.post('server/updateCampo.php',{tabela:"financeiro",coluna:"dt_baixa",valor:params.newValue,id:$(this).attr('data-pk')});
					table.fnReloadAjax();
				});

				$(document).on("focus", ".mask", function () {
					$(this).mask("00/00/0000");
				});

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
					x = table.fnReloadAjax('server/buscaConciliacao.php?busca='+$("#buscaBanco").val());
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}else{
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = table.fnReloadAjax('server/buscaConciliacao.php?busca='+$("#buscaBanco").val());
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

	};



	loadScript("js/plugin/datatables/jquery.dataTables.min.js", function(){
		loadScript("js/plugin/datatables/dataTables.colVis.min.js", function(){
			loadScript("js/plugin/datatables/dataTables.tableTools.min.js", function(){
				loadScript("js/plugin/datatables/dataTables.bootstrap.min.js", function(){
					loadScript("js/plugin/datatable-responsive/datatables.responsive.min.js",function(){
						loadScript("js/plugin/x-editable/x-editable.min.js", pagefunction);
					});
				});
			});
		});
	});
</script>
