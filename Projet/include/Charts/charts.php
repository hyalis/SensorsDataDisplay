<?php
	include "./bdd.php";
?>

<script src="js/jquery-1.10.2.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css">
<script type='text/javascript' src='js/jquery.treeselect.js'></script>
<link rel='stylesheet' type='text/css' href='css/jquery.treeselect.css' />


<script type="text/javascript" src="./js/jscolor.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script src="js/jQDateRangeSlider-withRuler-min.js"></script>
<script src="js/moment.min.js"></script>
<script src="./amcharts/serial.js" type="text/javascript"></script>





	<style>
		#wrapper {
			width: 80%;
			float: left;
			padding-left: 0px;
		}
		#tree-wrapper {
			width: 20%;
			float: left;
			margin-top: 65px;
			padding-left: 25px;
		}
	</style>

<link rel="stylesheet" href="./css/iThing.css" type="text/css" >

<!-- Init le bubblechart -->
<script type="text/javascript">
	var chart;
		
	var chartData = [{
								"y" : 0,
								"x" : 0,
								"value" : 0
				
							}
	];
	
	exportConfig = {
		menuTop: 'auto',
		menuLeft: 'auto',
		menuRight: '30px',
		menuBottom: '30px',
		menuItems: [{
			textAlign: 'center',
			onclick: function () {},
			icon: '../amcharts/images/export.png',
			iconTitle: 'Save chart as an image',
			items: [{
				title: 'JPG',
				format: 'jpg'
			}, {
				title: 'PNG',
				format: 'png'
			}, {
				title: 'SVG',
				format: 'svg'
			}]
		}],
		menuItemStyle: {
			backgroundColor: 'transparent',
			rollOverBackgroundColor: '#EFEFEF',
			color: '#000000',
			rollOverColor: '#CC0000',
			paddingTop: '6px',
			paddingRight: '6px',
			paddingBottom: '6px',
			paddingLeft: '6px',
			marginTop: '0px',
			marginRight: '0px',
			marginBottom: '0px',
			marginLeft: '0px',
			textAlign: 'left',
			textDecoration: 'none'
		}
	}
	
	
	var graph = new AmCharts.AmGraph();
	AmCharts.ready(function () {
		// XY Chart
		chart = new AmCharts.AmXYChart();
		chart.pathToImages = "amcharts/images/";
		chart.dataProvider = chartData;
		chart.startDuration = 1.5;
	
		// AXES
		// X
		var xAxis = new AmCharts.ValueAxis();
		xAxis.position = "bottom";
		xAxis.axisAlpha = 0;
		xAxis.minMaxMultiplayer = 1.2;
		chart.addValueAxis(xAxis);
	
		// Y
		var yAxis = new AmCharts.ValueAxis();
		yAxis.position = "left";
		yAxis.minMaxMultiplier = 1.2;
		yAxis.axisAlpha = 0;
		chart.addValueAxis(yAxis);
	
		// GRAPHS
		// first graph
		
		graph.valueField = "value";
		graph.lineColor = "#00FFFF";
		graph.xField = "x";
		graph.yField = "y";
		graph.lineAlpha = 0;
		graph.bullet = "bubble";
		graph.bulletBorderThickness = 0.5;
		graph.bulletAlpha = 0.75;	//Opacity
		graph.bulletBorderAlpha = 0.8;	//Opacity des bords
		graph.balloonText = "x:<b>[[x]]</b> y:<b>[[y]]</b><br>value:<b>[[value]]</b>";
		chart.addGraph(graph);
	
		// CURSOR
		var chartCursor = new AmCharts.ChartCursor();
		chart.addChartCursor(chartCursor);
	
		// SCROLLBAR
		var chartScrollbar = new AmCharts.ChartScrollbar();
		chart.addChartScrollbar(chartScrollbar);
	
		chart.exportConfig = {}; 
	
		// WRITE                                                
		//chart.write("chartdiv");
	});
</script>

