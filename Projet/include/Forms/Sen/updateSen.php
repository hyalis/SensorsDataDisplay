<?php
	include "../../bdd.php";
	
	$idPiece = $_GET['idPiece']; 
	$idCapteur = $_GET['idCapteur']; 
	$name = $_GET['name'];
	$idTypeCapteur = $_GET['idTypeCapteur'];
	
	// Requ�te faisant la mise � jour de l'�l�ment apr�s la modification dans le modal d'edition
	$resultats=$connection->query("UPDATE CAPTEUR SET nomCapteur = '$name', TypeCapteur_idTypeCapteur = $idTypeCapteur WHERE idCapteur = $idCapteur");
	
	header('Location: ' . $chemin . 'index.php?p=Forms/Sen/editS'); 
?>