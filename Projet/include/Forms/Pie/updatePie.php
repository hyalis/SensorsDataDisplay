<?php
	include "../../bdd.php";
	$idBatiment = $_GET['idBatiment']; 
	$idPiece = $_GET['idPiece']; 
	$name = $_GET['name'];
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];

	// Requ�te faisant la mise � jour de l'�l�ment apr�s la modification dans le modal d'edition
	$resultats=$connection->query("UPDATE piece SET nom = '$name' , lat = '$lat', lng = '$lng' WHERE idPiece = $idPiece");
	header('Location: '. $chemin .'index.php?p=Forms/Pie/editP&idBatiment='.$idBatiment); 
?>