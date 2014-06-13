<?php
	include "./bdd.php";
	$resultats=$connection->query("	SELECT IDBATIMENT, batiment.NOM, ADRESSE, CP, VILLE, count(idPiece) as NBPIECE
														FROM batiment, piece 
														WHERE Batiment_idBatiment = idBatiment
														GROUP BY IDBATIMENT, batiment.NOM, ADRESSE, CP, VILLE
															UNION
														SELECT idBatiment, batiment.nom, adresse, cp, ville, 0 FROM batiment
														WHERE idBatiment NOT IN (	SELECT DISTINCT Batiment_idBatiment 
																					FROM piece
																				)
														");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'.$resultat->NOM .'</td>
						<td>'.$resultat->ADRESSE .'</td>
						<td>'.$resultat->CP .'</td>
						<td>'.$resultat->VILLE .'</td>
						<td>'.$resultat->NBPIECE .'</td>
						<td>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editBatModal" onClick="editBat('.$resultat->IDBATIMENT.')"></span></a>
							<a href="index.php?p=Forms/Pie/editP&idBatiment='.$resultat->IDBATIMENT.'"><span class="glyphicon glyphicon-home"></a> ';
							
			if ($resultat->NBPIECE == 0) 
				echo 		"<a href='#'><span class='glyphicon glyphicon-remove' onClick='confirmer($resultat->IDBATIMENT);'></span></a> " ;
			echo '		</td>
					</tr>';
					
	}
	$resultats->closeCursor(); 
?>