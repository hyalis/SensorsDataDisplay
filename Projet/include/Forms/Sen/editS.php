<script>	
	// Permet de faire des modification sur le capteur voulu avec le modal d'édition
	function editSen(idSen)
	{
		$("#listType").html("");
		$("#titreModal").html("Edition du sensor");
			
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
					var infoCap = xmlhttp.responseText.split('***');
					$("#inpName").val(infoCap[0]);
					$("#inpIdCap").val(infoCap[1]);
					for(i = 2; i < infoCap.length - 1; i = i + 2){
						if(infoCap[i] == infoCap[infoCap.length-1])
							$("#listType,#listTypeAdd").html( $("#listType").html() + "<option value='" + infoCap[i] + "' selected>" + infoCap[i+1] + "</option>");
						else
							$("#listType, #listTypeAdd").html( $("#listType").html() + "<option value='" + infoCap[i] + "'>" + infoCap[i+1] + "</option>");
					}
					
					//$("#inpIdCap").val(idCap);
				}
			}
		}
		xmlhttp.open("GET","./include/Forms/Sen/infoSen.php?idSensor="+idSen,true);
		xmlhttp.send();
	}
	
	
	
	// Permet de vérifier si les infos dans le modal d'ajout ne contient pas des champs invalides
	function checkInfo(){
		if($("#addNameValue").val() != ""){
			$('#addSenModal button:submit').removeAttr("disabled", true);
		} else {
			$('#addSenModal button:submit').attr("disabled", true);
		}
		
		if($("#inpName").val() != ""){
			$('#editSenModal button:submit').removeAttr("disabled", true);
		} else {
			$('#editSenModal button:submit').attr("disabled", true);
		}
	}
	
	// Vide le champs de saisi dans le modal d'ajout
	function cleanForm(){
		$("#addNameValue").val("");
		editSen(-1);
		$('#addSenModal button:submit').attr("disabled", true);
	}
	
	// Demande de confirmation de suppression du capteur
	function confirmer(idSensor){
			if (confirm ("Etes vous sur de vouloir supprimer ?"))
			window.location="./include/Forms/Sen/remSen.php?idSensor="+idSensor ;
	}
	
	
</script>


<div class="row">
	<div class="col-lg-12">
		<h1>Edit Sensors <small>Edit sensors</small></h1>
		<ol class="breadcrumb">
			<li class="active"><i class="fa fa-signal"></i> Edit sensors</li>
		</ol>
	</div>
</div><!-- /.row -->


<div class="row">
	<div class="col-lg-12">
		<h2>Sensors list :</h2>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th>Name <i class="fa fa-sort"></i></th>
						<th>Type<i class="fa fa-sort"></i></th>
						<th>Edit <i class="fa fa-sort"></i></th>
					</tr>
				</thead>
				<tbody id="tabSensor">
					<?php
						
						include "listSen.php";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div><!-- /.row -->



<div class="row">
	<div class="col-lg-12 text-center">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addSenModal" onClick="cleanForm();" style="width: 100px;font-size: 15pt;">Add</button>
	</div>
</div><!-- /.row -->



<!-- LES MODALS -->
<div class="modal fade" id="editSenModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Sen/updateSen.php">
				<div class="modal-body">
						<input type="hidden" id="inpIdCap" name="idCapteur" value="">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" onkeyup="checkInfo();" id="inpName">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Type</label>
							<div class="col-sm-10">
								<select class="form-control" id="listType" name="idTypeCapteur">
								</select>
							</div>
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


<div class="modal fade" id="addSenModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal">New sensors</h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Sen/addSen.php">
				<div class="modal-body">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" onkeyup="checkInfo();" id="addNameValue">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Type</label>
							<div class="col-sm-10">
								<select class="form-control" id="listTypeAdd" name="idTypeCapteur">
								</select>
							</div>
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