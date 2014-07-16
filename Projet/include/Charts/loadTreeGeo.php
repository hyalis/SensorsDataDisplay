<?php
	include "./bdd.php";
	// On récupérer tous les capteur qui sont toujours en train de capter des données au moment présent
	$resultats=$connection->query("	SELECT IDBATIMENT, Batiment.nom as NOMBAT, IDPIECE, Piece.nom as NOMPIE, IDCAPTEUR, NOMCAPTEUR, IDLIBVAL, LIBELLE
									FROM Batiment, Piece, localiser, capteur, typeCapteur, LibVal
									WHERE Batiment_idBatiment = idBatiment
									AND idPiece = Piece_idPiece
									AND Capteur_idCapteur = idCapteur
									AND Capteur.TypeCapteur_idTypeCapteur = idTypeCapteur
									AND idTypeCapteur = libval.TypeCapteur_idTypeCapteur
									AND dateF IS NULL
									ORDER BY IDBATIMENT, IDPIECE, IDCAPTEUR, IDLIBVAL");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	$json = "";
	$etat = 1; // Correspond a la profondeur de l'arbre
	$bat = "";
	$pie = "";
	$cap = "";
	
	$resultat = $resultats->fetch();
	
	// Création du json pour notre treeselect
	// Seul les items sélectionnables ont des id unique
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
			case 3 : 	$json = $json .	"{'id':'cap',
										'title':'" . str_replace("."," ","$resultat->NOMCAPTEUR") . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$cap = $resultat->IDCAPTEUR;
						$etat = 4;
				break;
			case 4 :	$json = $json .	"{'id':'xxx" . $resultat->IDPIECE ."xxx" . $resultat->IDCAPTEUR . "xxx" . $resultat->IDLIBVAL . "',
										'title':'" . $resultat->IDCAPTEUR . " - " . $resultat->LIBELLE . "',
										'has_children':false,
										'level': $etat,
										'children':[]}";
						$resultat = $resultats->fetch();
						if($resultat && $bat == $resultat->IDBATIMENT) {
							if($pie == $resultat->IDPIECE) {
								if($cap == $resultat->IDCAPTEUR) {
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