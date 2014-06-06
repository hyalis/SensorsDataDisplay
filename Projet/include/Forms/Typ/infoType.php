<?php
	include "../../bdd.php";
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	$resultats=$connection->query("SELECT  NOMTYPE FROM TYPECAPTEUR WHERE idTypeCapteur = $idTypeCapteur");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	
	
	echo $resultat->NOMTYPE ;
	
	$resultats->closeCursor(); 
?>