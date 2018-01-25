<?php
require_once("inc/init.php");
require_once("../server/seguranca.php");
$numero = $_POST['numero'];
$pasta = $_POST['pasta'];
$especialidade 	   = $_POST['especialidade'];
$id        = $_POST['id'];
?>
<div class="row">
	<div class="col-xs-12 text-align-left">
		<a class="btn btn-labeled bg-color-blueDark" id="voltar" style="color:white" href="javascript:void(0);">
			<span class="btn-label">
			<i class="glyphicon glyphicon-backward"></i>
			</span>
			Voltar
		</a>
	</div>
</div>
<div class="row" id="pastaCli2">
	<div class="col-sm-2 col-xs-4">
		Número<input type="text" name="numero" id="numero" class="form-control wd100" disabled>
	</div>
	<div class="col-sm-5 col-xs-8">
		Especialidade<select class="form-control" id="esp_id" name="esp_id" disabled>

		</select>
	</div>
	<div class="col-sm-5 col-xs-12">
		<?php echo $_SESSION['config']['empresa'];?><select class="form-control" id="emp_id" name="emp_id" disabled></select>
	</div>
</div>

<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
	<header>
		<h2>Procedimentos</h2>

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

			<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
				<tr>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="ID" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="PROCEDIMENTO" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="DENTE" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="CONVENIO" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="DENTISTA" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="DT_EXEC" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="STATUS" />
					</th>

				</tr>
				<tr>
					<th data-class="expand" style="text-align: center">ID</th>
					<th  style="text-align: center">PROCEDIMENTO</th>
					<th data-hide="phone,tablet" style="text-align: center">DENTE</th>
					<th data-hide="phone,tablet" style="text-align: center">CONVENIO</th>
					<th data-hide="phone,tablet" style="text-align: center">DENTISTA</th>
					<th data-hide="phone,tablet" style="text-align: center">DT. EXEC.</th>
					<th data-hide="phone,tablet" style="text-align: center">STATUS</th>
				</tr>
				</thead>
			</table>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->
</div>



