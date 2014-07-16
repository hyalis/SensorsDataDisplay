<?php
	include "../../bdd.php";
	
	$idCapteur = $_GET['idCap'];
	$idPiece = $_GET['idPiece'];
	
	// Requête permettant de supprimer les références du capteur dans Localiser et Capteur
	$resultats=$connection->query("DELETE FROM Localiser WHERE Capteur_idCapteur = $idCapteur");
	$resultats=$connection->query("DELETE FROM Capteur WHERE idCapteur = $idCapteur");
	
	header('Location: '. $chemin .'index.php?p=Forms/Cap/editC&idPiece='.$idPiece); 
?>