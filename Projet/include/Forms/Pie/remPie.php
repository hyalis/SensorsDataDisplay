<?php
	include "../../bdd.php";
	
	$idPiece = $_GET['idPiece'];
	$idBatiment = $_GET['idBatiment'];
	// Requ�te permettant de supprimer l'�l�ment voulu
	$resultats=$connection->query("DELETE FROM piece WHERE idPiece = $idPiece");
	
	include "listPie.php";
	$resultats->closeCursor();
	
	header('Location: '. $chemin .'index.php?p=Forms/Pie/editP&idBatiment='.$idBatiment); 
?>