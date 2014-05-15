<?php
	include "bdd.php";
	
	$idCapteur = $_GET['idCap'];
	$idPiece = $_GET['idPiece'];
	$resultats=$connection->query("DELETE FROM Localiser WHERE Capteur_idCapteur = $idCapteur");
	$resultats=$connection->query("DELETE FROM Capteur WHERE idCapteur = $idCapteur");
	header('Location: ../index.php?p=editS&idPiece='.$idPiece); 
?>