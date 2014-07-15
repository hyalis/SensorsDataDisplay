<?php
	include "../../bdd.php";
	$idPiece = $_GET['idPiece'];
	
	// Retourne les éléments de la piéce sélectionnée que l'on souhaite éditer
	$resultats=$connection->query("SELECT NOM , LAT, LNG FROM Piece WHERE idPiece = $idPiece");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	echo $resultat->NOM ."***". $resultat->LAT ."***". $resultat->LNG  ;
	$resultats->closeCursor(); 
?>