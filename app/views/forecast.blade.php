@extends('layouts.master')
@section('content')
<?php $f = new Forecast(array()); ?>
<h1>Pron&oacute;stico <small>{{ date("d/m/Y H:i:s", $forecast->currently->time) }}</small></h1>
<h3>Diario</h3>
<table class="table">
<thead>
<tr>
	<th>Fecha</th>
	<th>icon</th>
	<th>precipIntensity</th>
	<th>precipProbability</th>
	<th>cloudCover</th>
	<th>Icon</th>
</tr>
</thead>
<?php foreach($forecast->daily->data as $d) { ?>
	<tr>
		<td>{{ date("Y-m-d H:i:s", $d->time) }}</td>
		<td>{{ $d->icon }}</td>
		<td>{{ $d->precipIntensity }} </td>
		<td>{{ $d->precipProbability }}</td>
		<td>{{ $d->cloudCover }}</td>
		<td><img src="/assets/images/forecast/<?php echo $f->getForecastIcon($d->icon, $d->cloudCover, $d->precipIntensity, $d->precipProbability) ?>.jpg"></td>
	</tr>
<?php } ?>
</table>
<h3>Horario</h3>
<table class="table">
<thead>
<tr>
        <th>Fecha</th>
        <th>icon</th>
        <th>precipIntensity</th>
        <th>precipProbability</th>
        <th>cloudCover</th>
        <th>Icon</th>
</tr>
</thead>
<?php $f = new Forecast(array());
foreach($forecast->hourly->data as $d) { ?>
        <tr>
                <td>{{ date("Y-m-d H:i:s", $d->time) }}</td>
                <td>{{ $d->icon }}</td>
                <td>{{ $d->precipIntensity }} </td>
                <td>{{ $d->precipProbability }}</td>
                <td>{{ $d->cloudCover }}</td>
                <td><img src="/assets/images/forecast/<?php echo $f->getForecastIcon($d->icon, $d->cloudCover, $d->precipIntensity, $d->precipProbability) ?>.jpg"></td>
        </tr>
<?php } ?>
</table>
@stop
