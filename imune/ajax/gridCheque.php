<?php
require_once("inc/init.php");
require_once("../server/seguranca.php");
@$id = $_POST['id'];
$day = date('w');
$week_start = date('d/m/Y', strtotime('-'.$day.' days'));
$week_end = date('d/m/Y', strtotime('+'.(6-$day).' days'));
$mes_start = date('Y-m-01 00:00:00');
$mes_end = date('Y-m-t 23:59:59');


$colunas	= "financeiro.id,pessoa.nome,empresa.razao as empresa,concat(banco.cod,'-',banco.banco) as banco,natureza.nome as natureza,centrocusto.nome as centrocusto,financeiro.dt_fat,concat(financeiro.cheque,financeiro.boleto) as cheque,financeiro.valorliquido,financeiro.obs,financeiro.status as status";
$tabn		= "id,nome,empresa,banco,Nat.Fin.,C.Custo,Dt. Fat.,numero,valor,obs,status";

$tabela		= "financeiro,pessoa,empresa,banco,centrocusto,natureza where banco.id = financeiro.ban_id and centrocusto.id = financeiro.cen_id and natureza.id = financeiro.nat_id and empresa.id = financeiro.emp_id and pessoa.id = financeiro.pes_id and dt_emi between '$mes_start' and '$mes_end' and cb = 1 and financeiro.status < 5 ";

if(isset($_POST['id'])){
	$tabela .= "  and financeiro.pes_id = '$id'";
}

$select = "select ".$colunas." from ".$tabela." order by id desc";
$colunas = $tabn;
?>
<style>
	.ui-autocomplete { position: absolute; cursor: default;z-index:999999 !important;}
