@extends('layouts.master')
@section('content-css')
#tabla_datos .dato{
    text-shadow: "0px 0px 0x #0"
}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-xs-12 col-lg-offset-3 col-md-offset-2">
        <div id="alert-wrapper" style="display: none">
        <div class="alert alert-info">
            <p style="text-align: center;"><strong>¿Seguís ahí?</strong> Las actualizaciones quedan pausadas hasta que respondas</p>
            <p style="text-align: center;"><button type="button" onclick="resetUpdates();" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;Sigo acá</button></p>
        </div>
        </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Datos actuales</div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" style="text-align: center;"><span id="horario"></span></th>
                            </tr>                    
                        </thead>
                        <tbody id="tabla_datos">
                            <tr>
                                <td style="width: 55%">Temperatura</td>
                                <td style="width: 45%;" class="dato"><span id="temperatura"></span>ºC</td>
                            </tr>
                            <tr>
                                <td>Humedad</td>
                                <td class="dato"><span id="humedad"></span>%</td>
                            </tr>
                            <tr>
                                <td>Velocidad de viento</td>
                                <td class="dato"><span id="velocidad"></span> km/h</td>
                            </tr>
                            <tr>
                                <td>R&aacute;faga de viento</td>
                                <td class="dato"><span id="rafaga"></span> km/h</td>
                            </tr>
                            <tr>
                                <td>Direcci&oacute;n de viento</td>
                                <td class="dato"><span id="direccion"></span></td>
                            </tr>
                            <tr>
                                <td>Precipitaci&oacute;n</td>
                                <td class="dato"><span id="lluvia"></span> mm / 10 min</td>
                            </tr>                           
                        </tbody>
                    </table>
                    <div class="progress" style="width: 90%; margin-top: 20px; margin-right: auto; margin-left: auto">
                        <div class="progress-bar progress-bar-success" style="width: 0%; transition: none" id="pb">                            
                        </div>
                    </div>
            </div>            
            @if(@isset($forecast))            
            <div class="panel panel-primary">
                <div class="panel-heading">Pron&oacute;stico</div>
                    <table class="table table-bordered table-forecast" style="text-align: center;">
                        <thead>
                            <tr>
                                <th style="width: 25%;">{{ $forecast[0]["date"]}}</th>
                                <th style="width: 25%;">{{ $forecast[1]["date"]}}</th>
                                <th style="width: 25%;">{{ $forecast[2]["date"]}}</th>
                                <th style="width: 25%;">{{ $forecast[3]["date"]}}</th>
                            </tr>
                        </thead>
                        <tr>
                            <td><a href="#" onclick="showForecast(0);"><img src="{{ $forecast[0]["icon"]}}" class="img-rounded"/></a></td>
                            <td><a href="#" onclick="showForecast(1);"><img src="{{ $forecast[1]["icon"]}}" class="img-rounded"/></a></td>
                            <td><a href="#" onclick="showForecast(2);"><img src="{{ $forecast[2]["icon"]}}" class="img-rounded"/></a></td>
                            <td><img src="{{ $forecast[3]["icon"]}}" class="img-rounded"/></td>
                        </tr>                
                        <tr>
                            <td>@if (@isset($forecast[0]["max"]))<span style="color: #c7254e">{{ $forecast[0]["max"]}}&deg;C</span><br>@endif<span style="color: #34789a">{{ $forecast[0]["min"]}}&deg;C</span></td>
                            <td><span style="color: #c7254e">{{ $forecast[1]["max"]}}&deg;C</span><br><span style="color: #34789a">{{ $forecast[1]["min"]}}&deg;C</span></td>
                            <td><span style="color: #c7254e">{{ $forecast[2]["max"]}}&deg;C</span><br><span style="color: #34789a">{{ $forecast[2]["min"]}}&deg;C</span></td>
                            <td><span style="color: #c7254e">{{ $forecast[3]["max"]}}&deg;C</span><br><span style="color: #34789a">{{ $forecast[3]["min"]}}&deg;C</span></td>
                        </tr>
                        <tr>
                            <td>{{$forecast[0]["windDir"]}} @ {{$forecast[0]["windSpeed"]}} km/h</td>
                            <td>{{$forecast[1]["windDir"]}} @ {{$forecast[1]["windSpeed"]}} km/h</td>
                            <td>{{$forecast[2]["windDir"]}} @ {{$forecast[2]["windSpeed"]}} km/h</td>
                            <td>{{$forecast[3]["windDir"]}} @ {{$forecast[3]["windSpeed"]}} km/h</td>
                        </tr>
                    </table>
            </div>
            @endif            
        </div>
    </div>    

