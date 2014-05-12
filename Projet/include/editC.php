
<script>
	function removeSensor(idBat)
	{
		if(confirm("Voulez vous vraiment supprimer le batiment numero " + idBat + " ainsi que les pieces qui lui sont associes ?")){
			document.getElementById('tabBatiment').innerHTML='<h2><img src="./img/loading.gif" style="margin-right:25px;"/>Please wait...</h2>';
			if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					if(xmlhttp.responseText==""){
						//Si la rep du PHP est vide
						alert ("La req n'a pas fonctionne");
						alert(xmlhttp.responseText);
					} else {
						//Si la rep du PHP n'est pas vide
						//alert ("Requete OK, MAJ du tab des bats ...");
			//alert ("Rep du PHP = " + xmlhttp.responseText);
				document.getElementById('tabBatiment').innerHTML=xmlhttp.responseText;
					}
				}
			}
			xmlhttp.open("GET","./include/remBat.php?idBatiment="+idBat,true);
			xmlhttp.send();
		}	
	}
</script>
<div class="row">
	<div class="col-lg-12">
		<h1>Edit Sensor <small>Edit your Sensor</small></h1>
		<ol class="breadcrumb">
			<li><a href="index.php?p=dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>	
			<li class="active"><i class="fa fa-edit"></i> Edit sensor</li>
		</ol>
	</div>
</div>



<div class="row">
	<div class="col-lg-12">
		<h2>Sensors list :</h2>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th>Name <i class="fa fa-sort"></i></th>
						<th>Edit <i class="fa fa-sort"></i></th>
					</tr>
				</thead>
				<tbody id="tabSensor">
					<?php
						include "listSensor.php";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

 <div class="row">
	<div class="col-lg-12">
		<img src="./img/work_in.png" class="img-responsive center-block img-rounded" alt="Work in" style="width: 200px;">
	</div>
</div><!-- /.row -->