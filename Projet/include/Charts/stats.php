<?php
	include "../bdd.php";

	$dateDeb = $_GET['dateDeb'];
	$dateFin = $_GET['dateFin'];
	
	$idCapteur1 = $_GET['idCapteur1'];
	$idLibVal1 = $_GET['idLibVal1'];
	$idPiece = $_GET['idPiece'];
	
	$nbData = $_GET['nbData'];

	$resultats=$connection->query("	SELECT count(valeur) as TOTAL
									FROM valeurmesure, mesure, localiser 
									WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
									AND mesure.Capteur_idCapteur = localiser.Capteur_idCapteur
									AND mesure.Capteur_idCapteur = '$idCapteur1' 
									AND LibVal_idLibVal = '$idLibVal1' 
									AND Piece_idPiece = $idPiece
									AND mesure.DateMesure BETWEEN TO_DATE('$dateDeb','yyyy-mm-dd hh24:mi:ss') AND TO_DATE('$dateFin','yyyy-mm-dd hh24:mi:ss')");
																	
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$res = $resultats->fetch();
	$stats = "	Hour : ". ceil((($res->TOTAL)/2))*$nbData ." <br>
				Day : ". ceil(($res->TOTAL)/2/24)*$nbData ." <br>
				Week : ". ceil(($res->TOTAL)/2/24/7)*$nbData ." <br>
				Month : ". ceil(($res->TOTAL)/2/24/30)*$nbData ." <br>
				Year : ". ceil(($res->TOTAL)/2/24/30/12)*$nbData ;
	echo $stats;
?>