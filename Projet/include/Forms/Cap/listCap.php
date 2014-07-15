<?php
	include "./bdd.php";
	$idPiece = $_GET['idPiece'];
	// Requête retournant la liste des capteur présent dans la pièce
	$resultats=$connection->query("	SELECT IDCAPTEUR, NOMCAPTEUR, NOMTYPE 
									FROM Capteur, TypeCapteur, Localiser
									WHERE TypeCapteur_idTypeCapteur = idTypeCapteur 
									AND Capteur_idCapteur = idCapteur
									AND Piece_idPiece = $idPiece
									AND dateF IS NULL");
														
																											
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	// Création des éléments du tableau en fonction de la réponse de la requête
	while( $resultat = $resultats->fetch() )
	{
		if($resultat->NOMCAPTEUR != "")
			echo	'<tr>
						<td>'.$resultat->NOMCAPTEUR.'</td>
						<td>'.$resultat->NOMTYPE.'</td>
						<td>
							<a href="#"><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editCapModal" onClick="editCap('.$resultat->IDCAPTEUR.')"></span></a>
							<a href="./include/Forms/Cap/sortirCapteur.php?idCap='.$resultat->IDCAPTEUR.'&idPiece='.$idPiece.'"><span class="glyphicon glyphicon-share-alt"></span></a>
							<a href="#"><span class="glyphicon glyphicon-remove" onClick="confirmer('.$resultat->IDCAPTEUR .', '.$idPiece.' )";></span></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>