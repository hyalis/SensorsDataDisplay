<?php
	include "../bdd.php";
	
	$nbArgs = sizeof($_GET);
	//print_r($_GET);
	$params = array_values($_GET);
	
	$time = $_GET['time'];
	
	// On organise dans un tableau tout les couples capteur_idCapteur et libVal_idLibVal pour le traiter par la suite
	for($i = 1; $i <= $nbArgs - 1; $i = $i + 2){
		//DEBUG
		// echo "Capteur" . ((($i+1)/2)-1) . " = " . $params[$i] . "<br>";
		// echo "LibVal" . ((($i+1)/2)-1) . " = " . $params[$i+1] . "<br>";
		
		//Remplissage du tableau
		$capteur[(($i+1)/2)-1][0] = $params[$i];
		$capteur[(($i+1)/2)-1][1] = $params[$i+1];
	}
	
	$req = "SELECT TO_CHAR(DATEMESURE,'yyyy-mm-dd hh24:mi:ss') as DATEMESURE ";
	
	for($i = 0; $i < sizeof($_GET)/3; $i++){
		$req = $req . ", T" . ($i+1) . ".V" . ($i+1) . " as VALUE" . $i;
	}
	
	$req = $req . " FROM ";
	


	for($i = 0; $i < sizeof($capteur); $i++){
		$req = $req . "(	SELECT TRUNC(VALEUR,2) as V" . ($i+1) . ", mesure.DateMesure 
									FROM mesure, valeurmesure
									WHERE LibVal_idLibVal = " . $capteur[$i][1] . "
									AND Capteur_idCapteur = " . $capteur[$i][0] . "
									AND Mesure_idMesure = idMesure
									AND DateMesure > SYSDATE - INTERVAL '$time' SECOND) T" . ($i+1) . ","; 						
	}
	
	$req = substr($req, 0, strlen($req)-1);
	
	if(sizeof($capteur)>1){
		$req = $req . "	WHERE";
		for($i = 0; $i < sizeof($capteur) - 1; $i++){
			$req = $req . " T" . ($i+1) . ".DateMesure = T" . ($i+2) . ".DateMesure AND";
		}
		$req = substr($req, 0, strlen($req)-3);
	}
	
	$req = $req . " ORDER BY DATEMESURE DESC";
	
	//echo $req . "<br><br><br><br>";

	$resultats=$connection->query($req);
	$resultats->setFetchMode(PDO::FETCH_OBJ);

	$resultat = $resultats->fetch();
	
	if(isset($resultat->DATEMESURE) && $resultat->DATEMESURE != ""){
		echo	'{"date" : "' . $resultat->DATEMESURE .'",';
		for($i = 0; $i < sizeof($capteur)-1; $i++){
			$name = "VALUE".$i;
			echo	'"' . $i . '" : "' . $resultat->$name . '",';	
		}	
		$name = "VALUE".$i;
		echo		'"' . $i . '" : "' . $resultat->$name . '"';
		echo "}";
	}
	$resultats->closeCursor();

?>