
<script>
	
	function editType(idCapteur)
	{
		$("#titreModal").html("Edition du Type #" + idCapteur);
			
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
					var infType = xmlhttp.responseText ;
					$("#inpName").val(infType);
					$("#inpIdType").val(idCapteur);
				}
			}
		}
		xmlhttp.open("GET","./include/Forms/Typ/infoType.php?idTypeCapteur="+idCapteur,true);
		xmlhttp.send();
	}
	
	function checkInfo(){
		if($("#addNameValue").val() != ""){
			$('#addTypModal button:submit').removeAttr("disabled", true);
		} else {
			$('#addTypModal button:submit').attr("disabled", true);
		}
		
		if($("#inpName").val() != ""){
			$('#editTypModal button:submit').removeAttr("disabled", true);
		} else {
			$('#editTypModal button:submit').attr("disabled", true);
		}
	}
	
	function cleanForm(){
		$("#addNameValue").val("");
		$('#addTypModal button:submit').attr("disabled", true);
	}
	
</script>
<div class="row">
	<div class="col-lg-12">
		<h1>Edit Type <small>Edit your Type</small></h1>
		<ol class="breadcrumb">
			<li class="active"><i class="fa fa-edit"></i> Edit Type</li>
		</ol>
	</div>
</div>



<div class="row">
	<div class="col-lg-12">
		<h2>Types list :</h2>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th>Name <i class="fa fa-sort"></i></th>
						<th>Number of measure <i class="fa fa-sort"></i></th>
						<th>Edit <i class="fa fa-sort"></i></th>
					</tr>
				</thead>
				<tbody id="tabType">
					<?php
						include "listType.php";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- LES MODALS -->
<div class="modal fade" id="editTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Typ/updateType.php">
				<div class="modal-body" id="modalBody">
					<input type="hidden" id="inpIdType" name="idTypeCapteur" value="">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" id="inpName">
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

<div class="modal fade" id="addTypModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal">New Type</h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Typ/addTyp.php">
				<div class="modal-body">
						<div class="form-group">
							<label class="col-sm-2 control-label" id="inpName">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" onkeyup="checkInfo();" id="addNameValue">
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


<div class="row">
	<div class="col-lg-12 text-center">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addTypModal" onClick="cleanForm();" style="width: 100px;font-size: 15pt;">Add</button>
	</div>
</div><!-- /.row -->

 <div class="row">
	<div class="col-lg-12">
		<img src="./img/work_in.png" class="img-responsive center-block img-rounded" alt="Work in" style="width: 200px;">
	</div>
</div><!-- /.row -->