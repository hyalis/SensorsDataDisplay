<?php
	include "bdd.php";
	
	$idBatiment = $_GET['idBatiment'];
	$resultats=$connection->query("DELETE FROM batiment WHERE idBatiment = $idBatiment");
	
	include "listBat.php";
	$resultats->closeCursor();
?>