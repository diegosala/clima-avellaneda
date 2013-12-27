<?php

ini_set("show_errors", true);

date_default_timezone_set("America/Argentina/Buenos_Aires");

$r = file_get_contents("php://input");
$text = json_decode($r, true);
$s = $text["datos"];

$ts = time();

$bateria = trim(substr($s, 42, 6))*1;
//$bateria = $bateria * 1023 / 15;
//$bateria = $bateria * 15 / 1100;

$datos = array(
		"timestamp" => $ts,
		"hora" => date("d/m @ H:i:s", $ts), 
	    "temperatura"=>trim(substr($s, 0, 6))*1,
		"humedad"=>trim(substr($s, 6, 6))*1,
		"velocidad"=>trim(substr($s, 12, 6))*1,
		"rafaga"=>trim(substr($s, 18, 6))*1,
		"direccion"=>trim(substr($s, 24, 6))*1,
        "lluvia"=>trim(substr($s, 36, 6))*1,
        "bateria"=>round($bateria,3)
	);
    
if ($datos["humedad"] == 0) {
    $log = @fopen("log_lluvia.txt", "a");
    @fwrite($log, date("Y-m-d H:i:s").": ".$r.PHP_EOL);
    @fclose($log);
    exit();	
}

$tsdb = date("Y-m-d H:i:s");
$db = new PDO('mysql:host=localhost;dbname=diego45_avellaclima', 'diego45_avella', 'avellaclima');

$insert = "insert into live (temperature, humidity, wind_speed, wind_gust, wind_direction, rain, battery, timestamp, date_period)VALUES ({$datos["temperatura"]}, {$datos["humedad"]}, {$datos["velocidad"]}, {$datos["rafaga"]}, {$datos["direccion"]}, {$datos["lluvia"]}, {$datos["bateria"]}, '{$tsdb}', date_period('{$tsdb}'))";

$stmt = $db->prepare($insert);
$stmt->execute();

$last_id = $db->lastInsertId();
$diff = $last_id - 12 * 10;
$r = $db->query("SELECT sum(rain) lluvia FROM live WHERE id BETWEEN {$diff} AND {$last_id} AND humidity > 0");
$lluvia = $r->fetch(PDO::FETCH_ASSOC);

$datos["lluvia"] = $lluvia["lluvia"] * 0.3;
	
file_put_contents("arduino.txt", json_encode($datos, true));

//echo $insert;
?>
