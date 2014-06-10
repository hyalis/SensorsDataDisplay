<?php
	include "../../bdd.php";
	$name = $_GET['name'];

	$resultats=$connection->query("INSERT INTO Typecapteur(nomType) VALUES('$name')");
	// echo "INSERT INTO Typecapteur(nomType) VALUES('$name')";
	header('Location: ' . $chemin . 'index.php?p=Forms/Typ/editT'); 
?>