<?php
require_once("inc/init.php");
require_once("../server/seguranca.php");
$id = $_POST['id'];
?>
<div class="row" id="pastaCli">
	<div class="col-sm-2 col-xs-4">
		Número<input type="text" name="numero" id="numero" class="form-control wd100">
	</div>
	<div class="col-sm-5 col-xs-8">
		Especialidade<select class="form-control" id="especialidade" name="especialidade">
			<option value="0">SELECIONE UMA ESPECIALIDADE</option>
		</select>
	</div>
	<div class="col-sm-5 col-xs-12">
		<?php echo $_SESSION['config']['empresa'];?><select class="form-control" id="emp_id" name="emp_id"></select>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 text-align-right">
		<a class="btn btn-labeled btn-success" id="add_especialidade" href="javascript:void(0);">
			<span class="btn-label">
			<i class="glyphicon glyphicon-book"></i>
			</span>
			Adicionar
		</a>
	</div>
</div>


<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
	<header>
		<h2>Pastas</h2>
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
						<input type="text" class="form-control" placeholder="NÚMERO" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="ESPECIALIDADE" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="<?php echo mb_strtoupper($_SESSION['config']['empresa'],'utf8');?>" />
					</th>

				</tr>
				<tr>
					<th data-class="expand" style="text-align: center">NÚMERO</th>
					<th  style="text-align: center">ESPECIALIDADE</th>
					<th data-hide="phone,tablet" style="text-align: center"><?php echo mb_strtoupper($_SESSION['config']['empresa'],'utf8');?></th>
				</tr>
				</thead>
			</table>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->
</div>


<script type="text/javascript">
	$("#pastaCli").find("#numero").mask('00000000');
	pageSetUp();
	var pagefunction = function() {


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
						$("#dt_basic").dataTable().fnReloadAjax();
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
		var table = $('#dt_basic').dataTable({

			oSearch: {"bRegex": true},
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"autoWidth" : true,
			"ajax": "server/buscaPasta.php?pes_id=<?php echo $id;?>",
			"columns": [
				{ "data": "numero" },
				{ "data": "especialidade" },
				{ "data": "unidade"}
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
				$(row).attr('style', 'especialidader:pointer');


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

		$('#dt_basic tbody').on( 'dblclick', 'tr', function () {
			$.post("ajax/pasta_aux.php",{id:<?php echo $id;?>,pasta:$(this).find("#numero").attr('retorno'),numero:$(this).find("#numero").attr('valor'),especialidade:$(this).find("#especialidade").attr('retorno')}).done(function(data){
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
		} );
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
