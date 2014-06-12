<?php
	include "./bdd.php";
	$idSensor = $_GET['idSensor'];
	$resultats=$connection->query("	SELECT IDLOCALISER, DATED, DATEF , PIECE.NOM AS NOMPIECE
										FROM piece, capteur, localiser
										WHERE Piece_idPiece = idPiece
										AND Capteur_idCapteur = $idSensor
										GROUP BY IDLOCALISER , NOMPIECE, DATED, DATEF");

	
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'.$resultat->NOMPIECE.'</td>
						<td>'.$resultat->DATED.'</td>';
			if($resultat->DATEF == "")
				echo	'<td>Is in service</td>' ;
			else
				echo	'<td>'.$resultat->DATEF.'</td>';
			echo 	'</tr>';
	}
	$resultats->closeCursor(); 

?>