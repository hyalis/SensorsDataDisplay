<?php
	include "../../bdd.php";

	$name = $_GET['name'];
	$idTypeCapteur = $_GET['idTypeCapteur'];

	//Récupère un nouvel id de capteur
	$resultats=$connection->query("SELECT MAX(idCapteur)+1 as idCapt FROM Capteur;");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	$idCapteur = $resultat->idCapt;
	
	$resultats=$connection->query("INSERT INTO Capteur(idCapteur, nomCapteur, TypeCapteur_idTypeCapteur) VALUES ($idCapteur, '$name',$idTypeCapteur);");
	$resultats=$connection->query("INSERT INTO Localiser(dateD,dateF, Piece_idPiece, Capteur_idCapteur) VALUES (now(), now(), 1, $idCapteur);");

	
	header('Location: /SensorsDataDisplay/Projet/index.php?p=Forms/Sen/editS'); 
?>