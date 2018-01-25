<?php
	require_once("inc/init.php");
	require_once("../server/seguranca.php");
	$id = $_POST['id'];
?>
<div class="row">
	<div class="col-sm-3 col-xs-6">
		Matricula<input type="text" name="matricula" id="matricula" class="form-control wd100">
	</div>
	<div class="col-sm-4 col-xs-6">
		Curso<select class="form-control" id="curso" name="curso">
			<option value="0">SELECIONE UM CURSO</option>
		</select>
	</div>
	<div class="col-sm-3 col-xs-8">
		Turno<select name="turno" id="turno" class="form-control">
			<option value="1">MATUTINO</option>
			<option value="2">VESPERTINO</option>
			<option selected value="3">NOTURNO</option>
		</select>
	</div>
	<div class="col-sm-2 col-xs-4">
		Turma<select class="form-control" id="turma" name="turma">
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-sm-3 col-xs-6">
		<?php echo $_SESSION['config']['empresa'];?><select class="form-control" id="emp_id" name="emp_id"></select>
	</div>
	<div class="col-sm-4 col-xs-6">
		Modalidade<select class="form-control" id="modalidade" name="modalidade"></select>
	</div>
	<div class="col-sm-3 col-xs-6">
		Status<select class="form-control" id="status" name="status">
			<option value="1">INTERESSADO</option>
			<option value="2" selected>INSCRITO</option>
			<option value="3">APROVADO</option>
			<option value="4">AUSENTE</option>
			<option value="5">REPROVADO</option>
			<option value="6">PRÉ-CONFIRMADO</option>
			<option value="7">ATIVO</option>
			<option value="8">FORMANDO</option>
			<option value="9">CONCLUÍDO</option>
			<option value="10">DESISTENTE</option>
			<option value="11">CANCELADO</option>
			<option value="12">TRANCADO</option>
			<option value="13">TRANSFERIDO</option>
		</select>
	</div>
	<div class="col-sm-2 col-xs-6">
		Convênio<select class="form-control" id="convenio" name="convenio">
		</select>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 text-align-right">
		<a class="btn btn-labeled btn-success" id="add_curso" href="javascript:void(0);">
			<span class="btn-label">
			<i class="glyphicon glyphicon-book"></i>
			</span>
			Adicionar Curso
		</a>
	</div>
</div>


<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
	<header>
		<h2>Cursos</h2>
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
						<input type="text" class="form-control" placeholder="MATRICULA" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="CURSO" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="PERÍODOS" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="TURNO" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="TURMA" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="UNIDADE" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="MODALIDADE" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="CONVÊNIO" />
					</th>
					<th class="hasinput">
						<input type="text" class="form-control" placeholder="STATUS" />
					</th>
				</tr>
				<tr>
					<th data-class="expand" style="text-align: center">MATRICULA</th>
					<th  style="text-align: center">CURSO</th>
					<th data-hide="phone,tablet" style="text-align: center">PERÍODOS</th>
					<th data-hide="phone,tablet" style="text-align: center">TURNO</th>
					<th data-hide="phone,tablet" style="text-align: center">TURMA</th>
					<th data-hide="phone,tablet" style="text-align: center">UNIDADE</th>
					<th data-hide="phone,tablet" style="text-align: center">MODALIDADE</th>
					<th data-hide="phone,tablet" style="text-align: center">CONVÊNIO</th>
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
	$("#matricula").mask('00000000');
	pageSetUp();
	var pagefunction = function() {


		$("#add_curso").click(function(){

			var matricula 	= $("#matricula").val();
			var curso		= $("#curso option:selected").val();
			var turno		= $("#turno option:selected").val();
			var turma		= $("#turma option:selected").val();
			var empresa		= $("#emp_id option:selected").val();
			var modalidade	= $("#modalidade option:selected").val();
			var status		= $("#status option:selected").val();
			var convenio	= $("#convenio option:selected").val();


			if(isNaN(matricula) || matricula == undefined || matricula == null || matricula.length == 0){
				alerta("O campo de matricula precisa ser preenchido!","","warning","warning");
			}
			else if(curso == 0){
				alerta("Selecione um curso!","","warning","warning");
			}
			else{
				confirma("Aviso","Deseja vincular este curso a este aluno?",function(){
					$.post('server/academico.php',{
						matricula:matricula,
						curso	  :curso,
						turno	  :turno,
						turma     :turma,
						empresa   :empresa,
						modalidade:modalidade,
						status	  :status,
						convenio  :convenio,
						id		  :<?php echo $id;?>
					}).done(function(data){
						if(data == 99999999999){
							alerta("Curso não registrado!","Este curso já existe para este aluno","danger","ban");
						}
						else if(data > 0){
							alerta("Sucesso!","Curso adicionado com sucesso!","success","check");
						}else{
							alerta("Não foi possível adicionar o curso!","","danger","ban");
						}
						$("#dt_basic").dataTable().fnReloadAjax();
					}).fail(function(){

					});
				});
			}

		});


		$.post("server/recupera.php",{tabela:"curso"}).done(function(data){
			var obj = JSON.parse(data);
			for (i in obj){
				$("#curso").append('<option disciplinas="'+obj[i].disciplinas+'" tipo="'+obj[i].tipo+'" periodos="'+obj[i].periodos+'" value="'+obj[i].id+'">'+obj[i].nome+'</option>');
			}
		}).fail(function(){

		});

		$.post("server/recupera.php",{tabela:"empresa"}).done(function(data){
			var obj = JSON.parse(data);
			for (i in obj){
				$("#emp_id").append('<option value="'+obj[i].id+'">'+obj[i].fantasia+'</option>');
			}
		}).fail(function(){

		});

		$.post("server/recupera.php",{tabela:"convenio"}).done(function(data){
			var obj = JSON.parse(data);
			for (i in obj){
				$("#convenio").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
			}
		}).fail(function(){

		});

		$.post("server/recupera.php",{tabela:"modalidade"}).done(function(data){
			var obj = JSON.parse(data);
			for (i in obj){
				$("#modalidade").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
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
			"order":[[ 13, 'asc' ],[12,'desc'],[3,'desc']],
			oSearch: {"bRegex": true},
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"autoWidth" : true,
			"ajax": "server/buscaAcademico.php?pes_id=<?php echo $id;?>",
			"columns": [
				{ "data": "matricula" },
				{ "data": "curso" },
				{ "data": "periodos" },
				{ "data": "turno" },
				{ "data": "turma" },
				{ "data": "unidade"},
				{ "data": "modalidade" },
				{ "data": "convenio" },
				{ "data": "status" }
			],
			"order":[[8,'desc']],
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
				$(row).attr('style', 'cursor:pointer');


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
			$.post("ajax/grade.php",{id:<?php echo $id;?>,matricula:$(this).find("#matricula").attr('valor'),curso:$(this).find("#curso").attr('retorno')}).done(function(data){
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
