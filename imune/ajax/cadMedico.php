
<?php $nome = "vacina"; $tabela = "vacinas";
require_once "../server/seguranca.php";
?>

<div class="jarviswidget jarviswidget jarviswidget-color-green"  id="novaVacina">

	<header>
		<span class="widget-icon"> <i class="fa fa-table"></i> </span>
		<h2>Cadastro-Medico</h2>
	</header>

<div id="novoMedico">


		<div class="panel-group smart-accordion-default" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a data-toggle="collapse" href="#collapseOne"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i>  Dados Gerais</a></h4>
				</div>
				<div id="collapseOne" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-6 col-xs-1 text-center">
								<img id="imgavatar" name="imagefile" class="avatarselector myimgdestination thumbnail img-btn" style="cursor:pointer;display: inline !important;" src="" width="170px" height="170px" data-destination="myimgdestination" data-source="imgavatar">
							</div>
							<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
								Usuario Cadastro:<input type="text" name="celular" id="uso_cad" class="form-control wd100">
							</div>
							<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
								Unidade:<select type="text" name="email" id="unidade" class="form-control wd100"></select>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
								Data Cadastro:<input type="text"  id="data_cad" class="form-control wd100">
							</div>
							<div class="col-lg-5 col-md-5 col-sm-3 col-xs-12">
								Cadastro N°:<input type="text"  id="n_cad" class="form-control wd100">
							</div>
							<div class="col-lg-10 col-md-10 col-sm-6 col-xs-12">
								Nome Completo <span class="red">*</span> <input autofocus type="text" id="nome" class=" inputs form-control wd100">
							</div>
							<div class="col-lg-5 col-sm-5 col-xs-6">
								Telefone <span class="red">*</span><input type="text"  id="telefone" class="form-control wd100">
							</div>
							<div class="col-lg-5 col-sm-5 col-xs-6">
								Celular<input type="text" id="celular" class="form-control wd100">
							</div>
							<div class="col-lg-12 col-sm-12 col-xs-12">
								Email<input type="text"  id="email" class="form-control wd100">
							</div>
							<div class="col-lg-6 col-sm-6 col-xs-6">
								Cidade<input type="text"  id="cidade" class="form-control wd100">
							</div>
							<div class="col-lg-6 col-sm-6 col-xs-6">
								Estado<input type="text"  id="estado" class="form-control wd100">
							</div>
						</div>
						<div class="row">

						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title"><a data-toggle="collapse"  href="#collapseThree"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i> Informações Adicionais </a></h4>
				</div>
				<div id="collapseThree" class="panel-collapse collapse in">
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="clearfix">
									Observações:
									<textarea class="form-control" name="obs" id="obs" style="width:100%"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row" id="botoesCliente">
		<div class="col-sm-12 center">
			<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>CADASTRAR</a>
			<a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
			<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
			<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
			<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
		</div>
	</div>
