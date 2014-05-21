<?php
	include "../bdd.php";
	
	$nbArgs = sizeof($_GET);	
	$params = array_values($_GET);

	$dateDeb = $_GET['dateDeb'];
	$dateFin = $_GET['dateFin'];
	$groupBy = $_GET['groupBy'];
	
	
	for($i = 2; $i <= $nbArgs - 2; $i = $i + 2){
		//DEBUG
		//echo "Capteur" . ($i/2) . " = " . $params[$i] . "<br>";
		//echo "LibVal" . ($i/2) . " = " . $params[$i+1] . "<br>";
		//Remplissage du tableau
		$capteur[($i/2)-1][0] = $params[$i];
		$capteur[($i/2)-1][1] = $params[$i+1];
	}
	
	
	/*
	if(!empty($_GET['dateDeb']) && !empty($_GET['dateFin']) && !empty($_GET['idCapteur1']) && !empty($_GET['idLibVal1']) && !empty($_GET['idCapteur2']) && !empty($_GET['idLibVal2']) && !empty($_GET['idCapteur3']) && !empty($_GET['idLibVal3']) && !empty($_GET['groupBy'])){
		$dateDeb = $_GET['dateDeb'];
		$dateFin = $_GET['dateFin'];
		
		$idCapteur1 = $_GET['idCapteur1'];
		$idLibVal1 = $_GET['idLibVal1'];
		
		$idCapteur2 = $_GET['idCapteur2'];
		$idLibVal2 = $_GET['idLibVal2'];
		
		$idCapteur3 = $_GET['idCapteur3'];
		$idLibVal3 = $_GET['idLibVal3'];
		
		$groupBy = $_GET['groupBy'];
	} else {
		$dateDeb = '2010-12-01';
		$dateFin = '2010-12-02';
		
		$idCapteur1 = 5;
		$idLibVal1 = 17;
		
		$idCapteur2 = 2;
		$idLibVal2 = 6;
		
		$idCapteur3 = 8;
		$idLibVal3 = 25;
		
		$groupBy = "";
	}*/
	
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
	}
		

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
	
	$resultats->closeCursor(); 

	echo "END";
	
	
	//echo "<br><br><br><br><br>LINE REQQQq !!!!! <br><br><br><br>";
	
	
	
	
	$lineReq = "SELECT LEFT(T1.date,13) as dateMesure ";

	for($i = 0; $i < sizeof($capteur); $i++){
		$lineReq = $lineReq . ", ROUND(AVG(T" . ($i+1) . ".V" . ($i+1) . "),2) as Value" . $i;
	}

	$lineReq = $lineReq . " FROM ";

	for($i = 0; $i < sizeof($capteur); $i++){
		$lineReq = $lineReq . "(	SELECT valeur as V" . ($i+1) . ", mesure.date FROM valeurmesure, mesure 
									WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
									AND Capteur_idCapteur = " . $capteur[$i][0] . "
									AND LibVal_idLibVal = " . $capteur[$i][1] . "
									AND mesure.date BETWEEN '$dateDeb%' AND '$dateFin%' ) T" . ($i+1) . ",";
	}
	$lineReq = substr($lineReq, 0, strlen($lineReq)-1);
	
	if(sizeof($capteur)>1){
		$lineReq = $lineReq . "	WHERE";
		for($i = 0; $i < sizeof($capteur) - 1; $i++){
			$lineReq = $lineReq . " T" . ($i+1) . ".date = T" . ($i+2) . ".date AND";
		}
	}

	$lineReq = substr($lineReq, 0, strlen($lineReq)-3);
	
	$lineReq = $lineReq . "$grbStr;";
							
							
							
	//echo "#6  = " . $lineReq . "<br><br><br>"; 
	
	//echo "<br><br><br><br><br>FINNNNNNNNNNNNNNNNNNNNNNNNNN REQQQq !!!!! <br><br><br><br>";

	
	
	
	
	$resultats=$connection->query($lineReq);
									
									

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