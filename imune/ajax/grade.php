<?php
	require_once("inc/init.php");
	require_once("../server/seguranca.php");
	$matricula = $_POST['matricula'];
	$curso 	   = $_POST['curso'];
	$id        = $_POST['id'];
?>
<div class="row">
	<div class="col-xs-12 text-align-left">
		<a class="btn btn-labeled bg-color-blueDark" id="voltar" style="color:white" href="javascript:void(0);">
			<span class="btn-label">
			<i class="glyphicon glyphicon-backward"></i>
			</span>
			Voltar
		</a>
	</div>
</div>
<div class="row">
	<div class="col-sm-3 col-xs-6">
		Matricula<input type="text" name="matricula" id="matricula" class="form-control wd100" value="<?php echo $matricula;?>" disabled>
	</div>
	<div class="col-sm-4 col-xs-6">
		Curso<select class="form-control" id="curso" name="curso" disabled>
			<option value="0">SELECIONE UM CURSO</option>
		</select>
	</div>
	<div class="col-sm-3 col-xs-8">
		Turno<select name="turno" id="turno" class="form-control" disabled>
			<option value="MATUTINO">MATUTINO</option>
			<option value="VESPERTINO">VESPERTINO</option>
			<option selected value="NOTURNO">NOTURNO</option>
		</select>
	</div>
	<div class="col-sm-2 col-xs-4">
		Turma<select class="form-control" id="turma" name="turma" disabled>
			<option value="A">A</option>
			<option value="B">B</option>
			<option value="C">C</option>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-sm-3 col-xs-6">
		<?php echo $_SESSION['config']['empresa'];?><select class="form-control" id="emp_id" name="emp_id" disabled></select>
	</div>
	<div class="col-sm-4 col-xs-6">
		Modalidade<select class="form-control" id="modalidade" name="modalidade" disabled></select>
	</div>
	<div class="col-sm-3 col-xs-6">
		Status<select class="form-control" id="status" name="status" disabled>
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
		Convênio<select class="form-control" id="convenio" name="convenio" disabled>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 text-align-right">
		<a class="btn btn-labeled btn-warning" href="javascript:void(0);">
			<span class="btn-label">
			<i class="glyphicon glyphicon-pencil"></i>
			</span>
			Editar Curso
		</a>
	</div>
</div>
<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-2" data-widget-fullscreenbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-colorbutton="false">
	<header>
		<h2>Lista de Disciplinas</h2>
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
			<div class="col-sm-4 col-xs-12">
				<h6>Disciplinas Disponíveis</h6>

				<div class="dd" id="nestable3">
					<ol class="dd-list">
					</ol>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<h6>Demais Disciplinas</h6>

				<div class="dd" id="nestable">
					<ol class="dd-list">
					</ol>
				</div>
			</div>
			<div class="col-sm-4 col-xs-12">
				<h6>Em Curso</h6>

				<div class="dd" id="nestable2">
					<ol class="dd-list">
					</ol>
				</div>
			</div>

		</div>
		<!-- end widget content -->

	</div>
	<!-- end widget div -->
</div>



