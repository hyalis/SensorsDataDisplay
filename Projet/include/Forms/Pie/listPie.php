<?php
	include "bdd.php";
	$idBatiment = $_GET['idBatiment'];
	$resultats=$connection->query("	SELECT IDPIECE, NOM, count(idCapteur) as NBPIECE
														FROM piece, capteur, localiser
														WHERE Piece_idPiece = idPiece
														AND Capteur_idCapteur = idCapteur
														AND Batiment_idBatiment = $idBatiment
														AND dateF IS NULL
														GROUP BY IDPIECE, NOM
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
		if($resultat->NOM != "")
			echo	'<tr>
						<td>'.$resultat->NOM.'</td>
						<td>'.$resultat->NBPIECE.'</td>
						<td>
							<a href="#"><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editPieModal" onClick="editPie('.$resultat->IDPIECE.')"></span></a>
							<a href="index.php?p=Forms/Cap/editC&idPiece='.$resultat->IDPIECE.'"><span class="glyphicon glyphicon-signal"></span></a> ';
			if ($resultat->NBPIECE ==0)
				echo 		' <a href="./include/Forms/Pie/remPie.php?idPiece='.$resultat->IDPIECE.'&idBatiment='.$idBatiment.'"><span class="glyphicon glyphicon-remove"></span></a> ';
			echo 		'</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>