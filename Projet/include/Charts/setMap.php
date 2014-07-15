<?php
	include "../../bdd.php";
	
	// Selection des attributs necessaires a la geo localisation des capteurs dans la map ainsi que de pouvoir identifier de maniere unique chaque capteur
	
	$resultats=$connection->query("	SELECT DISTINCT Batiment.nom as NOMBAT, Piece.nom as NOMPIE, LAT, LNG, IDTYPECAPTEUR, NOMTYPE, Piece.idPiece
									FROM Batiment, Piece, Localiser, Capteur, TypeCapteur, LibVal
									WHERE Batiment_idBatiment = idBatiment
									AND idPiece = Piece_idPiece
									AND idCapteur = Capteur_idCapteur
									AND idTypeCapteur = Capteur.TypeCapteur_idTypeCapteur
									AND idTypeCapteur = LibVal.TypeCapteur_idTypeCapteur
									ORDER BY NOMBAT, NOMPIE, LAT, LNG, IDTYPECAPTEUR, NOMTYPE");
									
									
	/*$resultats=$connection->query("	SELECT Batiment.nom as NOMBAT, Piece.nom as NOMPIE, LAT, LNG
									FROM Batiment, Piece
									WHERE Batiment_idBatiment = idBatiment");*/
									
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	
	// envoie du premier capteur par echo
	
	$res = $resultats->fetch();
	$nomBat = $res->NOMBAT;
	$idPie = $res->IDPIECE;
	$nomPie = $res->NOMPIE;
	echo $nomBat . "***" . $idPie . "***" . $nomPie . "***" . $res->LAT . "***" . $res->LNG . "***<option value='" . $res->IDTYPECAPTEUR . "'>" . $res->NOMTYPE . "</option>";
	

	// on transmet tout les autres elements a charts.php pour la gestion de la map
	
	while($res){
		while($nomBat == $res->NOMBAT && $nomPie == $res->NOMPIE){
			echo "<option value='" . $res->IDTYPECAPTEUR . "'>" . $res->NOMTYPE . "</option>";
			$res = $resultats->fetch();
		}
		echo "<br>";
		$nomBat = $res->NOMBAT;
		$idPie = $res->IDPIECE;
		$nomPie = $res->NOMPIE;
		echo $nomBat . "***" . $idPie . "***" . $nomPie . "***" . $res->LAT . "***" . $res->LNG . "***<option value='" . $res->IDTYPECAPTEUR . "'>" . $res->NOMTYPE . "</option>";
		$res = $resultats->fetch();
	}
?>