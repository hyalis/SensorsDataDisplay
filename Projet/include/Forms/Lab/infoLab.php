<?php
	include "../../bdd.php";
	$idLibVal = $_GET['idLibVal'];
	
	$resultats=$connection->query("SELECT libelle, description, unite FROM libval WHERE idLibVal = $idLibVal");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	echo $resultat->libelle . "***" . $resultat->description . "***" . $resultat->unite ;
	$resultats->closeCursor(); 
?>