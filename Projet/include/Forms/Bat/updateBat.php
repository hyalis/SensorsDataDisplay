<?php
	include "../../bdd.php";
	$idBatiment = $_GET['idBatiment']; 
	$name = $_GET['name'];
	$adresse = $_GET['adress'];
	$zip = $_GET['zip'];
	$city = $_GET['city'];

	$resultats=$connection->query("UPDATE Batiment SET nom = '$name', adresse = '$adresse', cp = '$zip', ville = '$city' WHERE idBatiment = $idBatiment");
	header('Location: '. $chemin .'index.php?p=Forms/Bat/editB'); 
?>