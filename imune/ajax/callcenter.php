<?php require_once "../server/seguranca.php";?>
<?php require_once("inc/init.php"); ?>
<div id="cadastro2" class="hide"></div>
<section id="widget-grid" class="">

	<!-- row -->
	<div class="row">

		<!-- NEW WIDGET START -->
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget" id="wid-id-6" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false">
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
					<span class="widget-icon"> <i class="fa fa-phone txt-color-darken"></i> </span>
					<h2>CALLCENTER</h2>
					<ul class="nav nav-tabs pull-right in" id="myTab">
						<li class="active">
							<a data-toggle="tab" id="btn_receber" href="#s1"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Geral</span></a>
						</li>

						<li>
							<a data-toggle="tab" id="btn_pagar" href="#s2"><i class="glyphicon glyphicon-list-alt"></i> <span class="hidden-mobile hidden-tablet">Faltantes</span></a>
						</li>
					</ul>


				</header>

				<!-- widget div-->
				<div>
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">

					</div>
					<!-- end widget edit box -->

					<div class="widget-body">

						<div id="myTabContent" class="tab-content">
							<div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
								<!-- content -->
								<div class="row no-space">
									<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover font-xs" width="100%">
										<thead>
										<tr>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="ID" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="<?php echo mb_strtoupper($_SESSION['config']['profissional']);?>" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="<?php echo mb_strtoupper($_SESSION['config']['cliente']);?>" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="TELEFONE" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="CELULAR" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="DATA" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="HORA" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="OBS" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="RESULTADO" />
											</th>
											<th class="hasinput">
												<input type="text" class="form-control" placeholder="STATUS" />
											</th>
										</tr>
										<tr>
											<th data-class="expand">ID</th>
											<th data-hide="minimo,phone,meio"><?php echo mb_strtoupper($_SESSION['config']['profissional']);?></th>
											<th data-hide="minimo,phone,meio"><?php echo mb_strtoupper($_SESSION['config']['cliente']);?></th>
											<th data-hide="minimo,phone,meio">TELEFONE</th>
											<th data-hide="minimo,phone,meio">CELULAR</th>
											<th data-hide="minimo,phone,meio">DATA</th>
											<th data-hide="minimo,phone,meio">HORA</th>
											<th data-hide="minimo,phone,meio">OBS</th>
											<th data-hide="minimo,phone,meio">RESULTADO</th>
											<th data-hide="minimo,phone,meio">STATUS</th>
										</tr>
										</thead>
									</table>
								</div>

								<!-- end content -->

							</div>
							<!-- end s1 tab pane -->

							<div class="tab-pane fade" id="s2">
								<table id="datatable_col_reorder2" class="table table-striped table-bordered table-hover font-xs" width="100%">
									<thead>
									<tr>
										<th class="hasinput">
											<input type="text" class="form-control" placeholder="<?php echo mb_strtoupper($_SESSION['config']['cliente']);?>" />
										</th>
										<th class="hasinput">
											<input type="text" class="form-control" placeholder="ULT. CONSULTA" />
										</th>
										<th class="hasinput">
											<input type="text" class="form-control" placeholder="<?php echo mb_strtoupper($_SESSION['config']['profissional']);?>" />
										</th>

										<th class="hasinput">
											<input type="text" class="form-control" placeholder="TELEFONE" />
										</th>
										<th class="hasinput">
											<input type="text" class="form-control" placeholder="CELULAR" />
										</th>
										<th class="hasinput">
											<input type="text" class="form-control" placeholder="T. FALTAS" />
										</th>

									</tr>
									<tr>
										<th data-class="expand"><?php echo mb_strtoupper($_SESSION['config']['cliente']);?></th>
										<th data-hide="minimo,phone,meio">ULT. CONSULTA</th>
										<th data-hide="minimo,phone,meio">TELEFONE</th>
										<th data-hide="minimo,phone,meio">CELULAR</th>
										<th data-hide="minimo,phone,meio"><?php echo mb_strtoupper($_SESSION['config']['profissional']);?></th>
										<th data-hide="minimo,phone,meio">T. FALTAS</th>
									</tr>
									</thead>
								</table>
							</div>
						</div>



					</div>

				</div>
				<!-- end widget div -->
			</div>
		</article>
	</div>
