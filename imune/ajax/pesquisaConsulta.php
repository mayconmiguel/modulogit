<?php require_once "../server/seguranca.php";?>
<?php require_once("inc/init.php"); ?>

<div class="row" id="pesquisaConsulta">
	<div class="col-xs-12">
		<input class="form-control" id="pesquisaCli">
	</div>
</div>
<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover font-xs" width="100%">
	<thead>
	<tr>

		<th class="hasinput">
			<input type="text" class="form-control" placeholder="DATA" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="HORA" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="<?php echo mb_strtoupper($_SESSION['config']['profissional']);?>" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="STATUS" />
		</th>
	</tr>
	<tr>


		<th data-class="expand">DATA</th>
		<th data-hide="minimo,phone,meio">HORA</th>
		<th data-hide="minimo,phone,meio"><?php echo mb_strtoupper($_SESSION['config']['profissional']);?></th>
		<th data-hide="minimo,phone,meio">STATUS</th>


	</tr>
	</thead>
</table>

<script>




	var pagefunction = function() {

		$.fn.dataTable.ext.errMode = 'none';

		jQuery.extend(jQuery.fn.dataTableExt.oSort, {
			"date-uk-pre": function (a) {
				var ukDatea = a.split('/');
				return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
			},

			"date-uk-asc": function (a, b) {
				return ((a < b) ? -1 : ((a > b) ? 1 : 0));
			},

			"date-uk-desc": function (a, b) {
				return ((a < b) ? 1 : ((a > b) ? -1 : 0));
			}
		});

		jQuery.fn.dataTableExt.oApi.fnReloadAjax = function (oSettings, sNewSource, fnCallback, bStandingRedraw) {
			// DataTables 1.10 compatibility - if 1.10 then `versionCheck` exists.
			// 1.10's API has ajax reloading built in, so we use those abilities
			// directly.
			if (jQuery.fn.dataTable.versionCheck) {
				var api = new jQuery.fn.dataTable.Api(oSettings);

				if (sNewSource) {
					api.ajax.url(sNewSource).load(fnCallback, !bStandingRedraw);
				}
				else {
					api.ajax.reload(fnCallback, !bStandingRedraw);
				}
				return;
			}

			if (sNewSource !== undefined && sNewSource !== null) {
				oSettings.sAjaxSource = sNewSource;
			}

			// Server-side processing should just call fnDraw
			if (oSettings.oFeatures.bServerSide) {
				this.fnDraw();
				return;
			}

			this.oApi._fnProcessingDisplay(oSettings, true);
			var that = this;
			var iStart = oSettings._iDisplayStart;
			var aData = [];

			this.oApi._fnServerParams(oSettings, aData);

			oSettings.fnServerData.call(oSettings.oInstance, oSettings.sAjaxSource, aData, function (json) {
				/* Clear the old information from the table */
				that.oApi._fnClearTable(oSettings);

				/* Got the data - add it to the table */
				var aData = (oSettings.sAjaxDataProp !== "") ?
					that.oApi._fnGetObjectDataFn(oSettings.sAjaxDataProp)(json) : json;

				for (var i = 0; i < aData.length; i++) {
					that.oApi._fnAddData(oSettings, aData[i]);
				}

				oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();

				that.fnDraw();

				if (bStandingRedraw === true) {
					oSettings._iDisplayStart = iStart;
					that.oApi._fnCalculateEnd(oSettings);
					that.fnDraw(false);
				}

				that.oApi._fnProcessingDisplay(oSettings, false);

				/* Callback user function - for event handlers etc */
				if (typeof fnCallback == 'function' && fnCallback !== null) {
					fnCallback(oSettings);
				}
			}, oSettings);
		};

		var responsiveHelper_datatable_col_reorder = undefined;

		var breakpointDefinition = {
			always: 2560,
			tablet: 1024,
			meio: 720,
			phone: 480,
			minimo: 300,
		};

		var table = $('#datatable_col_reorder').dataTable({
			aLengthMenu: [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "TODOS"]
			],

			"columns": [
				{"data": "dt_start","sType":"date-uk"},
				{"data": "hora"},
				{"data": "profissional"},
				{"data": "status"}

			],
			"order": [[0, 'asc'],[1, 'asc']],
			oSearch: {"bRegex": true},
			iDisplayLength: 25,
			// "sDom": '<"top"f>t<"clear">',
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>" +
			"t" +
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"autoWidth": true,
			"preDrawCallback": function () {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder) {
					responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
				}
			}, "oLanguage": {
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
			"rowCallback": function (nRow, aData, iDisplayIndex) {
				responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
				var row = table.fnGetNodes(nRow);
			},
			"drawCallback": function (oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}
		});


		$("#pesquisaConsulta").find('input[id="pesquisaCli"]').autocomplete({
			source: "ajax/buscaCli.php",
			select: function(event,ui){
				$(this).attr("retorno",ui.item.id);
				$(this).attr("value",ui.item.nome);

				$("#datatable_col_reorder").dataTable().fnReloadAjax('server/buscaPesquisaConsulta.php?cli_id='+ui.item.id);
			},
			search:function(){
				loading('show');
			},
			response:function(event,ui){
				loading('hide')
				if (!ui.content.length) {
					var noResult = { value:"",label:"Nenhum registro encontrado" };
					ui.content.push(noResult);
				}
			},
			delay:1000,
			minLength:3
		});
		$("#pesquisaConsulta").find('#pesquisaCli').autocomplete('option','appendTo',"div[id='cadastro']");


		var timer;
		var x;

		$("#datatable_col_reorder thead th input[type=text]").on('keyup change', function () {
			var campo = $(this);
			if (x) {
				x.abort()
			} // If there is an existing XHR, abort it.
			clearTimeout(timer); // Clear the timer so we don't end up with dupes.
			timer = setTimeout(function () { // assign timer a new timeout
				x = atuatu(campo);
				// run ajax request and store in x variable (so we can cancel)
			}, 500); // 2000ms delay, tweak for faster/slower


		});

		function atuatu(a) {
			$("#datatable_col_reorder").dataTable().api().column(a.parent().index() + ':visible').search(a.val()).draw();
		};


	};


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


