<?php
	include "../../bdd.php";
	$idPiece = $_GET['idPiece']; 
	$name = $_GET['name'];
	$idBatiment = $_GET['idBatiment'];

	$resultats=$connection->query("INSERT INTO Piece(nom, Batiment_idBatiment) VALUES('$name',$idBatiment);");
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Pie/editP&idBatiment='.$idBatiment); 
?>