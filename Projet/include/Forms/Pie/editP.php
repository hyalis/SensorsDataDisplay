<script>	
	function editPie(idPie)
	{
		$("#titreModal").html("Edition de la piece #" + idPie);
			
		if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText==""){
					alert ("La req n'a pas fonctionne");
					alert(xmlhttp.responseText);
				} else {
					var infType = xmlhttp.responseText.split('***');
					$("#inpName").val(infType[0]);
					$("#inpLAT").val(infType[1]);
					$("#inpLNG").val(infType[2]);
					$("#inpIdPie").val(idPie);
				}
			}
		}
		xmlhttp.open("GET","./include/Forms/Pie/infoPie.php?idPiece="+idPie,true);
		xmlhttp.send();
	}
	
	function confirmer(pie, bat){
		if (confirm ("Voulez-vous supprimer ?"))
			window.location="./include/Forms/Pie/remPie.php?idPiece="+pie+"&idBatiment="+bat;
	}
	
	function checkInfo(){
		if($("#addNameValue").val() != ""){
			$('#addPieModal button:submit').removeAttr("disabled", true);
		} else {
			$('#addPieModal button:submit').attr("disabled", true);
		}
		
		if($("#inpName").val() != ""){
			$('#editPieModal button:submit').removeAttr("disabled", true);
		} else {
			$('#editPieModal button:submit').attr("disabled", true);
		}
	}
	
	function cleanForm(){
		$("#addNameValue").val("");
		$('#addPieModal button:submit').attr("disabled", true);
	}
	
	
</script>
<style type="text/css">
	#map-canvasEdit { height: 225px; width: 100%; }
	#map-canvasAdd { height: 225px; width: 100%; }
</style>

<script type="text/javascript"
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC578bQir1LR4a7et03L-sfZURnwlWD0TI&sensor=true">
</script>
<script type="text/javascript">
	var mapEdit = null;
	var mapAdd = null;
	
	var marker = null;

	var infowindow = new google.maps.InfoWindow(
	{ 
		size: new google.maps.Size(150,50)
	});

// A function to create the marker and set up the event window function 
function createMarker(mapParam, latlng, name, html) {
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        map: mapParam,
        zIndex: Math.round(latlng.lat()*-100000)<<5
    });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString); 
        infowindow.open(mapParam,marker);
        });
    google.maps.event.trigger(marker, 'click');    
    return marker;
}

	function initialize() {
		var mapOptions = {
			center: new google.maps.LatLng(43.561267, 1.469426),
			zoom: 16,
			mapTypeControl: true,
			mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
			navigationControl: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		mapEdit = new google.maps.Map(document.getElementById("map-canvasEdit"),
		mapOptions);
		
		mapAdd = new google.maps.Map(document.getElementById("map-canvasAdd"),
		mapOptions);
		
		google.maps.event.addListener(mapEdit, 'click', function() {
			infowindow.close();
        });
		
		google.maps.event.addListener(mapAdd, 'click', function() {
			infowindow.close();
        });

		google.maps.event.addListener(mapEdit, 'click', function(event) {
			if (marker) {
				marker.setMap(null);
				marker = null;
			}
			
			$("#inpLAT").val(event.latLng.lat());
			$("#inpLNG").val(event.latLng.lng());
			
			marker = createMarker(mapEdit, event.latLng, "name", "<b>Location</b><br>"+event.latLng);

		});
		
		google.maps.event.addListener(mapAdd, 'click', function(event) {
			if (marker) {
				marker.setMap(null);
				marker = null;
			}
			
			$("#addLAT").val(event.latLng.lat());
			$("#addLNG").val(event.latLng.lng());
			
			marker = createMarker(mapAdd, event.latLng, "name", "<b>Location</b><br>"+event.latLng);

		});

	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>


<div class="row">
	<div class="col-lg-12">
		<h1>Edit Rooms 
			<small> Edit rooms of #<?php 
				include "./bdd.php";
				$resultats=$connection->query("SELECT NOM FROM batiment WHERE idBatiment = ".$_GET['idBatiment'] );
				$resultats->setFetchMode(PDO::FETCH_OBJ);
				$resultat = $resultats->fetch() ; 
				echo $resultat->NOM ; ?>
			</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php?p=Forms/Bat/editB"><i class="fa fa-edit"></i> Edit building</a></li>
			<li class="active"><i class="fa fa-home"></i> Edit rooms</li>
		</ol>
	</div>
</div><!-- /.row -->



<div class="row">
	<div class="col-lg-12">
		<h2>Rooms list :</h2>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th>Name <i class="fa fa-sort"></i></th>
						<th>Latitude <i class="fa fa-sort"></i></th>
						<th>Longitude <i class="fa fa-sort"></i></th>
						<th>Sensors <i class="fa fa-sort"></i></th>
						<th>Edit <i class="fa fa-sort"></i></th>
					</tr>
				</thead>
				<tbody id="tabPiece">
					<?php
						include "listPie.php";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div><!-- /.row -->




<div class="row">
	<div class="col-lg-12 text-center">
		<button onClick="cleanForm();" type="button" class="btn btn-success" data-toggle="modal" data-target="#addPieModal" style="width: 100px;font-size: 15pt;">Add</button>
	</div>
</div><!-- /.row -->

<!-- LES MODALS -->
<div class="modal fade" id="editPieModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Pie/updatePie.php">
				<div class="modal-body">
						<input type="hidden" id="inpIdPie" name="idPiece" value="">
						<input type="hidden" id="inpIdBat" name="idBatiment" value="<?php echo $idBatiment; ?>">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" onkeyup="checkInfo();"  id="inpName">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Latitude</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="lat" id="inpLAT" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Longitude</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="lng" id="inpLNG" readonly>
							</div>
						</div>		
						<div>
							<div id="map-canvasEdit"></div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="addPieModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal">New room</h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Pie/addPie.php">
				<div class="modal-body">
						<input type="hidden" id="inpIdPie" name="idPiece" value="">
						<input type="hidden" id="inpIdBat" name="idBatiment" value="<?php echo $idBatiment; ?>">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" onkeyup="checkInfo();"  id="addNameValue">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Latitude</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="lat" id="addLAT" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Longitude</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="lng" id="addLNG" readonly>
							</div>
						</div>
						<div>
							<div id="map-canvasAdd"></div>
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$("#addPieModal").on("shown.bs.modal", function () {
		google.maps.event.trigger(mapAdd, "resize");
	});
	
	$("#editPieModal").on("shown.bs.modal", function () {
		google.maps.event.trigger(mapEdit, "resize");
	});
</script>
