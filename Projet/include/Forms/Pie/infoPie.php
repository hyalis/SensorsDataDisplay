<?php
	include "../../bdd.php";
	$idPiece = $_GET['idPiece'];
	
	// Retourne les �l�ments de la pi�ce s�lectionn�e que l'on souhaite �diter
	$resultats=$connection->query("SELECT NOM , LAT, LNG FROM Piece WHERE idPiece = $idPiece");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	echo $resultat->NOM ."***". $resultat->LAT ."***". $resultat->LNG  ;
	$resultats->closeCursor(); 
?>