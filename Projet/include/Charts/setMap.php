<?php
	include "../../bdd.php";
	
	$resultats=$connection->query("	SELECT Batiment.nom as NOMBAT, Piece.nom as NOMPIE, LAT, LNG
									FROM Batiment, Piece
									WHERE Batiment_idBatiment = idBatiment");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while($res = $resultats->fetch()){
		echo $res->NOMBAT . "***" . $res->NOMPIE . "***" . $res->LAT . "***" . $res->LNG . "<br>";
	}
?>