<table class="table">
	<tr><td>Temperatura m&aacute;xima</td><td><?php echo $year->max_temperature ?>°C @ <?php echo $year->max_temperaure_date ?></td></tr>
	<tr><td>Temperatura m&iacute;nima</td><td><?php echo $year->min_temperature ?>°C  @ <?php echo $year->min_temperaure_date ?></td></tr>
	<tr><td>Temperatura promedio</td><td><?php echo $year->avg_temperature ?>°C</td></tr>
	<tr><td>Humedad promedio</td><td><?php echo $year->avg_humidity ?>%</td></tr>
	<tr><td>Viento promedio</td><td><?php echo $year->avg_windspeed ?> km/h</td></tr>
	<tr><td>R&aacute;faga m&aacute;xima</td><td><?php echo $year->max_windgust ?> km/h @ <?php echo $year->max_windgust_date ?></td></tr>
	<tr><td>Precipitaci&oacute;n</td><td><?php echo $year->sum_rain ?> mm</td></tr>
</table>
