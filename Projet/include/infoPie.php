<?php
	include "bdd.php";
	$idPiece = $_GET['idPiece'];
	
	$resultats=$connection->query("SELECT nom FROM Piece WHERE idPiece = $idPiece");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	echo $resultat->nom;
	$resultats->closeCursor(); 
?>