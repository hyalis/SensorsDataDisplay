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
	
	$grbStr = " GROUP BY ";
	
	switch($groupBy){
		case "YEAR" :	$group = " TO_CHAR(DATEMESURE,'yyyy') ";
			break;
		case "MONTH" :	$group = " TO_CHAR(DATEMESURE,'yyyy-mm') ";
			break;
		case "DAY" :	$group = " TO_CHAR(DATEMESURE,'yyyy-mm-dd') ";
			break;
		case "HOUR" :	$group = " TO_CHAR(DATEMESURE,'yyyy-mm-dd hh24') ";
			break;
		case "MIN" :	$group = " TO_CHAR(DATEMESURE,'yyyy-mm-dd hh24:mi') ";
			break;
		case "SEC" : 	$group = " TO_CHAR(DATEMESURE,'yyyy-mm-dd hh24:mi:ss') ";
			break;
	}
	$grbStr = $grbStr . $group;

	for($i = 0; $i < $nbCourbes; $i++){

			//Récupère toutes les données de ce capteur entre ces deux dates
			$res=$connection->query("	SELECT $group as DATEMESURE, TRUNC(AVG(VALEUR),2) as VALEUR
										FROM mesure, valeurmesure
										WHERE Capteur_idCapteur = " . $capteur[$i][0] . "
										AND LibVal_idLibVal = " . $capteur[$i][1] . "
										AND mesure.DateMesure BETWEEN TO_DATE('$dateDeb','yyyy-mm-dd hh24:mi') AND TO_DATE('$dateFin','yyyy-mm-dd hh24:mi')
										AND Mesure_idMesure = idMesure
										$grbStr");
			
			

			 /*echo "	SELECT $group as DATEMESURE, AVG(VALEUR) as VALEUR
										FROM mesure, valeurmesure
										WHERE Capteur_idCapteur = " . $capteur[$i][0] . "
										AND LibVal_idLibVal = " . $capteur[$i][1] . "
										AND mesure.DateMesure BETWEEN TO_DATE('$dateDeb','yyyy-mm-dd hh24:mi') AND TO_DATE('$dateFin','yyyy-mm-dd hh24:mi')
										AND Mesure_idMesure = idMesure
										$grbStr";*/
										
			$res->setFetchMode(PDO::FETCH_OBJ);
			
			while($val = $res->fetch())
			{
				$data[$val->DATEMESURE][0] = $val->DATEMESURE;
				$data[$val->DATEMESURE][($i+1)] = $val->VALEUR;
				//echo "Pour le capteur $i data[date][($i+1)] =  " . $val->valeur . "<br>";
			}
		
	}
	
	// echo "<br><br><br><br><br><br><br><br><b>Tableau final</b><br>";		
	 // print_r($data);
	ksort($data);
	echo "END";
	$test = true;
	
	$strEcho = "";
	foreach ($data as &$value) {
		$date = $value[0];
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!! AVEC trou !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		// for($i = 1; $i <= $nbCourbes; $i++){
			// if(!isset($value[$i]))
				// $value[$i] = "false";
		// }

		// if($test){
			// echo	'	{
						// "date" : "' . $date .'", 
				// ';
			// for($i = 0; $i < $nbCourbes-1; $i++){
				// echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)]) . '",';	
			// }	
			// echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)])  . '"';
			// echo "}";
			// $test = false;
		// } else {
			// echo	'	,{
						// "date" : "' . $date .'", 
				// ';
			// for($i = 0; $i < $nbCourbes-1; $i++){
				// echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)])  . '",';	
			// }	
			// echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)])  . '"';
			// echo "}";
		// }	
		
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!! SANS trou, Marche pas !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		
		if($test){
			$strEcho = $strEcho .	'	{
						"date" : "' . $date .'", 
				';
			while (list($key, $val) = each($value)) {
				if($key != 0)
					$strEcho = $strEcho .			'"' . ($key-1) . '" : "' . str_replace ( ",", ".", $val) . '", ';	
			}
			$strEcho = substr($strEcho,0,-2);
			$strEcho = $strEcho .	 "}";
			$test = false;
		} else {
			$strEcho = $strEcho .		'	,{
						"date" : "' . $date .'", 
				';
				
				
			while (list($key, $val) = each($value)) {
				if($key != 0)
					$strEcho = $strEcho .			'"' . ($key-1) . '" : "' . str_replace ( ",", ".", $val) . '", ';	
			}
			$strEcho = substr($strEcho,0,-2);
			$strEcho = $strEcho .	 "}";
		}
	}
	echo $strEcho;
?>