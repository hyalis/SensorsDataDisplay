<?php
	include "../../bdd.php";
	
	$idTypeCapteur = $_GET['idTypeCapteur'];
	//echo "Je suis le PHP et tu veux que je vire le typecapteur $idTypeCapteur mais je ne le fait pas car je test.";
	
	$resultats = $connection->query("UPDATE VALEURMESURE SET LIBVAL_IDLIBVAL = NULL FROM LIBVAL WHERE LIBVAL_IDLIBVAL = IDLIBVAL AND TYPECAPTEUR_IDTYPECAPTEUR = $idTypeCapteur");
	$resultats = $connection->query("DELETE FROM LIBVAL WHERE TYPECAPTEUR_IDTYPECAPTEUR = $idTypeCapteur");
	$resultats=$connection->query("DELETE FROM TYPECAPTEUR WHERE IDTYPECAPTEUR = $idTypeCapteur");
	//echo "DELETE FROM typecapteur WHERE idTypeCapteur = $idTypeCapteur" ;
	//Traitement des erreurs ---> A REVOIR !!!! (certainement pas -1...)
	/*if($resultats == -1){
		echo "KO";
	} else {
		echo "OK";
	}*/
	include "listType.php";
	$resultats->closeCursor();
	
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Typ/EditT'); 
?>