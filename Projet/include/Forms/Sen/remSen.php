<?php
	include "../../bdd.php";
	
	$idSensor = $_GET['idSensor'];
	
	// Requête permettant de supprimer le capteur 
	$resultats=$connection->query("DELETE FROM CAPTEUR WHERE idCapteur = $idSensor");
	
	header('Location: ' . $chemin . 'index.php?p=Forms/Sen/editS'); 
?>