<?php
	include "../../bdd.php";
	$idTypeCapteur = $_GET['idTypeCapteur'];
	// Requête permettant d'obtenir tout le id et libelle du capteur $idTypeCapteur pour pouvoir renseigner le marqueur sur la map
	$resultats=$connection->query("	SELECT IDLIBVAL, LIBELLE
									FROM LibVal
									WHERE TypeCapteur_idTypeCapteur = $idTypeCapteur");
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	// Envoie les informations a charts pour mettre à jour les champs dans la map
	while($res = $resultats->fetch()){
		echo "<option value='" . $res->IDLIBVAL . "'>" . $res->LIBELLE ."</option>";
	}

?>