<?php
	include "../../bdd.php";
	$idLibVal = $_GET['idLibVal'];
	
	$resultats=$connection->query("SELECT LIBELLE, DESCRIPTION, UNITE FROM LIBVAL WHERE idLibVal = $idLibVal");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	echo $resultat->LIBELLE . "***" . $resultat->DESCRIPTION . "***" . $resultat->UNITE ;
	$resultats->closeCursor(); 
?>