<!-- Init le line chart -->
<script type="text/javascript">
           var chart2;
			var chartData = [];        
           AmCharts.ready(function () {
               // SERIAL CHART
               chart2 = new AmCharts.AmSerialChart();
               chart2.pathToImages = "./amcharts/images/";
			   chart2.dataDateFormat = "YYYY-MM-DD HH";
               chart2.dataProvider = chartData;
               chart2.categoryField = "date";
			   chart2.autoMarginOffset = 20;
               // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
              // chart2.addListener("dataUpdated", zoomChart);

               // AXES
               // category
               var categoryAxis = chart2.categoryAxis;
               categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
               categoryAxis.minPeriod = "hh"; // our data is daily, so we set minPeriod to DD
               categoryAxis.minorGridEnabled = true;
               categoryAxis.axisColor = "#DADADA";

               // first value axis (on the left)
               var valueAxis1 = new AmCharts.ValueAxis();
               valueAxis1.axisColor = "#FF6600";
               valueAxis1.axisThickness = 2;
               valueAxis1.gridAlpha = 0;
               chart2.addValueAxis(valueAxis1);

               // second value axis (on the right)
               var valueAxis2 = new AmCharts.ValueAxis();
               valueAxis2.position = "right"; // this line makes the axis to appear on the right
               valueAxis2.axisColor = "#FCD202";
               valueAxis2.gridAlpha = 0;
               valueAxis2.axisThickness = 2;
               chart2.addValueAxis(valueAxis2);

               // third value axis (on the left, detached)
               valueAxis3 = new AmCharts.ValueAxis();
               valueAxis3.offset = 50; // this line makes the axis to appear detached from plot area
               valueAxis3.gridAlpha = 0;
               valueAxis3.axisColor = "#B0DE09";
               valueAxis3.axisThickness = 2;
               chart2.addValueAxis(valueAxis3);

               // GRAPHS
               // first graph
               var graph1 = new AmCharts.AmGraph();
               graph1.valueAxis = valueAxis1; // we have to indicate which value axis should be used
               graph1.title = "x";
               graph1.valueField = "x";
               graph1.bullet = "round";
               graph1.hideBulletsCount = 30;
               graph1.bulletBorderThickness = 1;
               chart2.addGraph(graph1);

               // second graph
               var graph2 = new AmCharts.AmGraph();
               graph2.valueAxis = valueAxis2; // we have to indicate which value axis should be used
               graph2.title = "y";
               graph2.valueField = "y";
               graph2.bullet = "square";
               graph2.hideBulletsCount = 30;
               graph2.bulletBorderThickness = 1;
               chart2.addGraph(graph2);

               // third graph
               var graph3 = new AmCharts.AmGraph();
               graph3.valueAxis = valueAxis3; // we have to indicate which value axis should be used
               graph3.valueField = "value";
               graph3.title = "value";
               graph3.bullet = "triangleUp";
               graph3.hideBulletsCount = 30;
               graph3.bulletBorderThickness = 1;
               chart2.addGraph(graph3);

               // CURSOR
               var chartCursor = new AmCharts.ChartCursor();
               chartCursor.cursorPosition = "mouse";
               chart2.addChartCursor(chartCursor);

               // SCROLLBAR
               var chartScrollbar = new AmCharts.ChartScrollbar();
               chart2.addChartScrollbar(chartScrollbar);

               // LEGEND
               var legend = new AmCharts.AmLegend();
               legend.marginLeft = 110;
               legend.useGraphSettings = true;
               chart2.addLegend(legend);

               // WRITE
               //chart2.write("graphdiv");
			   
           });

           // generate some random data, quite different range
          /* function generateChartData() {
				chartData.push(<?php include "reqLineChart.php"; ?>);
           }*/

           // this method is called when chart is first inited as we listen for "dataUpdated" event
           function zoomChart() {
               // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
               chart2.zoomToIndexes(10, 20);
           }
</script>

<!-- Affiche/Cache les parametres -->
<script>
	function cacher(varCour){
		switch(varCour){
			case 1 :	$("#var2 :input").attr("disabled", true);
						$("#var3 :input").attr("disabled", true);
				break;
			case 2 :	$("#var1 :input").attr("disabled", true);
						$("#var3 :input").attr("disabled", true);
				break;
			case 3 :	$("#var1 :input").attr("disabled", true);
						$("#var2 :input").attr("disabled", true);
				break;
		}
	}
	
	function afficher(varCour){
		switch(varCour){
			case 1 :	$("#var2 :input").attr("disabled", false);
						$("#var3 :input").attr("disabled", false);
				break;
			case 2 :	$("#var1 :input").attr("disabled", false);
						$("#var3 :input").attr("disabled", false);
				break;
			case 3 :	$("#var1 :input").attr("disabled", false);
						$("#var2 :input").attr("disabled", false);
				break;
		}
	}
