<?php
	include "../../bdd.php";
	$idSensor = $_GET['idSensor'];
	
	$resultats=$connection->query("SELECT idCapteur, nomCapteur, TypeCapteur_idTypeCapteur FROM capteur WHERE idCapteur = $idSensor");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	
	$return = $resultat->nomCapteur . "***";
	$return = $return . $resultat->idCapteur;
	$idTypeCapteurCourant = $resultat->TypeCapteur_idTypeCapteur;
	
	$resultats=$connection->query("SELECT idTypeCapteur, nomType FROM typecapteur");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
		$return = $return . "***" . $resultat->idTypeCapteur . "***" . $resultat->nomType;
	}
	
	$return = $return . "***" . $idTypeCapteurCourant;
	
	echo $return;
	
	$resultats->closeCursor(); 
?>