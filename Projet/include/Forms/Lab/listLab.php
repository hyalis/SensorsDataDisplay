<?php
	include "./bdd.php";
	
	$idTypeCapteur = $_GET['idTypeCapteur'];
	$resultats=$connection->query(" SELECT libelle, description, unite, idLibVal
										FROM libval
										WHERE TypeCapteur_idTypeCapteur = $idTypeCapteur ;");
	
	//SELECT count(*) FROM libval WHERE TypeCapteur_idTypeCapteur group by TypeCapteur_idTypeCapteur
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'.$resultat->libelle.'</td>
						<td>'.$resultat->description.'</td>
						<td>'.$resultat->unite.'</td>
						<td>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editLabelModal" onClick="editLabel('.$resultat->idLibVal.')"></span></a>
							<a href="./include/Forms/Lab/remLab.php?idLibVal='.$resultat->idLibVal.'&idTypeCapteur='.$idTypeCapteur.'"><span class="glyphicon glyphicon-remove"></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 
?>