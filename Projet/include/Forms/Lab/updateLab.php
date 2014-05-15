<?php
	include "bdd.php";
	$idLibVal = $_GET['idLibVal'];
	$name = $_GET['name'];
	$description = $_GET['description'];
	$unite = $_GET['unite'];
	
	$resultats=$connection->query("UPDATE libval SET libelle = '$name', description = '$description', unite = '$unite' WHERE idLibVal = $idLibVal");
	$resultats2=$connection->query("SELECT TypeCapteur_idTypeCapteur FROM libval WHERE idLibVal = $idLibVal");
	
	echo "UPDATE libval SET libelle = '$name', description = '$description', unite = '$unite' WHERE idLibVal = $idLibVal";

	$resultats2->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats2->fetch();
	header('Location: ../index.php?p=editL&idTypeCapteur='.$resultat->TypeCapteur_idTypeCapteur); 
?>