<div class="modal fade" id="forecastModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Pron&oacute;stico detallado <span id="date"></span> <small>Actualizado <span id="updated"></span></small></h4>
      </div>
      <div class="modal-body">
        <h4 id="forecastDate"></h4>
	<table class="table" id="forecastTable">
		<thead>
			<tr>
				<th>Horario</th>
				<th>Temperatura</th>
				<th>Viento</th>
				<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@stop
@section('content-js')
    <script type="text/javascript">
    var updates;
    
    function resetUpdates() {
        updates = 100;
        $("#alert-wrapper").hide("blind");
        fetchStats();
    }    
    
	function showForecast(n_day) {
		$.ajax({
	                url: '/forecast/' + n_day,
			dataType: 'json',
	                type: 'GET',
			success: function(data) {
				$("#forecastModal .modal-dialog .modal-content .modal-header .modal-title #date").text(data.date);
				$("#forecastModal .modal-dialog .modal-content .modal-header .modal-title #updated").text(data.updated);
				var modalBody = $("#forecastModal .modal-dialog .modal-content .modal-body");
				var forecastTable = $(modalBody).find("#forecastTable tbody")[0];
				var n_rows = forecastTable.rows.length;
				for (var i=0; i < n_rows; i++) {
					forecastTable.deleteRow(0);
				}

				var fDetail = data.detail;
				for (var i=0; i < fDetail.length; i++) {
					var row = forecastTable.insertRow(i);
					var timeCell = row.insertCell(0);
					var temperatureCell = row.insertCell(1);
					var windCell = row.insertCell(2);
					var icon = row.insertCell(3);

					timeCell.innerHTML = fDetail[i].time;
					temperatureCell.innerHTML = fDetail[i].temperature + "&deg;C";
					windCell.innerHTML = fDetail[i].windDir + " @ " + fDetail[i].windSpeed + " km/h";
					icon.innerHTML = "<img src='" + fDetail[i].icon + "' />";
				}

				$('#forecastModal').modal();
			}
		});
	}

     function getDireccion(id) {
        switch(id) {
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
    
    function fetchStats() {     
            updates--;
            
            if (updates <= 0) {
                $("#alert-wrapper").show("blind");
                return;
            }                
               
            $.ajax({
                url: '/datos.txt?t=' + Math.random(),
                dataType: 'json',     
                type: 'GET',
                success: function(data) {
                    $("#horario").text(data.hora);
                    $("#temperatura").text(data.temperatura);
                    $("#humedad").text(data.humedad);
                    $("#velocidad").text(data.velocidad);
                    $("#rafaga").text(data.rafaga);
                    $("#direccion").text(getDireccion(data.direccion));
                    $("#lluvia").text(data.lluvia);
                                        
                    $("#tabla_datos .dato").animate({textShadow: "#C0B6B6 5px 5px 5px;"});
                    
                    $("#horario").css("color", "#6cb484");
                    $("#horario").animate({color: "#000000"});
                    
                    $("#pb").css("width", "0%");                    
                    $(".progress").removeClass("progress-striped active");
                    
                    $("#pb").animate(
                        {width: "100%"}, 
                        {
                            duration: 5000,
                            easing: "easeInCirc",
                            complete: function() {                                                                
                                fetchStats();
                                $(".progress").addClass("progress-striped active");
                                return;
                            }
                        });                    
                    
                },
                error: function(a,b,c) {
                    console.log(JSON.stringify(a));
                    console.log(b);
                    console.log(c);        
                    setTimeout(fetchStats, 5000); 
                }
            });
    }
    
	$(document).ready(function() { resetUpdates(); fetchStats(); });
    </script>    

@stop

