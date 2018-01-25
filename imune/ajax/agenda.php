<?php

	require_once "../server/seguranca.php";
	$empresa = $_SESSION['imunevacinas']['usuarioEmpresa'];
?>
<style>
	#bt2:hover,#bt1:hover,#bt3:hover{
		color:lightblue;
	}
	.fc-day:hover,tr[data-time]:hover{
		background:lightblue;
	}
	.fc-day-header{
		padding-top:10px !important;;
	}
	.fc-event {
		margin-left:-3px !important;
		position: relative; /* for resize handle and other inner positioning */
		display: block; /* make the <a> tag block */
		font-size: .85em;
		line-height: 1.3;
		border-radius: 3px;
		border: 1.9px solid #3a87ad; /* default BORDER color */

		margin:0.5px;
		background-color: #3a87ad; /* default BACKGROUND color */
		font-weight: normal; /* undo jqui's ui-widget-header bold */
	}
	.fc-nonbusiness{
		background:rgba(120,120,120,1);
	}
	.fc-widget-content td:hover{

	}
</style>
<div class="col-xs-12">

	<!-- new widget -->
	<div class="jarviswidget jarviswidget-color-blueDark">

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
			<input type="text" id="datepicker" style="visibility:hidden">
			<span class="widget-icon" title="Pesquisar"> <i id="bt2" class="fa fa-search" style="cursor:pointer"></i> </span>
			<span class="widget-icon" title="Calendário"> <i id="bt1" class="fa fa-calendar" style="cursor:pointer"></i> </span>
			<span class="widget-icon" title="Relatório"> <i id="bt3" class="fa fa-book" style="cursor:pointer"></i> </span>

			<div class="widget-toolbar">
				<!-- add: non-hidden - to disable auto hide -->
				<div class="btn-group">
					<button class="btn dropdown-toggle btn-xs btn-default" data-toggle="dropdown">
						Visualização <i class="fa fa-caret-down"></i>
					</button>
					<ul class="dropdown-menu js-status-update pull-right">
						<li>
							<a href="javascript:void(0);" id="mt">Mês</a>
						</li>
						<li>
							<a href="javascript:void(0);" id="ag">Semana</a>
						</li>
						<li>
							<a href="javascript:void(0);" id="td">Dia</a>
						</li>
					</ul>
				</div>
			</div>
		</header>

		<!-- widget div-->
		<div>

			<div class="widget-body no-padding">
				<!-- content goes here -->
				<div class="widget-body-toolbar">
					<div id="age">
						<select class="select2-selection select2-selection--single" id="agenda" style="width: 100%;">

						</select>
					</div>
					<div id="calendar-titulo" style="margin-top:-5px;padding-bottom:5px;display:block;">
						<h5>&nbsp;</h5>
					</div>
					<div id="calendar-buttons" style="margin-top: 45px;">
						<div class="btn-group">
							<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-prev"><i class="fa fa-chevron-left"></i></a>
							<a href="javascript:void(0)" class="btn btn-default btn-xs" id="btn-next"><i class="fa fa-chevron-right"></i></a>
						</div>
					</div>
				</div>
				<div id="calendar"></div>

				<!-- end content -->
			</div>

		</div>
		<!-- end widget div -->
	</div>
	<br><br><br>
	<!-- end widget -->

</div>
<?php



