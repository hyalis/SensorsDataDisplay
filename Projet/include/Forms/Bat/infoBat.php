<?php
	include "../../bdd.php";
	$idBatiment = $_GET['idBatiment'];
	
	$resultats=$connection->query("SELECT NOM, ADRESSE, CP, VILLE FROM batiment WHERE idBatiment = $idBatiment");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	echo $resultat->NOM . "***" . $resultat->ADRESSE . "***" . $resultat->CP . "***" . $resultat->VILLE;
	$resultats->closeCursor(); 
?>