<?php
	include "../../bdd.php";
	
	$idBatiment = $_GET['idBatiment'];
	
	// Requête permettant de supprimer l'élément passer en parametre par $idBatiment
	$resultats=$connection->query("DELETE FROM batiment WHERE idBatiment = $idBatiment");
	
	$resultats->closeCursor();
	
	header('Location: '. $chemin .'index.php?p=Forms/Bat/editB'); 
?>