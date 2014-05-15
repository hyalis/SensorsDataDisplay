<?php
	include "../../bdd.php";
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	$resultats=$connection->query("SELECT  nomType FROM typecapteur WHERE idTypeCapteur = $idTypeCapteur");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	
	
	echo $resultat->nomType ;
	
	$resultats->closeCursor(); 
?>