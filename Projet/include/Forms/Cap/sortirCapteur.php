<?php
	include "../../bdd.php";
	
	$idCapteur = $_GET['idCap'];
	$idPiece = $_GET['idPiece'];
	
	$resultats=$connection->query("UPDATE localiser SET dateF = now() WHERE Piece_idPiece = $idPiece AND Capteur_idCapteur = $idCapteur;");
	
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Cap/editC&idPiece='.$idPiece); 
?>