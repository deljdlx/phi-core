<?php
//require(__DIR__.'/../bootstrap.php');


?>



<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>SB Admin 2 - Bootstrap Admin Theme</title>



	<script src="vendor/jquery.js"></script>






	<!--FONTS//-->
	<link rel="stylesheet" href="vendor/roboto-fontfacekit/font/roboto_light_macroman/stylesheet.css"/>
	<link href="vendor/material-icon/material-icon.css" rel="stylesheet">
	<link href="./vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<link href="vendor/MaterialDesign-Webfont/css/materialdesignicons.min.css" rel="stylesheet">



	<!-- Bootstrap Core -->

	<link href="./vendor/bootstrap-pack/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">



	<script src="./vendor/bootstrap-pack/bootstrap/dist/js/bootstrap.min.js"></script>





	<!--Menu -->
	<link href="./vendor/bootstrap-pack/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	<script src="./vendor/bootstrap-pack/metisMenu/dist/metisMenu.min.js"></script>


	<!-- Timeline CSS -->
	<link href="./vendor/bootstrap-pack/sb-admin/dist/css/timeline.css" rel="stylesheet">




	<!-- Custom CSS -->


	<link href="./vendor/bootstrap-pack/sb-admin/dist/css/sb-admin-2.css" rel="stylesheet">


	<!--
	<script src="./vendor/bootstrap-pack/sb-admin/dist/js/sb-admin-2.js"></script>
	//-->








	<!-- Bootstrap Material Design -->
	<link href="vendor/bootstrap-pack/bootstrap-material-design/dist/css/bootstrap-material-design.css" rel="stylesheet">
	<link href="vendor/bootstrap-pack/bootstrap-material-design/dist/css/ripples.min.css" rel="stylesheet">


	<script src="vendor/snackbarjs/dist/snackbar.min.js"></script>
	<link href="vendor/snackbarjs/dist/snackbar.min.css" rel="stylesheet">

	<script src="vendor/bootstrap-pack/bootstrap-material-design/dist/js/ripples.min.js"></script>
	<script src="vendor/bootstrap-pack/bootstrap-material-design/dist/js/material.min.js"></script>

	<script src="vendor/jquery.nouislider.min.js"></script>



	<!--date picker//-->
	<link id="bsdp-css" href="vendor/bootstrap-pack/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet">
	<script src="vendor/bootstrap-pack/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="vendor/bootstrap-pack/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js" charset="UTF-8"></script>



	<!--social button//-->
	<link href="./vendor/bootstrap-pack/bootstrap-social/bootstrap-social.css" rel="stylesheet">



	<!-- Morris Charts CSS -->
	<link href="./vendor/bootstrap-pack/sb-admin/bower_components/morrisjs/morris.css" rel="stylesheet">
	<script src="./vendor/bootstrap-pack/sb-admin/bower_components/raphael/raphael-min.js"></script>
	<script src="./vendor/bootstrap-pack/sb-admin/bower_components/morrisjs/morris.min.js"></script>
	<!--
	<script src="./vendor/bootstrap-pack/sb-admin/js/morris-data.js"></script>
	//-->





	<script src="vendor/babelcore.js"></script>
	<script src="vendor/react/build/react.js"></script>
	<script src="vendor/react/build/react-dom.js"></script>


	<!-- include summernote css/js-->
	<link href="vendor/summernote/dist/summernote.css" rel="stylesheet">
	<script src="vendor/summernote/dist/summernote.js"></script>
	<script src="vendor/summernote/lang/summernote-fr-FR.js"></script>

	<script src="vendor/summernote/plugin/addclass.js"></script>




	<script src="vendor/khi/Khi.js"></script>
	<script src="vendor/khi/Request.js"></script>
	<script src="vendor/khi/Router.js"></script>
	<script src="vendor/khi/RouterRule.js"></script>




	<script src="source/helper/function.js"></script>
	<script src="source/class/Bienvenue.js"></script>
	<script src="source/class/Component.js"></script>
	<script src="source/class/Workspace/Workspace.js"></script>
	<script src="source/class/Module.js"></script>
	<script src="source/class/ModuleLoader.js"></script>



	<script src="source/class/Workspace/LeftNavigationBar/LeftNavigationBar.js"></script>
	<script src="source/class/Workspace/TopNavigationBar/TopNavigationBar.js"></script>



	<link rel="stylesheet" href="vendor/jstree/dist/themes/default/style.min.css" />
	<script src="vendor/jstree/dist/jstree.min.js"></script>



	<link rel="stylesheet" href="source/class/Component/Ripple/ripple.css"/>
	<script src="source/class/Component/Ripple/Ripple.Js"></script>

	<link rel="stylesheet" href="source/class/Component/Tree/css/jstree-fontawesome.css"/>
	<script src="source/class/Component/Tree/Tree.js"></script>


		<script>

			$(function() {

				var workspace=new Bienvenue.Workspace();
				workspace.run();

				var router=new Khi.Router();

				router.addRule('moduleLoader', function(request) {
					if(request.url.match(/#module=.+/)) {
						return true;
					}
				}, function(request) {
					var moduleName=request.anchorParameters.module;
					workspace.loadModule(moduleName)
				})

				router.run();

			});
		</script>










	<link rel="stylesheet" href="source/css/workspace.css"





	</head>

	<body>

		<div class="mainContainer">



			<div class="topNavigationBar">Top</div>


			<div class="bodyContainer">

				<div class="leftMenuContainer">
					<div class="navbar-default sidebar"></div>
				</div>


				<div class="bienvenue-panel-main">main</div>


			</div>

			<div class="bottomBar">Bottom</div>


		</div>


	<div>

	</div>


	<!--
<div id="wrapper">


	<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
		<div class="topNavigationBar"></div>
		<div class="navbar-default sidebar" role="navigation"></div>
	</nav>


	<div id="page-wrapper">
		<div class="row bienvenue-panel-main">
		</div>
	</div>
</div>
//-->

</body>

</html>
