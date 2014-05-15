
<script>
	function removeType(idCapt)
	{
		if(confirm("Voulez vous vraiment supprimer le Type numero " + idCapt )){
			document.getElementById('tabType').innerHTML='<h2><img src="./img/loading.gif" style="margin-right:25px;"/>Please wait...</h2>';
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
				document.getElementById('tabType').innerHTML=xmlhttp.responseText;
					}
				}
			}
			xmlhttp.open("GET","./include/remType.php?idTypeCapteur="+idCapt,true);
			xmlhttp.send();
		}	
	}
	
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
		xmlhttp.open("GET","./include/infoType.php?idTypeCapteur="+idCapteur,true);
		xmlhttp.send();
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

<div class="modal fade" id="editTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="titreModal"></h4>
			</div>
			<form class="form-horizontal" role="form" method="GET" action="./include/updateType.php">
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


 <div class="row">
	<div class="col-lg-12">
		<img src="./img/work_in.png" class="img-responsive center-block img-rounded" alt="Work in" style="width: 200px;">
	</div>
</div><!-- /.row -->