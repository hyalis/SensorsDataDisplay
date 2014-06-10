<?php
	include "../../bdd.php";
	
	$idTypeCapteur = $_GET['idTypeCapteur'];
	//echo "Je suis le PHP et tu veux que je vire le typecapteur $idTypeCapteur mais je ne le fait pas car je test.";
	
	$resultats = $connection->query("UPDATE VALEURMESURE SET LibVal_idLibVal = NULL FROM libval WHERE LibVal_idLibVal = idLibVal AND TypeCapteur_idTypeCapteur = $idTypeCapteur");
	$resultats = $connection->query("DELETE FROM libval WHERE TypeCapteur_idTypeCapteur = $idTypeCapteur");
	$resultats = $connection->query("DELETE FROM typecapteur WHERE idTypeCapteur = $idTypeCapteur");
	$resultats->closeCursor();
	
	header('Location: ' . $chemin . 'index.php?p=Forms/Typ/editT'); 
?>