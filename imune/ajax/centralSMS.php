<?php require_once "../server/seguranca.php";?>
<?php require_once("inc/init.php"); ?>
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
					<span class="widget-icon"> <i class="glyphicon glyphicon-envelope txt-color-darken"></i> </span>
					<h2>CENTRAL SMS</h2>

					<ul class="nav nav-tabs pull-right in" id="myTab">
						<li class="active">
							<a data-toggle="tab" id="btn_receber" href="#s1"><i class="fa fa-clock-o"></i> <span class="hidden-mobile hidden-tablet">Envio de SMS</span></a>
						</li>

						<li>
							<a data-toggle="tab" id="btn_pagar" href="#s2"><i class="glyphicon glyphicon-list-alt"></i> <span class="hidden-mobile hidden-tablet">Configurações</span></a>
						</li>
					</ul>

				</header>

				<!-- widget div-->
				<div class="no-padding">
					<!-- widget edit box -->
					<div class="jarviswidget-editbox">

						test
					</div>
					<!-- end widget edit box -->

					<div class="widget-body">
						<!-- content -->
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane fade active in padding-10 no-padding-bottom" id="s1">
								<div class="row no-space">
									<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" id="enviaSMS">

									</div>
									<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 show-stats">

										<div class="row">
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Enviados (Hoje) <span class="pull-right">2000 SMS(s)</span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-blueDark" style="width: 100%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> 1 - Pendentes (Hoje) <span class="pull-right">440 SMS(s)</span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-orange" style="width: 34%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> 2 - Não Entregues (Hoje)<span class="pull-right">77 SMS(s)</span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-redLight" style="width: 77%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> 3 - Entregues (Hoje)<span class="pull-right">77 SMS(s)</span> </span>
												<div class="progress">
													<div class="progress-bar bg-color-green" style="width: 77%;"></div>
												</div> </div>
											<div class="col-xs-6 col-sm-6 col-md-12 col-lg-12"> <span class="text"> Respondidos (Hoje) <span class="pull-right">7 SMS(s)</span> </span>
												<div class="progress">
													<div class="progress-bar label-primary" style="width: 84%;"></div>
												</div> </div>
										</div>

									</div>
								</div>

								<div class="show-stat-microcharts">
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">

										<div class="easy-pie-chart txt-color-orangeDark" data-percent="33" data-pie-size="50">
											<span class="percent">35</span>
										</div>
										<span class="easy-pie-title"> Enviados <i class="fa fa-caret-up icon-color-bad"></i> </span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-greenLight"><i class="fa fa-caret-up"></i> 97</span>
											</li>
											<li>
												<span class="label bg-color-blueLight"><i class="fa fa-caret-down"></i> 44</span>
											</li>
										</ul>
										<div class="sparkline txt-color-greenLight hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent">
											130, 187, 250, 257, 200, 210, 300, 270, 363, 247, 270, 363, 247
										</div>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<div class="easy-pie-chart txt-color-greenLight" data-percent="78.9" data-pie-size="50">
											<span class="percent">78.9 </span>
										</div>
										<span class="easy-pie-title"> Pendentes <i class="fa fa-caret-down icon-color-good"></i></span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-blueDark"><i class="fa fa-caret-up"></i> 76</span>
											</li>
											<li>
												<span class="label bg-color-blue"><i class="fa fa-caret-down"></i> 3</span>
											</li>
										</ul>
										<div class="sparkline txt-color-blue hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent">
											257, 200, 210, 300, 270, 363, 130, 187, 250, 247, 270, 363, 247
										</div>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<div class="easy-pie-chart txt-color-blue" data-percent="23" data-pie-size="50">
											<span class="percent">23 </span>
										</div>
										<span class="easy-pie-title"> Entregues <i class="fa fa-caret-up icon-color-good"></i></span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-darken">10</span>
											</li>
											<li>
												<span class="label bg-color-blueDark"><i class="fa fa-caret-up"></i> 10</span>
											</li>
										</ul>
										<div class="sparkline txt-color-darken hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent">
											200, 210, 363, 247, 300, 270, 130, 187, 250, 257, 363, 247, 270
										</div>
									</div>
									<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
										<div class="easy-pie-chart txt-color-darken" data-percent="36" data-pie-size="50">
											<span class="percent">36 <i class="fa fa-caret-up"></i></span>
										</div>
										<span class="easy-pie-title"> Não Entregues <i class="fa fa-caret-down icon-color-good"></i></span>
										<ul class="smaller-stat hidden-sm pull-right">
											<li>
												<span class="label bg-color-red"><i class="fa fa-caret-up"></i> 124</span>
											</li>
											<li>
												<span class="label bg-color-blue"><i class="fa fa-caret-down"></i> 40</span>
											</li>
										</ul>
										<div class="sparkline txt-color-red hidden-sm hidden-md pull-right" data-sparkline-type="line" data-sparkline-height="33px" data-sparkline-width="70px" data-fill-color="transparent">
											2700, 3631, 2471, 2700, 3631, 2471, 1300, 1877, 2500, 2577, 2000, 2100, 3000
										</div>
									</div>
								</div>

							</div>
							<!-- end s1 tab pane -->

							<div class="tab-pane fade" id="s2">

							</div>
						</div>

						<!-- end content -->
					</div>

				</div>
				<!-- end widget div -->
			</div>





			<div class="jarviswidget" id="wid-id-13"
				 data-widget-load="ajax/gridCampanha.php"
				 data-widget-colorbutton="false"
				 data-widget-colorbutton="false"
				 data-widget-editbutton="false"
				 data-widget-togglebutton="false"
				 data-widget-deletebutton="false"
				 data-widget-fullscreenbutton="false"
				 data-widget-custombutton="false">
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
					<h2>Histórico SMS</h2>

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

						<!-- widget body text-->

						<p>This content will be replaced via ajax loader...</p>

						<!-- end widget body text-->

					</div>
					<!-- end widget content -->

				</div>
				<!-- end widget div -->

			</div>

		</article>
	</div>
