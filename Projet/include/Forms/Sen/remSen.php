<?php
	include "../../bdd.php";
	
	$idSensor = $_GET['idSensor'];
	$resultats=$connection->query("DELETE FROM Capteur WHERE idCapteur = $idSensor");
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Sen/editS'); 
?>