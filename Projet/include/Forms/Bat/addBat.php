<?php
	include "../../bdd.php";
	
	$idBatiment = $_GET['idBatiment']; 
	$name = $_GET['name'];
	$adresse = $_GET['adress'];
	$zip = $_GET['zip'];
	$city = $_GET['city'];

	// Requ�te ajoutant le nouveau batiment a partir du modal d'ajout
	$resultats=$connection->query("INSERT INTO Batiment(nom, adresse, cp, ville) VALUES('$name','$adresse','$zip','$city')");
	
	header('Location: ' . $chemin . 'index.php?p=Forms/Bat/editB'); 
?>