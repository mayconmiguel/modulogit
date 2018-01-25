<div class="jarviswidget" id="wid-id-6" data-widget-colorbutton="false" data-widget-togglebutton="false" data-widget-editbutton="false" data-widget-fullscreenbutton="false" data-widget-deletebutton="false">
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
		<h2><strong>CENTRAL DE CONTAS</strong></h2>
		<div class="widget-toolbar" role="menu">
			<a rel="popover-hover" data-placement="top" data-content="Nova Conta" data-html="true" class="btn btn-warning" id="dash_btn_2" href="javascript:void(0);"><i class="glyphicon glyphicon-file""></i> <span class=" hidden-xs hidden-mobile"> Nova Conta </span></a>
			<a rel="popover-hover" data-placement="top" data-content="Novo Cliente" data-html="true" class="btn btn-primary" id="dash_btn_1" href="javascript:void(0);"><i class="glyphicon glyphicon-user""></i> <span class=" hidden-xs hidden-mobile"> Novo Cliente </span></a>
		</div>
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

			<div class="widget-body-toolbar" style="text-align: center">

				<div class="btn-group" style="text-align: center">
					<button rel="popover-hover" data-placement="top" data-content="<span class='txt-color-red'>Contas à Pagar</span>" data-html="true" id="btn_pagar" type="button" class="btn btn-default txt-color-red">
						<i class="glyphicon glyphicon-calendar"></i><span class="hidden-xs hidden-mobile"> Contas à Pagar </span>
					</button>
					<button rel="popover-hover" data-placement="top" data-content="<span class='txt-color-green'>Contas à Receber</span>" data-html="true" id="btn_receber" type="button" class="btn btn-default txt-color-green">
						<i class="glyphicon glyphicon-calendar"></i><span class="hidden-xs hidden-mobile"> Contas à Receber </span>
					</button>
					<button rel="popover-hover" data-placement="top" data-content="<span class='txt-color-redLight'>Contas Pagas</span>" data-html="true" id="btn_pagas" type="button" class="btn btn-default txt-color-redLight">
						<i class="glyphicon glyphicon-usd"></i><span class="hidden-xs hidden-mobile"> Contas Pagas </span>
					</button>
					<button rel="popover-hover" data-placement="top" data-content="<span class='txt-color-teal'>Contas Recebidas</span>" data-html="true" id="btn_recebidas" type="button"class="btn btn-default txt-color-teal">
						<i class="glyphicon glyphicon-usd"></i><span class="hidden-xs hidden-mobile"> Contas Recebidas </span>
					</button>
					<button rel="popover-hover" data-placement="top" data-content="<span class='txt-color-blueDark'>Contas Conciliadas</span>" data-html="true" id="btn_conciliadas" type="button"class="btn btn-default txt-color-blueDark">
						<i class="fa fa-bank"></i><span class="hidden-xs hidden-mobile"> Contas Conciliadadas </span>
					</button>
				</div>
			</div>
			<div class="widget-body" id="fin_content">

			</div>
		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->

</div>


<script>
	$(function(){
		$("#wid-id-6").find('#dash_btn_1').click(function() {
			loading('show');
			$.post('ajax/cadcliente.php').done(function(data){
				$("#cadastro").empty().html(data);
				$("#cadastro").dialog({
					autoOpen : true,
					width : '95%',
					resizable : false,
					modal : true,
					title : "Novo Cliente"
				});
				loading('hide');
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
				loading('hide');
			});
		});
		$("#wid-id-6").find('#dash_btn_2').click(function() {
			loading('show');
			$.post('ajax/cadContas.php').done(function(data){
				$("#cadastro").empty().html(data);
				$("#cadastro").dialog({
					autoOpen : true,
					width : '95%',
					resizable : false,
					modal : true,
					title : "Nova Conta"
				});
				loading('hide');
			}).fail(function(){
				alerta("ERRO!","Função não encontrada!","danger","ban");
				loading('hide');
			});
		});
	});
	limpa("#cadastro");
	$("[rel=tooltip]").tooltip();

	$.post("ajax/gridContas.php",{type:1}).done(function(data){
		$("#fin_content").html(data);
	});

	$("#wid-id-6").find("#btn_nova").click(function(){
		loading('show');
		$.post("ajax/cadContas.php").done(function(data){
			$("#fin_content").html(data);
			loading('hide');
		}).fail(function(){
			loading('hide');
			alerta('Não foi possível executar esta operação!','Verifique o acesso a rede, certifique-se que sua conexão esta ok e tente novamente.','danger','ban');
		});
	});

	$("#wid-id-6").find("#btn_pagar").click(function(){
		loading('show');
		$.post("ajax/gridContas.php",{type:1}).done(function(data){
			$("#fin_content").html(data);
			loading('hide');
		}).fail(function(){
			loading('hide');
			alerta('Não foi possível executar esta operação!','Verifique o acesso a rede, certifique-se que sua conexão esta ok e tente novamente.','danger','ban');
		});
	});
	$("#wid-id-6").find("#btn_receber").click(function(){
		loading('show');
		$.post("ajax/gridContas.php",{type:2}).done(function(data){
			$("#fin_content").html(data);
			loading('hide');
		}).fail(function(){
			loading('hide');
			alerta('Não foi possível executar esta operação!','Verifique o acesso a rede, certifique-se que sua conexão esta ok e tente novamente.','danger','ban');
		});
	});
	$("#wid-id-6").find("#btn_pagas").click(function(){
		loading('show');
		$.post("ajax/gridContas.php",{type:3}).done(function(data){
			$("#fin_content").html(data);
			loading('hide');
		}).fail(function(){
			loading('hide');
			alerta('Não foi possível executar esta operação!','Verifique o acesso a rede, certifique-se que sua conexão esta ok e tente novamente.','danger','ban');
		});
	});
	$("#wid-id-6").find("#btn_recebidas").click(function(){
		loading('show');
		$.post("ajax/gridContas.php",{type:4}).done(function(data){
			$("#fin_content").html(data);
			loading('hide');
		}).fail(function(){
			loading('hide');
			alerta('Não foi possível executar esta operação!','Verifique o acesso a rede, certifique-se que sua conexão esta ok e tente novamente.','danger','ban');
		});
	});
	$("#wid-id-6").find("#btn_conciliadas").click(function(){
		loading('show');
		$.post("ajax/gridConciliacao.php").done(function(data){
			$("#fin_content").html(data);
			loading('hide');
		}).fail(function(){
			loading('hide');
			alerta('Não foi possível executar esta operação!','Verifique o acesso a rede, certifique-se que sua conexão esta ok e tente novamente.','danger','ban');
		});
	});

</script>