<?php
	include "../../bdd.php";
	
	$idTypeCapteur = $_GET['idTypeCapteur'];
	//echo "Je suis le PHP et tu veux que je vire le typecapteur $idTypeCapteur mais je ne le fait pas car je test.";
	
	// Requête permettant de supprimer l'élément voulu
	$resultats = $connection->query("DELETE FROM typecapteur WHERE idTypeCapteur = $idTypeCapteur");
	$resultats->closeCursor();
	
	header('Location: ' . $chemin . 'index.php?p=Forms/Typ/editT'); 
?>