</script>

<!-- Recharge les data du chart en fonction du temps -->
<script>
function updaValues(){
		var dateDeb = $(".ui-rangeSlider-leftLabel .ui-rangeSlider-label-value").html();
		var dateFin = $(".ui-rangeSlider-rightLabel .ui-rangeSlider-label-value").html();
		
		opt1capt = document.getElementById('optioncapteur1').value;
		opt1lib = document.getElementById('optionlib1').value;
		
		opt2capt = document.getElementById('optioncapteur2').value;
		opt2lib = document.getElementById('optionlib2').value;
		
		opt3capt = document.getElementById('optioncapteur3').value;
		opt3lib = document.getElementById('optionlib3').value;
		
		groupBy = document.getElementById('groupBy').value;
		
		
		document.getElementById('graphiques').style.position = 'relative'; document.getElementById('graphiques').style.top = '0px';
		
		document.getElementById('graphdiv').innerHTML='<h2><img src="./img/loading.gif" style="margin-right:25px;"/>Please wait...</h2>';
		if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText==""){
				
				} else {
					document.getElementById('graphiques').style.position = 'relative'; document.getElementById('graphiques').style.top = '0px';
					$("#slider").resize();
					
					var elem = xmlhttp.responseText.split('END');
					var dataBubble = elem[0];
					var dataLine = elem[1];
					
					var chartData = JSON.parse("[" + dataBubble + "]");
					chart.dataProvider = chartData;
					chart.validateData();
					//chart.write("chartdiv");
					
					chartData = JSON.parse("[" + dataLine + "]"); 
					
					switch(groupBy){
						case "YEAR": chart2.categoryAxis.minPeriod = "YYYY";
							break;
						case "MONTH": chart2.categoryAxis.minPeriod = "MM";	
							break;
						case "DAY": chart2.categoryAxis.minPeriod = "DD";	
							break;
						case "HOUR": chart2.categoryAxis.minPeriod = "hh";	
							break;
						default : chart2.categoryAxis.minPeriod = "DD";
					}
									
					chart2.dataProvider = chartData;
					chart2.validateData();
					
					if($("ul#onglet li.active a").attr('href')=='#line'){
						chart2.write("graphdiv");
					} else {
						chart.write("graphdiv");
					}
				}
			}
		}
		xmlhttp.open("GET","./include/Charts/reqChart.php?dateDeb="+dateDeb+"&dateFin="+dateFin+"&idCapteur1="+opt1capt+"&idLibVal1="+opt1lib+"&idCapteur2="+opt2capt+"&idLibVal2="+opt2lib+"&idCapteur3="+opt3capt+"&idLibVal3="+opt3lib+"&groupBy="+groupBy,true);
		xmlhttp.send();
	}
</script>


<!-- Charge les pieces -->
<script>
	function showPiece(str, valeur)
	{
		document.getElementById('formPiece'+valeur).style.visibility="hidden";
		document.getElementById('formCapteur'+valeur).style.visibility="hidden";
		document.getElementById('formLib'+valeur).style.visibility="hidden";
		cacher(valeur);
		if (str==""){
			document.getElementById('optionpiece'+valeur).innerHTML="";
			return;
		} 
		if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('optionpiece'+valeur).innerHTML=xmlhttp.responseText;
				if(xmlhttp.responseText.indexOf("option")==-1){
					afficher(valeur);
					document.getElementById('formPiece'+valeur).style.visibility="hidden";
					document.getElementById('formCapteur'+valeur).style.visibility="hidden";
					document.getElementById('formLib'+valeur).style.visibility="hidden";
					showSubmit();
				} else {
					afficher(valeur);
					piece = document.getElementById('optionpiece' + valeur).value;
					showCapteur(piece, valeur);
					document.getElementById('formPiece'+valeur).style.visibility="visible";
					showSubmit();
				}
			}
		}

		xmlhttp.open("GET","./include/Charts/getPiece.php?batiment="+str,true);
		xmlhttp.send();
	}
</script>

