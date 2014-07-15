<?php
	include "../../bdd.php";
	
	$idPiece = $_GET['idPiece'];
	$idBatiment = $_GET['idBatiment'];
	// Requête permettant de supprimer l'élément voulu
	$resultats=$connection->query("DELETE FROM piece WHERE idPiece = $idPiece");
	
	include "listPie.php";
	$resultats->closeCursor();
	
	header('Location: '. $chemin .'index.php?p=Forms/Pie/editP&idBatiment='.$idBatiment); 
?>