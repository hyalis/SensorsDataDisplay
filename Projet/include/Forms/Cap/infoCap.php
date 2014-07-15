<?php
	include "../../bdd.php";
	$idCapteur = $_GET['idCapteur'];
	// Retourne les éléments nécessaire pour completer les champs d'edition dans le modal
	$resultats=$connection->query("SELECT IDCAPTEUR, NOMCAPTEUR, TypeCapteur_idTypeCapteur as TYPE FROM capteur WHERE idCapteur = $idCapteur");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	
	$return = $resultat->NOMCAPTEUR . "***";
	$return = $return . $resultat->IDCAPTEUR;
	$idTypeCapteurCourant = $resultat->TYPE;
	
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