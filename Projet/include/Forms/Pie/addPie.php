<?php
	include "../../bdd.php";
	$idPiece = $_GET['idPiece']; 
	$name = $_GET['name'];
	$idBatiment = $_GET['idBatiment'];
	$lat = $_GET['lat'];
	$lng = $_GET['lng'];

	$resultats=$connection->query("INSERT INTO Piece(nom, Batiment_idBatiment,LAT, LNG) VALUES('$name',$idBatiment,'$lat','$lng')");
	header('Location: '. $chemin .'index.php?p=Forms/Pie/editP&idBatiment='.$idBatiment); 
?>