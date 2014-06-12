<?php
	include "../../bdd.php";
	
	$resultats=$connection->query("	SELECT DISTINCT Batiment.nom as NOMBAT, Piece.nom as NOMPIE, LAT, LNG, IDTYPECAPTEUR, NOMTYPE
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
	
	
	$res = $resultats->fetch();
	$nomBat = $res->NOMBAT;
	$nomPie = $res->NOMPIE;
	echo $nomBat . "***" . $nomPie . "***" . $res->LAT . "***" . $res->LNG . "***<option value='" . $res->IDTYPECAPTEUR . "'>" . $res->NOMTYPE . "</option>";
	

	while($res){
		while($nomBat == $res->NOMBAT && $nomPie == $res->NOMPIE){
			echo "<option value='" . $res->IDTYPECAPTEUR . "'>" . $res->NOMTYPE . "</option>";
			$res = $resultats->fetch();
		}
		echo "<br>";
		$nomBat = $res->NOMBAT;
		$nomPie = $res->NOMPIE;
		echo $nomBat . "***" . $nomPie . "***" . $res->LAT . "***" . $res->LNG . "***<option value='" . $res->IDTYPECAPTEUR . "'>" . $res->NOMTYPE . "</option>";
		$res = $resultats->fetch();
	}
?>