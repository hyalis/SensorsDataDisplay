
<script>
	function removeLabel(idlibelle)
	{
		if(confirm("Voulez vous vraiment supprimer le Label numero " + idCapt )){
			document.getElementById('tabLab').innerHTML='<h2><img src="./img/loading.gif" style="margin-right:25px;"/>Please wait...</h2>';
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
				document.getElementById('tabLab').innerHTML=xmlhttp.responseText;
					}
				}
			}
			
			xmlhttp.open("GET","./include/remLab.php?idLibVal="+idlibelle,true);
			xmlhttp.send();
		}	
	}
	
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
		xmlhttp.open("GET","./include/infoLab.php?idLibVal="+idlibelle,true);
		xmlhttp.send();
	}
	
	
</script>
<div class="row">
	<div class="col-lg-12">
		<h1>Edit Label <small>Edit your Label</small></h1>
		<ol class="breadcrumb">
			<li><a href="index.php?p=editT"><i class="fa fa-dashboard"></i>Edit Type</a></li>
			<li class="active"><i class="fa fa-edit"></i> Edit Label</li>
		</ol>
	</div>
</div>



<div class="row">
	<div class="col-lg-12">
		<h2>Types label :</h2>
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


<div class="modal fade" id="editLabelModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/updateLab.php">
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

 <div class="row">
	<div class="col-lg-12">
		<img src="./img/work_in.png" class="img-responsive center-block img-rounded" alt="Work in" style="width: 200px;">
	</div>
</div><!-- /.row -->