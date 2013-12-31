@extends('layouts.master')
@section('content')
<h1>Contacto</h1>
<div class="alert alert-danger">{{ $errors }}</div>
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
{{ Form::textArea('comment', $input["comment"], array('class' => 'form-control')) }}
</div>
{{ Form::submit('Enviar', array('class' => 'btn btn-default')) }}
{{ Form::close() }}
@stop
