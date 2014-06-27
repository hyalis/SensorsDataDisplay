<?php
	include "./bdd.php";
?>


<link rel="stylesheet" href="css/jquery-ui.css">
<link rel='stylesheet' type='text/css' href='css/jquery.treeselect.css' />
<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>

<script src="js/jquery-1.10.2.js"></script>
<script type='text/javascript' src='js/jquery.treeselect.js'></script>
<script type="text/javascript" src="./js/jscolor.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script src="js/moment.min.js"></script>
<script src="./amcharts/serial.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>

<!-- Init le bubblechart -->
<script type="text/javascript">
	var chart;
	var dataLibMap = [];
	var chartData = [{
								"y" : 0,
								"x" : 0,
								"value" : 0
					}];
	
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

<!-- Init le line chart -->
	var chart2;
	var chartData = [];        
	AmCharts.ready(function () {
	   // SERIAL CHART
	   chart2 = new AmCharts.AmSerialChart();
	   chart2.pathToImages = "./amcharts/images/";
	   chart2.dataDateFormat = "YYYY-MM-DD HH:NN:SS";
	   chart2.dataProvider = chartData;
	   chart2.categoryField = "date";
	   chart2.autoMarginOffset = 20;
	   // listen for "dataUpdated" event (fired when chart is inited) and call zoomChart method when it happens
	  // chart2.addListener("dataUpdated", zoomChart);
	  
		//AXES
		var categoryAxis = chart2.categoryAxis;
		categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
		categoryAxis.minPeriod = "ss"; // our data is daily, so we set minPeriod to DD
		categoryAxis.minorGridEnabled = true;
		categoryAxis.axisColor = "#DADADA";

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
	});

	// this method is called when chart is first inited as we listen for "dataUpdated" event
	function zoomChart() {
	   // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
	   chart2.zoomToIndexes(10, 20);
	}
	
	var tabGraphs = new Array();
	<!-- Recharge les data du chart en fonction du temps -->
	function updaValues(){
		var dateDeb = $("#datetimepickerDeb").val();
		var dateFin = $("#datetimepickerFin").val();
		
		if($("#live .active input").val() == 'ON')
			dateFin = "2999-12-31 23:59:59";
		
		groupBy = document.getElementById('groupBy').value;
		
		if($(".nav-tabs .active a").attr("value") == "Geo")
			url = updaValueGeo(dateDeb,dateFin,groupBy);
		if($(".nav-tabs .active a").attr("value") == "Sensor")
			url = updaValueSen(dateDeb,dateFin,groupBy);
		if($(".nav-tabs .active a").attr("value") == "Exper" || $(".nav-tabs .active a").attr("value") == "Map")
			url = updaValueExp(dateDeb,dateFin,groupBy);

			
		//document.getElementById('graphiques').style.position = 'relative'; document.getElementById('graphiques').style.top = '0px';	
		document.getElementById('graphdiv').innerHTML='<h2><img src="./img/loading.gif" style="margin-right:25px;"/>Please wait...</h2>';
		$("#graphiques .nav-tabs li").removeClass('active');
		$("#graphiques .nav-tabs li:contains(Line)").attr("class","active");
		
		if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		} else {	// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				if(xmlhttp.responseText==""){
				
				} else {
					//document.getElementById('graphiques').style.position = 'relative'; document.getElementById('graphiques').style.top = '0px';
					document.getElementById('map-canvas').style.display='none';
					document.getElementById('graphdiv').style.display='';
					
					for(i=0; i < tabGraphs.length; i++){
						chart2.removeGraph(tabGraphs[i]);
					}
					tabGraphs = new Array();
					for(i=0; i < $(".chosentree-choices li").size()-1; i++){
					
						var valueAxis = new AmCharts.ValueAxis();
						valueAxis.axisColor = "#FF6600";
						valueAxis.axisThickness = 2;
						valueAxis.gridAlpha = 0;
						valueAxis.axisAlpha = 0;
						valueAxis.labelsEnabled = false;
						chart2.addValueAxis(valueAxis);
						
						var graph = new AmCharts.AmGraph();
						graph.title = $(".chosentree-choices li span").get(i).textContent;
						graph.valueAxis = valueAxis;
						graph.valueField = i;
						graph.bullet = "round";
						graph.hideBulletsCount = 30;
						graph.bulletBorderThickness = 1;
						if($("#connect .active input").val() == "connect")
							graph.connect = true;
						else
							graph.connect = false;
						chart2.addGraph(graph);		
						tabGraphs[i] = graph;
					}
					
					var elem = xmlhttp.responseText.split('END');
					var dataBubble = elem[0];
					var dataLine = elem[1];
					
					var chartData = JSON.parse("[" + dataBubble + "]");
					chart.dataProvider = chartData;
					chart.validateData();
					
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
						case "MIN" : chart2.categoryAxis.minPeriod = "mm";
							break;
						case "SEC" : chart2.categoryAxis.minPeriod = "ss";
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
					chart2.validateData();

					if($("#live .active input").val() == 'ON')
						liveData();
				}
			}
		}
		xmlhttp.open("GET",url,true);
		xmlhttp.send();
	}
	
	function updaValueGeo(dateDeb,dateFin,groupBy) {
		var idCapteursIdLibVal = $(".chosentree-choices li[id]").map(function() { return this.id.substr(10,this.id.length); }).get();
		var pieces = new Array();
		var capteurs = new Array();
		var libVals = new Array();
		var strPHP = "./include/Charts/OracleReqChartGeo.php?dateDeb="+dateDeb+"&dateFin="+dateFin;
	
		for(i=0; i < idCapteursIdLibVal.length; i++){
			pieces[i] = idCapteursIdLibVal[i].split("xxx")[0];
			capteurs[i] = idCapteursIdLibVal[i].split("xxx")[1];
			libVals[i] = idCapteursIdLibVal[i].split("xxx")[2];
			strPHP = strPHP + "&idPiece" + (i+1) + "=" + pieces[i];
			strPHP = strPHP + "&idCapteur" + (i+1) + "=" + capteurs[i];
			strPHP = strPHP + "&idLibVal" + (i+1) + "=" + libVals[i];
			
		}
		strPHP = strPHP + "&groupBy=" + groupBy;
		return strPHP;
	}
	
	function updaValueSen(dateDeb,dateFin,groupBy) {
		var idCapteursIdLibVal = $(".chosentree-choices li[id]").map(function() { return this.id.substr(10,this.id.length); }).get();
		var capteurs = new Array();
		var libVals = new Array();
		var strPHP = "./include/Charts/OracleReqChartSen.php?dateDeb="+dateDeb+"&dateFin="+dateFin;
	
		for(i=0; i < idCapteursIdLibVal.length; i++){
			capteurs[i] = idCapteursIdLibVal[i].split("xxx")[0];
			libVals[i] = idCapteursIdLibVal[i].split("xxx")[1];
			strPHP = strPHP + "&idCapteur" + (i+1) + "=" + capteurs[i];
			strPHP = strPHP + "&idLibVal" + (i+1) + "=" + libVals[i];
		}
		strPHP = strPHP + "&groupBy=" + groupBy;
		return strPHP;
	}
	
	
	function updaValueExp(dateDeb,dateFin,groupBy) {
		var idCapteursIdLibVal = $(".chosentree-choices li[id]").map(function() { return this.id.substr(10,this.id.length); }).get();
		var capteurs = new Array();
		var libVals = new Array();
		var strPHP = "./include/Charts/OracleReqChartExp.php?dateDeb="+dateDeb+"&dateFin="+dateFin;
	
		for(i=0; i < idCapteursIdLibVal.length; i++){
			capteurs[i] = idCapteursIdLibVal[i].split("xxx")[0];
			libVals[i] = idCapteursIdLibVal[i].split("xxx")[1];
			strPHP = strPHP + "&idPiece" + (i+1) + "=" + capteurs[i];
			strPHP = strPHP + "&idLibVal" + (i+1) + "=" + libVals[i];
		}
		strPHP = strPHP + "&groupBy=" + groupBy;
		return strPHP;
	}
	
	function liveData(){
		var idCapteursIdLibVal = $(".chosentree-choices li[id]").map(function() { return this.id.substr(10,this.id.length); }).get();
		var capteurs = new Array();
		var libVals = new Array();
		var strPHP = "./include/Charts/live.php?time=5";
	
		for(i=0; i < idCapteursIdLibVal.length; i++){
			capteurs[i] = idCapteursIdLibVal[i].split("xxx")[1];
			libVals[i] = idCapteursIdLibVal[i].split("xxx")[2];
			strPHP = strPHP + "&idCapteur" + (i+1) + "=" + capteurs[i];
			strPHP = strPHP + "&idLibVal" + (i+1) + "=" + libVals[i];
		}
		var intervalId = setInterval(function(){
						if($("#live .active input").val() == 'OFF')
							clearInterval(intervalId);
						if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
							xmlhttp=new XMLHttpRequest();
						} else {	// code for IE6, IE5
							xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange=function(){
							if (xmlhttp.readyState==4 && xmlhttp.status==200){
								if(xmlhttp.responseText==""){
								
								} else {
									//alert(xmlhttp.responseText);
									chart2.dataProvider.shift();
									chart2.dataProvider.push(JSON.parse(xmlhttp.responseText));
									chart2.validateData();
									
								}
							}
						}
						xmlhttp.open("GET",strPHP,true);
						xmlhttp.send();
					},5000);
	
	}
	

	<!-- Change la couleur du graph -->
	function updaColor(color){
		graph.lineColor = "#"+color;
		chart.validateNow();
	}

	function changeBullet(str){
		graph.bullet = str;
		chart.validateNow();
	}

	function showSubmit(){
		if($(	".chosentree-choices li").size() > 1 
				&& $("#datetimepickerDeb").val() != "" 
				&& (	($("#datetimepickerFin").val() != "" && $("#datetimepickerDeb").val() != $("#datetimepickerFin").val()) 
					|| $("#live .active input").val() == 'ON' )
		){
			document.getElementById('submit').style.display='';
			updaStats();
		} else {
			document.getElementById('submit').style.display='none';
		}
	}

	function updaStats(){
		var dateDeb = $("#datetimepickerDeb").val();
		var dateFin = $("#datetimepickerFin").val();
		
		var idCapteursIdLibVal = $(".chosentree-choices li[id]").map(function() { return this.id.substr(10,this.id.length); }).get();
		
		opt1pie = idCapteursIdLibVal[0].split("xxx")[0];
		opt1capt = idCapteursIdLibVal[0].split("xxx")[1];
		opt1lib = idCapteursIdLibVal[0].split("xxx")[2];
		nbData = $(".chosentree-choices li").size()-1;
		
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
		xmlhttp.open("GET","./include/Charts/stats.php?dateDeb="+dateDeb+"&dateFin="+dateFin+"&idCapteur1="+opt1capt+"&idLibVal1="+opt1lib+"&idPiece="+opt1pie+"&nbData="+nbData,true);
		xmlhttp.send();
	}

	function onLine(){
		//document.getElementById('parameters').style.display='none'; 
		$("#graphiques .nav-tabs li").removeClass('active');
		$("#graphiques .nav-tabs li:contains(Line)").attr("class","active");
		document.getElementById('map-canvas').style.display='none';
		document.getElementById('graphdiv').style.display='';
		chart2.write('graphdiv');
		chart2.validateData();
	}
	
	function onMap(){
		//document.getElementById('parameters').style.display='none'; 
		$("#graphiques .nav-tabs li").removeClass('active');
		$("#graphiques .nav-tabs li:contains(Map)").attr("class","active");
		document.getElementById('map-canvas').style.display='';
		document.getElementById('graphdiv').style.display='none';
	}
	
	function onBubble(){
		document.getElementById('parameters').style.display=''; 
		chart.write('graphdiv');
	}
	
	//DEBUT TREE
	var loadChildrenGeo = function(node, level) {
		var hasChildren = node.level < 3;
		node.children.push(<?php include "./include/Charts/loadTreeGeo.php"; ?>);		
		return node;
	};
	
	var loadChildrenSensor = function(node, level) {
		var hasChildren = node.level < 3;
		node.children.push(<?php include "./include/Charts/loadTreeSensor.php"; ?>);		
		return node;
	};
	
	var loadChildrenExper = function(node, level) {
		var hasChildren = node.level < 4;
		node.children.push(<?php include "./include/Charts/loadTreeExper.php"; ?>);		
		return node;
	};
	
	jQuery(function() {
		$('div.chosentree').chosentree({
			width: 200,
			deepLoad: true,
			showtree: true,
			input_placeholder: '',
			load: function(node, callback) {
				setTimeout(function() {
				callback(loadChildrenGeo(node, 0));
				}, 1000);
				setTimeout(function() {
				$(".treenode .odd input, .treenode .even input").remove("[value=bat],[value=pie],[value=cap]");
				}, 1500);
			}
		});
	});
	
	function reLoadTree(typeTree){
		$('div.chosentree').html("");
		if(typeTree=="Geo") {
			$('div.chosentree').chosentree({
				width: 200,
				deepLoad: true,
				showtree: true,
				input_placeholder: '',
				load: function(node, callback) {
					setTimeout(function() {
					callback(loadChildrenGeo(node, 0));
					}, 1);
					setTimeout(function() {
					$(".treenode .odd input, .treenode .even input").remove("[value=bat],[value=pie],[value=cap]");
					}, 500);
				}
			});
		}
		if (typeTree=="Sensor"){
			$('div.chosentree').chosentree({
				width: 200,
				deepLoad: true,
				showtree: true,
				input_placeholder: '',
				load: function(node, callback) {
					setTimeout(function() {
					callback(loadChildrenSensor(node, 0));
					}, 1);
					setTimeout(function() {
					$(".treenode .odd input, .treenode .even input").remove("[value=typ],[value=cap]");
					}, 500);
				}
			});
		}
		if (typeTree=="Exper"){
			$('div.chosentree').chosentree({
				width: 200,
				deepLoad: true,
				showtree: true,
				input_placeholder: '',
				load: function(node, callback) {
					setTimeout(function() {
					callback(loadChildrenExper(node, 0));
					}, 1);
					setTimeout(function() {
					$(".treenode .odd input, .treenode .even input").remove("[value=bat],[value=pie],[value=typ],[value=capsup]");
					}, 500);
				}
			});
		}
		if (typeTree=="Map"){
			deleteItem(false,false,false);
		}
		showSubmit();
	}
    //FIN TREE
	
	function addItem(){
		idTypeCapteur = $("#idTypeCapteurMap").val();
		idLibVal = $("#libValMap").val();
		textLibVal = $("#libValMap option:selected").text();
		item = "<li class='search-choice' id='choice_xxx" + idTypeCapteur + "xxx" + idLibVal + "'><a href='#' onClick='deleteItem("+idTypeCapteur + "," + idLibVal + ",&quot;" + textLibVal + "&quot;);'><span class='glyphicon glyphicon-remove'></span>   </a> <span>   " + textLibVal + "</span><a class='search-choice-close' href='#'></a></li>";
		if(dataLibMap.indexOf(item) == -1)
			dataLibMap.push(item);
		$("#ongletLabels .active").removeClass("active");
		$("#ongletMapLabel").addClass("active");
		$('div.chosentree').html("<h2>Selection de la map</h2><div class='chosentree-choices'><ul id='listeLabelMap' style='list-style-type: none;'><li> </li></ul><div>");
		for(i=0; i < dataLibMap.length; i++){
			$("#listeLabelMap").html($("#listeLabelMap").html() + dataLibMap[i]);
		}
		showSubmit();
		//$("#listeLabelMap").html($("#listeLabelMap").html() + "<li class='search-choice' id='choice_xxx" + idTypeCapteur + "xxx" + idLibVal + "'><span>" + $("#libValMap option:selected").text() + "</span><a class='search-choice-close' href='#'></a></li>");
	}
	
	function deleteItem(idTypeCapteur, idLibVal, textLibVal){
		item = "<li class='search-choice' id='choice_xxx" + idTypeCapteur + "xxx" + idLibVal + "'><a href='#' onClick='deleteItem("+idTypeCapteur + "," + idLibVal + ",&quot;" + textLibVal + "&quot;);'><span class='glyphicon glyphicon-remove'></span>   </a> <span>   " + textLibVal + "</span><a class='search-choice-close' href='#'></a></li>";
		if(idTypeCapteur != false)
			dataLibMap.splice(dataLibMap.indexOf(item),1);
		$('div.chosentree').html("<h2>Selection de la map</h2><div class='chosentree-choices'><ul id='listeLabelMap' style='list-style-type: none;'><li> </li></ul><div>");
		for(i=0; i < dataLibMap.length; i++){
			$("#listeLabelMap").html($("#listeLabelMap").html() + dataLibMap[i]);
		}
		showSubmit();
	}