</div>


	<?php

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		?>
		<script>
			//mostra botões ocultos;
			$("#editar, #excluir").removeClass("hidden");

			//oculta botões;
			$("#cadastrar").addClass("hidden");

			//bloqueia campos;
			// desabilita todos campos de entrada
			$("#novo<?php echo $tabela;?>").find("input,textarea,select").each(function(){
				$(this).attr("disabled","disabled");
			});

			//busca campos no banco;
			$.post("server/recupera.php",{tabela:'medico where id = <?php echo $id;?>'}).done(function(data){
				var obj = JSON.parse(data);


				//alimenta formulário;
				$("#novoMedico").find("#uso_cad").val(obj[0].uso_cad);
				$("#novoMedico").find("#unidade").val(obj[0].unidade);
				$("#novoMedico").find("#data_cad").val(obj[0].data_cad);
				$("#novoMedico").find("#n_cad").val(obj[0].n_cad);
				$("#novoMedico").find("#nome").val(obj[0].nome);
				$("#novoMedico").find("#telefone").val(obj[0].telefone);
				$("#novoMedico").find("#celular").val(obj[0].celular);
				$("#novoMedico").find("#email").val(obj[0].email);
				$("#novoMedico").find("#cidade").val(obj[0].cidade);
				$("#novoMedico").find("#estado").val(obj[0].estado);
				$("#novoMedico").find("#obs").val(obj[0].obs);

			});

			//editando formulário
			$("#editar").click(function(){
				//Liberar campos pra edição
				$("#novo<?php echo $tabela;?>").find("input,textarea,select").each(function(){
					$(this).removeAttrs("disabled");
				});

				//focar no primeiro campo
				$("#nome").focus().select();

				//esconde botões
				$("#excluir,#editar").addClass("hidden");

				//aparece botões
				$("#salvar,#cancelar").removeClass("hidden");
			});

			//excluindo item


			// cancelando edição
			$("#cancelar").click(function(){
				$.post("ajax/cadMedico.php",{id:<?php echo $id;?>}).done(function(data){
					$("#cadastro").empty().html(data);
				}).fail(function(){
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
			});

			//salvando edição

		</script>
	<?php
	}else{
	?>
		<script type="text/javascript">
			$("input[name='tipo[]']").each(function(){
				$(this).attr('checked',true);
			});
			//inserir cadastro
			$("#cadastrar").click(function(){
				var nome 		= $("#nome").val();

				if(nome==="")
				{

					alerta("AVISO!","Favor preencher o campo Imunobiologico!","warning","warning");
					focar($("#nome"));
				}

				else
				{
					var data = new FormData();
					$("#novaVacina").find('input:text,select,textarea').each(function(){
						data.append($(this).attr('id'),$(this).val());
					});
					data.append("funcao",1);

					loading("show");
					$.ajax({
						url: 'server/medico.php',
						type: 'POST',
						processData: false,
						contentType: false,
						cache: false,
						data:data,
						success: function(data) {
							if(data == 2){
								alerta("AVISO!","Já existe uma <?php echo $nome;?> com o mesmo nome cadastrado no sistema!","warning","warning");
								focar($("#nome"));
								loading('hide');
							}else if(data == 1){
								alerta("SUCESSO!","<?php echo $nome;?> cadastrado com sucesso!","success","check");
								$("#cadastro").dialog('close');
								$.ajax({
									url: 'ajax/medico.php',
									type: 'POST',
									cache: false,
									success: function(data) {
										$("#content").html(data);
									},
									error:function(){
										loading('hide');
									}
								});
							}else if(data == 0){
								alerta("ERRO!","Erro ao cadastrar <?php echo $nome;?>!","danger","ban");
								$("#cadastro").dialog('close');
							}
							loading("hide");
						}
					});
				}
			});


		</script>
		<?php
	}

	?>


	<script type="text/javascript">

	/*	$("#dt_fabricacao").datepicker({


			changeMonth: true,
			numberOfMonths: 1,
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>',
			language: 'pt-BR',
			dateFormat: 'dd/mm/yy',
			currentText: 'Hoje',
			monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
				'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
				'Jul','Ago','Set','Out','Nov','Dez'],
			dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
			dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
			dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
			onClose: function (selectedDate) {

			}

		}).val("<?php echo date('01/m/Y');?>");
		$("#vencimento").datepicker({

			changeMonth: true,
			numberOfMonths: 1,
			prevText: '<i class="fa fa-chevron-left"></i>',
			nextText: '<i class="fa fa-chevron-right"></i>',
			language: 'pt-BR',
			dateFormat: 'dd/mm/yy',
			currentText: 'Hoje',
			monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
				'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
				'Jul','Ago','Set','Out','Nov','Dez'],
			dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
			dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
			dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
			onClose: function (selectedDate) {

			}
		}).val("<?php echo date('t/m/Y');?>");


		$("#esquema").select2();
		$("#valor").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});
		$("#valordesconto").maskMoney({thousands:'', decimal:',', affixesStay: false,suffix:' %'});

*/

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