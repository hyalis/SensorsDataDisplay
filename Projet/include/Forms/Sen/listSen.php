<?php
	include "./bdd.php";
	$resultats=$connection->query("	SELECT IDCAPTEUR, NOMCAPTEUR, NOMTYPE 
									FROM CAPTEUR, TYPECAPTEUR
									WHERE TypeCapteur_idTypeCapteur = idTypeCapteur ");
														
																											
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	while( $resultat = $resultats->fetch() )
	{
		if($resultat->NOMCAPTEUR != "")
			echo	'<tr>
						<td>'. $resultat->NOMCAPTEUR .'</td>
						<td>'. $resultat->NOMTYPE .'</td>
						<td>
							<a href="#"><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editSenModal" onClick="editSen('. $resultat->IDCAPTEUR .')"></span></a>
							<a href="index.php?p=Forms/His/editH&idSensor='. $resultat->IDCAPTEUR .'"><span class="glyphicon glyphicon-calendar"></span></a> 
							<a href="#"><span class="glyphicon glyphicon-remove" onClick="confirmer('. $resultat->IDCAPTEUR .')";></span></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 

?>