<?php
	include "../../bdd.php";
	$idPiece = $_GET['idPiece']; 
	$idCapteur = $_GET['idCapteur']; 
	$name = $_GET['name'];
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	$resultats=$connection->query("UPDATE Capteur SET nomCapteur = '$name', TypeCapteur_idTypeCapteur = $idTypeCapteur WHERE idCapteur = $idCapteur");
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Cap/editC&idPiece='.$idPiece); 
?>