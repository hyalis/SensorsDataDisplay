<?php
	include "./bdd.php";
	
	$resultats=$connection->query("	SELECT idTypeCapteur , nomType, idCapteur, nomCapteur, idLibVal, libelle
									FROM typecapteur, capteur, libval
									WHERE idTypeCapteur = capteur.TypeCapteur_idTypeCapteur
									AND libval.TypeCapteur_idTypeCapteur = idTypeCapteur
									ORDER BY idTypeCapteur, idCapteur, idlibval");
									
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	$json = "";
	$etat = 1;
	$typ = "";
	$cap = "";
	$mes = "";
	
	$resultat = $resultats->fetch();
	
	while($resultat)
	{
		switch($etat){
			case 1 : 	$json = $json .	"{'id':'typ',
										'title':'" . $resultat->nomType . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$typ = $resultat->idTypeCapteur;
						$etat = 2;
				break;
			case 2 :	$json = $json .	"{'id':'cap',
										'title':'" . $resultat->nomCapteur . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$cap = $resultat->idCapteur;
						$etat = 3;
				break;
			case 3 :	$json = $json .	"{'id':'xxx" . $resultat->idCapteur ."xxx" . $resultat->idLibVal ."',
										'title':'" . $resultat->libelle . "',
										'has_children':false,
										'level': $etat,
										'children':[]}";
						$resultat = $resultats->fetch();
						if($resultat && $typ == $resultat->idTypeCapteur) {
							if($cap == $resultat->idCapteur) {
								$json = $json .	",";
								$etat = 3;
							} else {
								$json = $json .	"]},";
								$etat = 2;
							}
						} else {
							$json = $json .	"]}]},";
							$etat = 1;
						}		
		}
	}
	echo substr($json, 0, strlen($json)-1);
	$resultats->closeCursor();
?>