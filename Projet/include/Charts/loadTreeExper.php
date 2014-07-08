<?php
	include "./bdd.php";
	
	$resultats=$connection->query("	SELECT DISTINCT   IDBATIMENT, Batiment.nom as NOMBAT , IDPIECE ,Piece.nom as NOMPIE, IDTYPECAPTEUR, NOMTYPE, IDLIBVAL, LIBELLE, IDCAPTEUR, NOMCAPTEUR
									FROM Batiment , Piece , localiser, capteur, typeCapteur, libval 
									WHERE Batiment_idBatiment = idBatiment
									AND idPiece = Piece_idPiece
									AND Capteur_idCapteur = idCapteur
									AND Capteur.TypeCapteur_idTypeCapteur = idTypeCapteur
									AND idTypeCapteur = libval.TypeCapteur_idTypeCapteur
									ORDER BY IDBATIMENT, IDPIECE, IDTYPECAPTEUR, IDLIBVAL , IDCAPTEUR
									");
									
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	$json = "";
	$jsonC = "";
	$etat = 1;
	$bat = "";
	$pie = "";
	$typ = "";
	$idlibval = "";
	$tempId = "";
	$libelle = "";
	
	$resultat = $resultats->fetch();
	
	while($resultat)
	{
		switch($etat){
			case 1 : 	$json = $json .	"{'id':'bat',
										'title':'" . $resultat->NOMBAT . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$bat = $resultat->IDBATIMENT;
						$etat = 2;
				break;
			case 2 :	$json = $json .	"{'id':'pie',
										'title':'" . $resultat->NOMPIE . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$pie = $resultat->IDPIECE;
						$etat = 3;
				break;
			case 3 :	$json = $json .	"{'id':'typ',
										'title':'" . $resultat->NOMTYPE . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$typ = $resultat->IDTYPECAPTEUR;
						$etat = 4;
				break;
			case 4 :	//$jsonC = $jsonC .	"{'id':'xxx" . $resultat->idPiece ."xxx" . $resultat->idTypeCapteur ."xxx" . $resultat->idLibVal ."xxx". $resultat->idCapteur."',
						$jsonC = $jsonC .	"{'id':'capsup',
										'title':'" . str_replace("."," ","$resultat->NOMCAPTEUR") . "',
										'has_children':false,
										'level': 5,
										'children':[]}";
										
						$idlibval= $resultat->IDLIBVAL ;
						$libelle =  $resultat->NOMPIE . " - " . $resultat->LIBELLE ;
						$cap = $resultat->IDCAPTEUR ;
						
						$resultat = $resultats->fetch();
						if($resultat && $bat == $resultat->IDBATIMENT) {
							if($pie == $resultat->IDPIECE) {
								if($typ == $resultat->IDTYPECAPTEUR) {
									if($idlibval== $resultat->IDLIBVAL){
										$tempId = $tempId ."xxx". $cap ;
										$jsonC = $jsonC .	",";
										$etat = 4;
									} else {
										
										$json = $json .	"{'id':'xxx".$pie."xxx".$idlibval."',
														'title':'". $libelle ."',
														'has_children':true,
														'level': 4,
														'children':[". $jsonC ."]},";
										$jsonC = "";
										$tempId = "";
										$etat = 4;
									}
									
								} else {
									$json = $json .	"{'id':'xxx".$pie."xxx".$idlibval."',
													'title':'". $libelle ."',
													'has_children':true,
													'level': 4,
													'children':[". $jsonC ."]}]},";
									$jsonC = "";
									$tempId = "";
									$etat = 3;
								}
							} else {
								$json = $json ."{'id':'xxx".$pie."xxx".$idlibval."',
												'title':'". $libelle ."',
												'has_children':true,
												'level': 4,
												'children':[". $jsonC ."]}]}]},";
								$jsonC = "";
								$tempId = "";
								$etat = 2;
							}
						} else {
							$json = $json .	"{'id':'xxx".$pie."xxx".$idlibval."',
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