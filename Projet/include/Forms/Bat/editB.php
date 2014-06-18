<script>

	function editBat(idBat)
	{
		$("#titreModal").html("Edition du batiment #" + idBat);
			
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
					var infoBat = xmlhttp.responseText.split('***');
					$("#inpName").val(infoBat[0]);
					$("#inpAdress").html(infoBat[1]);
					$("#inpZip").val(infoBat[2]);
					$("#inpCity").val(infoBat[3]);
					$("#inpIdBat").val(idBat);
				}
			}
		}
		xmlhttp.open("GET","./include/Forms/Bat/infoBat.php?idBatiment="+idBat,true);
		xmlhttp.send();
	}
	
	
	function checkInfo(){
		if($("#addNameValue").val() != ""){
			$('#addBatModal button:submit').removeAttr("disabled", true);
		} else {
			$('#addBatModal button:submit').attr("disabled", true);
		}
		
		if($("#inpName").val() != ""){
			$('#editBatModal button:submit').removeAttr("disabled", true);
		} else {
			$('#editBatModal button:submit').attr("disabled", true);
		}
	}
	
	function cleanForm(){
		$("#addNameValue").val("");
		$("#addAdressValue").val("");
		$("#addZipValue").val("");
		$("#addCityValue").val("");
		$('#addBatModal button:submit').attr("disabled", true);
	}
	
	
	function confirmer(bat){
		if (confirm ("Voulez-vous supprimer ?"))
			window.location="./include/Forms/Bat/remBat.php?idBatiment="+bat ;
	}
	
</script>

<div class="row">
	<div class="col-lg-12">
		<h1>Edit Buildings <small>Edit your buildings and rooms</small></h1>
		<ol class="breadcrumb">
			<li class="active"><i class="fa fa-edit"></i> Edit building</li>
		</ol>
	</div>
</div><!-- /.row -->



<div class="row">
	<div class="col-lg-12">
		<h2>Buildings list :</h2>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th>Name <i class="fa fa-sort"></i></th>
						<th>Adress <i class="fa fa-sort"></i></th>
						<th>Zip code <i class="fa fa-sort"></i></th>
						<th>City <i class="fa fa-sort"></i></th>
						<th>Rooms<i class="fa fa-sort"></i></th>
						<th>Edit <i class="fa fa-sort"></i></th>
					</tr>
				</thead>
				<tbody id="tabBatiment">
					<?php
						include "listBat.php";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div><!-- /.row -->

<div class="row">
	<div class="col-lg-12 text-center">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addBatModal" onClick="cleanForm();" style="width: 100px;font-size: 15pt;">Add</button>
	</div>
</div><!-- /.row -->

<!-- LES MODALS -->
<div class="modal fade" id="editBatModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Bat/updateBat.php">
				<div class="modal-body">
						<input type="hidden" id="inpIdBat" name="idBatiment" value="">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" onkeyup="checkInfo();" name="name" id="inpName">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Adress</label>
							<div class="col-sm-10">
								<textarea class="form-control" rows="3" name="adress" id="inpAdress"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Zip Code</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="zip" id="inpZip">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">City</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="city" id="inpCity">
							</div>
						</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" id="buttonSave">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="addBatModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal">New building</h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Bat/addBat.php">
				<div class="modal-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" id="inpName">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" onkeyup="checkInfo();" id="addNameValue">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Adress</label>
							<div class="col-sm-10">
								<textarea class="form-control" rows="3" name="adress" id="addAdressValue"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Zip Code</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="zip" id="addZipValue">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">City</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="city" id="addCityValue">
							</div>
						</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" disabled id="buttonSave">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>

