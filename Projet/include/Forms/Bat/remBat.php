<?php
	include "../../bdd.php";
	
	$idBatiment = $_GET['idBatiment'];
	
	// Requ�te permettant de supprimer l'�l�ment passer en parametre par $idBatiment
	$resultats=$connection->query("DELETE FROM batiment WHERE idBatiment = $idBatiment");
	
	$resultats->closeCursor();
	
	header('Location: '. $chemin .'index.php?p=Forms/Bat/editB'); 
?>