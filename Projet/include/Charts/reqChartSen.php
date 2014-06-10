<?php
	include "../bdd.php";
	
	$nbArgs = sizeof($_GET);
	$params = array_values($_GET);

	$dateDeb = $_GET['dateDeb'];
	$dateFin = $_GET['dateFin'];
	$groupBy = $_GET['groupBy'];
	
	// echo "<b>Paramètres</b><br><br>Date début : " . $dateDeb . "<br>Date fin : " . $dateFin . "<br>GroupBy : " . $groupBy . "<br>";
	// echo "<br><br><b>Les paramètres dynamiques</b><br>***********************<br><br>";
	
	for($i = 2; $i <= $nbArgs - 2; $i = $i + 2){
		//DEBUG
		// echo "idCapteur" . (($i)/2) . " = " . $params[$i] . "<br>";
		// echo "LibVal" . (($i)/2) . " = " . $params[$i+1] . "<br>";
		// echo "------------------<br>";
		
		//Remplissage du tableau
		$capteur[(($i)/2)-1][0] = $params[$i];
		$capteur[(($i)/2)-1][1] = $params[$i+1];
	}
	//echo "***********************<br><br>";
	$nbCourbes = sizeof($capteur);
	
	$grbStr = "";
	
	switch($groupBy){
		case "YEAR" :	$grbStr = " GROUP BY YEAR(dateMesure) ";
			break;
		case "MONTH" :	$grbStr = " GROUP BY YEAR(dateMesure), MONTH(dateMesure) ";
			break;
		case "WEEK" :	$grbStr = " GROUP BY YEAR(dateMesure), MONTH(dateMesure), WEEK(dateMesure) ";
			break;
		case "DAY" :	$grbStr = " GROUP BY YEAR(dateMesure), MONTH(dateMesure), DAY(dateMesure) ";
			break;
		case "HOUR" :	$grbStr = " GROUP BY YEAR(dateMesure), MONTH(dateMesure), DAY(dateMesure), HOUR(dateMesure) ";
			break;
		case "MIN" :	$grbStr = " GROUP BY YEAR(dateMesure), MONTH(dateMesure), DAY(dateMesure), HOUR(dateMesure), MINUTE(dateMesure) ";
			break;
		case "SEC" : 	$grbStr = " GROUP BY YEAR(dateMesure), MONTH(dateMesure), DAY(dateMesure), HOUR(dateMesure), MINUTE(dateMesure), SECOND(dateMesure) ";
			break;
	}

	for($i = 0; $i < $nbCourbes; $i++){

			//Récupère toutes les données de ce capteur entre ces deux dates
			$res=$connection->query("	SELECT mesure.date as DATEMESURE, VALEUR
										FROM mesure, valeurmesure
										WHERE Capteur_idCapteur = " . $capteur[$i][0] . "
										AND LibVal_idLibVal = " . $capteur[$i][1] . "
										AND mesure.date BETWEEN '$dateDeb' AND '$dateFin'
										AND Mesure_idMesure = idMesure
										$grbStr");
			
			

			// echo "	SELECT mesure.date as DATEMESURE, VALEUR
										// FROM mesure, valeurmesure
										// WHERE Capteur_idCapteur = " . $capteur[$i][0] . "
										// AND LibVal_idLibVal = " . $capteur[$i][1] . "
										// AND mesure.date BETWEEN '$dateDeb' AND '$dateFin'
										// AND Mesure_idMesure = idMesure
										// $grbStr";
			$res->setFetchMode(PDO::FETCH_OBJ);
			
			while($val = $res->fetch())
			{
				$data[$val->DATEMESURE][0] = $val->DATEMESURE;
				$data[$val->DATEMESURE][($i+1)] = $val->VALEUR;
				//echo "Pour le capteur $i data[date][($i+1)] =  " . $val->valeur . "<br>";
			}
		
	}
	
	//echo "<br><br><br><br><br><br><br><br><b>Tableau final</b><br>";		
	//print_r($data);
	asort($data);
	echo "END";
	$test = true;
	foreach ($data as &$value) {
		$date = $value[0];
		for($i = 1; $i <= $nbCourbes; $i++){
			if(!isset($value[$i]))
				$value[$i] = "false";
		}

		if($test){
			echo	'	{
						"date" : "' . $date .'", 
				';
			for($i = 0; $i < $nbCourbes-1; $i++){
				echo		'"' . $i . '" : "' . $value[($i+1)] . '",';	
			}	
			echo		'"' . $i . '" : "' . $value[($i+1)] . '"';
			echo "}";
			$test = false;
		} else {
			echo	'	,{
						"date" : "' . $date .'", 
				';
			for($i = 0; $i < $nbCourbes-1; $i++){
				echo		'"' . $i . '" : "' . $value[($i+1)] . '",';	
			}	
			echo		'"' . $i . '" : "' . $value[($i+1)] . '"';
			echo "}";
		}	
	}
?>