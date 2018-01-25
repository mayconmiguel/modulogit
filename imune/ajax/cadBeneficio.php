<?php require_once  "../server/seguranca.php";
	$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>
<article class="col-xs-12" id="atendimento">

	<!-- Widget ID (each widget will need unique ID)-->
	<div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false" data-widget-deletebutton="false">
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
			<span class="widget-icon"> <i class="fa fa-check"></i> </span>
			<h2>Novo Atendimento</h2>

		</header>

		<!-- widget div-->
		<div>

			<!-- widget edit box -->
			<div class="jarviswidget-editbox">
				<!-- This area used as dropdown edit box -->

			</div>
			<!-- end widget edit box -->

			<!-- widget content -->
			<div class="widget-body">

				<div class="row">
					<form id="wizard-1" novalidate="novalidate">
						<div id="bootstrap-wizard-1" class="col-sm-12">
							<div class="form-bootstrapWizard">
								<ul class="bootstrapWizard form-wizard">
									<li class="active" data-target="#step1">
										<a href="#tab1" data-toggle="tab"> <span class="step">1</span> <span class="title">Nome do Benefício</span> </a>
									</li>
									<li data-target="#step2">
										<a href="#tab2" data-toggle="tab"> <span class="step">2</span> <span class="title">Especialidade</span> </a>
									</li>
									<li data-target="#step3">
										<a href="#tab3" data-toggle="tab"> <span class="step">3</span> <span class="title">Tabela de Descontos</span> </a>
									</li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="tab-content">
								<div class="tab-pane active" id="tab1">
									<br>
									<h3><strong>PASSO 1 </strong> - NOME DO BENEFÍCIO</h3>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-star fa-lg fa-fw"></i></span>
													<input retorno="" placeholder="NOME DO BENEFÍCIO" autofocus type="text" name="beneficio" id="beneficio" class=" inputs form-control input-lg font-md">
												</div>
											</div>
										</div>
									</div>

								</div>

								<div class="tab-pane" id="tab2">
									<br>
									<h3><strong>PASSO 2</strong> - ESPECIALIDADES</h3>

									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-flag fa-lg fa-fw"></i></span>
													<select name="especialidade" id="especialidade" class="form-control input-lg font-md">

													</select>

												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="tab3">
									<br>
									<h3><strong>Passo 3</strong> - TABELA DE DESCONTOS</h3>
									<div class="row" id="tutoo">
										<div class="col-sm-6 col-xs-12">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-flag fa-lg fa-fw"></i></span>
													<select name="procedimento" id="procedimento" class="form-control input-lg font-md">

													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-tag fa-lg fa-fw"></i></span>
													<select name="tipo" id="tipo" class="form-control input-lg font-md">
														<option value="1">VALOR MONETÁRIO</option>
														<option value="2">PORCENTAGEM</option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-3 col-xs-6">
											<div class="form-group">
												<div class="input-group">
													<span class="input-group-addon"><i class="fa fa-money fa-lg fa-fw"></i></span>
													<input placeholder="DESCONTO" autofocus type="text" name="valor" id="valor" class=" inputs form-control input-lg font-md">
												</div>
											</div>
										</div>
										<div class="col-xs-12">
											<a id="adicionar" class="btn btn-block btn-success" href="javascript:void(0);">
														<span class="btn-label">
														<i class="glyphicon glyphicon-plus"></i>
														</span>
												ADICIONAR
											</a>
										</div>
									</div>

									<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1" data-widget-editbutton="false">
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
											<span class="widget-icon"> <i class="fa fa-table"></i> </span>
											<h2>Itens Adicionados</h2>
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


												<div class="table-responsive">

													<table id="tabela" class="table table-bordered table-striped">
														<thead>
														<tr>
															<th>PROCEDIMENTO</th>
															<th>TIPO</th>
															<th>VALOR</th>
															<th>AÇÕES</th>
														</tr>
														</thead>
														<tbody>

														</tbody>
													</table>

												</div>
											</div>
											<!-- end widget content -->

										</div>
										<!-- end widget div -->

									</div>

								</div>


								<div class="form-actions">
									<div class="row">
										<div class="col-sm-12">
											<ul class="pager wizard no-margin">
												<!--<li class="previous first disabled">
                                                <a href="javascript:void(0);" class="btn btn-lg btn-default"> First </a>
                                                </li>-->
												<li class="previous disabled">
													<a href="javascript:void(0);" class="btn btn-lg btn-default"> Anterior </a>
												</li>
												<!--<li class="next last">
                                                <a href="javascript:void(0);" class="btn btn-lg btn-primary"> Last </a>
                                                </li>-->
												<li class="next">
													<a href="javascript:void(0);" class="btn btn-lg txt-color-darken"> Próximo </a>
												</li>

											</ul>
										</div>
									</div>
								</div>

							</div>
						</div>
					</form>
				</div>

			</div>
			<!-- end widget content -->

		</div>
		<!-- end widget div -->

	</div>
	<!-- end widget -->

