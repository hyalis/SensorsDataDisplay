<?php
	include "./bdd.php";
	$idPiece = $_GET['idPiece'];
	// Requ�te retournant la liste des capteur pr�sent dans la pi�ce
	$resultats=$connection->query("	SELECT IDCAPTEUR, NOMCAPTEUR, NOMTYPE 
									FROM Capteur, TypeCapteur, Localiser
									WHERE TypeCapteur_idTypeCapteur = idTypeCapteur 
									AND Capteur_idCapteur = idCapteur
									AND Piece_idPiece = $idPiece
									AND dateF IS NULL");
														
																											
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	// Cr�ation des �l�ments du tableau en fonction de la r�ponse de la requ�te
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