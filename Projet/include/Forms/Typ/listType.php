<?php
	include "./bdd.php";
	$resultats=$connection->query("	SELECT NOMTYPE, IDTYPECAPTEUR ,count(*) as NBMESURE 
														FROM TYPECAPTEUR, LIBVAL 
														WHERE idTypecapteur = TypeCapteur_idTypeCapteur
														GROUP BY NOMTYPE, IDTYPECAPTEUR 
														UNION
														SELECT NOMTYPE, IDTYPECAPTEUR,0 FROM typecapteur
														WHERE idTypecapteur NOT IN (SELECT DISTINCT TypeCapteur_idTypeCapteur 
																					FROM LIBVAL)
														");
														
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'. $resultat->NOMTYPE .'</td>
						<td>'. $resultat->NBMESURE .'</td>
						<td>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editTypeModal" onClick="editType('. $resultat->IDTYPECAPTEUR .')"></span></a> 
							<a href="index.php?p=Forms/Lab/editL&idTypeCapteur='. $resultat->IDTYPECAPTEUR .'"></span><span class="glyphicon glyphicon-plus-sign"  ></span></a> ';
			if($resultat->NBMESURE == 0)
				echo		'<a href="./include/Forms/Typ/remType.php?idTypeCapteur='. $resultat->IDTYPECAPTEUR .'"><span class="glyphicon glyphicon-remove" </a> ';
			echo 		'</td>
					</tr>';
	}
	$resultats->closeCursor(); 
?>