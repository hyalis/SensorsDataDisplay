<?php
	include "../bdd.php";
	
	$nbArgs = sizeof($_GET);
	$params = array_values($_GET);

	$dateDeb = $_GET['dateDeb'];
	$dateFin = $_GET['dateFin'];
	$groupBy = $_GET['groupBy'];
	
	// echo "<b>Paramètres</b><br><br>Date début : " . $dateDeb . "<br>Date fin : " . $dateFin . "<br>GroupBy : " . $groupBy . "<br>";
	// echo "<br><br><b>Les paramètres dynamiques</b><br>***********************<br><br>";
	
	// On organise dans un tableau tout les couples idPiece , idCapteur et idLibVal pour le traiter par la suite
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
	
	for($i = 0; $i < $nbCourbes; $i++){
		//Récupère les dates ou le capteur était utilisé dans CETTE pièce
		$resultats=$connection->query("	SELECT IDLOCALISER, TO_CHAR(DATED,'yyyy-mm-dd hh24:mi:ss') AS DATED, TO_CHAR(DATEF,'yyyy-mm-dd hh24:mi:ss') AS DATEF
										FROM localiser 
										WHERE Capteur_idCapteur = " . $capteur[$i][1] . "
										AND Piece_idPiece = " . $capteur[$i][0] . "
										AND ( 		dateD BETWEEN TO_DATE('$dateDeb','yyyy-mm-dd  hh24:mi:ss') AND TO_DATE('$dateFin','yyyy-mm-dd  hh24:mi:ss')
											  OR 	dateF BETWEEN TO_DATE('$dateDeb','yyyy-mm-dd  hh24:mi:ss') AND TO_DATE('$dateFin','yyyy-mm-dd  hh24:mi:ss')
											  OR	(dateD <= TO_DATE('$dateDeb','yyyy-mm-dd  hh24:mi:ss') AND (dateF >= TO_DATE('$dateFin','yyyy-mm-dd  hh24:mi:ss') OR dateF IS NULL)))
										ORDER BY dateD ASC");
		// echo "<br><br><b>Requête qui liste la position du capteur #$i</b><br>";		
		// echo "	SELECT IDLOCALISER, TO_CHAR(DATED,'yyyy-mm-dd hh24:mi:ss') AS DATED, TO_CHAR(DATEF,'yyyy-mm-dd hh24:mi:ss') AS DATEF
										// FROM localiser 
										// WHERE Capteur_idCapteur = " . $capteur[$i][1] . "
										// AND Piece_idPiece = " . $capteur[$i][0] . "
										// AND ( 		dateD BETWEEN TO_DATE('$dateDeb%','yyyy-mm-dd  hh24:mi:ss') AND TO_DATE('$dateFin%','yyyy-mm-dd  hh24:mi:ss')
											  // OR 	dateF BETWEEN TO_DATE('$dateDeb%','yyyy-mm-dd  hh24:mi:ss') AND TO_DATE('$dateFin%','yyyy-mm-dd  hh24:mi:ss')
											  // OR	(dateD <= TO_DATE('$dateDeb%','yyyy-mm-dd  hh24:mi:ss') AND (dateF >= TO_DATE('$dateFin%','yyyy-mm-dd  hh24:mi:ss') OR dateF IS NULL)))
										// ORDER BY dateD ASC";
		$resultats->setFetchMode(PDO::FETCH_OBJ);
		while( $resultat = $resultats->fetch() )
		{
			// echo "<br><br><br>idLoc = " . $resultat->IDLOCALISER . " dateD = " . $resultat->DATED . " dateF = " . $resultat->DATEF . "<br><br><br>";

			$dateD = $resultat->DATED;
			
			if($dateD < $dateDeb)
				$dateD = $dateDeb;
				
			//Si il n'y a pas de date de fin c'est que le capteur est tj ds la pièce...
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
			



			//Récupère les données de CE capteur aux dates ou il se trouvait dans CETTE pièce
			$res=$connection->query("SELECT $group as DATEMESURE, TRUNC(AVG(VALEUR),2) AS VALEUR
										FROM valeurmesure, mesure 
										WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
										AND mesure.Capteur_idCapteur = " . $capteur[$i][1] . "
										AND LibVal_idLibVal = " . $capteur[$i][2] . "
										AND mesure.DateMesure BETWEEN TO_DATE('$dateD','yyyy-mm-dd  hh24:mi:ss') AND TO_DATE('$dateF','yyyy-mm-dd  hh24:mi:ss')
										GROUP BY $group
										ORDER BY DATEMESURE");
			// echo "<br><br><b>Requête qui liste les valeurs pour le capteur $i</b><br>";		
			// echo "<br><b>Capteur = </b> " . $capteur[$i][1] ."<br>";	
			// echo "<br><b>LibVal = </b> " . $capteur[$i][2] ."<br>";	
			// echo "	SELECT $group as DATEMESURE, TRUNC(AVG(VALEUR),2) AS VALEUR
										// FROM valeurmesure, mesure 
										// WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
										// AND mesure.Capteur_idCapteur = " . $capteur[$i][1] . "
										// AND LibVal_idLibVal = " . $capteur[$i][2] . "
										// AND mesure.DateMesure BETWEEN TO_DATE('$dateD','yyyy-mm-dd  hh24:mi:ss') AND TO_DATE('$dateF','yyyy-mm-dd  hh24:mi:ss')
										// GROUP BY $group
										// ORDER BY DATEMESURE";
			$res->setFetchMode(PDO::FETCH_OBJ);
			
			// on renseigne $data grace au résultat notre requete 
			while($val = $res->fetch())
			{
				$data[$val->DATEMESURE][0] = $val->DATEMESURE;
				$data[$val->DATEMESURE][($i+1)] = $val->VALEUR;
				// echo "Pour le capteur $i data[date][($i+1)] =  " . $val->VALEUR . "<br>";
				// echo "val->DATEMESURE =  " . $val->DATEMESURE . "<br>";
			}
		}
	}
	// echo "<br><br><br><br><br><br><br><br><b>Tableau final</b>AVANT<br>";		
	// print_r($data);
	ksort($data);
	// echo "<br><br><br>APRES<br>";	
	// print_r($data);
	// echo "<br><br><br><br>";	
	//echo "END";
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
				echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)]) . '",';	
			}	
			echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)]) . '"';
			echo "}";
			$test = false;
		} else {
			echo	'	,{
						"date" : "' . $date .'", 
				';
			for($i = 0; $i < $nbCourbes-1; $i++){
				echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)]) . '",';	
			}	
			echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)]) . '"';
			echo "}";
		}	
	}
?>