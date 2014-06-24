<?php
	include "bdd.php";
	$idBatiment = $_GET['idBatiment'];
	$resultats=$connection->query("		SELECT IDPIECE, NOM, LAT , LNG , count(distinct idCapteur) as NBCAPTEURS
										FROM piece, capteur, localiser
										WHERE Piece_idPiece = idPiece
										AND Capteur_idCapteur = idCapteur
										AND Batiment_idBatiment = $idBatiment
                                        AND dateF IS NULL
                                        GROUP BY IDPIECE, NOM , LAT , LNG
												UNION
										SELECT IDPIECE, NOM, LAT , LNG , 0 as NBCAPTEURS
										FROM piece
										WHERE idPiece NOT IN (
											SELECT Piece_idPiece
											FROM localiser
											WHERE dateF IS NULL
											)
										AND Batiment_idBatiment = $idBatiment");

	
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	while( $resultat = $resultats->fetch() )
	{
		if($resultat->NOM != "")
			echo	'<tr>
						<td>'.$resultat->NOM.'</td>
						<td>'.$resultat->LAT.'</td>
						<td>'.$resultat->LNG.'</td>
						<td>'.$resultat->NBCAPTEURS.'</td>
						<td>
							<a href="#"><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editPieModal" onClick="editPie('.$resultat->IDPIECE.')"></span></a>
							<a href="index.php?p=Forms/Cap/editC&idPiece='.$resultat->IDPIECE.'"><span class="glyphicon glyphicon-signal"></span></a> ';
			if ($resultat->NBCAPTEURS ==0)
				echo 		" <a href='#'><span class='glyphicon glyphicon-remove' onClick='confirmer($resultat->IDPIECE,$idBatiment);'></span></a> ";
			echo 		'</td>
					</tr>';
	}
	$resultats->closeCursor(); 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	 
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
?>