<?php
	include "./bdd.php";
	
	$resultats=$connection->query("	SELECT DISTINCT   idBatiment, Batiment.nom as nomBat , idPiece ,Piece.nom as nomPie, idTypeCapteur, nomType, idLibVal, libelle, idCapteur, nomCapteur
									FROM Batiment , Piece , localiser, capteur, typeCapteur, libval 
									WHERE Batiment_idBatiment = idBatiment
									AND idPiece = Piece_idPiece
									AND Capteur_idCapteur = idCapteur
									AND Capteur.TypeCapteur_idTypeCapteur = idTypeCapteur
									AND idTypeCapteur = libval.TypeCapteur_idTypeCapteur
									ORDER BY idBatiment, idPiece, idTypeCapteur, idLibval , idCapteur
									");
									
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	$json = "";
	$jsonC = "";
	$etat = 1;
	$bat = "";
	$pie = "";
	$typ = "";
	$lib = "";
	$tempId = "";
	$libelle = "";
	
	$resultat = $resultats->fetch();
	
	while($resultat)
	{
		switch($etat){
			case 1 : 	$json = $json .	"{'id':'bat',
										'title':'" . $resultat->nomBat . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$bat = $resultat->idBatiment;
						$etat = 2;
				break;
			case 2 :	$json = $json .	"{'id':'pie',
										'title':'" . $resultat->nomPie . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$pie = $resultat->idPiece;
						$etat = 3;
				break;
			case 3 :	$json = $json .	"{'id':'typ',
										'title':'" . $resultat->nomType . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$typ = $resultat->idTypeCapteur;
						$etat = 4;
				break;
			case 4 :	//$jsonC = $jsonC .	"{'id':'xxx" . $resultat->idPiece ."xxx" . $resultat->idTypeCapteur ."xxx" . $resultat->idLibVal ."xxx". $resultat->idCapteur."',
						$jsonC = $jsonC .	"{'id':'cap',
										'title':'" . $resultat->nomCapteur . "',
										'has_children':false,
										'level': 5,
										'children':[]}";
										
						$lib = $resultat->idLibVal ;
						$libelle = $resultat->libelle ;
						$cap = $resultat->idCapteur ;
						
						$resultat = $resultats->fetch();
						if($resultat && $bat == $resultat->idBatiment) {
							if($pie == $resultat->idPiece) {
								if($typ == $resultat->idTypeCapteur) {
									if($lib == $resultat->idLibVal){
										$tempId = $tempId ."xxx". $cap ;
										$jsonC = $jsonC .	",";
										$etat = 4;
									} else {
										
										$json = $json .	"{'id':'xxx".$pie."xxx".$lib.$tempId."xxx".$cap."',
														'title':'". $libelle ."',
														'has_children':true,
														'level': 4,
														'children':[". $jsonC ."]},";
										$jsonC = "";
										$tempId = "";
										$etat = 4;
									}
									
								} else {
									$json = $json .	"{'id':'xxx".$pie."xxx".$lib.$tempId."xxx".$cap."',
													'title':'". $libelle ."',
													'has_children':true,
													'level': 4,
													'children':[". $jsonC ."]}]},";
									$jsonC = "";
									$tempId = "";
									$etat = 3;
								}
							} else {
								$json = $json ."{'id':'xxx".$pie."xxx".$lib.$tempId."xxx".$cap."',
												'title':'". $libelle ."',
												'has_children':true,
												'level': 4,
												'children':[". $jsonC ."]}]}]},";
								$jsonC = "";
								$tempId = "";
								$etat = 2;
							}
						} else {
							$json = $json .	"{'id':'xxx".$pie."xxx".$lib.$tempId."xxx".$cap."',
											'title':'". $libelle ."',
											'has_children':true,
											'level': 4,
											'children':[". $jsonC ."]}]}]}]},";
							$jsonC = "";
							$tempId = "";
							$etat = 1;
						}
				
			
				
		}
	}
	echo substr($json, 0, strlen($json)-1);
	$resultats->closeCursor();
?>