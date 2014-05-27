<?php
	include "../bdd.php";
	
	$nbArgs = sizeof($_GET);
	$params = array_values($_GET);

	$dateDeb = $_GET['dateDeb'];
	$dateFin = $_GET['dateFin'];
	$groupBy = $_GET['groupBy'];
	
	
	for($i = 2; $i <= $nbArgs - 2; $i = $i + 3){
		//DEBUG
		//echo "idPiece" . (($i+1)/3) . " = " . $params[$i] . "<br>";
		//echo "Capteur" . (($i+1)/3) . " = " . $params[$i+1] . "<br>";
		//echo "LibVal" . (($i+1)/3) . " = " . $params[$i+2] . "<br>";
		
		//Remplissage du tableau
		$capteur[(($i+1)/3)-1][0] = $params[$i];
		$capteur[(($i+1)/3)-1][1] = $params[$i+1];
		$capteur[(($i+1)/3)-1][2] = $params[$i+2];
	}
	
	$grbStr = "";
	
	switch($groupBy){
		case "YEAR" :	$grbStr = " GROUP BY YEAR(T1.date) ";
			break;
		case "MONTH" :	$grbStr = " GROUP BY YEAR(T1.date), MONTH(T1.date) ";
			break;
		case "WEEK" :	$grbStr = " GROUP BY YEAR(T1.date), MONTH(T1.date), WEEK(T1.date) ";
			break;
		case "DAY" :	$grbStr = " GROUP BY YEAR(T1.date), MONTH(T1.date), DAY(T1.date) ";
			break;
		case "HOUR" :	$grbStr = " GROUP BY YEAR(T1.date), MONTH(T1.date), DAY(T1.date), HOUR(T1.date) ";
			break;
		case "MIN" :	$grbStr = " GROUP BY YEAR(T1.date), MONTH(T1.date), DAY(T1.date), HOUR(T1.date), MINUTE(T1.date) ";
			break;
		case "SEC" : 	$grbStr = " GROUP BY YEAR(T1.date), MONTH(T1.date), DAY(T1.date), HOUR(T1.date), MINUTE(T1.date), SECOND(T1.date) ";
			break;
	}
		
/*
	$resultats=$connection->query("	SELECT T1.x, Tab2.y, Tab3.value
								FROM 	(SELECT valeur as x, mesure.date 		FROM valeurmesure, mesure WHERE valeurmesure.Mesure_idMesure = mesure.idMesure AND capteur_idCapteur = " . $capteur[0][0] . " AND LibVal_idLibVal = ".$capteur[0][1] . " AND mesure.date BETWEEN '$dateDeb%' AND '$dateFin%' ) T1,
										(SELECT valeur as y, mesure.date 		FROM valeurmesure, mesure WHERE valeurmesure.Mesure_idMesure = mesure.idMesure AND capteur_idCapteur = " . $capteur[1][0] . " AND LibVal_idLibVal = ".$capteur[1][1] . " AND mesure.date BETWEEN '$dateDeb%' AND '$dateFin%') Tab2,
										(SELECT valeur as value, mesure.date 	FROM valeurmesure, mesure WHERE valeurmesure.Mesure_idMesure = mesure.idMesure AND capteur_idCapteur = " . $capteur[2][0] . " AND LibVal_idLibVal = ".$capteur[2][1] . " AND mesure.date BETWEEN '$dateDeb%' AND '$dateFin%') Tab3
								WHERE T1.date = Tab2.date
								AND Tab2.date = Tab3.date
								$grbStr
								ORDER BY Tab3.value DESC;");
											
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	$test = true;
	while( $resultat = $resultats->fetch() )
	{
		if($test){
			echo	'	{
							"y" : ' . $resultat->y .',
							"x" : ' . $resultat->x .',
							"value" : ' . $resultat->value .'
			
						}';
			$test = false;
		} else {
			echo	'	,{
							"y" : ' . $resultat->y .',
							"x" : ' . $resultat->x .',
							"value" : ' . $resultat->value .'
			
						}';
		}
	}
	
	$resultats->closeCursor(); */

	echo "END";
	
	$lineReq = "SELECT LEFT(T1.date,19) as dateMesure ";

	for($i = 0; $i < sizeof($capteur); $i++){
		$lineReq = $lineReq . ", ROUND(AVG(T" . ($i+1) . ".V" . ($i+1) . "),2) as Value" . $i;
	}

	$lineReq = $lineReq . " FROM ";

	for($i = 0; $i < sizeof($capteur); $i++){
		$lineReq = $lineReq . "(	SELECT valeur as V" . ($i+1) . ", mesure.date FROM valeurmesure, mesure, localiser
									WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
									AND localiser.capteur_idcapteur = mesure.capteur_idcapteur
									AND mesure.Capteur_idCapteur = " . $capteur[$i][1] . "
									AND LibVal_idLibVal = " . $capteur[$i][2] . "
									AND Piece_idPiece = " . $capteur[$i][0] . "
									AND mesure.date BETWEEN '$dateDeb%' AND '$dateFin%' ) T" . ($i+1) . ",";
	}
	
	$lineReq = substr($lineReq, 0, strlen($lineReq)-1);
	
	if(sizeof($capteur)>1){
		$lineReq = $lineReq . "	WHERE";
		for($i = 0; $i < sizeof($capteur) - 1; $i++){
			$lineReq = $lineReq . " T" . ($i+1) . ".date = T" . ($i+2) . ".date AND";
		}
		$lineReq = substr($lineReq, 0, strlen($lineReq)-3);
	}

	
	
	$lineReq = $lineReq . "$grbStr;";
							
	$resultats=$connection->query($lineReq);
	
	//echo $lineReq . "<br><br><br><br>";
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);

	$test = true;
	while( $resultat = $resultats->fetch() )
	{
		if($test){
			echo	'	{
						"date" : "' . $resultat->dateMesure .'", 
				';
			for($i = 0; $i < sizeof($capteur)-1; $i++){
				$name = "Value".$i;
				echo		'"' . $i . '" : "' . $resultat->$name . '",';	
			}	
			$name = "Value".$i;
			echo		'"' . $i . '" : "' . $resultat->$name . '"';
			echo "}";
			$test = false;
		} else {
			echo	'	,{
						"date" : "' . $resultat->dateMesure .'", 
				';
			for($i = 0; $i < sizeof($capteur)-1; $i++){
				$name = "Value".$i;
				echo		'"' . $i . '" : "' . $resultat->$name . '",';	
			}	
			$name = "Value".$i;
			echo		'"' . $i . '" : "' . $resultat->$name . '"';
			echo "}";
		}	
	}
	$resultats->closeCursor(); 
?>