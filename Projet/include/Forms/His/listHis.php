<?php
	include "./bdd.php";
	$idSensor = $_GET['idSensor'];
	$resultats=$connection->query("	SELECT IDLOCALISER, TO_CHAR(DATED,'yyyy-mm-dd hh:mi:ss') as DATED, TO_CHAR(DATEF,'yyyy-mm-dd hh:mi:ss') as DATEF, PIECE.NOM AS NOMPIECE
									FROM localiser, Piece
									WHERE Piece_idPiece = idPiece
									AND Capteur_idCapteur = $idSensor
									ORDER BY DATED");

	
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