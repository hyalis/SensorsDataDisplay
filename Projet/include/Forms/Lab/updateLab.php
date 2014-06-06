<?php
	include "../../bdd.php";
	$idLibVal = $_GET['idLibVal'];
	$name = $_GET['name'];
	$description = $_GET['description'];
	$unite = $_GET['unite'];
	
	$resultats=$connection->query("UPDATE LIBVAL SET LIBELLE = '$name', DESCRIPTION = '$description', UNITE = '$unite' WHERE IDLIBVAL = $idLibVal");
	$resultats2=$connection->query("SELECT TYPECAPTEUR_IDTYPECAPTEUR FROM LIBVAL WHERE idLibVal = $idLibVal");
	
	echo "UPDATE LIBVAL SET LIBELLE = '$name', DESCRIPTION = '$description', UNITE = '$unite' WHERE IDLIBVAL = $idLibVal";

	$resultats2->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats2->fetch();
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Lab/editL&idTypeCapteur='.$resultat->TYPECAPTEUR_IDTYPECAPTEUR); 
?>