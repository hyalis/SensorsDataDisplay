<?php
	include "bdd.php";
	$idBatiment = $_GET['idBatiment'];
	$resultats=$connection->query("	SELECT idPiece, nom, count(idCapteur) as nbPiece
														FROM piece, capteur, localiser
														WHERE Piece_idPiece = idPiece
														AND Capteur_idCapteur = idCapteur
														AND Batiment_idBatiment = $idBatiment
															UNION
														SELECT idPiece, nom, 0
														FROM piece
														WHERE idPiece NOT IN (
															SELECT DISTINCT Piece_idPiece
															FROM localiser
														)
														AND Batiment_idBatiment = $idBatiment");

	
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	while( $resultat = $resultats->fetch() )
	{
		if($resultat->nom != "")
			echo	'<tr>
						<td>'.$resultat->nom.'</td>
						<td>'.$resultat->nbPiece.'</td>
						<td>
							<a href="./include/remPie.php?idPiece='.$resultat->idPiece.'&idBatiment='.$idBatiment.'"><span class="glyphicon glyphicon-remove"></a>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editPieModal" onClick="editPie('.$resultat->idPiece.')"></span></a>
							<a href="index.php?p=editS&idPiece='.$resultat->idPiece.'"><span class="glyphicon glyphicon-signal"></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>