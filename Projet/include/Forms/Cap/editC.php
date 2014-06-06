<script>	
	function editCap(idCap)
	{
		$("#listType").html("");
		$("#titreModal").html("Edition du capteur #" + idCap);
			
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
		xmlhttp.open("GET","./include/Forms/Cap/infoCap.php?idCapteur="+idCap,true);
		xmlhttp.send();
	}
	
	
	
	function checkInfo(){
		if($("#addNameValue").val() != ""){
			$('#addCapModal button:submit').removeAttr("disabled", true);
		} else {
			$('#addCapModal button:submit').attr("disabled", true);
		}
		
		if($("#inpName").val() != ""){
			$('#editCapModal button:submit').removeAttr("disabled", true);
		} else {
			$('#editCapModal button:submit').attr("disabled", true);
		}
	}
	
	function cleanForm(){
		$("#addNameValue").val("");
		editCap(-1);
		$('#addCapModal button:submit').attr("disabled", true);
	}
	
	function radioChange(radio){
		//alert("changement !");
		if(radio==1){
			$('#radio2').removeAttr("checked", true);
			$('#addNameValue').removeAttr("disabled", true);
			$('#listTypeAdd').removeAttr("disabled", true);
			$('#listCap').attr("disabled", true);
			checkInfo();
			$("#inpRadio").val("1");
		} else {
			$('#radio1').removeAttr("checked", true);
			$('#listCap').removeAttr("disabled", true);
			$('#addNameValue').attr("disabled", true);
			$('#listTypeAdd').attr("disabled", true);
			$('#addNameValue').val("");
			$('#addCapModal button:submit').removeAttr("disabled", true);
			$("#inpRadio").val("2");
		}
	
	}
	
</script>


<?php
	include "./bdd.php";
	$idPiece = $_GET['idPiece'];
	$resultats=$connection->query("SELECT Batiment_idBatiment as IDBAT, NOM FROM Piece WHERE idPiece = $idPiece");
	$resultats->setFetchMode(PDO::FETCH_OBJ);
	$resultat = $resultats->fetch();
	$idBatiment = $resultat->IDBAT;
	$nomPiece = $resultat->NOM;
?>
<div class="row">
	<div class="col-lg-12">
		<h1>Edit Sensors <small>Edit sensors of <?php echo $nomPiece; ?></small></h1>
		<ol class="breadcrumb">
			<li><a href="index.php?p=Forms/Bat/editB"><i class="fa fa-edit"></i> Edit building</a></li>
			<li><a href="index.php?p=Forms/Pie/editP&idBatiment=<?php echo $idBatiment; ?>"><i class="fa fa-home"></i> Edit rooms</a></li>
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
				<tbody id="tabCapteur">
					<?php
						
						include "listCap.php";
					?>
				</tbody>
			</table>
		</div>
	</div>
</div><!-- /.row -->



<div class="row">
	<div class="col-lg-12 text-center">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addCapModal" onClick="cleanForm();" style="width: 100px;font-size: 15pt;">Add</button>
	</div>
</div><!-- /.row -->



<div class="row">
	<div class="col-lg-12">
		<img src="./img/work_in.png" class="img-responsive center-block img-rounded" alt="Work in" style="width: 200px;">
	</div>
</div><!-- /.row -->





<!-- LES MODALS -->
<div class="modal fade" id="editCapModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Cap/updateCap.php">
				<div class="modal-body">
						<input type="hidden" id="inpIdCap" name="idCapteur" value="">
						<input type="hidden" id="inpIdPie" name="idPiece" value="<?php echo $idPiece; ?>">
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


<div class="modal fade" id="addCapModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal">New sensors in this room</h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/Forms/Cap/addCap.php">
				<input type="hidden" id="inpIdPie" name="idPiece" value="<?php echo $idPiece; ?>">
				<input type="hidden" id="inpRadio" name="radio" value="1">
				<div class="modal-body">
						<h4><input type="radio" id="radio1" checked onChange="radioChange(1);"> Add a new sensor</h4><br>
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
						<hr>
						<h4><input type="radio" id="radio2" onChange="radioChange(2);"> Or choose an existing sensor unused</h4><br>
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<select class="form-control" id="listCap" name="idCapteur" disabled>
									<?php
										include "getCap.php";
									?>	
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