</script>
	<style type="text/css">
		#map-canvas { height: 460px; width: 100%; }
    </style>
	
	<script type="text/javascript"
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC578bQir1LR4a7et03L-sfZURnwlWD0TI&sensor=true">
	</script>
	<script type="text/javascript">
	
		function chargeLibVal() {
			idTypeCapteur = $("#idTypeCapteurMap").val();
			if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					if(xmlhttp.responseText == ""){
						$("#libValMap").html("NADA !!!!");
					} else {
						$("#libValMap").html(xmlhttp.responseText);
					}
				}
			}
			xmlhttp.open("GET","./include/Charts/getLibVal.php?idTypeCapteur=" + idTypeCapteur,true);
			xmlhttp.send();
			
		}
		function initialize() {
			var mapOptions = {
				center: new google.maps.LatLng(43.561267, 1.469426),
				zoom: 16
			};
			var map = new google.maps.Map(document.getElementById("map-canvas"),
			mapOptions);
			
			var bounds = new google.maps.LatLngBounds();
			
			
			if (window.XMLHttpRequest){	// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			} else {	// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
	
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 && xmlhttp.status==200){
					var pieces = xmlhttp.responseText.split("<br>");
					var infoWindowContent = new Array();
					var markers = new Array();
					for (index = 0; index < pieces.length; ++index) {
						piece = pieces[index].split("***");
						
						//Markers
						markers.push([piece[1],piece[2],piece[3]]);
					
						//Nom de la piece dans le batiment
						contentString = "<h4>" + piece[0] + "</h4>" +
										"<h5>" + piece[1] + "</h5>" +
										"<div class='form-group'>" +
											"<label>Type</label>" +
												"<select class='form-control' id='idTypeCapteurMap' onchange='chargeLibVal()'>" + piece[4] + "</select>" +
										"</div>" + 
										"<div class='form-group'>" +
											"<label>Libelle</label>" + 
											"<select class='form-control' id='libValMap'></select>" + 
										"</div>" +
										"<button type='button' class='btn btn-info' style='float: right;' onClick='addItem();'>Add</button>";
						infoWindowContent.push(contentString);
						
					}
					
					var infoWindow = new google.maps.InfoWindow(), marker, i;
					
					for( i = 0; i < markers.length; i++ ) {
						piece = pieces[i].split("***");
						var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
						bounds.extend(position);
						marker = new google.maps.Marker({
							position: position,
							map: map,
							title: markers[i][0]
						});
						
						google.maps.event.addListener(marker, 'click', (function(marker, i) {
							return function() {
								infoWindow.setContent(infoWindowContent[i]);
								infoWindow.open(map, marker);
								chargeLibVal();
							}
						})(marker, i));

						map.fitBounds(bounds);
					}
					var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
						this.setZoom(15);
						google.maps.event.removeListener(boundsListener);
					});
					
				}
			}
			xmlhttp.open("GET","./include/Charts/setMap.php",true);
			xmlhttp.send();	
		}
		google.maps.event.addDomListener(window, 'load', initialize);
	</script>
	
	