?>
<script>

	pageSetUp();
	var pagefunction = function() {



		$("#bt2").click(function(){
			$.post('ajax/pesquisaConsulta.php').done(function(data){
				$("#cadastro").empty().html(data).removeClass('hide').dialog({
					modal: true,
					autoOpen:true,
					//moveToTop:true,
					width:"90%",
					height:"auto",
					position:['center',20],
					title: "Pesquisar Consultas",
					title_html: true
				});
			});
		});




		$.post('server/recupera.php',{tabela:"agenda where grp_emp_id = <?php echo $empresa;?>"}).done(function(data){
			var obj = JSON.parse(data);
			if(obj.length < 1){
				alerta("Aviso!","Primeiro você precisa realizar a abertura de uma agenda de pelo menos um profissional!","warning","warning");
				loading('hide');
				top.location.href = "#ajax/novaAgenda.php";
			}else{
				$("#agenda").select2();
				$("#agenda").change(function(){
					loading('show');
					fullcalendar($("#agenda option:selected").val(),$("#agenda option:selected").attr('businessHours'),$("#agenda option:selected").attr('minTime'),$("#agenda option:selected").attr('maxTime'),$("#agenda option:selected").attr('slotLabelInterval'),$("#agenda option:selected").attr('slotDuration'),$("#agenda option:selected").attr('almoco'));
				});
				$.post('server/recupera2.php',{tabela:"select agenda.*, pessoa.nome as pessoa from pessoa,agenda where pessoa.id = agenda.pes_id and agenda.grp_emp_id = '<?php echo $_SESSION['imunevacinas']['usuarioEmpresa'] ;?>' order by pessoa.nome"}).done(function(data){
					var obj = JSON.parse(data);
					for(i in obj){
						if(i == 0){
							$("#agenda").empty().append('<option businessHours="'+obj[i].businessHours+'"minTime="'+obj[i].minTime+'" maxTime="'+obj[i].maxTime+'" slotLabelInterval="'+obj[i].slotLabelInterval+'" slotDuration="'+obj[i].slotDuration+'" almoco="'+obj[i].almoco+'" value="'+obj[i].pes_id+'">'+obj[i].prefixo+" "+obj[i].pessoa+'</option>');
							$("#agenda").select2('val',obj[i].pes_id);
						}else{
							$("#agenda").append('<option businessHours="'+obj[i].businessHours+'"minTime="'+obj[i].minTime+'" maxTime="'+obj[i].maxTime+'" slotLabelInterval="'+obj[i].slotLabelInterval+'" slotDuration="'+obj[i].slotDuration+'" almoco="'+obj[i].almoco+'" value="'+obj[i].pes_id+'">'+obj[i].prefixo+" "+obj[i].pessoa+'</option>');
						}
					};
					loading('show');

					var profica = "<?php echo @$_POST['profica'];?>";
					if(profica.length > 0){
						loading('show');
						$("#agenda").val("<?php echo @$_POST['profica'];?>").change();
					}else{
						fullcalendar($("#agenda option:selected").val(),$("#agenda option:selected").attr('businessHours'),$("#agenda option:selected").attr('minTime'),$("#agenda option:selected").attr('maxTime'),$("#agenda option:selected").attr('slotLabelInterval'),$("#agenda option:selected").attr('slotDuration'),$("#agenda option:selected").attr('almoco'));
					}

					fullcalendar($("#agenda option:selected").val(),$("#agenda option:selected").attr('businessHours'),$("#agenda option:selected").attr('minTime'),$("#agenda option:selected").attr('maxTime'),$("#agenda option:selected").attr('slotLabelInterval'),$("#agenda option:selected").attr('slotDuration'),$("#agenda option:selected").attr('almoco'));
				});


				/* initialize the calendar
				 -----------------------------------------------------------------*/
				$(function() {
					var d = new Date();
					var dia = d.getDate();
					if (dia.toString().length == 1)
						dia = "0"+dia;
					var mes = d.getMonth()+1;
					if(mes == 12){
						var ano2 = d.getFullYear()+1;
					}else{
						var ano2 = d.getFullYear();
					}
					var ano = d.getFullYear();
					$("#bt1").click(function() {
						$("#datepicker").datepicker({
							autoclose: true,
							todayHighlight: true,
							dateFormat: 'dd/mm/yy',
							prevText: '<i class="fa fa-chevron-left"></i>',
							nextText: '<i class="fa fa-chevron-right"></i>',
							language: 'pt-BR',
							currentText: 'Hoje',
							monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho',
								'Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
							monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun',
								'Jul','Ago','Set','Out','Nov','Dez'],
							dayNames: ['Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'],
							dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
							dayNamesMin: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
							onSelect:function (dateText) {
								var d = dateText.substr(6,4)+"-"+dateText.substr(3,2)+"-"+dateText.substr(0,2);

								$('#calendar').fullCalendar('gotoDate', d);
								$('#calendar').fullCalendar('changeView', 'agendaWeek');
								
							}
						});
						$("#datepicker").datepicker("show");
					});

					$("#bt3").click(function(){

						if(!$('#datepicker').datepicker( "getDate" )){
							var dt_agenda = "<?php echo date('Y-m-d');?>";
						}else{
							var dt        = $('#datepicker').datepicker( "getDate" );
							var dia = dt.getDate();
							if (dia.toString().length == 1)
								dia = "0"+dia;
							var mes = dt.getMonth()+1;
							if (mes.toString().length == 1)
								mes = "0"+mes;
							var ano = d.getFullYear();
							var dt_agenda = ano+"-"+mes+"-"+dia;
						};



						var data = new FormData();
						$.SmartMessageBox({
							title : "ATENÇÃO",
							content : "ESCOLHA UMA DAS OPÇÕES [1 - INDIVIDUAL] (GERA UM RELATÓRIO DA AGENDA ATUAL), [2 - GERAL](GERA UM RELATÓRIO DE TODAS AS AGENDAS)",
							buttons : "[2 - GERAL][1 - INDIVIDUAL]"
						}, function(ButtonPress, Value) {
							if(ButtonPress == "1 - INDIVIDUAL"){
								var funcao = 1;
								var id = $("#agenda option:selected").val();
								window.open('rel/relAgenda.php?id=' + id+'&funcao='+funcao+'&dt_agenda='+dt_agenda);
							}else if(ButtonPress == "2 - GERAL"){
								window.open('rel/relAgenda.php?dt_agenda='+dt_agenda);
							};

							return false;
						});
					});


				});
			}
		});
	};

	function outerHTML(node){
		return node.outerHTML || new XMLSerializer().serializeToString(node);
	}



	function fullcalendar(id,businessHours,minTime,maxTime,slotLabelInterval,slotDuration,almoco){
		// full calendar

		var horasSemana = new Array();
		var horas = businessHours.split('-');
		var hidden = ['0','1','2','3','4','5','6'];
		var hiddenDays = new Array();
		for(i in horas){
			hidden = $.grep(hidden, function(val, index) {
				return val != horas[i].split(';')[0];
			});
			horasSemana.push({
				dow:[''+horas[i].split(';')[0]+''],
				start:horas[i].split(';')[1],
				end:horas[i].split(';')[2],
			});
		}
		for(i in hidden){
			hiddenDays.push(parseInt(hidden[i]));
		};

		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();

		var hdr = {
			left: 'title',
			center: 'month,agendaWeek,agendaDay',
			right: 'prev,today,next'
		};
		$("#calendar").fullCalendar('destroy');
		$('#calendar').fullCalendar({

			header: hdr,

			droppable: false,
			eventDurationEditable:true,
			allDayDefault: false,
			allDaySlot:false,
			displayEventEnd:true,
			businessHours : true,
			firstDay:0,
			defaultView:'agendaWeek',
			dragOpacity: {
				agenda: .5
			},
			columnFormat:{
				agenda: 'dddd DD/MM/YY', //h:mm{ - h:mm}'
				month:'dddd',
				week:'dddd DD/MM/YY',
				day:'dddd DD/MM/YY'
			},
			axisFormat: 'H:mm', //,'h(:mm)tt',
			timeFormat: {
				agenda: 'H:mm', //h:mm{ - h:mm}'
				month:'H:mm',
				week:'H:mm',
				day:'H:mm'
			},
			slotLabelFormat:'H:mm',
			slotLabelInterval:slotLabelInterval,

			slotDuration:slotDuration,
			minTime:minTime,
			maxTime:maxTime,
			hiddenDays:hiddenDays,

			businessHours:horasSemana,
			eventSources: [
				"server/eventos.php?den_id="+id]
			,
			eventDragStart:function(event,jsEvent,ui,view){
				$(".popover").popover('hide');
			},
			eventDragStop:function(event,jsEvent,ui,view){
				$(".popover").popover('hide');
			},
			dayClick: function(date, jsEvent, view) {
				$(".popover").popover('hide');

				if(outerHTML(jsEvent.target).indexOf('fc-nonbusiness') >=0){
					alerta("O horário selecionado encontra-se indisponível para realizar marcações!","Verifique na agenda deste profissional a faixa de horários para o dia da semana selecionado!","warning","warning");
				}else if(outerHTML(jsEvent.target).indexOf('fc-bgevent') >=0)
				{

				}
				else{
					loading('show');
					var start = date['_d'].toISOString().replace(/[TZ]/g,' ').replace('.000','');
					$.post('ajax/novaConsulta.php',{den_id:$("#agenda option:selected").val(),start:start,minTime:minTime,maxTime:maxTime,slotDuration:slotDuration}).done(function(data){
						$("#cadastro").empty().html(data).removeClass('hide').dialog({
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
					loading('hide');
				}
			},
			eventMouseover:function(event,jsEvent,view){

			},
			eventMouseout:function(event,jsEvent,view){
				$(".popover").popover('hide');
			},
			eventClick: function(calEvent, jsEvent, view) {
				$(".popover").popover('hide');
				loading('show');

				var start = calEvent['_start']['_i'];
				var end = calEvent['_end']['_i'];
				var id  = calEvent['id'];
				$.post('ajax/novaConsulta.php',{id:id,den_id:$("#agenda option:selected").val(),start:start,end:end,minTime:minTime,maxTime:maxTime,slotDuration:slotDuration}).done(function(data){
					$("#cadastro").empty().html(data).removeClass('hide').dialog({
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
				loading('hide');
			},
			eventResize: function(event,jsEvent,view,ui) {
				$(".popover").popover('hide');
				if(event.tipo != null){
					var dt_start = event.start['_d'].toISOString().replace(/[TZ]/g,' ').replace('.000','');
					var dt_end	 = event.end['_d'].toISOString().replace(/[TZ]/g,' ').replace('.000','');
					var us_id    = "<?php echo $_SESSION['imunevacinas']['usuarioID'];?>";

					$.post("server/agendamento.php", {
						funcao: 2,
						id: event.id,
						title: event.title,
						obs: event.obs,
						ficha: event.ficha,
						cli_id: event.cli_id,
						den_id: event.den_id,
						status: event.status,
						color: event.color,
						start: dt_start,
						end: dt_end
					}).done(function (data) {
						$('#calendar').fullCalendar('refetchEvents');

					});
				}else {

				};

			},
			eventRender: function (event, element, icon) {
				if(event.tipo == 2){
					$(element).attr({'rel':'pop-hover'}).popover({
						container: "body",
						animated: true,
						title: "INFORMAÇÕES ADICIONAIS",
						content: '<b>FICHA: </b>'+event.ficha+'<br><b>ANTIGO: </b>'+event.ficha2+'<br><b>NOME: </b>'+event.title+'<br><b>OBS: </b>'+event.obs,
						placement: "top",
						trigger: "hover",
						html:true
					});
				}else if(event.tipo == 1){
					$(element).attr({'rel':'pop-hover'}).popover({
						container: "body",
						animated: true,
						title: "INFORMAÇÕES ADICIONAIS",
						content: '<b>EVENTO: </b>'+event.title,
						placement: "top",
						trigger: "hover",
						html:true
					});
					$(element).css({'cursor':'default'});
				}else
				{
					$(element).css({'cursor':'default','background-color':'purple'});
				}

			},

			windowResize: function (view) {
				if ($(window).width() < 765){
					$('#calendar').fullCalendar( 'changeView', 'agendaDay' );
				} else {
					$('#calendar').fullCalendar( 'changeView', 'agendaWeek' );
				}
				$('#calendar').fullCalendar('render');
			}
		});

		$('#calendar').fullCalendar( 'addEventSource',
			{

				events: [{
					title:"ALMOÇO",
					start: almoco.split('-')[0], // a start time (10am in this example)
					end: almoco.split('-')[1], // an end time (2pm in this example)
					allDay: false,
					durationEditable:false,
				}]
			}
		);

		$('#calendar').fullCalendar( 'addEventSource',"server/eventos2.php?den_id="+id);


		$("tr[data-time] td.fc-widget-content").each(function () {

		});


		/* hide default buttons */



		$('.fc-toolbar').css({"margin-top":"-45px","margin-left":"10px"});

		$('.fc-center,.fc-right').hide();

		loading('hide');

	}
	
	$('#btn-prev').click(function () {

		$('.fc-prev-button').click();
		//return false;
	});

	$('#btn-next').click(function () {

		$('.fc-next-button').click();
		//return false;
	});

	$('#calendar-buttons #btn-today').click(function () {
		$('.fc-today-button').click();
		//return false;
	});

	$('#mt').click(function () {
		$('#calendar').fullCalendar('changeView', 'month');

	});

	$('#ag').click(function () {
		$('#calendar').fullCalendar('changeView', 'agendaWeek');

	});

	$('#td').click(function () {
		$('#calendar').fullCalendar('changeView', 'agendaDay');

	});


	// loadscript and run pagefunction
	loadScript("js/plugin/moment/moment.min.js", function(){
		loadScript("js/plugin/fullcalendar/fullcalendar.js", pagefunction);
	});
</script>