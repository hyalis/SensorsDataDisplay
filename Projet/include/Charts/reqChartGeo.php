<?php
	include "../bdd.php";
	
	$nbArgs = sizeof($_GET);
	$params = array_values($_GET);

	$dateDeb = $_GET['dateDeb'];
	$dateFin = $_GET['dateFin'];
	$groupBy = $_GET['groupBy'];
	
	//echo "<b>Paramètres</b><br><br>Date début : " . $dateDeb . "<br>Date fin : " . $dateFin . "<br>GroupBy : " . $groupBy . "<br>";
	//echo "<br><br><b>Les paramètres dynamiques</b><br>***********************<br><br>";
	
	for($i = 2; $i <= $nbArgs - 2; $i = $i + 3){
		//DEBUG
		//echo "idPiece" . (($i+1)/3) . " = " . $params[$i] . "<br>";
		//echo "Capteur" . (($i+1)/3) . " = " . $params[$i+1] . "<br>";
		//echo "LibVal" . (($i+1)/3) . " = " . $params[$i+2] . "<br>";
		//echo "------------------<br>";
		
		//Remplissage du tableau
		$capteur[(($i+1)/3)-1][0] = $params[$i];
		$capteur[(($i+1)/3)-1][1] = $params[$i+1];
		$capteur[(($i+1)/3)-1][2] = $params[$i+2];
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
		//Récupère les dates ou le capteur était utilisé dans CETTE pièce
		$resultats=$connection->query("	SELECT idLocaliser, dateD, dateF 
										FROM localiser 
										WHERE Capteur_idCapteur = " . $capteur[$i][1] . "
										AND Piece_idPiece = " . $capteur[$i][0] . "
										AND ( 		dateD BETWEEN '$dateDeb%' AND '$dateFin%'
											  OR 	dateF BETWEEN '$dateDeb%' AND '$dateFin%'
											  OR	(dateD <= '$dateDeb%' AND (dateF >= '$dateFin%' OR dateF IS NULL)))
										ORDER BY dateD ASC");
		//echo "<br><br><b>Requête qui liste la position du capteur #$i</b><br>";		
		/*echo "	SELECT idLocaliser, dateD, dateF 
										FROM localiser 
										WHERE Capteur_idCapteur = " . $capteur[$i][1] . "
										AND Piece_idPiece = " . $capteur[$i][0] . "
										AND ( 		dateD BETWEEN '$dateDeb%' AND '$dateFin%'
											  OR 	dateF BETWEEN '$dateDeb%' AND '$dateFin%'
											  OR	(dateD <= '$dateDeb%' AND (dateF >= '$dateFin%' OR dateF IS NULL)))
										ORDER BY dateD ASC";*/
		$resultats->setFetchMode(PDO::FETCH_OBJ);
		
		while( $resultat = $resultats->fetch() )
		{
			//echo "<br><br><br>idLoc = " . $resultat->idLocaliser . " dateD = " . $resultat->dateD . " dateF = " . $resultat->dateF . "<br><br><br>";

			$dateD = $resultat->dateD;
			
			if($dateD < $dateDeb)
				$dateD = $dateDeb;
				
			//Si il n'y a pas de date de fin c'est que le capteur est tj ds la pièce... On va le plus loin possible (2099 est pas mal)
			if(empty($resultat->dateF) == 1){
				$dateF = $dateFin;
			} else {
				if($resultat->dateF > $dateFin)
					$dateF = $dateFin;
				else
					$dateF = $resultat->dateF;
			}

			//Récupère les données de CE capteur aux dates ou il se trouvait dans CETTE pièce
			$res=$connection->query("	SELECT LEFT(mesure.date,19) as dateMesure, valeur 
										FROM valeurmesure, mesure 
										WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
										AND mesure.Capteur_idCapteur = " . $capteur[$i][1] . "
										AND LibVal_idLibVal = " . $capteur[$i][2] . "
										AND mesure.date BETWEEN '$dateD' AND '$dateF'
										$grbStr");
			//echo "<br><br><b>Requête qui liste les valeurs pour le capteur $i</b><br>";		
			//echo "<br><b>Capteur = </b> " . $capteur[$i][1] ."<br>";	
			//echo "<br><b>LibVal = </b> " . $capteur[$i][2] ."<br>";	
			/*echo "	SELECT LEFT(mesure.date,19) as dateMesure, valeur 
										FROM valeurmesure, mesure 
										WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
										AND mesure.Capteur_idCapteur = " . $capteur[$i][1] . "
										AND LibVal_idLibVal = " . $capteur[$i][2] . "
										AND mesure.date BETWEEN '$dateD' AND '$dateF'
										GROUP BY YEAR(dateMesure), MONTH(dateMesure), DAY(dateMesure)<br>";*/
			$res->setFetchMode(PDO::FETCH_OBJ);
			
			while($val = $res->fetch())
			{
				$data[$val->dateMesure][0] = $val->dateMesure;
				$data[$val->dateMesure][($i+1)] = $val->valeur;
				//echo "Pour le capteur $i data[date][($i+1)] =  " . $val->valeur . "<br>";
			}
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