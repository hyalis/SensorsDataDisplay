<!-- Initialisation des variables PHP -->
<?php
	//Colore l'onglet actif
	$dashboard = "";
	$charts = "";
	$form = "";
	$import = "";
	if(!empty($_GET['p'])){
		//Selon l'onglet courant
		switch($_GET['p']){
			case 'Dashboard/dashboard' :	$dashboard = "active";
				break;
			case 'Charts/charts' : 	$charts = "active";
				break;
			case 'Forms/Bat/editB' : 		$form = "active";
				break;
			case 'Forms/Typ/editT' : 		$form = "active";
				break;
			case 'Forms/Pie/editP' : 		$form = "active";
				break;
			case 'Forms/Cap/editC' : 		$form = "active";
				break;
			case 'Forms/Lab/editL' : 		$form = "active";
				break;
			case 'Import/import' :  	$import = "active";
				break;
		}
	} else {
		$dashboard = "active";
	}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Clément Edouard - Léo Mouly - Damien Parise">

    <title>Dashboard - SensorsDataDisplay</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Page Specific CSS -->
    <link rel="stylesheet" href="css/morris-0.4.3.min.css">	
	
	<!-- Importation JavaScript de JQuery et Bootstrap-->
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery.mousewheel.min.js"></script>
	
	<script src="js/bootstrap.js"></script>
	
	<!-- Importation des fichiers JavaScript pour le Bubble Chart-->
	<script src="amcharts/amcharts.js" type="text/javascript"></script>
    <script src="amcharts/xy.js" type="text/javascript"></script>
	<script src="amcharts/exporting/amexport.js" type="text/javascript"></script>
	<script src="amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
	<script src="amcharts/exporting/canvg.js" type="text/javascript"></script>        
	<script src="amcharts/exporting/filesaver.js" type="text/javascript"></script>
	
	<style>
		#wrapper {
			width: 100%;
			float: left;
			padding-left: 0px;
		}
		#tree-wrapper {
			width: 0%;
			float: left;
		}
	</style>
	
</head>

<body>
	<div id="tree-wrapper">
		<div class="chosentree" style="width=20%;"></div>
	</div>
	<div id="wrapper">
		<!-- Sidebar -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="index.php">SensorsDataDisplay</a>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav navbar-center">
				<!-- <ul class="nav navbar-nav side-nav"> -->
					<li class="<?php echo $dashboard; ?>"><a href="index.php?p=Dashboard/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
					<li class="<?php echo $charts; ?>"><a href="index.php?p=Charts/charts"><i class="fa fa-bar-chart-o"></i> Charts</a></li>
					<li class="dropdown <?php echo $form; ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-edit"></i> Forms <b class="caret"></b></a>
						<ul class="dropdown-menu">
						<li><a href="index.php?p=Forms/Bat/editB">Edit Buildings/Rooms</a></li>
						<li><a href="index.php?p=Forms/Typ/editT">Edit Types/Label</a></li>
						</ul>
					</li>
					<li class="<?php echo $import; ?>"><a href="index.php?p=Import/import"><i class="fa fa-file"></i> Import File</a></li>
				</ul>

				<ul class="nav navbar-nav navbar-right navbar-user">
					<li class="dropdown user-dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Equipe SIG <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
							<li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="fa fa-power-off"></i> Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div><!-- /.navbar-collapse -->
		</nav>
		
		<!-- CONTENU DE LA PAGE CENTRALE -->
		<div id="page-wrapper">
		
			<?php
				if(!empty($_GET['p'])){
					if(file_exists('include/' . $_GET['p'] . '.php')){
							include('include/' . $_GET['p'] . '.php');
					} else {
							include('include/Dashboard/dashboard.php');
					}
				} else {
					include('include/Dashboard/dashboard.php');
				}
			?>
		</div><!-- /#page-wrapper -->

	</div><!-- /#wrapper -->

	

	<!-- Page Specific Plugins -->
	<script src="js/raphael-min.js"></script>
	<script src="js/tablesorter/jquery.tablesorter.js"></script>
	<script src="js/tablesorter/tables.js"></script>
</body>
</html>
