<table class="table">
	<tr><td>Temperatura m&aacute;xima</td><td><?php echo $day->max_temperature ?>°C @ <?php echo  $day->max_temperaure_time ?> </td></tr>
	<tr><td>Temperatura m&iacute;nima</td><td><?php echo $day->min_temperature ?>°C  @ <?php echo $day->min_temperaure_time ?> </td></tr>
	<tr><td>Temperatura promedio</td><td><?php echo $day->avg_temperature ?>°C</td></tr>
	<tr><td>Humedad promedio</td><td><?php echo $day->avg_humidity ?>%</td></tr>
	<tr><td>Viento promedio</td><td><?php echo $day->avg_windspeed ?> km/h</td></tr>
	<tr><td>R&aacute;faga m&aacute;xima</td><td><?php echo $day->max_windgust ?> km/h @ <?php echo $day->max_windgust_time ?></td></tr>
	<tr><td>Direcci&oacute;n dominante</td><td><?php echo $day->windDirection->code ?></td></tr>
	<tr><td>Precipitaci&oacute;n</td><td><?php echo $day->sum_rain ?> mm</td></tr>
</table>