<!-- Charge les capteurs -->
<script>
	function showCapteur(str, valeur)
	{
		
		document.getElementById('formCapteur'+valeur).style.visibility="hidden";
		document.getElementById('formLib'+valeur).style.visibility="hidden";
		cacher(valeur);
		if (str==""){
			document.getElementById('optioncapteur'+valeur).innerHTML="";
			return;
		} 
		if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('optioncapteur'+valeur).innerHTML=xmlhttp.responseText;
				if(xmlhttp.responseText.indexOf("option")==-1){
					afficher(valeur);
					document.getElementById('formCapteur'+valeur).style.visibility="hidden";
					document.getElementById('formLib'+valeur).style.visibility="hidden";
					showSubmit();
				} else {
					afficher(valeur);
					capteur = document.getElementById('optioncapteur' + valeur).value;
					showLib(capteur, valeur);
					document.getElementById('formCapteur'+valeur).style.visibility="visible";
					showSubmit();
				}
			}
		}
		
		xmlhttp.open("GET","./include/Charts/getCapteur.php?idPiece="+str,true);
		xmlhttp.send();
	}
</script>

<!-- Charge les libelle des variables -->
<script>
	function showLib(str, valeur)
	{
		document.getElementById('formLib'+valeur).style.visibility="hidden";
		cacher(valeur);
		if (str==""){
			document.getElementById('optionlib'+valeur).innerHTML="";
			return;
		} 
		if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				document.getElementById('optionlib'+valeur).innerHTML=xmlhttp.responseText;
				if(xmlhttp.responseText.indexOf("option")==-1){
					afficher(valeur);
					document.getElementById('formLib'+valeur).style.visibility="hidden";
					showSubmit();
				} else {
					afficher(valeur);
					document.getElementById('formLib'+valeur).style.visibility="visible";
					showSubmit();
				}
			}
		}
		
		xmlhttp.open("GET","./include/Charts/getLib.php?idCapteur="+str,true);
		xmlhttp.send();
	}
</script>

<!-- Change la couleur du graph -->
<script>
	function updaColor(color){
		graph.lineColor = "#"+color;
		chart.validateNow();
	}
</script>


<script>
	$('#line a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
});
	function changeBullet(str){
	graph.bullet = str;
	chart.validateNow();
	}
</script>

<script>
	function showSubmit(){
		if($("#optionlib1").css("visibility") == "visible" && $("#optionlib2").css("visibility") == "visible" && $("#optionlib3").css("visibility") == "visible"){
			document.getElementById('submit').style.display='';
			updaStats();
		} else {
			document.getElementById('submit').style.display='none';
		}
	}
</script>

<script>
	function updaStats(){
		var dateDeb = $(".ui-rangeSlider-leftLabel .ui-rangeSlider-label-value").html();
		var dateFin = $(".ui-rangeSlider-rightLabel .ui-rangeSlider-label-value").html();
		
		opt1capt = document.getElementById('optioncapteur1').value;
		opt1lib = document.getElementById('optionlib1').value;
		
		
		if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText == ""){
					document.getElementById('nbrData').innerHTML = '';
				} else {
					document.getElementById('nbrData').innerHTML = xmlhttp.responseText;
				}
			}
		}
		xmlhttp.open("GET","./include/Charts/stats.php?dateDeb="+dateDeb+"&dateFin="+dateFin+"&idCapteur1="+opt1capt+"&idLibVal1="+opt1lib,true);
		xmlhttp.send();
	}