</article>
<script>
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

	// PAGE RELATED SCRIPTS

	// pagefunction

	var pagefunction = function() {



		$("#tutoo").find("#valor").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});
		$("#tutoo").find("#tipo").change(function(){
			if($(this).val() == 2){
				$("#tutoo").find("#valor").maskMoney({prefix:'', allowNegative: false, thousands:'', decimal:',', affixesStay: false,suffix:' %'});
			}
			else{
				$("#tutoo").find("#valor").maskMoney({prefix:'R$ ', allowNegative: false, thousands:'', decimal:',', affixesStay: false});
			}
		});




		$("a[data-toggle='tab']").click(function(e){
			return false;
		});


		$.ajax({
			url: 'server/recupera.php',
			type: 'POST',
			data:{tabela:'especialidade where grp_emp_id = <?php echo $empresa;?> order by nome'},
			cache: false,
			async: false,
			success: function(data) {

				var obj = JSON.parse(data);
				for(i in obj){
					$("#especialidade").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
				};


			},
			error:function(){

			}
		});

		$.ajax({
			url: 'server/recupera.php',
			type: 'POST',
			data:{tabela:'procedimento where grp_emp_id = <?php echo $empresa;?> order by nome'},
			cache: false,
			async: false,
			success: function(data) {

				var obj = JSON.parse(data);
				for(i in obj){
					$("#procedimento").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
				};


			},
			error:function(){

			}
		});

		var i = 1;
		$("#adicionar").click(function(){
			console.log($("#procedimento option:selected").val());
			if($("#procedimento option:selected").val() === undefined){
				alerta("Não Existem mais Procedimentos para serem inseridos!","","warning","warning");
			}
			else if($("#tutoo").find('#valor').val().length == 0){
				$("#tutoo").find('#valor').focus().select();
				alerta("O valor do desconto não pode ser 0.","","warning","warning");
			}	
			else{
				$("#tabela").find('tbody').append('<tr id=tr'+i+'>' +
					'<td valor="'+$("#tutoo").find("#procedimento option:selected").val()+'">'+$("#tutoo").find("#procedimento option:selected").text()+'</td>' +
					'<td valor="'+$("#tutoo").find("#tipo option:selected").val()+'">'+$("#tutoo").find("#tipo option:selected").text()+'</td>' +
					'<td valor="'+$("#tutoo").find("#valor").val().replace(",",".")+'">'+$("#tutoo").find("#valor").val()+'</td>' +
					'<td valor="excluir"><a id="excluir" procedimento="'+$("#tutoo").find("#procedimento option:selected").html()+'" valor="'+$("#tutoo").find("#procedimento option:selected").val()+'" class="btn btn-danger" rel="popover-hover" data-placement="bottom" data-content="Excluir" data-html="true" href="javascript:void(0);" data-original-title="" title=""> <i class="fa fa-minus"></i><span class=" hidden-xs hidden-mobile"> Excluir </span></a> </td>' +
					'</tr>');
				$("#tutoo").find("#valor").val('').focus().select();
				$("#tutoo").find("#procedimento option[value='"+$("#procedimento option:selected").val()+"']").remove();
				$("#tr"+i).find("#excluir").click(function(){
					$("#procedimento").append('<option value="'+$(this).attr('valor')+'">'+$(this).attr('procedimento')+'</option>');

					$(this).parent().parent().remove();
					$("#tutoo").find('#valor').focus().select();
				});

				i++;
			}
		});




		// load bootstrap wizard

		loadScript("js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js", runBootstrapWizard);

		//Bootstrap Wizard Validations

		function runBootstrapWizard() {

			var $validator = $("#wizard-1").validate({

				rules: {
					beneficio: {
						required: true,
						minlength: 4
					},

					especialidade: {
						required: true
					},
					country: {
						required: true
					},
					tp_insc: {
						required: true
					},
					postal: {
						required: true,
						minlength: 4
					},
					telefone: {
						required: true,
						minlength: 10
					},
					hphone: {
						required: true,
						minlength: 10
					}
				},

				messages: {
					beneficio: "ESTE CAMPO É OBRIGATÓRIO!",
					especialidade:"ESPECÍFIQUE UMA ESPECIALIDADE",
					email:"",
					tp_insc:"Escolha um tipo!",
					info_desc:"Preencha este campo!"

				},

				highlight: function (element) {
					$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
				},
				unhighlight: function (element) {
					$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
				},
				errorElement: 'span',
				errorClass: 'help-block',
				errorPlacement: function (error, element) {
					if (element.parent('.input-group').length) {
						error.insertAfter(element.parent());
					} else {
						error.insertAfter(element);
					}
				}
			});

			$('#bootstrap-wizard-1').bootstrapWizard({

				'tabClass': 'form-wizard',
				'onPrevious':function(tab,navigation,index){
					if(index == -1){
						return false;
					}else{
						$(".next").find("a").html('Próximo');
						$('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index).removeClass('complete');
						$('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index).find('.step').html(index+1);
					}
				},
				'onNext': function (tab, navigation, index) {

					if(index == 2){

						$.ajax({
							url: 'server/recupera.php',
							type: 'POST',
							data:{tabela:'beneficio where nome = "'+$("#beneficio").val()+'" and esp_id='+$("#especialidade").val()},
							cache: false,
							async: false,
							success: function(data) {

								var obj = JSON.parse(data);
								for(i in obj){
									$("#procedimento option").each(function(){
										if(obj[i].pro_id == $(this).val()){
											$(this).remove();
										}
									});
									//$("#procedimento").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
								};


							},
							error:function(){

							}
						});



						setTimeout(function(){
							$(".next").removeClass('disabled');
							$("#tutoo").find('#valor').focus().select();
						},1000);
						$(".next").find("a").html('Confirmar');

						var $valid = $("#wizard-1").valid();
						if (!$valid) {
							$validator.focusInvalid();
							return false;
						} else {
							$('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass('complete');
							$('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step').html('<i class="fa fa-check"></i>');
						}
					}else if(index == 3){
							var data = [];
							$("#tabela").find('tbody tr').each(function(){
								data.push({nome:$("#beneficio").val(),especialidade:$("#especialidade option:selected").val(),procedimento:$(this).children('td').eq(0).attr("valor"),tipo:$(this).children('td').eq(1).attr("valor"),valor:$(this).children('td').eq(2).attr("valor")});
							});
						if(data.length == 0){
							alerta("Alerta!","Não existem itens na tabela!","warning","warning");
						}else{
							loading('show');

							$.ajax({
								url: 'server/beneficio.php?funcao=1',
								type: 'POST',
								dataType: "json",
								data:{data:data},
								cache: false,
								async: false,
								success: function(data) {
									if(data == 1){
										alerta("Sucesso!","Solicitação realizada com sucesso!","success","check");
										try{
											$("#cadastro").dialog('close');
										}catch(e){

										}
									}else{
										alerta("Falha ao inserir um interessado","","danger","ban");
									}
									try{
										$("#datatable_col_reorder").dataTable().fnReloadAjax();
									}
									catch(e){

									};
									loading('hide');
								},
								error:function(){
									alerta("Falha ao inserir um interessado","","danger","ban");
								}
							});



						}
					}else{
						$(".next").find("a").html('Próximo');
						var $valid = $("#wizard-1").valid();
						if (!$valid) {
							$validator.focusInvalid();
							return false;
						} else {
							$('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass('complete');
							$('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step').html('<i class="fa fa-check"></i>');
						}
					}
				}
			});

		};
	};
	// end pagefunction

	// Load bootstrap wizard dependency then run pagefunction
	pagefunction();
</script>