@extends('layouts.master')
@section('content')
	The current UNIX timestamp is {{ time() }}.
	<h1>Actuales, <?php echo $actuales; ?></h1>
@stop

