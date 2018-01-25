	<script> location.replace('http://localhost/imune/login.php'); </script>
	<br />
<b>Notice</b>:  Undefined index: config in <b>C:\xampp\htdocs\imune\inc\config.ui.php</b> on line <b>49</b><br />
<br />
<b>Notice</b>:  Undefined index: config in <b>C:\xampp\htdocs\imune\inc\config.ui.php</b> on line <b>66</b><br />
<br />
<b>Notice</b>:  Undefined index: config in <b>C:\xampp\htdocs\imune\inc\config.ui.php</b> on line <b>254</b><br />
<br />
<b>Notice</b>:  Undefined index: config in <b>C:\xampp\htdocs\imune\inc\config.ui.php</b> on line <b>368</b><br />
<br />
<b>Notice</b>:  Undefined index: config in <b>C:\xampp\htdocs\imune\inc\config.ui.php</b> on line <b>373</b><br />
<br />
<b>Notice</b>:  Undefined index: config in <b>C:\xampp\htdocs\imune\inc\config.ui.php</b> on line <b>379</b><br />
<br />
<b>Notice</b>:  Undefined index: config in <b>C:\xampp\htdocs\imune\inc\config.ui.php</b> on line <b>383</b><br />
<!DOCTYPE html>
<html style="background:#fff" lang="pt-br" >
	<head>
		<meta charset="utf-8">
		<!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->

		<title> imunevacinas </title>
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">



		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/smartadmin-production-plugins.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support is under construction-->
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/smartadmin-rtl.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/fullcalendar.css">

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/your_style.css"> -->
		<link href="js/plugin/avatareffects/css/avatareffects.lightred.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/your_style.css">

		<!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
		<link rel="stylesheet" type="text/css" media="screen" href="http://localhost/imune/css/demo.min.css">

		<!-- FAVICONS -->
		<link rel="shortcut icon" href="http://localhost/imune/img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="http://localhost/imune/img/favicon/favicon.ico" type="image/x-icon">

		<!-- GOOGLE FONT -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- Specifying a Webpage Icon for Web Clip
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="http://localhost/imune/img/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="http://localhost/imune/img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="http://localhost/imune/img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="http://localhost/imune/img/splash/touch-icon-ipad-retina.png">

		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="http://localhost/imune/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="http://localhost/imune/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="http://localhost/imune/img/splash/iphone.png" media="screen and (max-device-width: 320px)">
	</head>
	<style>
		/* Loading */
		#loading{ display:none;position:fixed; width:100%; height:100%; top:0; left:0; z-index:10001; background:url(http://localhost/imune/img/loading.gif) center no-repeat;}
		#loadfundo{background:rgba(0%,0%,0%,0.5); z-index:10000; position:fixed; width:100%; height:100%; top:0; left:0;}

	</style>

	<body class="menu-on-top  fixed-header fixed-navigation" >
		<!-- POSSIBLE CLASSES: minified, fixed-ribbon, fixed-header, fixed-width
			 You can also add different skin classes such as "smart-skin-1", "smart-skin-2" etc...-->
						<!-- HEADER -->
				<header id="header" class="hidden-print" >
					<img src="http://localhost/imune/img/imunee.fw" style="width:150px; margin:7px" alt="imunevacinas">



					<!-- pulled right: nav area -->
					<div class="pull-right">
						<!-- logout button -->

						<div id="logout12" class="btn-header transparent pull-right">
							<span> <a href="http://localhost/imune/logout.php" title="Alerta" data-action="userLogout" data-logout-msg="Aperte Sim caso deseje realmente sair do sistema."><i class="fa fa-sign-out"></i></a> </span>
						</div>
						<!-- end logout button -->
						<!-- collapse menu button -->
						<div id="hide-menu" class="btn-header pull-right" style="margin-right:5px;">
							<span> <a  href="javascript:void(0);" title="Collapse Menu" data-action="toggleMenu"><i class="fa fa-reorder"></i></a> </span>
						</div>

						<!-- end collapse menu -->

						<!-- #MOBILE -->
						<!-- Top menu profile link : this shows only when top menu is active -->
						<!--<ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
							<li class="">
								<a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown"> 

								</a>
								<ul class="dropdown-menu pull-right">
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Setting</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="#ajax/profile.php" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>rofile</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="toggleShortcut"><i class="fa fa-arrow-down"></i> <u>S</u>hortcut</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="javascript:void(0);" class="padding-10 padding-top-0 padding-bottom-0" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i> Full <u>S</u>creen</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="login.php" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout"><i class="fa fa-sign-out fa-lg"></i> <strong><u>L</u>ogout</strong></a>
									</li>
								</ul>
							</li>
						</ul>




						<!-- fullscreen button -->
						<div id="fullscreen" class="btn-header transparent pull-right">
							<span> <a id="telacheia" style="border:1px solid rgb(0,134,230);background:linear-gradient(rgb(0,134,230),rgb(31,81,153));color:whitesmoke" href="javascript:void(0);" title="Full Screen" data-action="launchFullscreen"><i class="fa fa-arrows-alt"></i></a> </span>
						</div>
						<!-- end fullscreen button -->

						<!-- #Voice Command: Start Speech -->
						<div id="speech-btn" class="btn-header transparent pull-right hidden-sm hidden-xs">
							<div> 
								<a href="javascript:void(0)" title="Voice Command" data-action="voiceCommand"><i class="fa fa-microphone"></i></a>
							</div>
						</div>
						<div id="" class="btn-header transparent pull-right">
							<span class=" hidden-mobile hidden-xs"> <a style="border:1px solid rgb(0,134,230);background:linear-gradient(rgb(0,134,230),rgb(31,81,153));color:whitesmoke"  href="http://localhost/imune/fluxograma" target="_blank" title="Ajuda" data-action="Ajuda" data-logout-msg="Acesse aqui e entenda os processos do sistema."><i class="fa fa-question"></i></a> </span>
						</div>
						<!-- end voice command -->

						<!-- multiple lang dropdown : find all flags in the flags page -->

					</div>
					<!-- end pulled right: nav area -->

				</header>
				<!-- END HEADER -->

				<!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
				Note: These tiles are completely responsive,
				you can add as many as you like
				-->
				<!--<div id="shortcut">
					<ul>
						<li>
							<a href="#ajax/inbox.php" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
						</li>
						<li>
							<a href="#ajax/calendar.php" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
						</li>
						<li>
							<a href="#ajax/gmap-xml.php" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
						</li>
						<li>
							<a href="#ajax/invoice.php" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
						</li>
						<li>
							<a href="#ajax/gallery.php" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
						</li>
						<li>
							<a href="#ajax/profile.php" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
						</li>
					</ul>
				</div>-->
				<!-- END SHORTCUT AREA -->


				<!-- Left panel : Navigation area -->
		<!-- Note: This width of the aside area can be adjusted through LESS variables -->
		<aside id="left-panel" class="hidden-print"style="background: #77ba91">

			<!-- User info -->
			<div class="login-info">
				<span> <!-- User image size is adjusted inside CSS, it should stay as is -->

					<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
						<span>
							<br />
