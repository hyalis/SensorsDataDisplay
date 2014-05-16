<?php
	include "../../bdd.php";
	
	$idPiece = $_GET['idPiece'];
	$idBatiment = $_GET['idBatiment'];
	$resultats=$connection->query("DELETE FROM piece WHERE idPiece = $idPiece");
	
	include "listPie.php";
	$resultats->closeCursor();
	
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Pie/editP&idBatiment='.$idBatiment); 
?>