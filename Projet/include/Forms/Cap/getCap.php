<?php
	include "../../bdd.php";
	
	$resultats=$connection->query("	SELECT idCapteur, nomCapteur
									FROM capteur, localiser l1
									WHERE l1.Capteur_idCapteur = idCapteur 
									AND dateF IS NOT NULL
									AND idCapteur NOT IN (	SELECT Capteur_idCapteur
															FROM localiser l2
															WHERE l1.Capteur_idCapteur = l2.Capteur_idCapteur
															AND l1.idLocaliser < l2.idLocaliser)");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
		echo "<option value='" . $resultat->idCapteur . "'>" . $resultat->nomCapteur . "</option>";
	}
	$resultats->closeCursor(); 
?>