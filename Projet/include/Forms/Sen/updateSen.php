<?php
	include "../../bdd.php";
	$idPiece = $_GET['idPiece']; 
	$idCapteur = $_GET['idCapteur']; 
	$name = $_GET['name'];
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	$resultats=$connection->query("UPDATE CAPTEUR SET NOMCAPTEUR = '$name', TYPECAPTEUR_IDTYPECAPTEUR = $idTypeCapteur WHERE IDCAPTEUR = $idCapteur");
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Sen/editS'); 
?>