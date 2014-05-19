<?php
	include "./bdd.php";
	$resultats=$connection->query("	SELECT idBatiment, Batiment.nom as nomBat, idPiece, Piece.nom as nomPie, idCapteur, nomCapteur, idLibVal, libelle
									FROM Batiment, Piece, localiser, capteur, typeCapteur, LibVal
									WHERE Batiment_idBatiment = idBatiment
									AND idPiece = Piece_idPiece
									AND Capteur_idCapteur = idCapteur
									AND Capteur.TypeCapteur_idTypeCapteur = idTypeCapteur
									AND idTypeCapteur = libval.TypeCapteur_idTypeCapteur
									AND dateF IS NULL
									ORDER BY idBatiment, idPiece, idCapteur, idLibVal");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	$json = "";
	$etat = 1;
	$bat = "";
	$pie = "";
	$cap = "";
	
	$resultat = $resultats->fetch();
	
	while($resultat)
	{
		switch($etat){
			case 1 : 	$json = $json .	"{'id':'bat" . $resultat->idBatiment . "',
										'title':'" . $resultat->nomBat . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$bat = $resultat->idBatiment;
						$etat = 2;
				break;
			case 2 :	$json = $json .	"{'id':'pie" . $resultat->idPiece . "',
										'title':'" . $resultat->nomPie . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$pie = $resultat->idPiece;
						$etat = 3;
				break;
			case 3 : 	$json = $json .	"{'id':'cap" . $resultat->idCapteur . "',
										'title':'" . $resultat->nomCapteur . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$cap = $resultat->idCapteur;
						$etat = 4;
				break;
			case 4 :	$json = $json .	"{'id':'lib" . $resultat->idLibVal . "',
										'title':'" . $resultat->libelle . "',
										'has_children':false,
										'level': $etat,
										'children':[]}";
						$resultat = $resultats->fetch();
						if($resultat && $bat == $resultat->idBatiment) {
							if($pie == $resultat->idPiece) {
								if($cap == $resultat->idCapteur) {
									$json = $json .	",";
									$etat = 4;
								} else {
									$json = $json .	"]},";
									$etat = 3;
								}
							} else {
								$json = $json .	"]}]},";
								$etat = 2;
							}
						} else {
							$json = $json .	"]}]}]},";
							$etat = 1;
						}		
		}
	}
	
	echo substr($json, 0, strlen($json)-1);
	$resultats->closeCursor();
?>