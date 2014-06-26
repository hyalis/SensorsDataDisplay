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
	
		$res=$connection->query("	SELECT TO_CHAR(DATED,'yyyy-mm-dd hh24:mi:ss') AS DATED  , TO_CHAR(DATEF,'yyyy-mm-dd hh24:mi:ss') AS DATEF, CAPTEUR_IDCAPTEUR
									FROM  LOCALISER, LIBVAL, CAPTEUR
									WHERE IDLIBVAL = " . $capteur[$i][1] . "
									AND  LIBVAL.TYPECAPTEUR_IDTYPECAPTEUR = CAPTEUR.TYPECAPTEUR_IDTYPECAPTEUR
									AND CAPTEUR.IDCAPTEUR = LOCALISER.CAPTEUR_IDCAPTEUR
									AND Piece_idPiece =" . $capteur[$i][0] );
									
				
		$res ->	setFetchMode(PDO::FETCH_OBJ);
		
		while ($resultat = $res-> fetch()){
			if ($resultat->DATED < $dateDeb){
				$dated = $dateDeb ;
			}
			else {
				$dated = $resultat->DATED ;
			}
			if ($resultat->DATEF > $dateFin){
				$datef =$dateFin ;
			}
			else {
				$datef = $resultat->DATEF ;
			}
			$res2=$connection->query("	SELECT VALEUR ,DATEMESURE
										FROM  VALEURMESURE, MESURE
										WHERE MESURE.CAPTEUR_IDCAPTEUR = ". $resultat->CAPTEUR_IDCAPTEUR ."
										AND MESURE.DATEMESURE BETWEEN TO_DATE(".$dated.",'yyyy-mm-dd hh24:mi:ss') AND TO_DATE(".$datef.",'yyyy-mm-dd hh24:mi:ss')
										AND MESURE.IDMESURE = VALEURMESURE.MESURE_IDMESURE 
										".$grbStr );
					
				
			$res2->setFetchMode(PDO::FETCH_OBJ);
	
			while($val = $res2->fetch())
			{
				$data[$val->DATEMESURE][0] = $val->DATEMESURE;
				$data[$val->DATEMESURE][($i+1)] = $val->VALEUR;
				//echo "Pour le capteur $i data[date][($i+1)] =  " . $val->valeur . "<br>";
			}
		}
	}

	/* for($i = 0; $i < $nbCourbes; $i++){
	
			$res=$connection->query("	SELECT DATED , DATEF, CAPTEUR_IDCAPTEUR
										FROM  LOCALISER, LIBVAL, CAPTEUR
										WHERE IDLIBVAL = " . $capteur[$i][1] . "
										AND  LIBVAL.TYPECAPTEUR_IDTYPECAPTEUR = CAPTEUR.TYPECAPTEUR_IDTYPECAPTEUR
										AND CAPTEUR.IDCAPTEUR = LOCALISER.CAPTEUR_IDCAPTEUR
										AND Piece_idPiece =" . $capteur[$i][0] . "
										ORDER BY DATED ASC , DATEF DESC");
										
					
			$res ->	setFetchMode(PDO::FETCH_OBJ);
			$dated = "";
			$datef = "";
			$dateflimite = "";
			$premiereboucle = true ; // a voir si on doit le remettre a true quand on fini ?????
			
			//et il faut que je reduise le resultat avec les dated et datef passer en argument
			//attention il manque le group by a rajouter
			
			while ($resultat = $res-> fetch()){
				if( ($dated == "" or $dated < $resultat->DATED) and ( $datef == "" or $datef < $resultat->DATEF)){
					$dated = $resultat->DATED ;
					$datef = $resultat->DATEF ;
					if($dateflimite ==""){
						$dateflimite = $datef ;
					}
					if($dateflimite>$datef){
						// on ne fait rien on a deja visite cet interval entre dated et dateflimite
					}
					else {
						if($premiereboucle or $dated>$dateflimite){
							$res2=$connection->query("	SELECT VALEUR ,DATEMESURE
														FROM  VALEURMESURE, MESURE
														WHERE MESURE.CAPTEUR_IDCAPTEUR = ". $resultat->CAPTEUR_IDCAPTEUR ."
														AND MESURE.DATEMESURE BETWEEN TO_DATE(".$dated.",'yyyy-mm-dd hh24:mi:ss') AND TO_DATE(".$datef.",'yyyy-mm-dd hh24:mi:ss')
														AND MESURE.IDMESURE = VALEURMESURE.MESURE_IDMESURE ");
							$premiereboucle = false ;
						}
						else{
							$res2=$connection->query("	SELECT VALEUR ,DATEMESURE
														FROM  VALEURMESURE, MESURE
														WHERE MESURE.CAPTEUR_IDCAPTEUR = ". $resultat->CAPTEUR_IDCAPTEUR ."
														AND MESURE.DATEMESURE BETWEEN TO_DATE(".$dateflimite.",'yyyy-mm-dd hh24:mi:ss') AND TO_DATE(".$datef.",'yyyy-mm-dd hh24:mi:ss')
														AND MESURE.IDMESURE = VALEURMESURE.MESURE_IDMESURE ");
						}
						
						
					}
					$res2->setFetchMode(PDO::FETCH_OBJ);
			
					while($val = $res2->fetch())
					{
						$data[$val->DATEMESURE][0] = $val->DATEMESURE;
						$data[$val->DATEMESURE][($i+1)] = $val->VALEUR;
						//echo "Pour le capteur $i data[date][($i+1)] =  " . $val->valeur . "<br>";
					}
					
					$dateflimite = $datef ;
				}
				else{
					// on ne fait rien interval visite
				}
				
			}
			
					
					/* // croise cette requete avec la précédante pour reduire la taille du tuple
					
					SELECT DATED , DATEF, CAPTEUR_IDCAPTEUR
										FROM  LOCALISER, LIBVAL, CAPTEUR
										WHERE IDLIBVAL = 252
										AND  LIBVAL.TYPECAPTEUR_IDTYPECAPTEUR = CAPTEUR.TYPECAPTEUR_IDTYPECAPTEUR
										AND CAPTEUR.IDCAPTEUR = LOCALISER.CAPTEUR_IDCAPTEUR
										AND Piece_idPiece = 1
										ORDER BY DATED ASC , DATEF DESC;
										
					// on a tout les intervalles sur idlibval et piece qu'on a voulu
					// maintenant il faut que l'on aille chercher les intervalles qui nous interesse
					
					// for sur le resultat
						// on regarde les date de debut et de fin pour voir si elles correspondent
						// on ne garde que celle qui nous interesse
						
					// maintenant il faut faire des requetes sur nos table en fonction de la dated et datef pour avoir les mesure qui sont localiser (les tuples dated sont trier pour plus de facilite
					// on a trois parametre par tuples
					
					// on fait la requete suivante
					
					SELECT VALEUR ,DATEMESURE
										FROM  VALEURMESURE, MESURE
										WHERE MESURE.CAPTEUR_IDCAPTEUR = param1
                    AND MESURE.DATEMESURE BETWEEN TO_DATE(param2,'yyyy-mm-dd hh24:mi:ss') AND TO_DATE(param3,'yyyy-mm-dd hh24:mi:ss')
                    AND MESURE.IDMESURE = VALEURMESURE.MESURE_IDMESURE ;
					
					// on modifie enregistre fin pour que se soit le prochain debut pour eviter les doublons
					// et on boucle avant on enregistre tout dans data
					
			 */
			

	// echo "<br><br><br><br><br><br><br><br><b>Tableau final</b><br>";		
	 // print_r($data);
	ksort($data);
	echo "END";
	$test = true;
	
	$strEcho = "";
	foreach ($data as &$value) {
		$date = $value[0];
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!! V.1 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
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
		
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!! V.2 !!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		
		// if($test){
			// $strEcho = $strEcho .	'	{
						// "date" : "' . $date .'", 
				// ';
			// while (list($key, $val) = each($value)) {
				// if($key != 0)
					// $strEcho = $strEcho .			'"' . ($key-1) . '" : "' . str_replace ( ",", ".", $val) . '", ';	
			// }
			// $strEcho = substr($strEcho,0,-2);
			// $strEcho = $strEcho .	 "}";
			// $test = false;
		// } else {
			// $strEcho = $strEcho .		'	,{
						// "date" : "' . $date .'", 
				// ';
				
				
			// while (list($key, $val) = each($value)) {
				// if($key != 0)
					// $strEcho = $strEcho .			'"' . ($key-1) . '" : "' . str_replace ( ",", ".", $val) . '", ';	
			// }
			// $strEcho = substr($strEcho,0,-2);
			// $strEcho = $strEcho .	 "}";
		// }
	}
	// echo $strEcho;
?>