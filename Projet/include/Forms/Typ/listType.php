<?php
	include "./bdd.php";
	$resultats=$connection->query("	SELECT NOMTYPE, IDTYPECAPTEUR ,count(*) as NUMBERMEASURE 
														FROM TYPECAPTEUR, LIBVAL 
														WHERE IDTYPECAPTEUR = TYPECAPTEUR_IDTYPECAPTEUR
														GROUP BY TYPECAPTEUR_IDTYPECAPTEUR
														UNION
														SELECT NOMTYPE, IDTYPECAPTEUR,0 from typecapteur
														WHERE IDTYPECAPTEUR NOT IN (SELECT DISTINCT TYPECAPTEUR_IDTYPECAPTEUR 
																					FROM libval)
														");
	//SELECT count(*) FROM libval WHERE TypeCapteur_idTypeCapteur group by TypeCapteur_idTypeCapteur
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'.$resultat->NOMTYPE.'</td>
						<td>'.$resultat->NUMBERMEASURE.'</td>
						<td>
							<a href="#"></span><span class="glyphicon glyphicon-wrench" data-toggle="modal" data-target="#editTypeModal" onClick="editType('.$resultat->IDTYPECAPTEUR.')"></span></a> 
							<a href="index.php?p=Forms/Lab/editL&idTypeCapteur='.$resultat->IDTYPECAPTEUR.'"></span><span class="glyphicon glyphicon-plus-sign"  ></span></a> ';
			if($resultat->NUMBERMEASURE ==0)
				echo		'<a href="./include/Forms/Typ/remType.php?idTypeCapteur='.$resultat->IDTYPECAPTEUR.'"><span class="glyphicon glyphicon-remove" </a> ';
			echo 		'</td>
					</tr>';
	}
	$resultats->closeCursor(); 
?>