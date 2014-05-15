<?php

	include "bdd.php";
	
	$resultats=$connection->query("SELECT libelle , idlibval FROM libval WHERE TypeCapteur_idTypeCapteur = $idTypeCapteur ;");
	$i = 1 ;
	//SELECT libelle FROM `libval` WHERE TypeCapteur_idTypeCapteur = 1 
	//SELECT count(*) as nb FROM `libval` WHERE TypeCapteur_idTypeCapteur = 1 
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	while( $resultat = $resultats->fetch() )
	{
		echo '<input type="hidden" id="inpIdType" name="'.$resultat->idlibval.'" value="'.$resultat->idlibval.'">
			<div class="form-group" id='.$i.'>
							<label class="col-sm-2 control-label">mesure'.$i.'</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name'.$i.'" id="inp'.$i.'">
							</div>
						</div>'
						;
		$i =$i+1;						
	}
	
	$resultats->closeCursor();
?>