</style>
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
				<h2>LANÇAMENTOS NESTE MÊS</h2>
				<div class="widget-toolbar">
					<div class="btn-group">
						<button class="btn dropdown-toggle btn-xs btn-danger" data-toggle="dropdown" aria-expanded="false">
							Opções
							<i class="fa fa-caret-down"></i>
						</button>
						<ul class="dropdown-menu pull-right">
							<li>
								<a href="javascript:void(0);" id="recebimento">Comprovante Recebimento</a>
							</li>
						</ul>
					</div>
				</div>
			</header>

			<!-- widget div-->
			<div>
				<div class="widget-body no-padding">

					<table id="datatable_col_reorder5" class="table table-striped table-bordered table-hover font-xs" width="100%">
						<thead>
						<tr>
							<th></th>
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
							<tr style="cursor:pointer" id="<?php echo 'tt'.$row['id'];?>" valor="<?php echo $row['id'];?>" status="<?php echo $row['status'];?>">
								<td>
									<input type="checkbox" status="<?php echo $row['status'];?>" name="titulos" nome="<?php echo $row['nome'];?>" valor="<?php echo $row[0];?>">
								</td>
								<?php
								$explode = explode(",",$colunas);
								for($i=0;$i<count($explode);$i++){

									?>
									<td style="position: relative;" id="td<?php echo $explode[$i];?>">
										<?php
										if($explode[$i] == "Dt. Cad."){
											$row[$i] = substr($row[$i],8,2)."/".substr($row[$i],5,2)."/".substr($row[$i],0,4);
										}else if($explode[$i] == "Dt. Fat." || $explode[$i] == "Dt. Baixa."){
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
												$row[$i] = "<span class='label bg-color-green'>RECEBIDO</span>";
											}
											elseif($row[$i] == "3"){
												$row[$i] = "<span class='label label-primary'>PAGO</span>";
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
							<script>
								$("#tt<?php echo $row[0];?>").dblclick(function(){
									if($(this).find("input[name='titulos']").attr('status') == 3 || $(this).find("input[name='titulos']").attr('status') == 4){

									}else{
										loading('show');
										$("html, body").animate({ scrollTop: 0 }, "slow");
										$("#inserir").addClass("hidden");
										$("#salvar,#cancelar").removeClass("hidden");
										$.post('server/recupera2.php',{tabela:"select financeiro.cen_id, financeiro.nat_id,financeiro.id, pessoa.nome, pessoa.id as pes_id, financeiro.emp_id, financeiro.ban_id, financeiro.pag_id, financeiro.dt_fat, concat(financeiro.cheque,financeiro.boleto) as numero, financeiro.valorliquido, financeiro.obs from financeiro,pessoa where pessoa.id = financeiro.pes_id and financeiro.id=<?php echo $row[0];?>"}).done(function(data){
											var obj2 = JSON.parse(data);
											obj2 = obj2[0];
											$("#lancamentoCheque").find('#empresa').val(obj2.emp_id).change();
											$("#lancamentoCheque").find('#tp').val(obj2.pag_id).change();
											setTimeout(function(){
												$("#lancamentoCheque").find('#natureza').val(obj2.nat_id).change();
												setTimeout(function(){
													$("#lancamentoCheque").find('#centrocusto').val(obj2.cen_id).change();
													$("#lancamentoCheque").find('#banco').val(obj2.ban_id).change();
													loading('hide');
												},1000);
											},2000);
											$("#lancamentoCheque").find('#cli_id').attr('financeiro',obj2.id);
											$("#lancamentoCheque").find('#cli_id').attr('retorno',obj2.pes_id);
											$("#lancamentoCheque").find('#cli_id').val(obj2.nome);

											$("#lancamentoCheque").find('#dt_fat').val(obj2.dt_fat.substr(8,2)+"/"+obj2.dt_fat.substr(5,2)+"/"+obj2.dt_fat.substr(0,4));
											$("#lancamentoCheque").find('#cheque').val(obj2.numero);
											$("#lancamentoCheque").find('#pr_bruto').val("R$ "+obj2.valorliquido.replace(".",","));
											$("#lancamentoCheque").find('#obs').val(obj2.obs);
											$("#lancamentoCheque").find("#cli_id").prop('disabled',true);
										});

										setTimeout(function(){
											loading('hide');
										},4000);

									}
								});
							</script>
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
	var titulos = [];
	var nome = "";
	$('input[name="titulos"]').click(function(){
		if(nome == ""){
			nome = $(this).attr('nome');
		}else{
			if(nome != $(this).attr('nome')){
				alerta("Alerta!","Selecione apenas titulos de 1 cliente por vez!","warning","warning");
				$("input[name='titulos']:checked").each(function(){
					$(this).removeAttrs("checked");
					nome = "";
				});
			}
		}
	});

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

		$("#recebimento").click(function(e){
			$("input[name='titulos']:checked").each(function(){
				var target = $(this).attr('valor');
				titulos.push(target);
			});
			var retorno = titulos;
			if(titulos.length >= 1){
				try{
					$("#cadastro").dialog('close');
				}catch(e){

				}
				$.SmartMessageBox({
					title : "ATENÇÃO",
					content : "Digite o nome do produtor e clique em continuar!",
					buttons : "[Cancelar][Continuar]",
					input : "text",
					inputValue: "",
					placeholder:"Nome do produtor!"
				}, function(ButtonPress, Value) {
					if(ButtonPress == "Continuar"){
						var valor = $(".divMessageBox").find('input:text').attr("value");
						comprovante("server/comprovante.php","titulos="+retorno+"&funcao=2&produtor="+valor);
					}
					try{
						$("#cadastro").dialog('open');
					}catch(e){

					}
				});

				$(function(){
					$(".divMessageBox").find('input:text').autocomplete({
						source: "ajax/busca.php",
						select: function(event,ui){
							$(this).attr("retorno",ui.item.id);
							$(this).attr("value",ui.item.nome);

						},
						search:function(){
							loading('show');
						},
						response:function(){
							loading('hide')
						},
						delay:1000,
						minLength:3,
					});
					$(".divMessageBox").find('input:text').autocomplete('option','appendTo',"div[class='divMessageBox']");
				});

				e.preventDefault();

			}else{
				alerta("POR FAVOR, SELECIONE PELO MENOS 1 TÍTULO.","","warning","warning");
			}
			titulos = [];
			$("input[name='titulos']").each(function(){
				$(this).removeAttrs("checked");
				nome = "";
			});
		});

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
			"order":[[ 1, 'desc' ],[2,'desc']],
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
