<?php
	try
	{
		$utilisateur = 'sdd_dev';
		$motdepasse = 'master1';
		$connexion = new PDO("oci:dbname=//195.220.60.14:1522/ETUQUA",$utilisateur, $motdepasse);
	}catch (PDOException $erreur){
		echo $erreur->getMessage() . "<br>";
	}

?>