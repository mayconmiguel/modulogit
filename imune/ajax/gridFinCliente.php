<?php
require_once("inc/init.php");
require_once("../server/seguranca.php");
@$id = $_POST['id'];
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));
$mes_start = date('01/m/Y');
$mes_end = date('t/m/Y');


$colunas	= "financeiro.id,pessoa.nome,financeiro.dt_emi,financeiro.dt_fat,financeiro.valorliquido,financeiro.obs,financeiro.status as status";
$tabn		= "id,nome,Dt. Emis.,Dt. Fat.,valor,obs,status";

$tabela		= "financeiro,pessoa where pessoa.id = financeiro.pes_id ";

if(isset($_POST['id'])){
	$tabela .= "  and financeiro.pes_id = '$id'";
}

$select = "select ".$colunas." from ".$tabela." order by id desc";


?>

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
				<h2>Ficha Financeira</h2>
			</header>

			<!-- widget div-->
			<div>


				<!-- end widget edit box -->

				<!-- widget content -->
				<div class="widget-body no-padding">

					<table id="datatable_col_reorder5" class="table table-striped table-bordered table-hover" width="100%">
						<thead>
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
								}else if($explode[$i] == "cpf"){
									?>
									<th data-class="phone">
										<?php echo "CPF / CNPJ";?>
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
						</tr>
						</thead>
						<tbody>
						<?php
						$valida = mysqli_query($con,$select);

						while($row = mysqli_fetch_array($valida)){
							?>
							<tr id="<?php echo 'tt'.$row[0];?>">
								<?php
								$explode = explode(",",$colunas);
								for($i=0;$i<count($explode);$i++){

									?>
									<td style="position: relative;" id="td<?php echo $explode[$i];?>">
										<?php
										if($explode[$i] == "Dt. Emis."){
											$row[$i] = substr($row[$i],8,2)."/".substr($row[$i],5,2)."/".substr($row[$i],0,4);
										}else if($explode[$i] == "Dt. Venc." || $explode[$i] == "Dt. Baixa."){
											$row[$i] = substr($row[$i],8,2)."/".substr($row[$i],5,2)."/".substr($row[$i],0,4);
										}else if($explode[$i] == "valor"){
											$row[$i] = "R$ " . str_replace(".",",",$row[$i]);
										}else if($explode[$i] == "status"){
											if($row[$i] == "2"){
												$row[$i] = "<span class='label label-success'>RECEBER</span>";
											}
											elseif($row[$i] == "1"){
												$row[$i] = "<span class='label bg-color-red'>PAGAR</span>";
											}
											elseif($row[$i] == "4"){
												$row[$i] = "<span class='label bg-color-green'>RECEBIDA</span>";
											}
											elseif($row[$i] == "3"){
												$row[$i] = "<span class='label label-primary'>PAGA</span>";
											}
										}
										?>
										<?php echo utf8_encode($row[$i]);?>
										<?php
										?>
									</td>
									<?php
								}
								?>
							</tr>
							<?php
						}
						?>
						</tbody>
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

		/* BASIC ;*/

		var responsiveHelper_datatable_col_reorder = undefined;

		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};



		/* COLUMN SHOW - HIDE */
		$('#datatable_col_reorder5').dataTable({
			"sDom": "<'dt-toolbar'<'col-sm-4 col-xs-6'f><'col-sm-4 col-xs-12 hidden-xs'l><'col-sm-4 col-xs-6 hidden-xs'C>r>"+
			"t"+
			"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
			"aLengthMenu": [
				[5, 10, 25, 50, -1],
				[5, 10, 25, 50, "TODOS"]
			],
			"order":[[ 0, 'desc' ],[1,'desc']],
			oSearch: {"bRegex": true},
			"iDisplayLength": 25,
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_datatable_col_reorder) {
					responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder5'), breakpointDefinition);
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
	};

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
