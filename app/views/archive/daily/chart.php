<script type="text/javascript">
$('a[data-toggle="tab"]').on('shown.bs.tab', loadChart);

function loadChart() {

var chart = $('.temperature.chart').highcharts();
if (typeof chart != "undefined")
	return;

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
$.ajax({
	url: '/archivo/<?php echo $avoid_date ?>/1',
	dataType: 'json',
	type: "GET",
	success: function(data) {
		var t = new Array();
		var h = new Array();
		var ws = new Array();
		var wg = new Array();
		
		for (var i = 0; i < data.length; i++) {
			t.push([new Date("<?php echo $current_date ?> " + data[i].time).getTime(), data[i].temperature*1]);
			h.push([new Date("<?php echo $current_date ?> " + data[i].time).getTime(), data[i].humidity*1]);
			ws.push([new Date("<?php echo $current_date ?> " + data[i].time).getTime(), data[i].wind_speed*1]);
			wg.push([new Date("<?php echo $current_date ?> " + data[i].time).getTime(), data[i].wind_gust*1]);
		}
		
		$('.temperature.chart').highcharts().series[0].setData(t);
		$('.temperature.chart').highcharts().series[1].setData(h);
		$('.wind.chart').highcharts().series[0].setData(ws);
		$('.wind.chart').highcharts().series[1].setData(wg);
		
	},
	error: function(a,b,c) {
		alert("Error");
	}
});
}
</script>
