<?php

//ini_set("show_errors", true);

date_default_timezone_set("America/Argentina/Buenos_Aires");

$r = file_get_contents("php://input");
$text = json_decode($r, true);
$s = $text["datos"];

$ts = time();

$bateria = trim(substr($s, 42, 6))*1;

$datos = array(
    "timestamp" => $ts,
    "hora" => date("d/m @ H:i:s", $ts), 
    "temperatura"=>trim(substr($s, 0, 6))*1,
    "humedad"=>trim(substr($s, 6, 6))*1,
    "velocidad"=>trim(substr($s, 12, 6))*1,
    "rafaga"=>trim(substr($s, 18, 6))*1,
    "direccion"=>trim(substr($s, 24, 6))*1,
    "lluvia"=>trim(substr($s, 36, 6))*1,
    "retry"=>trim(substr($s, 48, 6))*1,
    "uptime"=>trim(substr($s, 54, 6))*1,
    "bateria"=>round($bateria,3)
);

if ($datos["humedad"] == 0) {
    $log = @fopen("log_lluvia.txt", "a");
    @fwrite($log, date("Y-m-d H:i:s").": ".$r.PHP_EOL);
    @fclose($log);
    exit();	
}

$historial_lluvia = unserialize(file_get_contents("lluvia.txt"));
if (!is_array($historial_lluvia))
    $historial_lluvia = array();
if (count($historial_lluvia) > 120)
    array_shift($historial_lluvia);
array_push($historial_lluvia, $datos["lluvia"]);
file_put_contents("lluvia.txt", serialize($historial_lluvia));

$tsdb = date("Y-m-d H:i:s");
$db = new PDO('mysql:host=localhost;dbname=diego45_avellaclima', 'diego45_avella', 'avellaclima');

$insert = "insert into live (temperature, humidity, wind_speed, wind_gust, wind_direction, rain, battery, timestamp, date_period, retry, uptime) VALUES ({$datos["temperatura"]}, {$datos["humedad"]}, {$datos["velocidad"]}, {$datos["rafaga"]}, {$datos["direccion"]}, {$datos["lluvia"]}, {$datos["bateria"]}, '{$tsdb}', date_period('{$tsdb}'), {$datos["retry"]}, {$datos["uptime"]})";

$stmt = $db->prepare($insert);
$stmt->execute();

$datos["lluvia"] = array_sum($historial_lluvia)*0.3;

file_put_contents("datos.txt", json_encode($datos, true));