<b>Notice</b>:  Undefined index: imunevacinas in <b>C:\xampp\htdocs\imune\inc\nav.php</b> on line <b>11</b><br />
						</span>
						<i class="fa fa-angle-down"></i>
					</a>

				</span>
			</div>
			<!-- end user info -->

			<!-- NAVIGATION : This navigation is also responsive

			To make this navigation dynamic please make sure to link the node
			(the reference to the nav > ul) after page load. Or the navigation
			will not initialize.
			-->
			<nav>
				<!-- NOTE: Notice the gaps after each icon usage <i></i>..
				Please note that these links work a bit different than
				traditional hre="" links. See documentation for details.
				-->

				<ul><li><a
				href="ajax/dashboard.php"
				
				title="Dashboard"
				>
					<i class="fa fa-lg fa-fw fa-dashboard"></i>
					<span class="menu-item-parent">Dashboard </span>
					
				</a></li></ul>
			</nav>
			<span class="minifyme" data-action="minifyMenu"> <i class="fa fa-arrow-circle-left hit"></i> </span>

		</aside>
		<!-- END NAVIGATION -->
<!-- ==========================CONTENT STARTS HERE ========================== -->
<!-- MAIN PANEL -->
<div id="main" role="main">
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
	<!-- PAGE FOOTER -->
