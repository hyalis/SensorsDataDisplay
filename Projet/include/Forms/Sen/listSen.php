<?php
	include "./bdd.php";
	$resultats=$connection->query("	SELECT idCapteur, nomCapteur, nomType 
									FROM Capteur, TypeCapteur
									WHERE TypeCapteur_idTypeCapteur = idTypeCapteur ");
														
																											
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	while( $resultat = $resultats->fetch() )
	{
		if($resultat->nomCapteur != "")
			echo	'<tr>
						<td>'.$resultat->nomCapteur.'</td>
						<td>'.$resultat->nomType.'</td>
						<td>
							<a href="#"><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editSenModal" onClick="editSen('.$resultat->idCapteur.')"></span></a>
							<a href="./include/Forms/Sen/remSen.php?idSensor='.$resultat->idCapteur.'"><span class="glyphicon glyphicon-remove"></span></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>