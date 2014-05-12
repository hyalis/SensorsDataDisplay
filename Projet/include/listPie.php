<?php
	include "bdd.php";
	$resultats=$connection->query("	SELECT idPiece, nom, count(idCapteur) as nbPiece
														FROM piece, capteur, localiser
														WHERE Piece_idPiece = idPiece
														AND Capteur_idCapteur = idCapteur
															UNION
														SELECT idPiece, nom, 0
														FROM piece, capteur, localiser
														WHERE idPiece NOT IN (
															SELECT DISTINCT Piece_idPiece
															FROM localiser
														)");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'.$resultat->nom.'</td>
						<td>'.$resultat->nbPiece.'</td>
						<td>
							<a href="#"><span class="glyphicon glyphicon-remove" onClick="removeBat('.$resultat->idPiece.')"></a>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editBatModal" onClick="editBat('.$resultat->idPiece.')"></span></a>
							<a href="editP?idBatiment='.$resultat->idPiece.'"><span class="glyphicon glyphicon-home"></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>