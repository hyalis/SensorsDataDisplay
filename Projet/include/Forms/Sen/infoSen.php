<?php
	include "../../bdd.php";
	$idSensor = $_GET['idSensor'];
	
	$resultats=$connection->query("SELECT IDCAPTEUR, NOMCAPTEUR, TYPECAPTEUR_IDTYPECAPTEUR FROM CAPTEUR WHERE idCapteur = $idSensor");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	
	$return = $resultat->NOMCAPTEUR . "***";
	$return = $return . $resultat->IDCAPTEUR;
	$idTypeCapteurCourant = $resultat->TYPECAPTEUR_IDTYPECAPTEUR;
	
	$resultats=$connection->query("SELECT IDTYPECAPTEUR, NOMTYPE FROM typecapteur");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
		$return = $return . "***" . $resultat->IDTYPECAPTEUR . "***" . $resultat->NOMTYPE;
	}
	
	$return = $return . "***" . $idTypeCapteurCourant;
	
	echo $return;
	
	$resultats->closeCursor(); 
?>