<!-- En tête du wrapper -->
<div class="row">
  <div class="col-lg-12">
	<h1>Charts <small>Display Your Data</small></h1>
	<ol class="breadcrumb">
	  <li class="active"><i class="fa fa-bar-chart-o"></i> Charts</li>
	</ol>
  </div>
</div><!-- /.row -->

<div class="row">
	<div class="col-lg-3">
		<div id="tree-wrapper">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-check-square-o"></i>  Select label(s)</h3>
				</div>
				<div class="panel-body">
					<ul class="nav nav-tabs" id="ongletLabels">
						<li class="active"><a href="#geo" data-toggle="tab" onClick="reLoadTree('Geo');" value="Geo"><span class="glyphicon glyphicon-tasks"></span></a></li>
						<li><a href="#Sen" data-toggle="tab" onClick="reLoadTree('Sensor');" value="Sensor"><span class="glyphicon glyphicon-screenshot"></span></a></li>
						<li><a href="#Exp" data-toggle="tab" onClick="reLoadTree('Exper');" value="Exper"><span class="glyphicon glyphicon-filter"></span></a></li>
						<li id="ongletMapLabel"><a href="#Map" data-toggle="tab" onClick="reLoadTree('Map');" value="Map"><span class="glyphicon glyphicon-globe"></span></a></li>
					</ul>
					<div class="chosentree" style="width=20%;"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-9">
		<!-- Autres paramètre (couleur, forme, ...) et BtnSubmit -->
		<div class="row">
			<div class="col-lg-4">
				<div class="panel panel-primary">
					<div class="panel-heading" >
						<h3 class="panel-title"><i class="fa fa-calendar"></i> Date range</h3>
					</div>
					<div class="panel-body">
						<div class="form-group text-right">
							<div class="btn-group" data-toggle="buttons" id="live">
								<label class="btn btn-primary active">
									<input type="radio" name="options" id="option1" value="OFF"> LIVE OFF
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="options" id="option2" value="ON"> LIVE ON
								</label>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3" style="padding-left: 0px;">Start : </label>
							<input type="text"  class="col-sm-9" id="datetimepickerDeb" onChange="showSubmit();"/>
						</div><br>
						<div class="form-group" id="ddf">
							<br>
							<label class="col-sm-3" style="padding-left: 0px;">End : </label>
							<input type="text"class="col-sm-9" id="datetimepickerFin" onChange="showSubmit();"/>
						</div><br>
						<div class="form-group" >
							<label>Select Group by</label>
							<select class="form-control" id="groupBy">
								<option value='SEC'>Second</option>
								<option value='MIN'>Minute</option>
								<option value='HOUR'>Hour</option>
								<option value='DAY'>Day</option>
								<option value='MONTH'>Month</option>
								<option value='YEAR'>Year</option>
							</select>
						</div>
					</div>
				</div>
			</div>
