

<div class="row">
	<div class="col-lg-12">
		<h1>History
			<small> History of #<?php 
				include "./bdd.php";
				$resultats=$connection->query("SELECT NOMCAPTEUR FROM Capteur WHERE idCapteur = ".$_GET['idSensor'] );
				$resultats->setFetchMode(PDO::FETCH_OBJ);
				$resultat = $resultats->fetch() ; 
				echo $resultat->NOMCAPTEUR ; ?>
			</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php?p=Forms/Sen/editS"><i class="fa fa-edit"></i> Edit Sensors</a></li>
			<li class="active"><i class="fa fa-home"></i> History of sensor</li>
		</ol>
	</div>
</div><!-- /.row -->



<div class="row">
	<div class="col-lg-12">
		<h2>Activity history :</h2>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th>In <i class="fa fa-sort"></i></th>
						<th>At the beginning of activity<i class="fa fa-sort"></i></th>
						<th>At the end of activity<i class="fa fa-sort"></i></th>
					</tr>
				</thead>
				<tbody id="tabHistory">
					<?php
						include "listHis.php";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div><!-- /.row -->




