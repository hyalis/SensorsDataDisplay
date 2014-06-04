<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
    <title>Test OCI (Php vers Oracle)</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
	    <?php
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $server="nbrehat.cict.fr:1522/etuqua"; 
        $user="sdd_dev"; 
        $pass="master1"; 
      
        echo("Tentative de connexion à ".$server) ;
      
        // Connexion à la base de données
        $conn = oci_connect($user, $pass, $server);
        if (!$conn)
        {
          $e = oci_error();
          trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        echo('end of script') ;
	     ?>  
	</body>
</html>