</section>

<script>
	pageSetUp();

	var pagefunction = function() {



		// switch style change
		$('input[name="checkbox-style"]').change(function() {
			//alert($(this).val())
			$this = $(this);

			if ($this.attr('value') === "switch-1") {
				$("#switch-1").show();
				$("#switch-2").hide();
			} else if ($this.attr('value') === "switch-2") {
				$("#switch-1").hide();
				$("#switch-2").show();
			}

		});

		// tab - pills toggle
		$('#show-tabs').click(function() {
			$this = $(this);
			if($this.prop('checked')){
				$("#widget-tab-1").removeClass("nav-pills").addClass("nav-tabs");
			} else {
				$("#widget-tab-1").removeClass("nav-tabs").addClass("nav-pills");
			}

		});

	};

	// end pagefunction

	// run pagefunction on load

	pagefunction();


	limpa("#cadastro");
	$("[rel=tooltip]").tooltip();

	$.post("ajax/novoCampanha.php",{type:1}).done(function(data){
		$("#enviaSMS").html(data);
	});






	$("#wid-id-6").find("#btn_pagar").click(function(){
		loading('show');
		$.post("ajax/configSMS.php",{type:1}).done(function(data){
			$("#s2").html(data);
			loading('hide');
		}).fail(function(){
			loading('hide');
			alerta('Não foi possível executar esta operação!','Verifique o acesso a rede, certifique-se que sua conexão esta ok e tente novamente.','danger','ban');
		});
	});
	$("#wid-id-6").find("#btn_receber").click(function(){
		loading('show');
		$.post("ajax/novoCampanha.php",{type:2}).done(function(data){
			$("#enviaSMS").html(data);
			loading('hide');
		}).fail(function(){
			loading('hide');
			alerta('Não foi possível executar esta operação!','Verifique o acesso a rede, certifique-se que sua conexão esta ok e tente novamente.','danger','ban');
		});
	});


</script>


