<?php
	include "../../bdd.php";
	$idPiece = $_GET['idPiece']; 
	
	$radio = $_GET['radio']; 

	
	if($radio == 1) {
		$name = $_GET['name'];
		$idTypeCapteur = $_GET['idTypeCapteur'];
	
		//Récupère un nouvel id de capteur
		$resultats=$connection->query("SELECT MAX(idCapteur)+1 as idCapt FROM Capteur;");
		$resultats->setFetchMode(PDO::FETCH_OBJ);
		$resultat = $resultats->fetch();
		$idCapteur = $resultat->idCapt;
		
		$resultats=$connection->query("INSERT INTO Capteur(idCapteur, nomCapteur, TypeCapteur_idTypeCapteur) VALUES ($idCapteur, '$name',$idTypeCapteur);");
		$resultats=$connection->query("INSERT INTO Localiser(dateD,dateF, Piece_idPiece, Capteur_idCapteur) VALUES (now(), NULL, $idPiece, $idCapteur);");
	} else {
		$idCapteur = $_GET['idCapteur'];
		$resultats=$connection->query("INSERT INTO Localiser(dateD, dateF, Piece_idPiece, Capteur_idCapteur) VALUES (now(), NULL, $idPiece, $idCapteur);");
	}
	
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Cap/editC&idPiece='.$idPiece); 
?>