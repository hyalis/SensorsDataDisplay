<?php
	include "bdd.php";
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
							<a href="./include/remCap.php?idCap='.$resultat->idCapteur.'&idPiece='.$idPiece.'"><span class="glyphicon glyphicon-remove"></a>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editCapModal" onClick="editCap('.$resultat->idCapteur.')"></span></a>
							<a href="./include/sortirCapteur.php?idCap='.$resultat->idCapteur.'&idPiece='.$idPiece.'"><span class="glyphicon glyphicon-share-alt"></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>