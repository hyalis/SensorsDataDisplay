<?php
	include 'bdd.php';
	
	$result=$connection->query("SELECT count(*) as NB FROM batiment"); 
	$result->setFetchMode(PDO::FETCH_OBJ);
	$res = $result->fetch();
	$nbBatiments = $res->NB;
	
	$result=$connection->query("SELECT count(*) as NB FROM piece"); 
	$result->setFetchMode(PDO::FETCH_OBJ);
	$res = $result->fetch();
	$nbPieces = $res->NB;
	
	$result=$connection->query("SELECT count(*) as NBCAPTEURS FROM capteur"); 
	$result->setFetchMode(PDO::FETCH_OBJ);
	$res = $result->fetch();
	$nbCapteurs = $res->NBCAPTEURS;
	
	$result=$connection->query("SELECT count(*) as NBMESURES FROM mesure"); 
	$result->setFetchMode(PDO::FETCH_OBJ);
	$res = $result->fetch();
	$nbMesures = $res->NBMESURES;
	
	$result=$connection->query("SELECT count(*) as NBTYPES FROM typecapteur"); 
	$result->setFetchMode(PDO::FETCH_OBJ);
	$res = $result->fetch();
	$nbTypes = $res->NBTYPES;
	
	$result=$connection->query("SELECT count(*) as NBVAL FROM valeurmesure"); 
	$result->setFetchMode(PDO::FETCH_OBJ);
	$res = $result->fetch();
	$nbVals = $res->NBVAL;
	
	$result->closeCursor();
?>
<div class="row">
  <div class="col-lg-12">
	<h1>Dashboard <small>Statistics </small></h1>
	<ol class="breadcrumb">
	  <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
	</ol>
  </div>
</div><!-- /.row -->

<div class="row">
  <div class="col-lg-4">
	<div class="panel panel-info">
	  <div class="panel-heading">
		<div class="row">
		  <div class="col-xs-6">
			<i class="fa fa-comments fa-5x"></i>
		  </div>
		  <div class="col-xs-6 text-right">
			<p class="announcement-heading"><?php echo $nbBatiments; ?></p>
			<p class="announcement-text">Buildings</p>
		  </div>
		</div>
	  </div>
	  <a href="index.php?p=Forms/Bat/editB">
		<div class="panel-footer announcement-bottom">
		  <div class="row">
			<div class="col-xs-6">
			  Edit buildings
			</div>
			<div class="col-xs-6 text-right">
			  <i class="fa fa-arrow-circle-right"></i>
			</div>
		  </div>
		</div>
	  </a>
	</div>
  </div>
  <div class="col-lg-4">
	<div class="panel panel-warning">
	  <div class="panel-heading">
		<div class="row">
		  <div class="col-xs-6">
			<i class="fa fa-check fa-5x"></i>
		  </div>
		  <div class="col-xs-6 text-right">
			<p class="announcement-heading"><?php echo $nbPieces; ?></p>
			<p class="announcement-text">Rooms</p>
		  </div>
		</div>
	  </div>
	  <a href="index.php?p=Forms/Bat/editB">
		<div class="panel-footer announcement-bottom">
		  <div class="row">
			<div class="col-xs-6">
			  Edit Rooms
			</div>
			<div class="col-xs-6 text-right">
			  <i class="fa fa-arrow-circle-right"></i>
			</div>
		  </div>
		</div>
	  </a>
	</div>
  </div>
  <div class="col-lg-4">
	<div class="panel panel-success">
	  <div class="panel-heading">
		<div class="row">
		  <div class="col-xs-6">
			<i class="fa fa-comments fa-5x"></i>
		  </div>
		  <div class="col-xs-6 text-right">
			<p class="announcement-heading"><?php echo $nbCapteurs; ?></p>
			<p class="announcement-text"> Sensors</p>
		  </div>
		</div>
	  </div>
	  <a href="index.php?p=Forms/Bat/editB">
		<div class="panel-footer announcement-bottom">
		  <div class="row">
			<div class="col-xs-6">
			Edit Sensors
			</div>
			<div class="col-xs-6 text-right">
			  <i class="fa fa-arrow-circle-right"></i>
			</div>
		  </div>
		</div>
	  </a>
	</div>
  </div>
</div><!-- /.row -->

<!-- Second row -->
<div class="row">
  <div class="col-lg-4">
	<div class="panel panel-info">
	  <div class="panel-heading">
		<div class="row">
		  <div class="col-xs-6">
			<i class="fa fa-comments fa-5x"></i>
		  </div>
		  <div class="col-xs-6 text-right">
			<p class="announcement-heading"><?php echo $nbTypes; ?></p>
			<p class="announcement-text">Types of sensors</p>
		  </div>
		</div>
	  </div>
	  <a href="index.php?p=Forms/Typ/editT">
		<div class="panel-footer announcement-bottom">
		  <div class="row">
			<div class="col-xs-6">
			  Edit Types
			</div>
			<div class="col-xs-6 text-right">
			  <i class="fa fa-arrow-circle-right"></i>
			</div>
		  </div>
		</div>
	  </a>
	</div>
  </div>
  <div class="col-lg-4">
	<div class="panel panel-warning">
	  <div class="panel-heading">
		<div class="row">
		  <div class="col-xs-6">
			<i class="fa fa-check fa-5x"></i>
		  </div>
		  <div class="col-xs-6 text-right">
			<p class="announcement-heading"><?php echo $nbMesures; ?></p>
			<p class="announcement-text">Mesures</p>
		  </div>
		</div>
	  </div>
	  <a href="index.php?p=Charts/charts">
		<div class="panel-footer announcement-bottom">
		  <div class="row">
			<div class="col-xs-6">
			  Display charts
			</div>
			<div class="col-xs-6 text-right">
			  <i class="fa fa-arrow-circle-right"></i>
			</div>
		  </div>
		</div>
	  </a>
	</div>
  </div>
  <div class="col-lg-4">
	<div class="panel panel-success">
	  <div class="panel-heading">
		<div class="row">
		  <div class="col-xs-6">
			<i class="fa fa-comments fa-5x"></i>
		  </div>
		  <div class="col-xs-6 text-right">
			<p class="announcement-heading"><?php echo $nbVals; ?></p>
			<p class="announcement-text"> Values</p>
		  </div>
		</div>
	  </div>
	  <a href="index.php?p=Charts/charts">
		<div class="panel-footer announcement-bottom">
		  <div class="row">
			<div class="col-xs-6">
			  Display charts
			</div>
			<div class="col-xs-6 text-right">
			  <i class="fa fa-arrow-circle-right"></i>
			</div>
		  </div>
		</div>
	  </a>
	</div>
  </div>
</div><!-- /.row -->
<!-- End Second row -->