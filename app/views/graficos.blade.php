@extends('layouts.master')
@section('content')
<h1>Gr&aacute;ficos</h1>
<div class="row">
<div class="col-xs-12" id="th_chartContainer" style="height: 300px; width: 100%;"></div>
<div class="col-xs-12" id="v_chartContainer" style="height: 300px; width: 100%;"></div>
</div>
@stop
@section('content-js')
<script type="text/javascript" src="/assets/js/canvasjs.min.js"></script>
<script type="text/javascript">
	$( document ).ready(function() {

		// dataPoints
		var temperature = [];
		var humidity = [];
		var wind_speed = [];
		var wind_gust = [];
		var wind_direction = [];
		
		var th_chart = new CanvasJS.Chart("th_chartContainer",{
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
				title: 'Temperatura'
			}, 
			axisY2:{
				title: 'Humedad'
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
				axisYType: "secondary",
				xValueType: "dateTime",
				showInLegend: true,
				name: "Humedad" ,
				dataPoints: humidity
			}]
		});

		var v_chart = new CanvasJS.Chart("v_chartContainer",{
                        zoomEnabled: true,
                        title: {
                                text: "Velocidad del viento"
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
				title: "Velocidad"
                        },
			axisY2:{
                                title: "Direccion"
                        },
                        data: [{
                                // wind speed
                                type: "line",
                                xValueType: "dateTime",
                                showInLegend: true,
                                name: "Promedio",
                                dataPoints: wind_speed
                        },
                        {
                                // wind gust
                                type: "line",
                                xValueType: "dateTime",
                                showInLegend: true,
                                name: "Rafaga" ,
                                dataPoints: wind_gust
                        },
			{
				// wind direction
				type: "scatter",
				axisYType: "secondary",
				xValueType: "dateTime",
				showInLegend: false,
				name: "Direccion",
				dataPoints: wind_direction
			}]
                });

		var getDireccion = function(dir) {						
			switch(dir) {
		            case 1: return "N"; break;
		            case 2: return "NNE"; break;
		            case 3: return "NE"; break;
		            case 4: return "ENE"; break;
		            case 5: return "E"; break;
		            case 6: return "ESE"; break;
		            case 7: return "SE"; break;
		            case 8: return "SSE"; break;
		            case 9: return "S"; break;
		            case 10: return "SSW"; break;
		            case 11: return "SW"; break;
		            case 12: return "WSW"; break;
		            case 13: return "W"; break;
		            case 14: return "WNW"; break;
		            case 15: return "NW"; break;
		            case 16: return "NNW"; break;
		            case 255: return "---"; break;
		        }
		}

		var updateInterval = 5000;
		
		var start = function() {
			$.ajax({
                                url: '/ultimos/datos',
				dataType: 'json',
				type: 'GET',
				success: function(data) {
					var i = 0;
					var d;
					for(; i < data.length; i++) {
						d = new Date(data[i].timestamp);
						temperature.push({
							x: d,
							y: data[i].temperature*1
						});
						humidity.push({
                                                        x: d,
                                                        y: data[i].humidity*1
						});
						wind_speed.push({
                                                        x: d,
                                                        y: data[i].wind_speed*1
						});
						wind_gust.push({
                                                        x: d,
                                                        y: data[i].wind_gust*1
						});
						wind_direction.push({
                                                        x: d,
                                                        y: data[i].wind_direction*22.5
						});
					}
					
					th_chart.options.data[0].legendText = " Temperatura: " + data[i-1].temperature;
					th_chart.options.data[1].legendText = " Humedad: " + data[i-1].humidity;
					v_chart.options.data[0].legendText = " Promedio: " + data[i-1].wind_speed;
					v_chart.options.data[1].legendText = " Rafaga: " + data[i-1].wind_gust;
					v_chart.options.data[2].legendText = " Direccion: " + getDireccion(data[i-1].wind_direction*1)
					th_chart.render();
					v_chart.render();

					updateChart();
				}
			});
		};

		var updateChart = function () {
			$.ajax({
		                url: '/arduino.txt?t=' + Math.random(),
                		dataType: 'json',     
		                type: 'GET',
		                success: function(data) {
					var d = data.timestamp * 1000;
					temperature.push({
						x: d,
						y: data.temperatura*1
					});
					humidity.push({
                                                x: d,
                                                y: data[i].humedad*1
                                        });
                                        wind_speed.push({
                                                x: d,
                                                y: data[i].velocidad*1
                                        });
                                        wind_gust.push({
                                                x: d,
                                                y: data[i].rafaga*1
                                         });
                                         wind_direction.push({
                                                x: d,
                                                y: data[i].direccion*22.5
                                         });

					th_chart.options.data[0].legendText = " Temperatura: " + data.temperatura;
					th_chart.options.data[1].legendText = " Humedad: " + data.humedad;
                                        v_chart.options.data[0].legendText = " Promedio: " + data.velocidad;
                                        v_chart.options.data[1].legendText = " Rafaga: " + data.rafaga;
					v_chart.options.data[2].legendText = " Direccion: " + getDireccion(data.direccion*1)
					th_chart.render();
					v_chart.render();
					setTimeout(updateChart, 5000);
				},
				error: function(a,b,c) {
					console.log(JSON.stringify(a));
					console.log(b);
					console.log(c);        
					setTimeout(updateChart, 5000); 
				}
			});            
		};
		start();
	});
	</script>
@stop
