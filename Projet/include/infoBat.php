<?php
	include "bdd.php";
	$idBatiment = $_GET['idBatiment'];
	
	$resultats=$connection->query("SELECT nom, adresse, cp, ville FROM batiment WHERE idBatiment = $idBatiment");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	echo $resultat->nom . "***" . $resultat->adresse . "***" . $resultat->cp . "***" . $resultat->ville;
	$resultats->closeCursor(); 
?>