<?php
	include "../../bdd.php";

	$name = $_GET['name'];
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	// Requête ajoutant le nouveau Capteur a partir du modal d'ajout
	$resultats=$connection->query("INSERT INTO CAPTEUR(nomCapteur, TypeCapteur_idTypeCapteur) VALUES ('$name',$idTypeCapteur)");

	header('Location: ' . $chemin . 'index.php?p=Forms/Sen/editS'); 
?>