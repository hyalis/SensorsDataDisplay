<?php
	include "./bdd.php";
	
	$idTypeCapteur = $_GET['idTypeCapteur'];
	$resultats=$connection->query(" SELECT LIBELLE, DESCRIPTION, UNITE, IDLIBVAL
										FROM LIBVAL
<<<<<<< HEAD
										WHERE TypeCapteur_idTypeCapteur = $idTypeCapteur ");
=======
										WHERE TypeCapteur_idTypeCapteur = $idTypeCapteur ;");
>>>>>>> dcad84308c92531790d0abea5e58f07441d8c0a6
	
	//SELECT count(*) FROM libval WHERE TypeCapteur_idTypeCapteur group by TypeCapteur_idTypeCapteur
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
<<<<<<< HEAD
						<td>'.$resultat->LIBELLE .'</td>
						<td>'.$resultat->DESCRIPTION .'</td>
						<td>'.$resultat->UNITE .'</td>
=======
						<td>'. $resultat->LIBELLE. '</td>
						<td>'. $resultat->DESCRIPTION. '</td>
						<td>'. $resultat->UNITE .'</td>
>>>>>>> dcad84308c92531790d0abea5e58f07441d8c0a6
						<td>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editLabelModal" onClick="editLabel('. $resultat->IDLIBVAL .')"></span></a>
							<a href="./include/Forms/Lab/remLab.php?idLibVal='. $resultat->IDLIBVAL .'&idTypeCapteur='. $idTypeCapteur .'"><span class="glyphicon glyphicon-remove"></a>
						</td>
					</tr>';
	}
	$resultats->closeCursor(); 
?>