</section>


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
		var responsiveHelper_datatable_col_reorder2 = undefined;

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
			"ajax":"server/buscaCallcenter.php",
			"columns": [
				{"data": "id"},
				{"data": "profissional"},
				{"data": "cliente"},
				{"data": "telefone"},
				{"data": "celular"},
				{"data": "dt_start","sType":"date-uk"},
				{"data": "hora"},
				{"data": "obs"},
				{"data": "motivo"},
				{"data": "status"}

			],
			"order": [[5, 'desc'],[6, 'asc'],[9,'asc']],
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


				$(row).css({"cursor":"pointer"});


				$(row).children('td').eq(3).html('<mirai id="telefone">'+aData.telefone+'</mirai>');
				$(row).children('td').eq(4).html('<mirai id="celular">'+aData.celular+'</mirai>');

				if(aData.obs == null){
					aData.obs = 'Sem Observação';
				};
				$(row).children('td').eq(7).html('<mirai id="obs">'+aData.obs+'</mirai>');

				$(row).children('td').eq(8).html('<mirai id="motivo">'+aData.motivo+'</mirai>');

				$(row).find("#telefone").editable({
					type:'text',
					value:aData.telefone,
					emptytext:'Sem Telefone',
				});
				$(row).find("#celular").editable({
					type:'text',
					value:aData.celular,
					emptytext:'Sem Celular',
				});

				$(row).find('#telefone').on('save', function(e, params) {

					$.post('server/updateCampo.php',{tabela:"pessoa",coluna:$(this).attr('id'),valor:params.newValue,id:aData.cli_id});
					setTimeout(function(){
						alerta("Sucesso!","Operação Realizada Com Sucesso!","success","check");
						$("#datatable_col_reorder").dataTable().fnReloadAjax();
					},500);
				});
				$(row).find('#celular').on('save', function(e, params) {

					$.post('server/updateCampo.php',{tabela:"pessoa",coluna:$(this).attr('id'),valor:params.newValue,id:aData.cli_id});
					setTimeout(function(){
						alerta("Sucesso!","Operação Realizada Com Sucesso!","success","check");
						$("#datatable_col_reorder").dataTable().fnReloadAjax();
					},500);
				});

				if(aData.st <= 2 || aData.st == 4 || aData.st == 7){
					$(row).find('#obs').editable({
						type: 'textarea',
						emptytext:'Sem Observação',
						value:aData.obs,
						toggle:'click',
						send:"always"
					});




					$(row).find('#motivo').editable({
						type: 'select',
						value:aData.mot,
						source:[
							{value:0,text:'NÃO INFORMADO'},
							{value:1,text:'CONTATO REALIZADO COM SUCESSO'},
							{value:2,text:'RETORNAR LIGAÇÃO MAIS TARDE'},
							{value:3,text:'CAIXA POSTAL'},
							{value:4,text:'TELEFONE OCULPADO'},
							{value:5,text:'FORA DE AREA OU DESLIGADO'},
							{value:6,text:'NÚMERO DE TELEFONE NÃO EXISTE'},
							{value:7,text:'ENGANO / NÚMERO ERRADO'}
						],
						toggle:'click',
						send:"always"
					});

					$(row).find('#status').editable({
						type: 'select',
						value:aData.st+'|*|'+aData.color,
						source:[
							{value:1+'|*|#20202F',text:'AGENDADO'},
							{value:2+'|*|#001A66',text:'CONFIRMADA'},
							{value:3+'|*|#008C23',text:'COMPARECIDA'},
							{value:4+'|*|#D9A300',text:'REMARCADA'},
							{value:5+'|*|#B20000',text:'NÃO COMPARECIDA'},
							{value:6+'|*|orangeRed',text:'CANCELADA'},
							{value:7+'|*|#00B2B2',text:'ENCAIXADA'}
						],
						toggle:'click',
						send:"always"
					});



					$(row).find('#obs').on('save', function(e, params) {

						$.post('server/updateCampo.php',{tabela:"consulta",coluna:$(this).attr('id'),valor:params.newValue,id:aData.id});
						setTimeout(function(){
							alerta("Sucesso!","Operação Realizada Com Sucesso!","success","check");
							$("#datatable_col_reorder").dataTable().fnReloadAjax();
						},500);
					});


					$(row).find('#status').on('save', function(e, params) {

						if(params.newValue.split('|*|')[0] == 4){
							confirma("Aviso!","Você esta marcando este evento como uma remarcação deseja inserir um novo evento?",function(){
								$.post('ajax/agenda.php',{profica:aData.pro_id}).done(function(data){
									$("#cadastro2").empty().html(data).removeClass('hide').dialog({
										modal: true,
										autoOpen:true,
										//moveToTop:true,
										width:"90%",
										height:"auto",
										position:['center',20],
										title: "Novo Evento",
										title_html: true
									});
								});
								$.post('server/updateCampo.php',{tabela:"consulta",coluna:'status',valor:params.newValue.split('|*|')[0],id:aData.id});
								$.post('server/updateCampo.php',{tabela:"consulta",coluna:'color',valor:params.newValue.split('|*|')[1],id:aData.id});
								setTimeout(function(){
									$("#datatable_col_reorder").dataTable().fnReloadAjax();
								},500);
							});
						}else{
							$.post('server/updateCampo.php',{tabela:"consulta",coluna:'status',valor:params.newValue.split('|*|')[0],id:aData.id});
							$.post('server/updateCampo.php',{tabela:"consulta",coluna:'color',valor:params.newValue.split('|*|')[1],id:aData.id});
							setTimeout(function(){
								alerta("Sucesso!","Operação Realizada Com Sucesso!","success","check");
								$("#datatable_col_reorder").dataTable().fnReloadAjax();
							},500);
						}
					});

					$(row).find('#motivo').on('save', function(e, params) {

						if(params.newValue == 1){
							$.SmartMessageBox({
								title : "ATENÇÃO",
								content : "Deseja alterar este evento para qual status?",
								buttons : "[2 - CONFIRMADO][1 - REMARCADO]"
							}, function(ButtonPress, Value) {
								if(ButtonPress == "1 - REMARCADO"){

									confirma("Aviso!","Você esta remarcando este evento, deseja inserir um novo evento?",function(){
										$.post('ajax/agenda.php',{profica:aData.pro_id}).done(function(data){
											$("#cadastro2").empty().html(data).removeClass('hide').dialog({
												modal: true,
												autoOpen:true,
												//moveToTop:true,
												width:"90%",
												height:"auto",
												position:['center',20],
												title: "Novo Evento",
												title_html: true
											});
										});
										$.post('server/updateCampo.php',{tabela:"consulta",coluna:'status',valor:4,id:aData.id});
										setTimeout(function(){
											$("#datatable_col_reorder").dataTable().fnReloadAjax();
										},500);
									});
								}
								else if(ButtonPress == "2 - CONFIRMADO"){
									$.post('server/updateCampo.php',{tabela:"consulta",coluna:"status",valor:2,id:aData.id});
									setTimeout(function(){
										alerta("Sucesso!","Operação Realizada Com Sucesso!","success","check");
										$("#datatable_col_reorder").dataTable().fnReloadAjax();
									},500);
								}
								$.post('server/updateCampo.php',{tabela:"consulta",coluna:"motivo",valor:params.newValue,id:aData.id});

							});
						}else{
							$.post('server/updateCampo.php',{tabela:"consulta",coluna:$(this).attr('id'),valor:params.newValue,id:aData.id});
							setTimeout(function(){
								alerta("Sucesso!","Operação Realizada Com Sucesso!","success","check");
								$("#datatable_col_reorder").dataTable().fnReloadAjax();
							},500);
						}
					});
				}
			},
			"drawCallback": function (oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}
		});


		var table2 = $('#datatable_col_reorder2').dataTable({
			aLengthMenu: [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "TODOS"]
			],
			"ajax":"server/buscaFaltantes.php",
			"columns": [
				{"data": "cliente"},
				{"data": "ult_consulta","sType":"date-uk"},
				{"data": "telefone"},
				{"data": "celular"},
				{"data": "profissional"},
				{"data": "faltas"}

			],
			"order": [[1, 'desc']],
			oSearch: {"bRegex": true},
			iDisplayLength: 25,
			// "sDom": '<"top"f>t<"clear">',
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>" +
			"t" +
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"autoWidth": true,
			"preDrawCallback": function () {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder2) {
					responsiveHelper_datatable_col_reorder2 = new ResponsiveDatatablesHelper($('#datatable_col_reorder2'), breakpointDefinition);
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
				responsiveHelper_datatable_col_reorder2.createExpandIcon(nRow);
				var row = table2.fnGetNodes(nRow);


				$(row).css({"cursor":"pointer"});



			},
			"drawCallback": function (oSettings) {
				responsiveHelper_datatable_col_reorder2.respond();
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
					var noResult = { value:"",label:"Nenhum registro encontrado"};
					ui.content.push(noResult);
				}
			},
			delay:1000,
			minLength:3
		});
		$("#pesquisaConsulta").find('#pesquisaCli').autocomplete('option','appendTo',"div[id='cadastro']");
		$(".dt-toolbar .col-sm-4:first").append('Localizar BD: <input class="form-control" id="buscaBanco">');
		var timer;
		var x;

		$("#buscaBanco").keyup(function () {
			if(this.value.length > 2){
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = table.fnReloadAjax('server/buscaCallcenter.php?type=<?php echo $type;?>&busca='+$("#buscaBanco").val());
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}else{
				if (x) { x.abort() } // If there is an existing XHR, abort it.
				clearTimeout(timer); // Clear the timer so we don't end up with dupes.
				timer = setTimeout(function() { // assign timer a new timeout
					x = table.fnReloadAjax('server/buscaCallcenter.php?type=<?php echo $type;?>');
					// run ajax request and store in x variable (so we can cancel)
				}, 500); // 2000ms delay, tweak for faster/slower
			}
		});

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

		$("#datatable_col_reorder2 thead th input[type=text]").on('keyup change', function () {
			var campo = $(this);
			if (x) {
				x.abort()
			} // If there is an existing XHR, abort it.
			clearTimeout(timer); // Clear the timer so we don't end up with dupes.
			timer = setTimeout(function () { // assign timer a new timeout
				x = atuatu2(campo);
				// run ajax request and store in x variable (so we can cancel)
			}, 500); // 2000ms delay, tweak for faster/slower


		});

		function atuatu(a) {
			$("#datatable_col_reorder").dataTable().api().column(a.parent().index() + ':visible').search(a.val()).draw();
		};
		function atuatu2(a) {
			$("#datatable_col_reorder2").dataTable().api().column(a.parent().index() + ':visible').search(a.val()).draw();
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