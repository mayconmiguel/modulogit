<?php
$nome = "Veiculo"; $tabela = "veiculo";
require_once "../server/seguranca.php";
?>

<div id="novoVeiculo">


	<div class="panel-group smart-accordion-default" id="accordion">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title"><a data-toggle="collapse" href="#collapseOne"> <i class="fa fa-fw fa-plus-circle txt-color-green"></i> <i class="fa fa-fw fa-minus-circle txt-color-red"></i>  Dados Gerais</a></h4>
			</div>
			<div id="collapseOne" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="row">
						<div class="col-xs-12 col-sm-4">
							<form action="upload.php" class="dropzone" id="mydropzone" imagem="">
								<div class="fallback">
									<input name="file" type="file" />
								</div>
							</form>
						</div>
						<div class="col-xs-12 col-sm-8">
							Marca: <select class="form-control" id="marca"></select>
						</div>
						<div class="col-xs-12 col-sm-8">
							Modelo: <select class="form-control" id="modelo"></select>
						</div>
						<div class="col-xs-12 col-sm-8">
							Cor: <select class="form-control" id="cor"></select>
						</div>
						<div class="col-xs-3 col-sm-4">
							Ano Fab.: <select class="form-control" id="ano_fab">
								<?php
									for($ano = 1970;$ano<=date('Y')+1;$ano++){
										?>
										<option value="<?php echo $ano;?>"><?php echo $ano;?></option>
										<?php
									}
								?>
							</select>
						</div>
						<div class="col-xs-3 col-sm-4">
							Ano Mod.: <select class="form-control" id="ano_mod">
								<?php
								for($ano = 1970;$ano<=date('Y')+1;$ano++){
									?>
									<option value="<?php echo $ano;?>"><?php echo $ano;?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="col-xs-12 col-sm-8">
							Valor: <input class="form-control" id="valor">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							Opcionais:
							<select class="select2-selection select2-container-multi" style="width:100%" multiple id="opcionais"></select>
						</div>
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
						<div class="col-sm-4">
							Status
							<div class="radio">
								<label>
									<input class="radiobox style-0" type="radio" name="st" id="st" value="1" checked="checked">
									<span title='ATIVO' class='label bg-color-pink font-xs text-center'>&nbsp;&nbsp;&nbsp;ATIVO&nbsp;&nbsp;&nbsp;</span>
								</label>
							</div><div class="radio">
								<label>
									<input class="radiobox style-0" type="radio" name="st" id="st" value="0">
									<span title='INATIVO' class='label bg-color-magenta font-xs text-center'>&nbsp;INATIVO&nbsp;</span>
								</label>
							</div>
						</div>
						<div class="col-sm-4">
							Em destaque
							<div class="radio">
								<label>
									<input class="radiobox style-0" type="radio" name="dt" id="dt" value="1" checked="checked">
									<span title='SIM' class='label bg-color-green font-xs text-center'>SIM&nbsp;</span>
								</label>
							</div><div class="radio">
								<label>
									<input class="radiobox style-0" type="radio" name="dt" id="dt" value="0">
									<span title='NÃO' class='label bg-color-red font-xs text-center'>NÃO</span>
								</label>
							</div>
						</div>
						<div class="col-sm-4">
							Mostrar Preço
							<div class="radio">
								<label>
									<input class="radiobox style-0" type="radio" name="pr" id="pr" value="1" checked="checked">
									<span title='SIM' class='label bg-color-green font-xs text-center'>SIM&nbsp;</span>
								</label>
							</div><div class="radio">
								<label>
									<input class="radiobox style-0" type="radio" name="pr" id="pr" value="0">
									<span title='NÃO' class='label bg-color-red font-xs text-center'>NÃO</span>
								</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 col-xs-6">
							Placa
							<input class="form-control" id="placa">
						</div>
						<div class="col-sm-6 col-xs-6">
							Chassi
							<input class="form-control" id="chassi">
						</div>

					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="clearfix">
								Observações:
								<textarea class="form-control" name="obs" id="obs" style="width:100%"></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<form action="upload.php" class="dropzone" id="mydropzone2" imagem=""></form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<br>
<div class="row" id="botoesCliente">
	<div class="col-sm-12 center">
		<a href="javascript:void(0);" id="cancelar" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-repeat"></i></span>CANCELAR</a>
		<a href="javascript:void(0);" id="cadastrar" class="btn btn-sm btn-success"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
		<a href="javascript:void(0);" id="editar" class="btn btn-sm btn-warning hidden"> <span class="btn-label"><i class="glyphicon glyphicon-pencil"></i></span>EDITAR</a>
		<a href="javascript:void(0);" id="excluir" class="btn btn-sm btn-danger hidden"> <span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>EXCLUIR</a>
		<a href="javascript:void(0);" id="salvar" class="btn btn-sm btn-success hidden"> <span class="btn-label"><i class="glyphicon glyphicon-floppy-disk"></i></span>SALVAR</a>
	</div>
</div>
<script>

	Array.prototype.remove = function() {
		var what, a = arguments, L = a.length, ax;
		while (L && this.length) {
			what = a[--L];
			while ((ax = this.indexOf(what)) !== -1) {
				this.splice(ax, 1);
			}
		}
		return this;
	};

	$("#novoVeiculo").find("#placa").mask('AAA-0000');
	$("#novoVeiculo").find("#valor").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'', decimal:',', affixesStay: false});

	$("#novoVeiculo").find("#marca").change(function(){
		$.ajax({
			url: 'server/recupera.php',
			type: 'POST',
			data:{tabela:'modelo where mar_id = ' + $("#marca").val()},
			cache: false,
			async: false,
			success: function(data) {
				$("#novoVeiculo").find("#modelo").empty().append('<option value="0">NENHUM MODELO CADASTRADO</option>');
				var obj = JSON.parse(data);
				for(i in obj){
					if(i == 0){
						$("#novoVeiculo").find("#modelo").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}else{
						$("#novoVeiculo").find("#modelo").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}
				}
				loading('hide');
			},
			error:function(){
				loading('hide');
			}
		});

	});

	var pagefunction = function() {
		$.ajax({
			url: 'server/recupera.php',
			type: 'POST',
			data:{tabela:'cor order by nome'},
			cache: false,
			async: false,
			success: function(data) {

				var obj = JSON.parse(data);
				for(i in obj){
					if(i == 0){
						$("#novoVeiculo").find("#cor").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}else{
						$("#novoVeiculo").find("#cor").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}
				}
				loading('hide');
			},
			error:function(){
				loading('hide');
			}
		});

		$.ajax({
			url: 'server/recupera.php',
			type: 'POST',
			data:{tabela:'acessorio order by nome'},
			cache: false,
			async: false,
			success: function(data) {

				var obj = JSON.parse(data);
				for(i in obj){
					if(i == 0){
						$("#novoVeiculo").find("#opcionais").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}else{
						$("#novoVeiculo").find("#opcionais").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}
				}
				$("#opcionais").select2();
				loading('hide');
			},
			error:function(){
				loading('hide');
			}
		});

		$.ajax({
			url: 'server/recupera.php',
			type: 'POST',
			data:{tabela:'marca order by nome'},
			cache: false,
			async: false,
			success: function(data) {
				var obj = JSON.parse(data);
				for(i in obj){
					if(i == 0){
						$("#novoVeiculo").find("#marca").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
						$.ajax({
							url: 'server/recupera.php',
							type: 'POST',
							data:{tabela:'modelo where mar_id = ' + obj[i].id+' order by nome'},
							cache: false,
							async: false,
							success: function(data) {
								$("#novoVeiculo").find("#modelo").empty().append('<option value="0">NENHUM MODELO CADASTRADO</option>');
								var obj = JSON.parse(data);
								for(i in obj){
									if(i == 0){
										$("#novoVeiculo").find("#modelo").empty().append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
									}else{
										$("#novoVeiculo").find("#modelo").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
									}
								}
								loading('hide');
							},
							error:function(){
								loading('hide');
							}
						});
					}else{
						$("#novoVeiculo").find("#marca").append('<option value="'+obj[i].id+'">'+obj[i].nome+'</option>');
					}
				}

				loading('hide');
			},
			error:function(){
				loading('hide');
			}
		});



		if("<?php echo @$_POST['id'];?>"){

			$("#novoVeiculo").find("input,select,textarea,form").each(function(){
				$(this).prop('disabled',true);
			});

			$("#editar,#excluir").removeClass('hidden');
			$("#cadastrar").addClass('hidden');


			$("#editar").click(function(){

				$("#editar,#excluir").addClass('hidden');
				$("#cadastrar,#cancelar").removeClass('hidden');

				$(".dz-hidden-input").prop("disabled",false);


				$("#novoVeiculo").find('[class="dz-remove"]').each(function(){
					$(this).show();
				});
				$("#novoVeiculo").find("input,select,textarea,form").each(function(){
					$(this).prop('disabled',false);
				});
			});


			$("#cancelar").click(function(){
				$.post("ajax/cadveiculos.php",{id:"<?php echo @$_POST['id'];?>"}).done(function(data){
					$("#cadastro").empty().html(data);
				}).fail(function(){
					alerta("ERRO!","Função não encontrada!","danger","warning");
				});
			});


			$("#botoesCliente").find("#excluir").click(function(){

				confirma("ATENÇÃO","Você deseja excluir este item?",function(){
					$.ajax({
						url: 'server/veiculo.php',
						type: 'POST',
						cache: false,
						data: {funcao:3,id:"<?php echo @$_POST['id'];?>"},
						success: function(data) {
							if(data == 1){
								alerta("SUCESSO!","Operação realizada com sucesso!","success","check");
								try{
									$("#datatable_col_reorder").dataTable().fnReloadAjax();
								}
								catch(e){

								}
								$("#cadastro").dialog('close');
							}else{
								alerta("AVISO!","Não foi possível excluir este item!","danger","ban");
							}
						}
					});
				});
			});


			var id = "<?php echo @$_POST['id'];?>";

			$.ajax({
				url: 'server/recupera.php',
				type: 'POST',
				data:{tabela:'veiculo where id = ' + id},
				cache: false,
				async: false,
				success: function(data) {

					var obj = JSON.parse(data)[0];
					console.log(obj);
					$("#marca").val(obj.mar_id).change();
					$("#modelo").val(obj.mod_id);
					$("#cor").val(obj.cor_id);
					$("#ano_fab").val(obj.ano_fab);
					$("#ano_mod").val(obj.ano_mod);
					$("#valor").val(obj.valor);

					$("#placa").val(obj.placa);
					$("#chassi").val(obj.chassi);
					$("#obs").val(obj.obs);
					$("#mydropzone").attr('imagem',obj.img.split('/')[1]);

					$("input[id='pr'][value='"+obj.mostrapreco+"']").prop("checked",true);
					$("input[id='dt'][value='"+obj.veiculodestaque+"']").prop("checked",true);
					$("input[id='st'][value='"+obj.status+"']").prop("checked",true);


					var img = new Image();
					img.src =  obj.img;
					img.name = new Date().getTime()+obj.img.split("/")[1];
					img.size = 100;



					Dropzone.options.myAwesomeDropzone = false;
					Dropzone.autoDiscover = false;
					$("#mydropzone").dropzone({
						//url: "http://someserver.com/upload.php",
						paramName: "file", // The name that will be used to transfer the file
						maxFilesize: 2.5, // MB
						maxFiles: 1,
						parallelUploads: 1,
						dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-md-block visible-lg-block" style="position:absolute;left:0 ; padding:20px; margin: 10px;"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Arraste a imagem principal do veículo.</span><span>&nbsp&nbsp<h4 class="display-inline"> (Ou Click)</h4></span>',
						addRemoveLinks: true,
						thumbnailWidth: "128",
						thumbnailHeight: "128",
						dictCancelUpload:"Cancelar",
						dictMaxFilesExceeded: "Apenas uma imagem é permitida!",
						dictRemoveFile: "Excluir Imagem",
						dictCancelUploadConfirmation: "Deseja excluir esta imagem?",
						acceptedFiles:'image/*',
						init: function () {

							$(".dz-hidden-input").prop("disabled",true);
							this.files.push(img);
							this.emit("addedfile", img);
							this.createThumbnailFromUrl(img,img.src);
							this.emit('complete', img);
							this.emit('success', img);
						},
						success:function(file,serverFileName){
							file.serverFileName = serverFileName;
							$("#mydropzone").attr('imagem',file.serverFileName);
						}
					});



					loading('hide');
				},
				error:function(){
					loading('hide');
				}
			});


			$.ajax({
				url: 'server/recupera.php',
				type: 'POST',
				data:{tabela:'veiculo_acessorios where vei_id = '+id},
				cache: false,
				async: false,
				success: function(data) {
					var obj = JSON.parse(data);
					var opcionais = [];
					for(i in obj){
						opcionais.push(obj[i].ace_id);
					}

					$("#opcionais").select2('val',opcionais);

					loading('hide');
				},
				error:function(){
					loading('hide');
				}
			});



			$.ajax({
				url: 'server/recupera.php',
				type: 'POST',
				data:{tabela:'veiculo_fotos where vei_id = '+id},
				cache: false,
				async: false,
				success: function(data) {
					var obj = JSON.parse(data);
					var fotos = [''];


					$("#mydropzone2").dropzone({
						//url: "http://someserver.com/upload.php",
						paramName: "file", // The name that will be used to transfer the file
						maxFilesize: 2.5, // MB
						maxFiles: 12,
						dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-md-block visible-lg-block" style="position:absolute;left:0 ; padding:20px; margin: 10px;"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Arraste a imagem principal do veículo.</span><span>&nbsp&nbsp<h4 class="display-inline"> (Ou Click)</h4></span>',
						addRemoveLinks: true,
						thumbnailWidth: "128",
						thumbnailHeight: "128",
						dictCancelUpload:"Cancelar",
						dictMaxFilesExceeded: "Apenas 12 imagens são permitidas!",
						dictRemoveFile: "Excluir Imagem",
						dictCancelUploadConfirmation: "Deseja excluir esta imagem?",
						acceptedFiles:'image/*',
						uploadMultiple:false,
						init: function () {
							$(".dz-hidden-input").prop("disabled",true);

							for(i in obj){
								var img2 = new Image();
								img2.src =  obj[i].url;
								img2.name = obj[i].url.split("/")[1];
								img2.size = 100;

								fotos.push(obj[i].url.split("/")[1]);


								this.files.push(img2);
								this.emit("addedfile", img2);
								this.createThumbnailFromUrl(img2,img2.src);
								this.emit('complete', img2);
								this.emit('success', img2);
							}
							$("#mydropzone2").attr('imagem',fotos);



						},
						success:function(file,serverFileName){
							file.serverFileName = serverFileName;
							fotos.push(file.serverFileName);
							$("#mydropzone2").attr('imagem',fotos);

						}
					});








					loading('hide');
				},
				error:function(){
					loading('hide');
				}
			});


			$("#novoVeiculo").find('[class="dz-remove"]').each(function(){
				$(this).hide();
			});


		}else{
			Dropzone.options.myAwesomeDropzone = false;
			Dropzone.autoDiscover = false;
			$("#mydropzone").dropzone({
				//url: "/file/post",
				init: function() {
					this.on("addedfile", function(file) {

						// Create the remove button
						var removeButton = Dropzone.createElement('<a class="dz-remove" href="javascript:undefined;" data-dz-remove="">Remover Foto</a>');


						// Capture the Dropzone instance as closure.
						var _this = this;

						// Listen to the click event
						removeButton.addEventListener("click", function(e) {
							// Make sure the button click doesn't submit the form:
							e.preventDefault();
							e.stopPropagation();

							// Remove the file preview.
							_this.removeFile(file);
							console.log(file.name);
							// If you want to the delete the file on the server as well,
							// you can do the AJAX request here.
						});

						// Add the button to the file preview element.
						file.previewElement.appendChild(removeButton);
					}),


						this.on("success", function (file, serverFileName) {
							file.serverFileName = serverFileName;
							$("#mydropzone").attr('imagem',file.serverFileName);
						}),
						this.on("removedfile",function(file){

							$("#mydropzone").attr('imagem','');
						}),
						this.on("maxfilesreached",function(file){
							console.log(file[0].name);
							this.removeFile(file[1]);

						});
				},

				addRemoveLinks : false,
				maxFilesize: 2.5,
				dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-md-block visible-lg-block" style="position:absolute;left:0 ; padding:20px; margin: 10px;"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Arraste a imagem principal do veículo.</span><span>&nbsp&nbsp<h4 class="display-inline"> (Ou Click)</h4></span>',
				dictResponseError: 'Erro ao inserir imagem!',
				maxFiles:1,
				uploadMultiple:false,
				acceptedFiles:'image/*'
			});

			var fotos = [];

			$("#mydropzone2").dropzone({
				//url: "/file/post",
				init: function() {
					this.on("addedfile", function(file) {

						// Create the remove button
						var removeButton = Dropzone.createElement('<a class="dz-remove" href="javascript:undefined;" data-dz-remove="">Remover Foto</a>');


						// Capture the Dropzone instance as closure.
						var _this = this;

						// Listen to the click event
						removeButton.addEventListener("click", function(e) {
							// Make sure the button click doesn't submit the form:
							e.preventDefault();
							e.stopPropagation();

							// Remove the file preview.
							_this.removeFile(file);
							// If you want to the delete the file on the server as well,
							// you can do the AJAX request here.
						});

						// Add the button to the file preview element.
						file.previewElement.appendChild(removeButton);
					}),

						this.on("success", function (file, serverFileName) {
							file.serverFileName = serverFileName;
							fotos.push(file.serverFileName);
							$("#mydropzone2").attr('imagem',fotos);
						}),
						this.on("removedfile",function(file){
							fotos.remove(file.name);

							$("#mydropzone2").attr('imagem','');
							$("#mydropzone2").attr('imagem',fotos);
						});
				},
				addRemoveLinks : false,
				maxFilesize: 2.5,
				dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-md-block visible-lg-block" style="position:absolute;left:0 ; padding:20px; margin: 10px;"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Arraste as demais imagens do veículo.</span><span>&nbsp&nbsp<h4 class="display-inline"> (Ou Click)</h4></span>',
				dictResponseError: 'Erro ao inserir imagem!',
				maxFiles:12,
				uploadMultiple:false,
				acceptedFiles:'image/*'
			});
		}




	};

	$("#cadastrar").click(function(){

		var img = '';
		var fotos = [''];
		if("<?php echo @$_POST['id'];?>"){
			var funcao = 2;
			var id = "<?php echo @$_POST['id'];?>";
		}else{
			var funcao = 1;
		}

		var div = $("#novoVeiculo");
		var img = div.find("#mydropzone").attr('imagem');
		var marca = div.find("#marca option:selected").val();
		var modelo = div.find("#modelo option:selected").val();
		var cor = div.find("#cor option:selected").val();
		var ano_fab = div.find("#ano_fab option:selected").val();
		var ano_mod = div.find("#ano_mod option:selected").val();
		var valor = div.find("#valor").val().replace(",",".");
		var opcionais = [];
		$("#opcionais option:selected").each(function(){
			opcionais.push($(this).val());
		});
		var placa = div.find("#placa").val();
		var chassi = div.find("#chassi").val();
		var obs = div.find("#obs").val();
		var mostrarpreco = div.find("#pr:checked").val();
		var destaque = div.find("#dt:checked").val();
		var status = div.find("#st:checked").val();

		var fotos = $("#mydropzone2").attr('imagem').split(',');





		console.log(img);
		console.log(marca);
		console.log(modelo);
		console.log(cor);
		console.log(valor);
		console.log(ano_fab);
		console.log(ano_mod);
		console.log(opcionais);
		console.log(placa);
		console.log(chassi);
		console.log(obs);
		console.log(mostrarpreco);
		console.log(destaque);
		console.log(status);
		console.log(fotos);

		$.ajax({
			url: 'server/veiculo.php',
			type: 'POST',
			data:{id:id,funcao:funcao,img:img,marca:marca,modelo:modelo,cor:cor,ano_fab:ano_fab,ano_mod:ano_mod,opcionais:opcionais,placa:placa,chassi:chassi,obs:obs,mostrarpreco:mostrarpreco,destaque:destaque,status:status,fotos:fotos,valor:valor},
			cache: false,
			async: false,
			success: function(data) {
				if (data.match(/[a-z]/i)) {
					alerta("Error!",data,"danger","ban");
				}else{
					alerta("Sucesso!","Cadastro realizado com sucesso!","success","check");
					$.post("ajax/cadveiculos.php").done(function(data){
						$("#cadastro").empty().html(data);
					}).fail(function(){
						alerta("ERRO!","Função não encontrada!","danger","warning");
					});
					try{
						$("#datatable_col_reorder").dataTable().fnReloadAjax();
						$("#cadastro").dialog('close');
					}
					catch(e){}
				}
				loading('hide');
			},
			error:function(){
				loading('hide');
			}
		});

	});




	// end pagefunction

	// run pagefunction on load

	loadScript("js/plugin/dropzone/dropzone.min.js", pagefunction);
</script>