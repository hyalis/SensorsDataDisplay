<?php
	include "../../bdd.php";
	$idPiece = $_GET['idPiece']; 
	$idCapteur = $_GET['idCapteur']; 
	$name = $_GET['name'];
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	$resultats=$connection->query("UPDATE CAPTEUR SET nomCapteur = '$name', TypeCapteur_idTypeCapteur = $idTypeCapteur WHERE idCapteur = $idCapteur");
	header('Location: ' . $chemin . 'index.php?p=Forms/Sen/editS'); 
?>