<div class="page-footer">
	<div class="row">
		<div class="col-xs-12 col-sm-12">
			<span class="txt-color-white">imunevacinas<span class="hidden-xs"> - SISTEMA DE GESTÃO</span> © 2016</span>
		</div>
	</div>
</div>
<!-- END PAGE FOOTER --><!-- END FOOTER -->

<!-- ==========================CONTENT ENDS HERE ========================== -->

		<!--================================================== -->

		<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)
		<script data-pace-options='{ "restartOnRequestAfter": true }' src="http://localhost/imune/js/plugin/pace/pace.min.js"></script>-->

		<!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script>
			if (!window.jQuery) {
				document.write('<script src="http://localhost/imune/js/libs/jquery-2.1.1.min.js"><\/script>');
			}
		</script>

		<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
		<script>
			if (!window.jQuery.ui) {
				document.write('<script src="http://localhost/imune/js/libs/jquery-ui-1.10.3.min.js"><\/script>');
			}
		</script>

		<!-- IMPORTANT: APP CONFIG -->
		<script src="js/app.config.js"></script>

		<!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
		<script src="http://localhost/imune/js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script>

		<!-- BOOTSTRAP JS -->
		<script src="http://localhost/imune/js/bootstrap/bootstrap.min.js"></script>

		<!-- CUSTOM NOTIFICATION -->
		<script src="http://localhost/imune/js/notification/SmartNotification.min.js"></script>

		<!-- JARVIS WIDGETS -->
		<script src="http://localhost/imune/js/smartwidgets/jarvis.widget.min.js"></script>

		<!-- EASY PIE CHARTS -->
		<script src="http://localhost/imune/js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js"></script>

		<!-- SPARKLINES -->
		<script src="http://localhost/imune/js/plugin/sparkline/jquery.sparkline.min.js"></script>

		<!-- JQUERY VALIDATE -->
		<script src="http://localhost/imune/js/plugin/jquery-validate/jquery.validate.min.js"></script>

		<!-- JQUERY MASKED INPUT -->
		<script src="http://localhost/imune/js/plugin/masked-input/jquery.maskedinput.min.js"></script>

		<script src="http://localhost/imune/js/jquery.maskMoney.js"></script>

		<!-- JQUERY SELECT2 INPUT -->
		<script src="http://localhost/imune/js/plugin/select2/select2.min.js"></script>

		<!-- JQUERY UI + Bootstrap Slider -->
		<script src="http://localhost/imune/js/plugin/bootstrap-slider/bootstrap-slider.min.js"></script>

		<!-- browser msie issue fix -->
		<script src="http://localhost/imune/js/plugin/msie-fix/jquery.mb.browser.min.js"></script>

		<!-- FastClick: For mobile devices -->
		<script src="http://localhost/imune/js/plugin/fastclick/fastclick.min.js"></script>

		<!--[if IE 8]>

			<h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

		<![endif]-->

		<!-- Demo purpose only -->
		<script src="http://localhost/imune/js/jquery.maskMoney.js"></script>
		<script src="http://localhost/imune/js/custom.js"></script>
		<script src="http://localhost/imune/js/encry.js"></script>

		<!-- MAIN APP JS FILE -->
		<script src="http://localhost/imune/js/app.min.js"></script>

		<!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
		<!-- Voice command : plugin -->
		<script src="http://localhost/imune/js/speech/voicecommand.min.js"></script>

		<!-- SmartChat UI : plugin -->
		<script src="http://localhost/imune/js/smart-chat-ui/smart.chat.ui.min.js"></script>
		<script src="http://localhost/imune/js/smart-chat-ui/smart.chat.manager.min.js"></script>
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

	saldoSMS();
	setInterval(function(){
		saldoSMS();
	},60000);


	setInterval(function(){
		mai();
		$('body').attr('style','padding-right:0 !important');
	},1000);


</script>