<?php
	include "../../bdd.php";
	
	$idBatiment = $_GET['idBatiment'];
	$resultats=$connection->query("DELETE FROM batiment WHERE idBatiment = $idBatiment");
	
	$resultats->closeCursor();
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Bat/editB'); 
?>