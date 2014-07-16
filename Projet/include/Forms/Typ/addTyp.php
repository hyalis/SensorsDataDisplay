<?php
	include "../../bdd.php";
	
	$name = $_GET['name'];

	// Requête ajoutant le nouveau typeCapteur a partir du modal d'ajout
	$resultats=$connection->query("INSERT INTO Typecapteur(nomType) VALUES('$name')");
	// echo "INSERT INTO Typecapteur(nomType) VALUES('$name')";
	
	header('Location: ' . $chemin . 'index.php?p=Forms/Typ/editT'); 
?>