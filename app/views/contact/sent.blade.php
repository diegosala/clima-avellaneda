@extends('layouts.master')
@section('content')
<h1>Contacto</h1>
@if ($success)
<div class="alert alert-success"><strong>Muchas gracias por contactarse</strong>, su mensaje ha sido enviado correctamente.</div>
@else
<div class="alert alert-danger"><strong>Ha ocurrido un error al enviar el mensaje</strong></div>
@endif
@stop