<script type="text/javascript">

	$.post('server/recupera2.php',{tabela:"select disciplinas from curso where id = '<?php echo $curso;?>'"}).done(function(data){
		var obj2 = JSON.parse(data)[0].disciplinas.split(',');
		var disciplinas = "( ";
		for(o in obj2){
			disciplinas += "id = '"+obj2[o]+"' or ";
		}
		disciplinas = disciplinas.substr(0,disciplinas.length-3)+")";
		$.post('server/recupera.php',{tabela:'disciplina where '+disciplinas}).done(function(data2){
			var obj = JSON.parse(data2);
			for(i in obj){
				$("#nestable3").find('.dd-list').append('<li class="dd-item" data-id="'+obj[i].id+'">'+
					'<div class="dd-handle">'+
					'<h4><span class="semi-bold">'+obj[i].nome+' </span> - '+obj[i].carga+' Horas</h4>'+
					'<span>'+status+'</span>'+
					'<span class="air air-top-right padding-7">'+
					'</span>'+
					'</div>'+
					'</li>'
				);
			}
		});
	});


	$.post("server/recupera2.php",{tabela:"select grade.id as id, disciplina.carga as carga, disciplina.nome as disciplina, grade.ativo,grade.status,grade.valor, grade.matricula from disciplina,grade where disciplina.id = grade.dis_id and grade.matricula = '<?php echo $matricula;?>'"}).done(function(data){
		var obj = JSON.parse(data);
		var contador = 0;
		for(i in obj){
			if(obj[i].status == 0){
				var status = '<label class="label label-info font-sm">Pendente</label>';
			}
			else if(obj[i].status == 1){
				var status = '<label class="label label-primary font-sm">Cursando</label>';
			}
			else if(obj[i].status == 2){
				var status = '<label class="label label-success font-sm">Aprovado</label>';
			}
			else if(obj[i].status == 3){
				var status = '<label class="label label-danger font-sm">Reprovado</label>';
			}
			else if(obj[i].status == 4){
				var status = '<label class="label label-warning font-sm">Dependência</label>';
			}

			if(obj[i].ativo == 0){
				$("#nestable").find('.dd-list').append('<li class="dd-item" data-id="'+obj[i].id+'">'+
					'<div class="dd-handle">'+
					'<h4><span class="semi-bold">'+obj[i].disciplina+' </span> - '+obj[i].carga+' Horas</h4>'+
					'<span>'+status+'</span>'+
					'<span class="air air-top-right padding-7">'+
					'</span>'+
					'</div>'+
					'</li>'
				);
			}else{
				$("#nestable2").find('.dd-list').append('<li class="dd-item" data-id="'+obj[i].id+'">'+
					'<div class="dd-handle">'+
					'<h4><span class="semi-bold">'+obj[i].disciplina+' </span> - '+obj[i].carga+' Horas</h4>'+
					'<span>'+status+'</span>'+
					'<span class="air air-top-right padding-7">'+
					'</span>'+
					'</div>'+
					'</li>'
				);
				contador++;
			};
		};
		if(contador == 0){
			$("#nestable2").find('.dd-list').addClass('dd-empty');
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



	$("#voltar").click(function(){
		loading("show");
		$.post("ajax/cadcliente.php",{id:<?php echo $id;?>}).done(function(data){
			$("#cadastro").empty().html(data);
			$("#cadastro").dialog({
				autoOpen : true,
				width : '95%',
				resizable : false,
				modal : true,
				title : "Editar <?php echo $_SESSION['config']['cliente'];?>"
			});
			$("#t_pro").click();
		}).fail(function(){
			alerta("ERRO!","Função não encontrada!","danger","ban");
		});
	});
	pageSetUp();
	var pagefunction = function() {

		var updateOutput = function(e) {
			var list = e.length ? e : $(e.target), output = list.data('output');
			if (window.JSON) {
				output.val(window.JSON.stringify(list.nestable('serialize')));
				//, null, 2));
			} else {
				output.val('JSON browser support required for this demo.');
			}
		};

		$('#nestable3').nestable({
			group : 1,
			maxDepth:1
		}).on('change', function(){

		});
		// activate Nestable for list 1
		$('#nestable').nestable({
			group : 1,
			maxDepth:1
		}).on('change', function(){

		});

		// activate Nestable for list 2
		$('#nestable2').nestable({
			group : 1,
			maxDepth:1
		}).on('change', function(){

		});

		// output initial serialised data
		updateOutput($('#nestable').data('output', $('#nestable-output')));
		updateOutput($('#nestable2').data('output', $('#nestable2-output')));

	};
	// load nestable.min.js then run pagefunction
	loadScript("js/plugin/jquery-nestable/jquery.nestable.min.js", pagefunction);
</script>