<script type="text/javascript">



	$.ajax({
		url: 'server/recupera.php',
		type: 'POST',
		data:{tabela:'especialidade where grp_emp_id="<?php echo $_SESSION['imunevacinas']['usuarioEmpresa'];?>"'},
		cache: false,
		async: false,
		success: function(data) {

			var obj = JSON.parse(data);
			for (i in obj){
				$("#pastaCli2").find("#esp_id").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
			}
		},
		error:function(){

		}
	});
	$.ajax({
		url: 'server/recupera.php',
		type: 'POST',
		data:{tabela:'empresa where grp_emp_id="<?php echo $_SESSION['imunevacinas']['usuarioEmpresa'];?>"'},
		cache: false,
		async: false,
		success: function(data) {

			var obj = JSON.parse(data);
			for (i in obj){
				$("#pastaCli2").find("#emp_id").append('<option value="'+obj[i].id+'">'+obj[i].fantasia+'</option>');
			}


		},
		error:function(){

		}
	});

	$.ajax({
		url: 'server/recupera.php',
		type: 'POST',
		data:{tabela:"pasta where numero = '<?php echo $numero;?>'"},
		cache: false,
		async: false,
		success: function(data) {

			var obj = JSON.parse(data)[0];
			$("#pastaCli2").find("#numero").val(obj.numero);
			$("#pastaCli2").find("#esp_id").val(obj.esp_id);
			$("#pastaCli2").find("#emp_id").val(obj.emp_id);


		},
		error:function(){

		}
	});

	$("#voltar").click(function(){
		loading("show");
		$.post("ajax/cadcliente.php",{id:<?php echo $id;?>}).done(function(data){
			$("#cadastro").empty().html(data);
			$("#cadastro").dialog({
				autoOpen : true,
				width : '95%',
				resizable : false,
				modal : true,
				title : "Editar <?php echo $_SESSION['config']['cliente'];?>"
			});
			$("#t_pro").click();
		}).fail(function(){
			alerta("ERRO!","Função não encontrada!","danger","ban");
		});
	});
	pageSetUp();
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
			tablet : 1024,
			phone : 480
		};

		/* COLUMN SHOW - HIDE */
		var table = $('#dt_basic').dataTable({

			oSearch: {"bRegex": true},
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"autoWidth" : true,
			"ajax": "server/buscaPastaAUX.php?pasta=<?php echo $pasta;?>",
			"columns": [
				{ "data": "numero" },
				{ "data": "procedimento" },
				{ "data": "dente" },
				{ "data": "convenio" },
				{ "data": "dentista" },
				{ "data": "dt_exec" },
				{ "data": "status"}
			],
			"order":[[1,'desc']],
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder) {
					responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
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



				if(aData.st <= 1 || aData.st == 3){

					$(row).find('td,label').css({cursor:'pointer'});

					$(row).find('#dentista').editable({
						type: 'select',
						value:aData.den_id,
						source:'server/recupera3.php?tabela=5',
						toggle:'click',
						send:"always",
					});



					$(row).find('#dente').editable({
						type: 'select',
						value:aData.dente1,
						source:[{value:11,text:11},{value:12,text:12},{value:13,text:13},{value:14,text:14},{value:15,text:15},{value:16,text:16},{value:17,text:17},{value:18,text:18},{value:21,text:21},{value:22,text:22},{value:23,text:23},{value:24,text:24},{value:25,text:25},{value:26,text:26},{value:27,text:27},{value:28,text:28},{value:31,text:31},{value:32,text:32},{value:33,text:33},{value:34,text:34},{value:35,text:35},{value:36,text:36},{value:37,text:37},{value:38,text:38},{value:41,text:41},{value:42,text:42},{value:43,text:43},{value:44,text:44},{value:45,text:45},{value:46,text:46},{value:47,text:47},{value:48,text:48},{value:'A-I',text:'A-I'},{value:'A-S',text:'A-S'}],
						toggle:'click',
						send:"always",
					});
					$(row).find('#status').editable({
						type: 'select',
						value:aData.st,
						source:[{value:0,text:'0-Pendente'},{value:1,text:'1-Em Andamento'},{value:2,text:'2-Concluído'},{value:3,text:'3-Cancelado'},{value:4,text:'4-Glozado'}],
						toggle:'click',
						send:"always",
					});
					$(row).find('#status').on('save', function(e, params) {

						$.post('server/updateCampo.php',{tabela:"pasta_aux",coluna:"status",valor:params.newValue,id:$(this).parent().parent().find("#numero").attr('valor')});
						setTimeout(function(){
							table.fnReloadAjax();
						},500);
					});
					$(row).find('#dentista').on('save', function(e, params) {

						$.post('server/updateCampo.php',{tabela:"pasta_aux",coluna:"den_id",valor:params.newValue,id:$(this).parent().parent().find("#numero").attr('valor')});
						setTimeout(function(){
							table.fnReloadAjax();
						},500);
					});
					$(row).find('#dente').on('save', function(e, params) {
						$.post('server/updateCampo.php',{tabela:"pasta_aux",coluna:"dente",valor:params.newValue,id:$(this).parent().parent().find("#numero").attr('valor')});
						setTimeout(function(){
							table.fnReloadAjax();
						},500);
					});
				}


			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}
		});

		var timer;
		var x;

		$("#dt_basic thead th input[type=text]").on( 'keyup change', function () {
			var campo = $(this);
			if (x) { x.abort() } // If there is an existing XHR, abort it.
			clearTimeout(timer); // Clear the timer so we don't end up with dupes.
			timer = setTimeout(function() { // assign timer a new timeout
				x = atuatu(campo);
				// run ajax request and store in x variable (so we can cancel)
			}, 500); // 2000ms delay, tweak for faster/slower



		} );

		function atuatu(a){
			$("#dt_basic").dataTable().api().column( a.parent().index()+':visible' ).search( a.val() ).draw();
		};

		/*$('#dt_basic tbody').on( 'dblclick', 'tr', function () {
			$.post("ajax/pasta_aux.php",{id:<?php echo $id;?>,numero:$(this).find("#numero").attr('valor'),especialidade:$(this).find("#especialidade").attr('retorno')}).done(function(data){
				$("#cadastro").empty().html(data);
				$("#cadastro").dialog({
					autoOpen : true,
					width : '95%',
					resizable : false,
					modal : true,
					title : "Editar"
				});
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
			});
		} );*/

	};
	// load nestable.min.js then run pagefunction
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
