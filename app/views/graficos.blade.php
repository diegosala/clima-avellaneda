@extends('layouts.master')
@section('content')
<h1>GRAFICOS</h1>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
@stop
@section('content-js')
<script type="text/javascript" src="/assets/js/canvasjs.min.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {

		// dataPoints
		var temperature = [];
		var humidity = [];

		var chart = new CanvasJS.Chart("chartContainer",{
			zoomEnabled: true,
			title: {
				text: "Temperatura y humedad"		
			},
			toolTip: {
				shared: true
			},
			legend: {
				verticalAlign: "top",
				horizontalAlign: "center",
                                fontSize: 14,
				fontWeight: "bold",
				fontFamily: "calibri",
				fontColor: "dimGrey"
			},
			axisX: {
				title: "actualizado cada 5 segundos"
			},
			axisY:{
				
			}, 
			data: [{ 
				// temperature
				type: "line",
				xValueType: "dateTime",
				showInLegend: true,
				name: "Temperatura",
				dataPoints: temperature
			},
			{				
				// humidity
				type: "line",
				xValueType: "dateTime",
				showInLegend: true,
				name: "Humedad" ,
				dataPoints: humidity
			}]
		});



		var updateInterval = 5000;
		// initial value
		var yValue1 = 0; 
		var yValue2 = 0;

		var updateChart = function () {
			$.ajax({
		                url: '/arduino.txt?t=' + Math.random(),
                		dataType: 'json',     
		                type: 'GET',
		                success: function(data) {
					temperature.push({
						x: new Date(data.timestamp * 1000),
						y: data.temperatura
					});	
					
					setTimeout(updateChart, 5000);
				},
				error: function(a,b,c) {
					console.log(JSON.stringify(a));
					console.log(b);
					console.log(c);        
					setTimeout(updateChart, 5000); 
				}
			});            
	

			// updating legend text with  updated with y Value 
			chart.options.data[0].legendText = " Temperatura " + yValue1;
			chart.options.data[1].legendText = " Humedad" + yValue2; 

			chart.render();

		};

		// generates first set of dataPoints 
		updateChart();	
		 
		// update chart after specified interval 
		//setInterval(function(){updateChart()}, updateInterval);
	});
	</script>
@stop
