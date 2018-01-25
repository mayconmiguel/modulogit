<?php
	require_once("inc/init.php");
	require_once("../server/seguranca.php");

	$nome 		= "Empresa";
	$colunas	= "id,razao,susep,fantasia";
	$tabela		= "empresa";

	if(isset($_GET['busca'])){
		$busca = $_GET['busca'];
		if($busca == "PR1SC1L4"){
			$select = "select ".$colunas." from ".$tabela." where grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." order by id";
		}else{
			$select = "select ".$colunas." from ".$tabela." where (id = '$busca' or razao like '%$busca%') and  grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." order by id";
		}
	}else{
		$select = "select ".$colunas." from ".$tabela." where grp_emp_id = ".$_SESSION['imunevacinas']['usuarioEmpresa']." order by id asc";
	}

?>


<!-- widget grid -->
<section id="widget-grid-<?php echo $tabela;?>" class="well">
	<div class="jarviswidget jarviswidget-color-green" id="wid-id-2" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
		<header>
			<h2>Cadastros <span>> <?php echo $nome;?></span></h2>
		</header>

	</div>
	<div class="row">
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
			<a href="javascript:void(0);" id="novo" id="novo" class="btn btn-block btn-primary"> <span class="btn-label"><i class="glyphicon glyphicon-file"></i></span>NOVO </a>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-4 col-xs-4"></div>
		<div class="col-lg-2 col-md-2 col-sm-3 col-xs-3">
			<a href="javascript:void(0);" id="todos" class="btn btn-block btn-info"> <span class="btn-label"><i class="glyphicon glyphicon-book"></i></span>TODOS</a>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-2 col-sm-1 col-xs-1"></div>
		<div class="col-lg-4 col-md-8 col-sm-10 col-xs-10">
			<form action="" class="smart-form" style="background:rgba(255,255,255,0)">
				<fieldset style="background:rgba(255,255,255,0)">
					<section>
						<label class="input">
							<input type="text" id="busca" class="input-lg" placeholder="Digite o nome da <?php echo $nome;?>.">
							<a id="pesquisa" href="javascript:void(0);" class="btn btn-block btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-search"></i></span>PESQUISAR </a>
						</label>
					</section>
				</fieldset>
			</form>
		</div>
		<div class="col-lg-4 col-md-2 col-sm-1 col-xs-1"></div>
	</div>

	<div class="row" style="margin-top: 10px;">
		<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="jarviswidget jarviswidget-color-green" id="wid-id-2" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">

				<header>
					<h2><?php echo $nome;?></h4>

				</header>

				<div>

					<div class="jarviswidget-editbox">
					</div>
					<div class="widget-body no-padding">

						<table id="datatable_col_reorder" class="table table-striped table-bordered table-hover" width="100%">
							<thead>
								<tr>
									<?php
									$explode = explode(",",$colunas);
									for($i=0;$i<count($explode);$i++){
										if($explode[$i] == "razao"){
											?>
											<th data-class="expand">
												<?php echo strtoupper($explode[$i]);?>
											</th>
											<?php
										}else{
											?>
											<th data-hide="phone,tablet">
												<?php echo strtoupper($explode[$i]);?>
											</th>
											<?php
										}
									}
									?>
								</tr>
							</thead>
							<tbody>
							<?php
								$valida = mysqli_query($con,$select);
								while($row = mysqli_fetch_array($valida)){
									?>
									<tr id="<?php echo 'tt'.$row[0];?>" style="cursor:pointer">
										<?php
											$explode = explode(",",$colunas);
											for($i=0;$i<count($explode);$i++){
												if($explode[$i] == "cpf"){
													$mask ='data-mask="999.999.999-99"';
												}else if($explode[$i] == "cnpj"){
													$mask ='data-mask="99.999.999/9999-99"';
												}else if($explode[$i] == "rg"){
													$mask ='data-mask="??9.999.999"';
												}else if($explode[$i] == "telefone"){
													$mask ='data-mask="(99) 9999-9999"';
												}else if($explode[$i] == "celular"){
													$mask ='data-mask="(99) 99999-9999"';
												}else{
													$mask = null;
												}
												?>
												<td style="position: relative;" id="td<?php echo $explode[$i];?>">
													<?php echo utf8_encode($row[$i]);?>
												</td>
												<?php
											}
										?>
									</tr>
									<script>
										$("#tt<?php echo $row[0];?>").dblclick(function(){
											$.post("ajax/cad<?php echo $tabela;?>.php",{id:<?php echo $row[0];?>}).done(function(data){
												$("#cadastro").empty().html(data);
												$("#cadastro").dialog({
													autoOpen : true,
													width : '95%',
													resizable : false,
													modal : true,
													title : "Editar <?php echo $nome;?>"
												});
											}).fail(function(){
												alerta("ERRO!","Função não encontrada!","danger","ban");
											});
										});
									</script>
									<?php
								}
							?>
							</tbody>
						</table>

					</div>
				</div>
			</div>
		</article>
	</div>
	<div class="row">
		<div class="col-sm-12">
		</div>
			
	</div>
</section>
<script type="text/javascript">
	limpa("#cadastro");
	$("td[id='tdcpf']").mask("000.000.000-00");
	$("td[id='tdrg']").mask("000.000.000",{reverse:true});
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
	pageSetUp();
	var pagefunction = function() {

		focar("#busca");
		$("#todos").click(function(){
			loading('show');
			$.ajax({
				url: 'ajax/<?php echo $tabela;?>.php',
				type: 'GET',
				data:{busca:'PR1SC1L4'},
				cache: false,
				success: function(data) {
					$("#content").html(data);
					loading('hide');
				},
				error:function(){
					loading('hide');
				}
			});

		});
		//aciona busca
		$("#pesquisa").click(function(){
			if($("#busca").val().length < 3){
				alerta("AVISO!","Favor digitar pelo menos 3 caracteres para realizar a busca!","warning","warning");
				focar("#busca");
			}else{
				$.ajax({
					url: 'ajax/<?php echo $tabela;?>.php',
					type: 'GET',
					data:{busca:$("#busca").val()},
					cache: false,
					success: function(data) {
						$("#content").html(data);
						loading('hide');
					},
					error:function(){
						loading('hide');
					}
				});
			}
		});
		//enter aciona busca
		$("#busca").keydown(function(e){
			if(e.which == 13){
				$("#pesquisa").click();
			}
		});


		$.fn.dataTable.ext.errMode = 'none';

		// Dialog click
		$('#novo').click(function() {
			$.post('ajax/cad<?php echo $tabela;?>.php').done(function(data){
				$("#cadastro").empty().html(data);
				$("#cadastro").dialog({
					autoOpen : true,
					width : '95%',
					resizable : false,
					modal : true,
					title : "Novo <?php echo $nome;?>"
				});
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
			});
		});

		/* BASIC ;*/

		var responsiveHelper_datatable_col_reorder = undefined;


		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		/* COLUMN SHOW - HIDE */
		$('#datatable_col_reorder').dataTable({
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'f><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
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
			"rowCallback" : function(nRow) {
				responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_datatable_col_reorder.respond();
			}
		});

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