</script>
<script>
	function onLine(){
		$('#slider').resize(); 
		document.getElementById('parameters').style.display='none'; 
		chart2.write('graphdiv');
	}
	
	function onBubble(){
		$('#slider').resize(); 
		document.getElementById('parameters').style.display=''; 
		chart.write('graphdiv');
	}
	
	
	
	
	
		//DEBUT TREE
			var maxDepth = 3;
			var loadChildren = function(node, level) {
				var hasChildren = node.level < maxDepth;
				
				
				
				node.children.push({
					id:'bat'+1,
					title:'Tripode C',
					has_children:true,
					level: 1,
					children:[
						{
							id:'pie'+1,
							title:'Chambre 8024',
							has_children:true,
							level: 2,
							children:[
								{
									id:'lieu'+1,
									title:'Salle de Bain',
									has_children:false,
									level: 3,
									children:[]
								},
								{
									id:'lieu'+2,
									title:'Cuisine',
									has_children:false,
									level: 3,
									children:[]
								},
								{
									id:'lieu'+3,
									title:'Salon',
									has_children:false,
									level: 3,
									children:[]
								}
							]
						},
						{
							id:'pie'+2,
							title:'Chambre 8025',
							has_children:false,
							level: 2,
							children:[]
						},
						{
							id:'pie'+3,
							title:'Chambre 8026',
							has_children:false,
							level: 2,
							children:[]
						}
					]
				});
				
				
				/*
				for (var i=0; i<8; i++) {
					var id = node.id + (i+1).toString();
					node.children.push({
						id:id,
						title:'Node ' + id,
						has_children:hasChildren,
						level: node.level + 1,
						children:[]
					});
					if (hasChildren && level < 2) {
						loadChildren(node.children[i], (level+1));
					}
				}*/
				return node;
			};
		
		
	   jQuery(function() {
				$('div.chosentree').chosentree({
					width: 200,
					deepLoad: true,
					showtree: true,
					load: function(node, callback) {
						setTimeout(function() {
						callback(loadChildren(node, 0));
						}, 1000);
					}
				});
			});
			
			
			
			

    //FIN TREE
			
			
	
	
	
</script>


<!-- En t�te du wrapper -->
<div class="row">
  <div class="col-lg-12">
	<h1>Charts <small>Display Your Data</small></h1>
	<ol class="breadcrumb">
	  <li class="active"><i class="fa fa-bar-chart-o"></i> Charts</li>
	</ol>
  </div>
</div><!-- /.row -->


<div class="row" id="graphiques" style="position:absolute; top:-2000px;">
	<div class="col-lg-12">
		<h2>Charts</h2>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Your differents charts</h3>
			</div>
			<div class="panel-body">
				 
				<ul class="nav nav-tabs" id="onglet">
					<li class="active"><a href="#line" data-toggle="tab" onclick="onLine();">Line</a></li>
					<li><a href="#bubble" data-toggle="tab" onclick="onBubble();">Bubble</a></li>
				</ul>
				
				<div id="graphdiv" style="width: auto; height: 350px;"></div>
			</div>
		</div>
	</div>
</div>


