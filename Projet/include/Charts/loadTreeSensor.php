<?php
	include "./bdd.php";
	
	// On r�cup�rer les informations ordonn�es (typeCapteur > idCapteur > idLibVal) n�cessaire a la construction de notre arbre 
	$resultats=$connection->query("	SELECT IDTYPECAPTEUR , NOMTYPE, IDCAPTEUR, NOMCAPTEUR, IDLIBVAL, LIBELLE
									FROM typecapteur, capteur, libval
									WHERE idTypeCapteur = capteur.TypeCapteur_idTypeCapteur
									AND libval.TypeCapteur_idTypeCapteur = idTypeCapteur
									ORDER BY IDTYPECAPTEUR, IDCAPTEUR, IDLIBVAL");
									
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	$json = "";
	$etat = 1; // Correspond a la profondeur de l'arbre
	$typ = "";
	$cap = "";
	$mes = "";
	
	$resultat = $resultats->fetch();
	
	// Cr�ation du json pour notre treeselect
	// Seul les items s�lectionnables ont des id unique
	while($resultat)
	{
		switch($etat){
			case 1 : 	$json = $json .	"{'id':'typ',
										'title':'" . $resultat->NOMTYPE . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$typ = $resultat->IDTYPECAPTEUR;
						$etat = 2;
				break;
			case 2 :	$json = $json .	"{'id':'cap',
										'title':'" . str_replace("."," ","$resultat->NOMCAPTEUR") . "',
										'has_children':true,
										'level': $etat,
										'children':[";
						$cap = $resultat->IDCAPTEUR;
						$etat = 3;
				break;
			case 3 :	$json = $json .	"{'id':'xxx" . $resultat->IDCAPTEUR ."xxx" . $resultat->IDLIBVAL ."',
										'title':'#" . $resultat->IDCAPTEUR . " [" . $resultat->LIBELLE . "]',
										'has_children':false,
										'level': $etat,
										'children':[]}";
						$resultat = $resultats->fetch();
						if($resultat && $typ == $resultat->IDTYPECAPTEUR) {
							if($cap == $resultat->IDCAPTEUR) {
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