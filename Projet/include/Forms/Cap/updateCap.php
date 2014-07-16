<?php
	include "../../bdd.php";
	
	$idPiece = $_GET['idPiece']; 
	$idCapteur = $_GET['idCapteur']; 
	$name = $_GET['name'];
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	// Requête faisant la mise à jour de l'élément après la modification dans le modal d'edition
	$resultats=$connection->query("UPDATE Capteur SET nomCapteur = '$name', TypeCapteur_idTypeCapteur = $idTypeCapteur WHERE idCapteur = $idCapteur");
	
	header('Location: '. $chemin .'index.php?p=Forms/Cap/editC&idPiece='.$idPiece); 
?>