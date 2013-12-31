@extends('layouts.master')
@section('content')
	<div class="row">
		<div class="col-md-offset-2 col-md-8">
			@yield('archive')
		</div>
	</div>
@stop
@section('content-js')
@if (isset($datepicker_format))
<script type="text/javascript" src="/assets/js/bootstrap-datepicker.es.js"></script>
@endif
@stop
