<?php
	include "../../bdd.php";
	$idTypeCapteur = $_GET['idTypeCapteur'];
	$name = $_GET['name'];
	$desc = $_GET['desc'];
	$unit = $_GET['unit'];

	$resultats=$connection->query("INSERT INTO LIBVAL(libelle, description, unite, TypeCapteur_idTypeCapteur) VALUES('$name','$desc','$unit', '$idTypeCapteur')");
	echo "INSERT INTO LIBVAL(libelle, description, unite, TypeCapteur_idTypeCapteur, idLibVal) VALUES('$name','$desc','$unit', '$idTypeCapteur')";
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Lab/editL&idTypeCapteur='.$idTypeCapteur); 
?>