<!--
			<div class="col-lg-4"  id="parameters" style="display:none;">
				<div class="panel panel-primary" style="height: 268px;">
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
-->			
			<div class="col-lg-4" id="submit" style="display:none; ">
				<div class="panel panel-primary" style="height: 268px;">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Data (approximate)</h3>
					</div>
					 <div class="panel-body">
						<b><span id="nbrData">0</span></b> <br><br>
						<div class="btn-group" data-toggle="buttons" id="connect">
							<label class="btn btn-primary active">
								<input type="radio" name="options" id="opt1" value="connect"> Connect
							</label>
							<label class="btn btn-primary">
								<input type="radio" name="options" id="opt2" value="disconnect"> Disconnect
							</label>
						</div>
						<button class="btn btn-success" style="float: right;" onClick="updaValues(); ">Submit</button>
					</div>
				</div>
			</div>
		</div><!-- /.row -->
		
		<div class="row" id="graphiques" >
			<div class="col-lg-12">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Your differents charts</h3>
					</div>
					<div class="panel-body">
						<ul class="nav nav-tabs" id="onglet">
							<li class="active"><a href="#" data-toggle="tab" onclick="onMap();">Map</a></li>
							<li><a href="#line" data-toggle="tab" onclick="onLine();">Line</a></li>
							<!--<li><a href="#bubble" data-toggle="tab" onclick="onBubble();">Bubble</a></li>-->
						</ul>
						<br>
						<div id="graphdiv" style="width: auto; height: 350px;display:none; " ></div>
						<div id="map-canvas"/>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$('#datetimepickerDeb').datetimepicker().datetimepicker({
		step:2,
		format:'Y-m-d H:i',
		onChangeDateTime:function(dp,$input){
			$('#datetimepickerFin').datetimepicker({
				timepicker:true,
				step:30,
				format:'Y-m-d H:i',
				formatDate:'Y-m-d H:i',
				minDate:$input.val(),
				maxDate:'2099-12-31 23:59'
			});
			$("#datetimepickerFin").val($input.val());
		}
	});
	$(".chosentree").bind("click", function(){
		 setTimeout(function(){
								$("#choice_capsup").remove();
								showSubmit();
							},50)});
	
	$( "#live .btn" ).click('event', function() {
		setTimeout(function(){
								if($("#live .active input").val() == 'ON'){
									$("#ddf").hide();
									$("#datetimepickerFin").val("");
									showSubmit();
								} else {
									$("#ddf").show();
									showSubmit();
								}
							},100);
	});
</script>