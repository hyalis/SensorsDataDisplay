<?php
	include "../../bdd.php";
	
	$idLibVal = $_GET['idLibVal'];
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	// Requ�te permettant de supprimer l'�l�ment voulu
	$resultats=$connection->query("DELETE FROM LIBVAL WHERE idLibVal = $idLibVal");
	// echo "DELETE FROM libval WHERE idLibVal = $idLibVal" ;
	
	include "listLab.php";
	$resultats->closeCursor();
	
	header('Location: '. $chemin .'index.php?p=Forms/Lab/EditL&idTypeCapteur='.$idTypeCapteur); 
?>