<?php
	include "../../bdd.php";
	$idBatiment = $_GET['idBatiment']; 
	$idPiece = $_GET['idPiece']; 
	$name = $_GET['name'];

	$resultats=$connection->query("UPDATE piece SET nom = '$name' WHERE idPiece = $idPiece");
	header('Location: '. $chemin .'index.php?p=Forms/Pie/editP&idBatiment='.$idBatiment); 
?>