<?php
	include "../../bdd.php";
	
	$idTypeCapteur = $_GET['idTypeCapteur'];
	$name = $_GET['name'];
	$desc = $_GET['desc'];
	$unit = $_GET['unit'];

	// Requête ajoutant le nouveau libVal a partir du modal d'ajout
	$resultats=$connection->query("INSERT INTO libval(libelle, description, unite, TypeCapteur_idTypeCapteur) VALUES('$name','$desc','$unit', '$idTypeCapteur')");
	// echo "INSERT INTO libval(libelle, description, unite, TypeCapteur_idTypeCapteur, idLibVal) VALUES('$name','$desc','$unit', '$idTypeCapteur');";
	
	header('Location: '. $chemin .'index.php?p=Forms/Lab/editL&idTypeCapteur='.$idTypeCapteur); 
?>