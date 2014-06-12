<?php
	include "../../bdd.php";
	$idTypeCapteur = $_GET['idTypeCapteur'];
	$resultats=$connection->query("	SELECT IDLIBVAL, LIBELLE
									FROM LibVal
									WHERE TypeCapteur_idTypeCapteur = $idTypeCapteur");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while($res = $resultats->fetch()){
		echo "<option value='" . $res->IDLIBVAL . "'>" . $res->LIBELLE ."</option>";
	}

?>