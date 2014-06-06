<?php
	include "../bdd.php";
	
	$nbArgs = sizeof($_GET);
	//print_r($_GET);
	$params = array_values($_GET);
	
	$time = $_GET['time'];
	
	for($i = 1; $i <= $nbArgs - 1; $i = $i + 2){
		//DEBUG
		//echo "Capteur" . ((($i+1)/2)-1) . " = " . $params[$i] . "<br>";
		//echo "LibVal" . ((($i+1)/2)-1) . " = " . $params[$i+1] . "<br>";
		
		//Remplissage du tableau
		$capteur[(($i+1)/2)-1][0] = $params[$i];
		$capteur[(($i+1)/2)-1][1] = $params[$i+1];
	}
	
	$req = "SELECT LEFT(T1.date,19) as DATEMESURE ";
	
	for($i = 0; $i < sizeof($_GET)/3; $i++){
		$req = $req . ", ROUND(T" . ($i+1) . ".V" . ($i+1) . ",2) as Value" . $i;
	}
	
	$req = $req . " FROM ";

	for($i = 0; $i < sizeof($capteur); $i++){
		$req = $req . "(	SELECT valeur as V" . ($i+1) . ", mesure.date 
									FROM mesure, valeurmesure
									WHERE LibVal_idLibVal = " . $capteur[$i][1] . "
									AND Capteur_idCapteur = " . $capteur[$i][0] . "
									AND Mesure_idMesure = idMesure
									AND date > NOW() - INTERVAL $time SECOND) T" . ($i+1) . ","; 						
	}
	
	$req = substr($req, 0, strlen($req)-1);
	
	if(sizeof($capteur)>1){
		$req = $req . "	WHERE";
		for($i = 0; $i < sizeof($capteur) - 1; $i++){
			$req = $req . " T" . ($i+1) . ".date = T" . ($i+2) . ".date AND";
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
			$name = "Value".$i;
			echo	'"' . $i . '" : "' . $resultat->$name . '",';	
		}	
		$name = "Value".$i;
		echo		'"' . $i . '" : "' . $resultat->$name . '"';
		echo "}";
	}
	$resultats->closeCursor(); 

?>