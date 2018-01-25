<?php

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
//require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC.
E.G. $page_title = "Custom Title" */

$page_title = "Login";

/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
$no_main_header = true;
$page_body_prop = array("id"=>"extr-page", "class"=>"animated fadeInDown");
include("inc/header.php");

?>


<div id="main" role="main" style="background:rgba(0,0,0,0)">

	<!-- MAIN CONTENT -->
	<div id="content" class="container" style="margin-top:5%">

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm text-center">
				<img src="img/imuni.png" style="width: 55%; margin-top:%">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
				<div class="well no-padding">
					<form action="<?php echo APP_URL; ?>/server/valida.php" method="post" id="login-form" class="smart-form client-form">
						<header>
							<span class="hidden-md hidden-lg"><img src="img/logo3.png"></span><span class="hidden-sm hidden-xs">ACESSO AO SISTEMA</span>
						</header>

						<fieldset>

							<section>
								<label class="label">Email</label>
								<label class="input"> <i class="icon-append fa fa-user"></i>
									<input type="text" id="usuario" name="usuario">
									<b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Por favor, digite um endereço de email válido!</b></label>
							</section>

							<section>
								<label class="label">Senha</label>
								<label class="input"> <i class="icon-append fa fa-lock"></i>
									<input id="senha" type="password" name="senha">
									<b class="tooltip tooltip-top-right"><i class="fa fa-lock txt-color-teal"></i> Digite sua senha!</b> </label>
							</section>
						</fieldset>
						<footer>
							<button id="submit" type="submit" class="btn btn-primary">
								Entrar
							</button>
						</footer>
					</form>

				</div>
			</div>
		</div>
	</div>

</div>



<!-- END MAIN PANEL -->
<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php 
	//include required scripts
	include("inc/scripts2.php");
?>

<!-- PAGE RELATED PLUGIN(S) 
<script src="..."></script>-->
<?php
if(isset($_GET['error'])){
	$error = $_GET['error'];
}
?>


<script type="text/javascript">
	runAllForms();
	$("#usuario").focus();
	$(function() {
		var error = "<?php echo @$error;?>";
		if(error){
			$.bigBox({
				title : error,
				content : "",
				color : "#C46A69",
				icon : "fa fa-warning shake animated",
				timeout : 6000
			});
			$("#usuario").focus();
		}
		// Validation
		$("#login-form").validate({
			// Rules for form validation
			rules : {
				usuario : {
					required : true,
					email:true
				},
				senha : {
					required : true,
					minlength : 3,
					maxlength : 20
				}
			},

			// Messages for form validation
			messages : {
				usuario : {
					required : 'Por favor, digite um endereço de email válido!',
					email : 'Por favor, digite um endereço de email válido!'
				},
				senha : {
					required : 'Por favor, digite uma senha'
				}
			},
			success: 'valid',

// This does the actual form submitting
			submitHandler: function (form) {
				form.submit();
			},

			// Do not change code below
			errorPlacement : function(error, element) {
				error.insertAfter(element.parent());
			}
		});


	});

	$('#senha').keyup(function(e){
		if(e.which == 13){
			$("#submit").click();
		}
	});

</script>
