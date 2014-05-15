<?php
	include "../../bdd.php";
	
	$idLibVal = $_GET['idLibVal'];
	
	$resultats=$connection->query("DELETE FROM libval WHERE idLibVal = $idLibVal");
	echo "DELETE FROM libval WHERE idLibVal = $idLibVal" ;
	
	include "listLab.php";
	$resultats->closeCursor();
?>