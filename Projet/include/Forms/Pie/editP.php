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
					$("#inpName").val(xmlhttp.responseText);
					$("#inpIdPie").val(idPie);
				}
			}
		}
		xmlhttp.open("GET","./include/Forms/Pie/infoPie.php?idPiece="+idPie,true);
		xmlhttp.send();
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
		$('#addBatModal button:submit').attr("disabled", true);
	}
	
	
</script>

<div class="row">
	<div class="col-lg-12">
		<h1>Edit Rooms 
			<small> Edit rooms of #<?php 
				include "./bdd.php";
				$resultats=$connection->query("SELECT nom FROM batiment WHERE idBatiment = ".$_GET['idBatiment'].";" );
				$resultats->setFetchMode(PDO::FETCH_OBJ);
				$resultat = $resultats->fetch() ; 
				echo $resultat->nom ; ?>
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
						<th>Sensors<i class="fa fa-sort"></i></th>
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
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addPieModal" onClick="cleanForm();" style="width: 100px;font-size: 15pt;">Add</button>
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
								<input type="text" class="form-control" name="name" onkeyup="checkInfo();" id="inpName">
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
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div>