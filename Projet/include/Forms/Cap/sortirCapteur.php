<?php
	include "../../bdd.php";
	
	$idCapteur = $_GET['idCap'];
	$idPiece = $_GET['idPiece'];
	
	// Requête mettant une date de fin dans la table localiser pour signaler que le capteur $idCapteur n'est plus dans la piece
	$resultats=$connection->query("UPDATE localiser SET dateF = SYSDATE WHERE Piece_idPiece = $idPiece AND Capteur_idCapteur = $idCapteur");
	
	header('Location: '. $chemin .'index.php?p=Forms/Cap/editC&idPiece='.$idPiece); 
?>