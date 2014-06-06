<?php
	include "../../bdd.php";

	$name = $_GET['name'];
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	$resultats=$connection->query("INSERT INTO CAPTEUR(nomCapteur, TypeCapteur_idTypeCapteur) VALUES ('$name',$idTypeCapteur)");

	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Sen/editS'); 
?>