<!-- Param�trage des trois variables -->
<div class="row">
	<!-- Premi�re donn�e-->
	<div class="col-lg-4">
		<div class="panel panel-primary" id="var1">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> First data (x)</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Select Building</label>
					<select class="form-control" onchange="showPiece(this.value, 1)">
						<option>Choose :</option>
					<?php
						$resultats=$connection->query("SELECT nom FROM batiment");
						$resultats->setFetchMode(PDO::FETCH_OBJ);
						while( $resultat = $resultats->fetch() )
						{
								echo '<option>'.$resultat->nom.'</option>';
						}
						$resultats->closeCursor();
					?>
					</select>
				</div>
				<div class="form-group" id="formPiece1" style="visibility: hidden;">
					<label>Select Room</label>
					<select class="form-control" id="optionpiece1" onchange="showCapteur(this.value, 1)">
						<option>Choisir</option>
					</select>
				</div>
				<div class="form-group" id="formCapteur1" style="visibility: hidden;" >
					<label>Select Sensor</label>
					<select class="form-control" id="optioncapteur1" onchange="showLib(this.value, 1)">
						<option>Choisir</option>
					</select>
				</div>
				<div class="form-group" id="formLib1" style="visibility: hidden;" >
					<label>Select Variable</label>
					<select class="form-control" id="optionlib1">
						<option>Choisir</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<!-- Seconde donn�e-->
	<div class="col-lg-4" id="var2">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Second data (y)</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Select Building</label>
					<select class="form-control" onchange="showPiece(this.value, 2)">
						<option>Choose :</option>
					<?php
						$resultats=$connection->query("SELECT nom FROM batiment");
						$resultats->setFetchMode(PDO::FETCH_OBJ);
						while( $resultat = $resultats->fetch() )
						{
								echo '<option>'.$resultat->nom.'</option>';
						}
						$resultats->closeCursor();
					?>
					</select>
				</div>
				<div class="form-group" id="formPiece2" style="visibility: hidden;">
					<label>Select Room</label>
					<select class="form-control" id="optionpiece2" onchange="showCapteur(this.value, 2)">
						<option>Choisir</option>
					</select>
				</div>
				<div class="form-group" id="formCapteur2" style="visibility: hidden;" >
					<label>Select Sensor</label>
					<select class="form-control" id="optioncapteur2" onchange="showLib(this.value, 2)">
						<option>Choisir</option>
					</select>
				</div>
				<div class="form-group" id="formLib2" style="visibility: hidden;" >
					<label>Select Variable</label>
					<select class="form-control" id="optionlib2">
						<option>Choisir</option>
					</select>
				</div>
			</div>
		</div>
	</div>
	<!-- Troisi�me donn�e-->
	<div class="col-lg-4" id="var3">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Third data (value)</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Select Building</label>
					<select class="form-control" onchange="showPiece(this.value, 3)">
						<option>Choose :</option>
					<?php
						$resultats=$connection->query("SELECT nom FROM batiment");
						$resultats->setFetchMode(PDO::FETCH_OBJ);
						while( $resultat = $resultats->fetch() )
						{
								echo '<option>'.$resultat->nom.'</option>';
						}
						$resultats->closeCursor();
					?>
					</select>
				</div>
				<div class="form-group" id="formPiece3" style="visibility: hidden;">
					<label>Select Room</label>
					<select class="form-control" id="optionpiece3" onchange="showCapteur(this.value, 3)">
						<option>Choisir</option>
					</select>
				</div>
				<div class="form-group" id="formCapteur3" style="visibility: hidden;" >
					<label>Select Sensor</label>
					<select class="form-control" id="optioncapteur3" onchange="showLib(this.value, 3)">
						<option>Choisir</option>
					</select>
				</div>
				<div class="form-group" id="formLib3" style="visibility: hidden;" >
					<label>Select Variable</label>
					<select class="form-control" id="optionlib3">
						<option>Choisir</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12" id="sliderDate">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Date range</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<div id="slider"></div>
				</div>
				<div class="form-group" style="width: 150px;">
					<label>Select Group by</label>
					<select class="form-control" id="groupBy">
						<option value='HOUR'>Hour</option>
						<option value='DAY'>Day</option>
						<option value='WEEK'>Week</option>
						<option value='MONTH'>Month</option>
						<option value='YEAR'>Year</option>
					</select>
				</div>
				
			</div>
		</div>
	</div>
</div>


<!-- Autres param�tre (couleur, forme, ...) et BtnSubmit -->
<div class="row">
	<div class="col-lg-8"  id="parameters" style="display:none;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Parameters</h3>
			</div>
			<div class="panel-body">
				<div class="form-group">
					<label>Select Color</label>
					<input class="form-control color" onchange="updaColor(this.value)" value="00FFFF">
				</div>
				<div class="form-group">
					<label>Select Bullet</label>
					<select class="form-control" onchange="changeBullet(this.value)">
						<option>none</option>
						<option>round</option>
						<option>square</option>
						<option>triangleUp</option>
						<option>triangleDown</option>
						<option>triangleLeft</option>
						<option>triangleRight</option>
						<option selected="selected">bubble</option>
						<option>diamond</option>
						<option>xError</option>
						<option>yError</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-4" id="submit" style="display:none;">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Data (approximate)</h3>
			</div>
			 <div class="panel-body">
				<b><span id="nbrData">0</span></b> <br><br><br>
				<button class="btn btn-success" style="float: right;" onClick="updaValues(); ">Submit</button>
			</div>
		</div>
	</div>
</div><!-- /.row -->

<!-- Lance le dateSlider -->	
<script>
	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
  $("#slider").dateRangeSlider({
    bounds: {min: new Date(2010, 11, 1), max: new Date(2010, 12, 31)},
    defaultValues: {min: new Date(2010, 11, 13), max: new Date(2010, 11, 20)},
    scales: [{
      first: function(value){ return value; },
      end: function(value) {return value; },
      next: function(value){
        var next = new Date(value);
        return new Date(next.setMonth(value.getMonth() + 1));
      },
      label: function(value){
        return months[value.getMonth()];
      },
      format: function(tickContainer, tickStart, tickEnd){
        tickContainer.addClass("myCustomClass");
      }
    }]
  });
</script>
	
	
<script>
	$("#slider").bind("valuesChanged", function(e, data){
		updaStats();
	});
	
</script>