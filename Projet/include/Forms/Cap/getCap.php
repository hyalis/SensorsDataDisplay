<?php
	include "../../bdd.php";
	
	// Retourne tous les capteurs qui ne sont pas utilisés
	$resultats=$connection->query("	SELECT IDCAPTEUR, NOMCAPTEUR
									FROM capteur, localiser l1
									WHERE l1.Capteur_idCapteur = idCapteur 
									AND dateF IS NOT NULL
									AND idCapteur NOT IN (	SELECT Capteur_idCapteur
															FROM localiser l2
															WHERE l1.Capteur_idCapteur = l2.Capteur_idCapteur
															AND l1.idLocaliser < l2.idLocaliser)
									UNION
									SELECT idCapteur, nomCapteur
									FROM capteur
									WHERE idCapteur NOT IN (SELECT Capteur_idCapteur FROM Localiser)");
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	while( $resultat = $resultats->fetch() )
	{
		echo "<option value='" . $resultat->IDCAPTEUR . "'>" . $resultat->NOMCAPTEUR . "</option>";
	}
	
	$resultats->closeCursor(); 
?>