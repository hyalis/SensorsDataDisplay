<?php
	include "./bdd.php";
	
	$idTypeCapteur = $_GET['idTypeCapteur'];
	$resultats=$connection->query(" SELECT LIBELLE, DESCRIPTION, UNITE, IDLIBVAL
										FROM LIBVAL
										WHERE TYPECAPTEUR8IDTYPECAPTEUR = $idTypeCapteur ");
	
	//SELECT count(*) FROM libval WHERE TypeCapteur_idTypeCapteur group by TypeCapteur_idTypeCapteur
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'.$resultat->LIBELLE.'</td>
						<td>'.$resultat->DESCRIPTION.'</td>
						<td>'.$resultat->UNITE.'</td>
						<td>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editLabelModal" onClick="editLabel('.$resultat->IDLIBVAL.')"></span></a>
							<a href="./include/Forms/Lab/remLab.php?idLibVal='.$resultat->IDLIBVAL.'&idTypeCapteur='.$idTypeCapteur.'"><span class="glyphicon glyphicon-remove"></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 
?>