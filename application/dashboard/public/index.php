<?php
//require(__DIR__.'/../bootstrap.php');


?>



<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">


	<title>SB Admin 2 - Bootstrap Admin Theme</title>



	<script src="vendor/jquery.js"></script>



	<!--FONTS//-->
	<link rel="stylesheet" href="vendor/roboto-fontfacekit/font/roboto_light_macroman/stylesheet.css"/>
	<link href="vendor/material-icon/material-icon.css" rel="stylesheet">
	<link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link href="vendor/MaterialDesign-Webfont/css/materialdesignicons.min.css" rel="stylesheet">



	<!-- Bootstrap Core -->
	<link href="./vendor/sb-admin/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="./vendor/sb-admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>





	<!--Menu -->
	<link href="./vendor/sb-admin/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	<script src="./vendor/sb-admin/bower_components/metisMenu/dist/metisMenu.min.js"></script>


	<!-- Timeline CSS -->
	<link href="./vendor/sb-admin/dist/css/timeline.css" rel="stylesheet">




	<!-- Custom CSS -->
	<link href="./vendor/sb-admin/dist/css/sb-admin-2.css" rel="stylesheet">
	<script src="./vendor/sb-admin/dist/js/sb-admin-2.js"></script>




	<!-- Bootstrap Material Design -->
	<link href="vendor/bootstrap-material-design/dist/css/bootstrap-material-design.css" rel="stylesheet">
	<link href="vendor/bootstrap-material-design/dist/css/ripples.min.css" rel="stylesheet">


	<script src="vendor/snackbarjs/dist/snackbar.min.js"></script>
	<link href="vendor/snackbarjs/dist/snackbar.min.css" rel="stylesheet">

	<script src="vendor/bootstrap-material-design/dist/js/ripples.min.js"></script>
	<script src="vendor/bootstrap-material-design/dist/js/material.min.js"></script>

	<script src="vendor/jquery.nouislider.min.js"></script>



	<!--date picker//-->
	<link id="bsdp-css" href="vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="vendor/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js" charset="UTF-8"></script>



	<!--social button//-->
	<link href="./vendor/bootstrap-social/bootstrap-social.css" rel="stylesheet">



	<!-- Morris Charts CSS -->
	<link href="./vendor/sb-admin/bower_components/morrisjs/morris.css" rel="stylesheet">
	<script src="./vendor/sb-admin/bower_components/raphael/raphael-min.js"></script>
	<script src="./vendor/sb-admin/bower_components/morrisjs/morris.min.js"></script>
	<script src="./vendor/sb-admin/js/morris-data.js"></script>



	<script>
		$('#datePicker').datepicker({
			language: "fr",
			daysOfWeekHighlighted: "0,6",
			calendarWeeks: true,
			autoclose: true,
			todayHighlight: true
		});
	</script>

	<script>


		$(function () {

			$('#summernote').summernote({
				lang: 'fr-FR' // default: 'en-US'
			});


			//toop tip et tooltip on click===========================
			$('.bs-component [data-toggle="popover"]').popover();
			$('.bs-component [data-toggle="tooltip"]').tooltip();
			//============================================

			$.material.init();

			$(".shor").noUiSlider({
				start: 40,
				connect: "lower",
				range: {
					min: 0,
					max: 100
				}
			});

			$(".svert").noUiSlider({
				orientation: "vertical",
				start: 40,
				connect: "lower",
				range: {
					min: 0,
					max: 100
				}
			});
		});
	</script>





	<!-- include summernote css/js-->
	<link href="vendor/summernote/dist/summernote.css" rel="stylesheet">
	<script src="vendor/summernote/dist/summernote.js"></script>
	<script src="vendor/summernote/lang/summernote-fr-FR.js"></script>







<link rel="stylesheet" href="source/css/workspace.css"







</head>

<body>

<div id="wrapper">

	<!-- Navigation -->
	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.html">SB Admin v2.0</a>
		</div>
		<!-- /.navbar-header -->
		<?php include(__DIR__.'/nav-top.php');?>

		<?php include(__DIR__.'/nav-left.php');?>
		<!-- /.navbar-static-side -->
	</nav>





	<div id="page-wrapper">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>



				<div id="summernote"><p>Hello Summernote</p></div>


				<div class="form-group label-floating">
					<label class="control-label" for="datePicker">Date picker</label>
					<input class="form-control" id="datePicker" >
					<p class="help-block">You should really write something here</p>
				</div>




				<?php include(__DIR__.'/fragment/social-button.php');?>



			<?php include(__DIR__.'/test.php'); ?>




			</div>
			<!-- /.col-lg-12 -->
		</div>
		<!-- /.row -->
		<div class="row">


			<?php include(__DIR__.'/fragment/ticket.php');?>


		</div>
		<!-- /.row -->
		<div class="row">
			<div class="col-lg-8">




				<?php include(__DIR__.'/fragment/areachart.php');?>

			<!-- /.panel -->

				<?php include(__DIR__.'/fragment/barchart.php');?>
				<!-- /.panel -->

				<?php include(__DIR__.'/fragment/timeline.php');?>

				<!-- /.panel -->
			</div>
			<!-- /.col-lg-8 -->
			<div class="col-lg-4">



				<?php include(__DIR__.'/fragment/notification.php');?>
				<!-- /.panel -->

				<?php include(__DIR__.'/fragment/donut.php');?>
				<!-- /.panel -->
				<?php include(__DIR__.'/fragment/chat.php');?>
				<!-- /.panel .chat-panel -->
			</div>
			<!-- /.col-lg-4 -->
		</div>
		<!-- /.row -->
	</div>
	<!-- /#page-wrapper -->

</div>


</body>

</html>
