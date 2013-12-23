@extends('layouts.archive')
@section('archive')
<h1>Archivo diario</h1>
@if ($day > 0)
@include('archive.daily.detail')
@endif
@stop

