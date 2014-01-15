<ul class="nav nav-tabs">
<li class="active"><a href="#data" data-toggle="tab">Datos</a></li>
<li><a href="#charts" data-toggle="tab">Graficos</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="data">
<table class="table">
	<tr><td style="border-top:none">Temperatura m&aacute;xima</td><td style="border-top:none"><?php echo $day->max_temperature ?>°C @ <?php echo  $day->max_temperaure_time ?> </td></tr>
	<tr><td>Temperatura m&iacute;nima</td><td><?php echo $day->min_temperature ?>°C  @ <?php echo $day->min_temperaure_time ?> </td></tr>
	<tr><td>Temperatura promedio</td><td><?php echo $day->avg_temperature ?>°C</td></tr>
	<tr><td>Humedad promedio</td><td><?php echo $day->avg_humidity ?>%</td></tr>
	<tr><td>Viento promedio</td><td><?php echo $day->avg_windspeed ?> km/h</td></tr>
	<tr><td>R&aacute;faga m&aacute;xima</td><td><?php echo $day->max_windgust ?> km/h @ <?php echo $day->max_windgust_time ?></td></tr>
	<tr><td>Direcci&oacute;n dominante</td><td><?php echo $day->windDirection->code ?></td></tr>
	<tr><td>Precipitaci&oacute;n</td><td><?php echo $day->sum_rain ?> mm</td></tr>
</table>
<h2>Datos detallados</h2>
<table class="table table-condensed">
	<thead>
	<tr>
		<th>Hora</th>
		<th>Temperatura [°C]</th>
		<th>Humedad [%]</th>
		<th>Viento [km/h]</th>
		<th>Precipitaci&oacute;n [mm]</th>
	</tr>
	</thead>
<?php foreach($records as $record) { ?>
	<tr>
		<td><?php echo $record->time; ?></td>
		<td><?php echo $record->temperature; ?></td>
		<td><?php echo $record->humidity; ?></td>
		<td><?php echo $record->wind_speed; ?> (<?php echo $record->wind_gust; ?>)</td>
		<td><?php echo $record->rain; ?></td>
	</tr> 
<?php } ?>
</table>
<div class="row">
		<div class="col-xs-12" style="text-align: center;">
		<?php echo $records->links() ?>
	</div>
</div>
</div>
<div class="tab-pane active" id="charts">
	<div class="temperature chart"></div>
	<div class="wind chart"></div>
</div>
</div>

