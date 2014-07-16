<?php
	include "./bdd.php";
	
	// Requête qui retourne la liste des typeCapteurs avec leurs noms, leurs identifiants, et leurs nombres de libVal
	$resultats=$connection->query("	SELECT NOMTYPE, IDTYPECAPTEUR ,count(*) as NBMESURE 
														FROM TYPECAPTEUR, LIBVAL 
														WHERE idTypecapteur = TypeCapteur_idTypeCapteur
														GROUP BY NOMTYPE, IDTYPECAPTEUR 
														UNION
														SELECT NOMTYPE, IDTYPECAPTEUR,0 FROM typecapteur
														WHERE idTypecapteur NOT IN (SELECT DISTINCT TypeCapteur_idTypeCapteur 
																					FROM LIBVAL)
														");
												
	// Création des éléments du tableau en fonction de la réponse de la requête
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	// Construction des éléments du tableau pour charts
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'. $resultat->NOMTYPE .'</td>
						<td>'. $resultat->NBMESURE .'</td>
						<td>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editTypeModal" onClick="editType('. $resultat->IDTYPECAPTEUR .')"></span></a> 
							<a href="index.php?p=Forms/Lab/editL&idTypeCapteur='. $resultat->IDTYPECAPTEUR .'"></span><span class="glyphicon glyphicon-plus-sign"  ></span></a> ';
			if($resultat->NBMESURE == 0)
				echo		'<a href="#"><span class="glyphicon glyphicon-remove" onClick="confirmer('. $resultat->IDTYPECAPTEUR .')";></span></a>';
			echo 		'</td>
					</tr>';
	}
	$resultats->closeCursor(); 
?>