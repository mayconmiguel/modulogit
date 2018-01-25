

<?php
require_once "../server/seguranca.php";



$server = gethostbyaddr($_SERVER['SERVER_ADDR']);
$ip = $_SERVER['SERVER_ADDR'];
$us_nome = $_SESSION['usuarioNome'];
$us_id  = $_SESSION['usuarioID'];
$emp_id  = $_SESSION['usuarioEmpresa'];

?>

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
			<input type="text" class="form-control" placeholder="DESTINO" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="DATA/HORA" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="MENSAGEM" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="Nº MSG." />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="STATUS" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="RESPOSTA" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="CONTATO" />
		</th>
		<th class="hasinput">
			<input type="text" class="form-control" placeholder="USUÁRIO" />
		</th>
	</tr>
	<tr>

		<th data-hide="minimo,phone,meio,tablet">ID</th>
		<th data-class="expand">NOME</th>
		<th data-hide="minimo,phone,meio">DESTINO</th>
		<th data-hide="minimo,phone,meio">DATA/HORA</th>
		<th data-hide="minimo,phone,meio,tablet">MENSAGEM</th>
		<th data-hide="minimo,phone,meio,tablet">Nº MSG</th>
		<th data-hide="minimo,phone,meio">STATUS</th>
		<th data-hide="minimo,phone,meio">RESPOSTA</th>
		<th data-hide="minimo,phone,meio">CONTATO</th>
		<th data-hide="minimo,phone,meio">USUÁRIO</th>

	</tr>
	</thead>
</table>


<script>

	$.ajax
	({
		type: "POST",
		url: 'server/SMS.php',
		async: false,
		data: {funcao:2},
		success:function(data){

		}
	});

	$.ajax
	({
		type: "POST",
		url: 'server/respostaSMS.php',
		async: false,
		data: {funcao:2},
		success:function(data){

		}
	});


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
			ajax: {
				"url": "server/reportSMS.php",
				"dataSrc": "results"
			},
			"columns": [
				{"data": "messageId"},
				{"data": "cliente"},
				{"data": "to"},
				{"data": "sentAt"},
				{"data": "text"},
				{"data": "smsCount"},
				{"data": "status.id"},
				{"data": "resposta"},
				{"data": "cont"},
				{"data": "from"}

			],
			"order": [[7, 'desc'],[8, 'asc'],[3, 'desc']],
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


				//editables
				$(row).find('#contato').editable({
					type: 'select',
					value:aData.contato,
					source:[{value:0,text:'0 - Pendente'},{value:1,text:'1 - Realizado'}],
					toggle:'click',
					send:"always",
				});
				$(row).find('#contato').on('save', function(e, params) {

					$.post('server/updateCampo.php',{tabela:"sms",coluna:"contato",valor:params.newValue,id:aData.id});
					setTimeout(function(){
						alerta("Sucesso!","Operação Realizada Com Sucesso!","success","check");
						$("#datatable_col_reorder").dataTable().fnReloadAjax();
					},500);
				});


				var sentAt =  aData.sentAt.substr(8,2)+"/"+aData.sentAt.substr(5,2)+"/"+aData.sentAt.substr(0,4)+" "+(aData.sentAt.substr(11,2))+":"+aData.sentAt.substr(14,2);
				$(row).children('td').eq(3).html(sentAt);
				if(aData.status.groupId == 0){
					var status = '<label class="label label-primary">0 - Aceita</label>';
				}
				else if(aData.status.groupId == 1){
					var status = '<label class="label label-warning">1 - Pendente</label>';
				}
				else if(aData.status.groupId == 2) {
					var status = '<label class="label bg-color-redLight">2 - Não entregue</label>';
				}
				else if(aData.status.groupId == 3) {
					var status = '<label class="label label-success">3 - Entregue</label>';
				}
				else if(aData.status.groupId == 4){
					var status = '<label class="label bg-color-redLight">4 - Expirado</label>';
				}
				else{
					var status = '<label class="label label-danger">5 - Rejeitada</label>';
				}
				$(row).children('td').eq(6).html(status);

				$(row).attr('style', 'cursor:pointer');


			},
			"drawCallback": function (oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}
		});




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

		$('#datatable_col_reorder tbody').on('dblclick', 'tr', function () {

		});

	};


	$("#my-file-input").change(function(files){
		var fileToLoad = this.files[0];

		var fileReader = new FileReader();
		fileReader.onload = function(fileLoadedEvent){
			var textFromFileLoaded = fileLoadedEvent.target.result;
			document.getElementById("num2").value = textFromFileLoaded;
		};

		fileReader.readAsText(fileToLoad, "UTF-8");
	});


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
