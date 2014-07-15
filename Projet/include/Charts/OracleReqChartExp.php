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
	// echo "***********************<br><br>";
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
		// On récupérer la date de debut et de fin pour chaque capteur
		$res=$connection->query("	SELECT TO_CHAR(DATED,'yyyy-mm-dd hh24:mi:ss') AS DATED  , TO_CHAR(DATEF,'yyyy-mm-dd hh24:mi:ss') AS DATEF, CAPTEUR_IDCAPTEUR
									FROM  LOCALISER, LIBVAL, CAPTEUR
									WHERE IDLIBVAL = " . $capteur[$i][1] . "
									AND  LIBVAL.TYPECAPTEUR_IDTYPECAPTEUR = CAPTEUR.TYPECAPTEUR_IDTYPECAPTEUR
									AND CAPTEUR.IDCAPTEUR = LOCALISER.CAPTEUR_IDCAPTEUR
									AND Piece_idPiece = " . $capteur[$i][0]);
		
		// echo "	SELECT TO_CHAR(DATED,'yyyy-mm-dd hh24:mi:ss') AS DATED  , TO_CHAR(DATEF,'yyyy-mm-dd hh24:mi:ss') AS DATEF, CAPTEUR_IDCAPTEUR
									// FROM  LOCALISER, LIBVAL, CAPTEUR
									// WHERE IDLIBVAL = " . $capteur[$i][1] . "
									// AND  LIBVAL.TYPECAPTEUR_IDTYPECAPTEUR = CAPTEUR.TYPECAPTEUR_IDTYPECAPTEUR
									// AND CAPTEUR.IDCAPTEUR = LOCALISER.CAPTEUR_IDCAPTEUR
									// AND Piece_idPiece = " . $capteur[$i][0];							
			
		$res->setFetchMode(PDO::FETCH_OBJ);
		
		while ($resultat = $res->fetch()){
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
			
			// On récupérer les DATEMESURE et VALEUR de toutes les éléments qui sont dans l'interval voulu
			$res2=$connection->query("SELECT $group as DATEMESURE, TRUNC(AVG(VALEUR),2) AS VALEUR
										FROM valeurmesure, mesure 
										WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
										AND mesure.Capteur_idCapteur = " . $resultat->CAPTEUR_IDCAPTEUR . "
										AND LibVal_idLibVal = " . $capteur[$i][1] . "
										AND mesure.DateMesure BETWEEN TO_DATE('$dateD','yyyy-mm-dd  hh24:mi:ss') AND TO_DATE('$dateF','yyyy-mm-dd  hh24:mi:ss')
										GROUP BY $group
										ORDER BY DATEMESURE");
					
			 // echo  "SELECT $group as DATEMESURE, TRUNC(AVG(VALEUR),2) AS VALEUR
										// FROM valeurmesure, mesure 
										// WHERE valeurmesure.Mesure_idMesure = mesure.idMesure 
										// AND mesure.Capteur_idCapteur = " . $resultat->CAPTEUR_IDCAPTEUR . "
										// AND LibVal_idLibVal = " . $capteur[$i][1] . "
										// AND mesure.DateMesure BETWEEN TO_DATE('$dateD','yyyy-mm-dd  hh24:mi:ss') AND TO_DATE('$dateF','yyyy-mm-dd  hh24:mi:ss')
										// GROUP BY $group
										// ORDER BY DATEMESURE";
			$res2->setFetchMode(PDO::FETCH_OBJ);
			
		
			while($val = $res2->fetch())
			{
				$data[$val->DATEMESURE][0] = $val->DATEMESURE;
				$data[$val->DATEMESURE][($i+1)] = $val->VALEUR;
				//echo "Pour le capteur $i data[date][($i+1)] =  " . $val->valeur . "<br>";
			}
		}
	}

	// echo "<br><br><br><br><br><br><br><br><b>Tableau final</b><br>";		
	 // print_r($data);
	ksort($data);
	//echo "END";
	$test = true;
	
	$strEcho = "";
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
			echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)])  . '"';
			echo "}";
			$test = false;
		} else {
			echo	'	,{
						"date" : "' . $date .'", 
				';
			for($i = 0; $i < $nbCourbes-1; $i++){
				echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)])  . '",';	
			}	
			echo		'"' . $i . '" : "' . str_replace ( ",", ".", $value[($i+1)])  . '"';
			echo "}";
		}	
	}
?>