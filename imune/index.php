<?php
require_once "server/seguranca.php";
protegePagina();
//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");

/*---------------- PHP Custom Scripts ---------

YOU CAN SET CONFIGURATION VARIABLES HERE BEFORE IT GOES TO NAV, RIBBON, ETC. */



/* ---------------- END PHP Custom Scripts ------------- */

//include header
//you can add your custom css in $page_css array.
//Note: all css files are inside css/ folder
$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
include("inc/nav.php");

?>
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
	<?php
		//include("inc/ribbon.php");
	?>
	<div id="loading">
		<div id="loadfundo"></div>
	</div>

	<!-- MAIN CONTENT -->
	<div id="content">


	</div>
	<!-- END MAIN CONTENT -->

	<div id="cadastro">
	</div>
	<div id="dados" class="hidden">
	</div>
</div>
<!-- END MAIN PANEL -->

<!-- FOOTER -->
	<?php
		include("inc/footer.php");
	?>
<!-- END FOOTER -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

<?php 
	//include required scripts
	include("inc/scripts.php");
	//include footer
	//include("inc/google-analytics.php");
?>
<script>
	$("nav ul li a").click(function(){
		if($(this).attr('href') != "#"){
			$("[data-action='toggleMenu']").click();
		}
	});

	var idleTime = 0;
	$(document).ready(function () {
		document.addEventListener('contextmenu', event => event.preventDefault());
		//Increment the idle time counter every minute.
		var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

		//Zero the idle timer on mouse movement.
		$(this).mousemove(function (e) {
			idleTime = 0;
		});
		$(this).keypress(function (e) {
			idleTime = 0;
		});
	});

	function timerIncrement() {
		idleTime = idleTime + 1;
		if (idleTime > 60) { // 20 minutes
			location.href = 'logout.php';
		}
	};

	$(document).ready(function(){
		$(".popover").popover();
		$(".ui-datepicker").datepicker();

		$(document).dblclick(function(){
			$(".popover").popover('hide');
			$(".ui-datepicker").datepicker('hide');

		});

		$('.popover').click(function(){
			return false;
		});
		$('.ui-datepicker').click(function(){
			return false;
		});
	});

	//saldoSMS();
	//setInterval(function(){
		//saldoSMS();
	//},60000);


	setInterval(function(){
		mai();
		$('body').attr('style','padding-right:0 !important');
	},1000);


</script>