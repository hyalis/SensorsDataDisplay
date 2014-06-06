<?php
	include "./bdd.php";
	$idPiece = $_GET['idPiece'];
	$resultats=$connection->query("	SELECT IDCAPTEUR, NOMCAPTEUR, NOMTYPE 
									FROM Capteur, TypeCapteur, Localiser
									WHERE TypeCapteur_idTypeCapteur = idTypeCapteur 
									AND Capteur_idCapteur = idCapteur
									AND Piece_idPiece = $idPiece
									AND dateF IS NULL");
														
																											
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	while( $resultat = $resultats->fetch() )
	{
		if($resultat->NOMCAPTEUR != "")
			echo	'<tr>
						<td>'.$resultat->NOMCAPTEUR.'</td>
						<td>'.$resultat->NOMTYPE.'</td>
						<td>
							<a href="#"><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editCapModal" onClick="editCap('.$resultat->IDCAPTEUR.')"></span></a>
							<a href="./include/Forms/Cap/sortirCapteur.php?idCap='.$resultat->IDCAPTEUR.'&idPiece='.$idPiece.'"><span class="glyphicon glyphicon-share-alt"></span></a>
							<a href="./include/Forms/Cap/remCap.php?idCap='.$resultat->IDCAPTEUR.'&idPiece='.$idPiece.'"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>