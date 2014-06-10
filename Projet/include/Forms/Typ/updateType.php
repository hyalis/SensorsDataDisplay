<?php
	include "../../bdd.php";
	$idTypeCapteur = $_GET['idTypeCapteur']; 
	$name = $_GET['name'];
	
	$resultats=$connection->query("UPDATE typecapteur SET nomType = '$name' WHERE idTypeCapteur = $idTypeCapteur");
	
	//echo "UPDATE typecapteur SET nomType = '$name' WHERE idTypeCapteur = $idTypeCapteur" ;

	header('Location: ' . $chemin . 'index.php?p=Forms/Typ/editT'); 
?>