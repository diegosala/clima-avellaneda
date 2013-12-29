@extends('layouts.master')
@section('content-css')
#tabla_datos .dato{
    text-shadow: "0px 0px 0x #0"
}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-6 col-md-8 col-sm-12 col-lg-offset-3 col-md-offset-2">
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
        </div>
    </div>    
@stop
@section('content-js')
    <script type="text/javascript">
    
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
    
    fetchStats();
    </script>    

@stop

