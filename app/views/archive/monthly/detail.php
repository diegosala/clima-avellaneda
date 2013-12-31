<table class="table">
	<tr><td>Temperatura m&aacute;xima</td><td><?php echo $month->max_temperature ?>°C @ <?php echo $month->max_temperaure_date ?></td></tr>
	<tr><td>Temperatura m&iacute;nima</td><td><?php echo $month->min_temperature ?>°C  @ <?php echo $month->min_temperaure_date ?></td></tr>
	<tr><td>Temperatura promedio</td><td><?php echo $month->avg_temperature ?>°C</td></tr>
	<tr><td>Humedad promedio</td><td><?php echo $month->avg_humidity ?>%</td></tr>
	<tr><td>Viento promedio</td><td><?php echo $month->avg_windspeed ?> km/h</td></tr>
	<tr><td>R&aacute;faga m&aacute;xima</td><td><?php echo $month->max_windgust ?> km/h @ <?php echo $month->max_windgust_date ?></td></tr>
	<tr><td>Direcci&oacute;n dominante</td><td><?php echo $month->windDirection->code ?></td></tr>
	<tr><td>Precipitaci&oacute;n</td><td><?php echo $month->sum_rain ?> mm</td></tr>
</table>
