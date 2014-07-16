<?php
	include "../../bdd.php";
	
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	// Retourne le nom du capteur que l'on souhaite éditer
	$resultats=$connection->query("SELECT  NOMTYPE FROM TYPECAPTEUR WHERE idTypeCapteur = $idTypeCapteur");
	
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	
	echo $resultat->NOMTYPE ;
	
	$resultats->closeCursor(); 
?>