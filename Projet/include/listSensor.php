<?php
	include "bdd.php";
	$resultats=$connection->query("	SELECT nomType, idTypeCapteur FROM typecapteur;");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
			echo	'<tr>
						<td>'.$resultat->nomType.'</td>
						<td><a href="#"><span class="glyphicon glyphicon-remove" style="margin-right:15px;" onClick="removeSensor('.$resultat->idTypeCapteur.')"></a><a href="#"></span><span class="glyphicon glyphicon-wrench"></span></a></td>
					</tr>';
	}
	$resultats->closeCursor(); 
?>