
<script>
	
	function editLabel(idlibelle)
	{
		$("#titreModal").html("Edition du Label #" + idlibelle);
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
					$("#inpDesc").val(infType[1]);
					$("#inpUnit").val(infType[2]);
					$("#inpIdLibVal").val(idlibelle);
				}
			}
		}
		xmlhttp.open("GET","./include/Forms/Lab/infoLab.php?idLibVal="+idlibelle,true);
		xmlhttp.send();
	}
	
	
	function checkInfo(){
		if($("#addNameValue").val() != ""){
			$('#addLabModal button:submit').removeAttr("disabled", true);
		} else {
			$('#addLabModal button:submit').attr("disabled", true);
		}
		
		if($("#inpName").val() != ""){
			$('#editLabModal button:submit').removeAttr("disabled", true);
		} else {
			$('#editLabModal button:submit').attr("disabled", true);
		}
	}
	
	function cleanForm(){
		$("#addNameValue").val("");
		$("#addDescValue").val("");
		$("#addUnitValue").val("");
		$('#addLabModal button:submit').attr("disabled", true);
	}
	
	
</script>
<div class="row">
	<div class="col-lg-12">
		<h1> Edit Label 
			<small> Edit your Label of #<?php 
				include "./bdd.php";
				$resultats=$connection->query("SELECT NOMTYPE FROM TYPECAPTEUR WHERE idTypeCapteur = ". $_GET['idTypeCapteur'] );
				$resultats->setFetchMode(PDO::FETCH_OBJ);
				$resultat = $resultats->fetch() ; 
				echo $resultat->NOMTYPE ; ?>
			</small></h1>
		<ol class="breadcrumb">
			<li><a href="index.php?p=Forms/Typ/editT"><i class="fa fa-dashboard"></i> Edit Type </a></li>
			<li class="active"><i class="fa fa-edit"></i> Edit Label </li>
		</ol>
	</div>
</div>



<div class="row">
	<div class="col-lg-12">
		<h2> Types label :</h2>
		<div class="table-responsive">
			<table class="table table-bordered table-hover table-striped tablesorter">
				<thead>
					<tr>
						<th>Label <i class="fa fa-sort"></i></th>
						<th>Description <i class="fa fa-sort"></i></th>
						<th>unite <i class="fa fa-sort"></i></th>
						<th>Edit <i class="fa fa-sort"></i></th>
					</tr>
				</thead>
				<tbody id="tabLab">
					<?php
						include "listLab.php";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 text-center">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addLabModal" onClick="cleanForm();" style="width: 100px;font-size: 15pt;">Add</button>
	</div>
</div><!-- /.row -->

<div class="modal fade" id="editLabelModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Lab/updateLab.php">
				<div class="modal-body" id="modalBody">
					<input type="hidden" id="inpIdLibVal" name="idLibVal" value="">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" id="inpName">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="description" id="inpDesc">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Unite</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="unite" id="inpUnit">
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

<div class="modal fade" id="addLabModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal">New Label</h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Lab/addLab.php">
				<div class="modal-body">
					<input type="hidden" id="inpIdTypeCapteur" name="idTypeCapteur" value="<?php echo $idTypeCapteur; ?>">
						<div class="form-group">
							<label class="col-sm-2 control-label" id="inpName">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" onkeyup="checkInfo();" id="addNameValue">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" id="inpDesc">Description</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="desc" onkeyup="checkInfo();" id="addDescValue">
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label" id="inpUnit">Unite</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="unit" onkeyup="checkInfo();" id="addUnitValue">
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
