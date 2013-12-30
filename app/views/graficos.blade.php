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
			zoomEnabled: false,
			backgroundColor: "#fafff8",
			title: {
				text: "Temperatura y humedad",
				fontFamily: "'Helvetica Neue',Helvetica,Arial,sans-serif",
				fontColor: "#484a49"
			},
			toolTip: {
				shared: true
			},
			legend: {
				verticalAlign: "top",
				horizontalAlign: "center",
                fontSize: 14,
				fontWeight: "bold",
				fontFamily: "'Helvetica Neue',Helvetica,Arial,sans-serif",
				fontColor: "#484a49"
			},
			axisX: {
				title: "Últimos 30 minutos",
                titleFontSize: 12
			},
			axisY:{
				title: 'Temperatura',
				suffix: " ºC"
			}, 
			axisY2:{
				title: 'Humedad',
				maximum: 100,
				suffix: " %"
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
                        zoomEnabled: false,
			backgroundColor: "#fafff8",
                        title: {
                                text: "Velocidad del viento",
				fontFamily: "'Helvetica Neue',Helvetica,Arial,sans-serif",
				fontColor: "#484a49"
                        },
                        toolTip: {
                                shared: true
                        },
                        legend: {
                                verticalAlign: "top",
                                horizontalAlign: "center",
                                fontSize: 14,
                                fontWeight: "bold",
                                fontFamily: "'Helvetica Neue',Helvetica,Arial,sans-serif",
                                fontColor: "#484a49"
                        },
                        axisX: {
                                title: "Últimos 30 minutos",
                                titleFontSize: 12
                        },
                        axisY:{
				title: "Velocidad",
				gridThickness: 0,
				suffix: " km/h"
                        },
			axisY2:{
                                title: "Dirección",
				maximum: 360,
				interval: 22.5,
				suffix: " º"
                        },
                        data: [{
                                // wind speed
                                type: "spline",
				markerType: "none",
                                xValueType: "dateTime",
                                showInLegend: true,
                                name: "Promedio",
                                dataPoints: wind_speed
                        },
                        {
                                // wind gust
                                type: "spline",
				markerType: "none",
                                xValueType: "dateTime",
                                showInLegend: true,
                                name: "Ráfaga" ,
                                dataPoints: wind_gust
                        },
			{
				// wind direction
				type: "scatter",
				axisYType: "secondary",
				xValueType: "dateTime",
				showInLegend: true,
				name: "Dirección",
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
                                url: '/ultimos/datos/{{ $span }}?t=' + Math.random(),
				dataType: 'json',
				type: 'GET',
				success: function(data) {
					var i;
					var d;
					for(i = data.length - 1; i > 0; i--) {
						d = new Date(data[i].timestamp*1000);
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
                                                        y: (data[i].wind_direction*1 - 1)*22.5
						});
					}
					
					th_chart.options.data[0].legendText = " Temperatura: " + data[0].temperature + " ºC";
					th_chart.options.data[1].legendText = " Humedad: " + data[0].humidity + " %";
					v_chart.options.data[0].legendText = " Promedio: " + data[0].wind_speed + " km/h";
					v_chart.options.data[1].legendText = " Ráfaga: " + data[0].wind_gust + " km/h";
					v_chart.options.data[2].legendText = " Dirección: " + getDireccion(data[0].wind_direction*1)
					th_chart.render();
					v_chart.render();

					updateChart();
				}
			});
		};

		var updateChart = function () {
			$.ajax({
		                url: '/datos.txt?t=' + Math.random(),
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
                                                y: data.humedad*1
                                        });
                                        wind_speed.push({
                                                x: d,
                                                y: data.velocidad*1
                                        });
                                        wind_gust.push({
                                                x: d,
                                                y: data.rafaga*1
                                        });
                                        wind_direction.push({
                                                x: d,
                                                y: (data.direccion*1 - 1)*22.5
                                        });
				
					temperature.shift();
					humidity.shift();
					wind_speed.shift();
					wind_gust.shift();
					wind_direction.shift();					

					th_chart.options.data[0].legendText = " Temperatura: " + data.temperatura + " ºC";
					th_chart.options.data[1].legendText = " Humedad: " + data.humedad + " %";
                    v_chart.options.data[0].legendText = " Promedio: " + data.velocidad + " km/h";
                    v_chart.options.data[1].legendText = " Ráfaga: " + data.rafaga + "km/h";
					v_chart.options.data[2].legendText = " Dirección: " + getDireccion(data.direccion*1)
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
