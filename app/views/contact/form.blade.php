@extends('layouts.master')
@section('content')
<div class="row">
<div class="col-md-5">
<h2>Sobre...</h2>
<div class="well">
<p><strong>La estaci&oacute;n: </strong> desarrollada usando <a href="http://arduino.cc">Arduino</a> y un m&oacute;dulo de instrumental <a href="https://www.sparkfun.com/products/8942">WH-1081</a> junto a un sensor de temperatura <a href="http://datasheets.maximintegrated.com/en/ds/DS18B20.pdf">DS18B20</a> y de humedad <a href="http://www.phanderson.com/hih-4000.pdf">HIH-4000</a>.</p>
<div style="text-align: center"><a class="fancy" href="/assets/images/estacion_big.jpg"><img src="/assets/images/estacion_small.png" alt="Estaci&oacute;n meteorol&oacute;gica" class="img-thumbnail"></a></div>
</div>
<div class="well">
<p><strong>Diego: </strong>estudiante de Ingeneir&iacute;a en Sistemas de Informaci&oacute;n, egresado de la EET N&deg;7 de Quilmes, autor de este sitio y de <a href="http://climasurgba.com.ar">ClimaSurGBA</a>.</p>
<div style="text-align: center"><a class="fancy" href="/assets/images/diego_big.jpg"><img src="/assets/images/diego_small.png" alt="Diego" class="img-thumbnail"></a></div>
</div>

</div>
<div class="col-md-7">
<h2>Contacto</h2>
@if (count($errors->all()) > 0)
<div class="alert alert-danger"><strong>Por favor, corrija los siguientes errores:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}@endforeach</ul></div>
@endif
{{ Form::open(array('role'=>'form' ,'action' => 'ContactController@Send')) }}
<div class="form-group">
{{ Form::label('name', 'Nombre') }}
{{ Form::text('name', $input["name"], array('placeholder' => 'Ingrese su nombre', 'class' => 'form-control')) }}
</div>
<div class="form-group">
{{ Form::label('email', 'Correo electr&oacute;nico') }}
{{ Form::text('email', $input["email"], array('placeholder' => 'Ingrese su direcci&oacute;n de correo elctr&oacute;nico', 'class' => 'form-control')) }}
</div>
<div class="form-group">
{{ Form::label('comment', 'Comentario') }}
{{ Form::textArea('comment', $input["comment"], array('class' => 'form-control', 'rows' => 15)) }}
</div>
{{ Form::submit('Enviar', array('class' => 'btn btn-default')) }}
{{ Form::close() }}
</div>
</div>
@stop
@section('content-js')
<script type="text/javascript">
    $(document).ready(function() {
        $(".fancy").fancybox();
    });
</script>
@stop
