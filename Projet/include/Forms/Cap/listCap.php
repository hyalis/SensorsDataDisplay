<?php
	include "./bdd.php";
	$idPiece = $_GET['idPiece'];
	$resultats=$connection->query("	SELECT idCapteur, nomCapteur, nomType 
									FROM Capteur, TypeCapteur, Localiser
									WHERE TypeCapteur_idTypeCapteur = idTypeCapteur 
									AND Capteur_idCapteur = idCapteur
									AND Piece_idPiece = $idPiece
									AND dateF IS NULL");
														
																											
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	while( $resultat = $resultats->fetch() )
	{
		if($resultat->nomCapteur != "")
			echo	'<tr>
						<td>'.$resultat->nomCapteur.'</td>
						<td>'.$resultat->nomType.'</td>
						<td>
							<a href="#"><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editCapModal" onClick="editCap('.$resultat->idCapteur.')"></span></a>
							<a href="./include/Forms/Cap/sortirCapteur.php?idCap='.$resultat->idCapteur.'&idPiece='.$idPiece.'"><span class="glyphicon glyphicon-share-alt"></span></a>
							<a href="./include/Forms/Cap/remCap.php?idCap='.$resultat->idCapteur.'&idPiece='.$idPiece.'"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>