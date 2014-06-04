<?php

	
	/*$db = '//195.220.60.14/etuqua';
	$user = 'sdd_dev';
	$pass = 'master1';

	$conn = new PDO($db,$user,$pass);*/
	
		

	$hote = '195.220.60.14';
	$port = '1522';
	$service = 'ETUQUA';
	$utilisateur = 'sdd_dev';
	$motdepasse = 'master1';

	$lien_base =
		"oci:dbname=(DESCRIPTION = 
			(ADDRESS_LIST = 
				(ADDRESS = 
					(PROTOCOL = TCP)
					(Host = ".$hote .")
					(Port = ".$port."))
			)
			(CONNECT_DATA =
				(SERVICE_NAME = ".$service.")
		)
	)";
	/*
	 $lien_base =  "oci:dbname=(DESCRIPTION =
        (ADDRESS_LIST =
            (ADDRESS = (PROTOCOL = TCP)(HOST = 192.220.60.14)(PORT = 1522))
        ) (CONNECT_DATA =
            (SID = ETUQUA) (SERVER = DEDICATED)
        )
    )";
*/

	try
	{
		// connexion à la base Oracle et création de l'objet
		//$connexion = new PDO($lien_base, $utilisateur, $motdepasse);
		$connexion = new PDO($lien_base,$utilisateur, $motdepasse);
	}catch (PDOException $erreur){
		echo $erreur->getMessage() . "<br>";
	}
	phpinfo();
	
?>