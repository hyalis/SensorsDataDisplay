﻿<?php
	include "./bdd.php";
	$resultats=$connection->query("	SELECT nomType, idTypeCapteur,count(*) as numberMeasure 
														FROM typecapteur, libval 
														where idTypeCapteur = TypeCapteur_IdTypeCapteur
														group by TypeCapteur_idTypeCapteur
														UNION
														SELECT nomType, idTypeCapteur,0 from typecapteur
														WHERE idTypeCapteur NOT IN (SELECT DISTINCT TypeCapteur_idTypeCapteur 
																					FROM libval)
															;");
	//SELECT count(*) FROM libval WHERE TypeCapteur_idTypeCapteur group by TypeCapteur_idTypeCapteur
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'.$resultat->nomType.'</td>
						<td>'.$resultat->numberMeasure.'</td>
						<td>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editTypeModal" onClick="editType('.$resultat->idTypeCapteur.')"></span></a> 
							<a href="index.php?p=Forms/Lab/editL&idTypeCapteur='.$resultat->idTypeCapteur.'"></span><span class="glyphicon glyphicon-plus-sign"  ></span></a> ';
			if($resultat->numberMeasure ==0)
				echo		'<a href="./include/Forms/Typ/remType.php?idTypeCapteur='.$resultat->idTypeCapteur.'"><span class="glyphicon glyphicon-remove" </a> ';
			echo 		'</td>
					</tr>';
	}
	$resultats->closeCursor(); 
?>