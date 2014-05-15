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
							$("#listType").html( $("#listType").html() + "<option value='" + infoCap[i] + "' selected>" + infoCap[i+1] + "</option>");
						else
							$("#listType").html( $("#listType").html() + "<option value='" + infoCap[i] + "'>" + infoCap[i+1] + "</option>");
					}
					
					//$("#inpIdCap").val(idCap);
				}
			}
		}
		xmlhttp.open("GET","./include/infoCap.php?idCapteur="+idCap,true);
		xmlhttp.send();
	}
</script>

<div class="row">
	<div class="col-lg-12">
		<h1>Edit Sensors <small>Edit your sensors</small></h1>
		<ol class="breadcrumb">
			<li><a href="index.php?p=editB"><i class="fa fa-edit"></i> Edit building</a></li>
			<li class="active"><i class="fa fa-home"></i> Edit rooms</li>
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

<div class="modal fade" id="editCapModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/updateCap.php">
				<div class="modal-body">
						<input type="hidden" id="inpIdCap" name="idCapteur" value="">
						<input type="hidden" id="inpIdPie" name="idPiece" value="<?php echo $idPiece; ?>">
						<div class="form-group">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="name" id="inpName">
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



<div class="row">
	<div class="col-lg-12">
		<img src="./img/work_in.png" class="img-responsive center-block img-rounded" alt="Work in" style="width: 200px;">
	</div>
</div><!-- /.row -->