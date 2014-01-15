@extends('layouts.master')
@section('content')
<h1>Gr&aacute;ficos</h1>
<div class="row">
<div class="col-xs-12 temperature chart"></div>
<div class="col-xs-12 wind chart"></div>
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

		$('.temperature.chart').highcharts({
				chart: {
						backgroundColor: "#FAFFF8"
				},
				title: {
						text: 'Temperatura y Humedad'
		},
				xAxis: {
						type: 'datetime',
						title: {
								text: null
						}
				},
				yAxis: [{ // Primario
						title: {
								text: 'Temperatura'
						}
				},{ // Secundario
						title: {
								text: 'Humedad'
						},
						opposite: true
				}],
				plotOptions: {
						series: {
								marker: {
										enabled: false
								}
						}
				},
				series: [{
						type: 'line',
						name: 'Temperatura',
						data: []
				}, {
						yAxis: 1,
						type: 'line',
						name: 'Humedad',
						data: []
				}]
		});

		$('.wind.chart').highcharts({
				chart: {
						backgroundColor: "#FAFFF8"
				},
				title: {
						text: 'Velocidad del viento'
		},
				xAxis: {
						type: 'datetime',
						title: {
								text: null
						}
				},
				yAxis: { // Primario
						title: {
								text: 'Velocidad'
						}
				},
				plotOptions: {
						series: {
								marker: {
										enabled: false
								}
						}
				},
				series: [{
						type: 'line',
						name: 'Promedio',
						data: []
				}, {
						type: 'line',
						name: 'Rága',
						data: []
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
						d = data[i].timestamp*1000;
						temperature.push([
							d,
							data[i].temperature*1
						]);
						humidity.push([
                                                        d,
                                                        data[i].humidity*1
						]);
						wind_speed.push([
                                                        d,
                                                        data[i].wind_speed*1
						]);
						wind_gust.push([
                                                        d,
                                                        data[i].wind_gust*1
						]);
						wind_direction.push([
                                                        d,
                                                        (data[i].wind_direction*1 - 1)*22.5
						]);
					}

					$('.temperature.chart').highcharts().series[0].setData(temperature);
					$('.temperature.chart').highcharts().series[1].setData(humidity);
					$('.wind.chart').highcharts().series[0].setData(wind_speed);
					$('.wind.chart').highcharts().series[1].setData(wind_gust);
					
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
					
					$('.temperature.chart').highcharts().series[0].addPoint([d, data.temperatura*1], true, true, true);
					$('.temperature.chart').highcharts().series[1].addPoint([d, data.humedad*1], true, true, true);
					$('.wind.chart').highcharts().series[0].addPoint([d, data.velocidad*1], true, true, true);
					$('.wind.chart').highcharts().series[1].addPoint([d, data.rafaga*1], true, true, true);
					
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
