<?php
	include "../bdd.php";
	
	$nbArgs = sizeof($_GET);
	$params = array_values($_GET);

	$dateDeb = $_GET['dateDeb'];
	$dateFin = $_GET['dateFin'];
	$groupBy = $_GET['groupBy'];
	
	// echo "<b>Param�tres</b><br><br>Date d�but : " . $dateDeb . "<br>Date fin : " . $dateFin . "<br>GroupBy : " . $groupBy . "<br>";
	// echo "<br><br><b>Les param�tres dynamiques</b><br>***********************<br><br>";
	
	// on prepare un tableau pour enregistrer chaque capteurs selectionnes
	for($i = 2; $i <= $nbArgs - 2; $i = $i + 3){
		//DEBUG
		// echo "idPiece" . (($i+1)/3) . " = " . $params[$i] . "<br>";
		// echo "Capteur" . (($i+1)/3) . " = " . $params[$i+1] . "<br>";
		// echo "LibVal" . (($i+1)/3) . " = " . $params[$i+2] . "<br>";
		// echo "------------------<br>";
		
		//Remplissage du tableau
		$capteur[(($i+1)/3)-1][0] = $params[$i];
		$capteur[(($i+1)/3)-1][1] = $params[$i+1];
		$capteur[(($i+1)/3)-1][2] = $params[$i+2];
	}
	// echo "***********************<br><br>";
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
		//R�cup�re les dates ou le capteur �tait utilis� dans CETTE pi�ce
		$resultats=$connection->query("	SELECT IDLOCALISER, DATED, DATEF 
										FROM localiser 
										WHERE Capteur_idCapteur = " . $capteur[$i][1] . "
										AND Piece_idPiece = " . $capteur[$i][0] . "
										AND ( 		dateD BETWEEN '$dateDeb%' AND '$dateFin%'
											  OR 	dateF BETWEEN '$dateDeb%' AND '$dateFin%'
											  OR	(dateD <= '$dateDeb%' AND (dateF >= '$dateFin%' OR dateF IS NULL)))
										ORDER BY dateD ASC");
		// echo "<br><br><b>Requ�te qui liste la position du capteur #$i</b><br>";		
		// echo "	SELECT idLocaliser, dateD, dateF 
										// FROM localiser 
										// WHERE Capteur_idCapteur = " . $capteur[$i][1] . "
										// AND Piece_idPiece = " . $capteur[$i][0] . "
										// AND ( 		dateD BETWEEN '$dateDeb%' AND '$dateFin%'
											  // OR 	dateF BETWEEN '$dateDeb%' AND '$dateFin%'
											  // OR	(dateD <= '$dateDeb%' AND (dateF >= '$dateFin%' OR dateF IS NULL)))
										// ORDER BY dateD ASC";
		$resultats->setFetchMode(PDO::FETCH_OBJ);
		while( $resultat = $resultats->fetch() )
		{
			// echo "<br><br><br>idLoc = " . $resultat->IDLOCALISER . " dateD = " . $resultat->DATED . " dateF = " . $resultat->DATEF . "<br><br><br>";

			$dateD = $resultat->DATED;
			
			// cas standard
			if($dateD < $dateDeb)
				$dateD = $dateDeb;
				
			//Si il n'y a pas de date de fin c'est que le capteur est tj ds la pi�ce...
			if(empty($resultat->DATEF) == 1){
				$dateF = $dateFin;
			} else {
				if($resultat->DATEF > $dateFin)
					$dateF = $dateFin;
				else
					$dateF = $resultat->DATEF;
					$dateTrou = new DateTime($dateF);
					$dateTrou->add(new DateInterval('PT1S'));
					$data[$dateTrou->format('Y-m-d H:i:s')][0] = $dateTrou->format('Y-m-d H:i:s');
					$data[$dateTrou->format('Y-m-d H:i:s')][($i+1)] = "false";
			}
			



			//R�cup�re les donn�es de CE capteur aux dates ou il se trouvait dans CETTE pi�ce
			$res=$connection->query("	SELECT LEFT(mesure.DateMesure,19) as DATEMESURE, VALEUR 
										FROM valeurmesure, mesure 
										WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
										AND mesure.Capteur_idCapteur = " . $capteur[$i][1] . "
										AND LibVal_idLibVal = " . $capteur[$i][2] . "
										AND mesure.DateMesure BETWEEN '$dateD' AND '$dateF'
										$grbStr");
			// echo "<br><br><b>Requ�te qui liste les valeurs pour le capteur $i</b><br>";		
			// echo "<br><b>Capteur = </b> " . $capteur[$i][1] ."<br>";	
			// echo "<br><b>LibVal = </b> " . $capteur[$i][2] ."<br>";	
			// echo "	SELECT LEFT(mesure.DateMesure,19) as dateMesure, valeur 
										// FROM valeurmesure, mesure 
										// WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
										// AND mesure.Capteur_idCapteur = " . $capteur[$i][1] . "
										// AND LibVal_idLibVal = " . $capteur[$i][2] . "
										// AND mesure.DateMesure BETWEEN '$dateD' AND '$dateF'
										// GROUP BY YEAR(dateMesure), MONTH(dateMesure), DAY(dateMesure)<br>";
			$res->setFetchMode(PDO::FETCH_OBJ);
			
			// on renseigne $data avec notre requete 
			while($val = $res->fetch())
			{
				$data[$val->DATEMESURE][0] = $val->DATEMESURE;
				$data[$val->DATEMESURE][($i+1)] = $val->VALEUR;
				//echo "Pour le capteur $i data[date][($i+1)] =  " . $val->valeur . "<br>";
			}
			
			//$dateTrou = $dateF + 1 seconde;
			
			
			//echo "dateTrou = " . $dateTrou->format('Y-m-d H:i:s') . "<br>";		
		}
	}
	
	//echo "<br><br><br><br><br><br><br><br><b>Tableau final</b>AVANT<br>";		
	//print_r($data);
	ksort($data);
	//echo "<br><br><br>APRES<br>";	
	//print_r($data);
	//echo "<br><br><br><br>";	
	echo "END";
	$test = true;
	
	// formattage des valeurs numerique conversion de "," en "."
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