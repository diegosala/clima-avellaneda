<?php
class Forecast {
	private $rf;
	public function __construct($rf)
	{
		$this->rf = $rf;
	}

	public function getDailyForecast() 
	{
            $rawForecast = $this->rf;
            $finalForecast = array();
                
            $offset = 0;
            if (date("H") >= 18) {
                $now = new DateTime();
                $tomorrow = new DateTime();
                $tomorrow->add(new DateInterval("P1D"));
                $tomorrow->setTime(3, 0);
                $threeAM = $now->diff($tomorrow);                                
                $d = $threeAM->h + 3;
                
                $finalForecast[] = array(
                    "date" => "Esta noche", //date("d/m H:i:s", $rawForecast->hourly->data[$d]->time),
                    "icon" => "/assets/images/forecast/{$this->getForecastIcon($rawForecast->hourly->data[$d]->icon, $rawForecast->hourly->data[$d]->cloudCover, $rawForecast->hourly->data[$d]->precipIntensity, $rawForecast->hourly->data[$d]->precipProbability, true)}.jpg",                    
                    "min" => round($rawForecast->hourly->data[$d]->temperature),
                    "cover" => $rawForecast->hourly->data[$d]->cloudCover,
                    "windDir" => $this->getWindDirection($rawForecast->hourly->data[$d]->windBearing),
                    "windSpeed" => round($rawForecast->hourly->data[$d]->windSpeed*(3600 / 1000))
                );                
                if (date("d", $rawForecast->hourly->data[$d]->time) != date("d"))
                    $offset++;
            }
            
            foreach($rawForecast->daily->data as $dailyData) {
                if($offset > 0) {
                    $offset--;
                    continue;
                }
                $finalForecast[] = array(
                    //"date" => date("d/m", $dailyData->time),
                    "date" => WeekDay::getSpanish(date("w", $dailyData->time)),			
                    "icon" => "/assets/images/forecast/{$this->getForecastIcon($dailyData->icon, $dailyData->cloudCover, $dailyData->precipIntensity, $dailyData->precipProbability)}.jpg",
                    "cover" => $dailyData->cloudCover,
                    "max" => round(@isset($dailyData->temperatureMax) ? $dailyData->temperatureMax : null),
                    "min" => round(@isset($dailyData->temperatureMin) ? $dailyData->temperatureMin : null),
                    "windDir" => $this->getWindDirection($dailyData->windBearing),
                    "windSpeed" => round($dailyData->windSpeed*(3600 / 1000))
                );                
            }

	return $finalForecast;
	}

	public function getHourlyForecast($dayNumber) {
		$currentDay = 0;
		$final_forecast = array();
		$date = date("Ymd", $this->rf->hourly->data[0]->time);

		foreach($this->rf->hourly->data as $hourlyData) {
			if (date("Ymd", $hourlyData->time) != $date) {
				$date = date("Ymd", $hourlyData->time);
				$currentDay++;
			}

			if ($currentDay != $dayNumber)
				continue;

			$dayNumberDate = isset($dayNumberDate) ? $dayNumberDate : date("d/m/Y", $hourlyData->time);

			$final_forecast[] = array(
				"time" => date("H:i", $hourlyData->time),
				"icon" => "/assets/images/forecast/{$this->getForecastIcon($hourlyData->icon, $hourlyData->cloudCover, $hourlyData->precipIntensity, $hourlyData->precipProbability)}.jpg",
				"temperature" => round(@isset($hourlyData->temperature) ? $hourlyData->temperature : null),
				"windDir" => $this->getWindDirection($hourlyData->windBearing),
				"windSpeed" => round($hourlyData->windSpeed*(3600 / 1000))
			);
		}

		return array("date" => $dayNumberDate, "updated" => date("d/m @ H:i", $this->rf->currently->time),"detail" => $final_forecast);
	}

	public function getForecastIcon($icon, $cloudCover = "", $precipIntensity = "", $precipProbability = "", $night = false) {
	if ($precipProbability > 0.1)
		$precipProbability = round($precipProbability, 1) * 100;
	else
		$precipProbability = "";
        switch ($icon) {
                        case 'clear-day': return "skc"; break;
                        case 'clear-night': return "nskc"; break;
                        case 'rain': 
                            if ($precipIntensity >= 1)
                                return ($night ? "n" : "")."tsra".$precipProbability;
                            elseif ($precipIntensity >= 0.25)
                                return ($night ? "n" : "")."ra".$precipProbability;
                            else
                                return ($night ? "n" : "")."shra".$precipProbability; 
                            break;
                        case 'snow': return "skc"; break;
                        case 'sleet': return "skc"; break;
                        case 'wind': return "skc"; break;
                        case 'fog': return "skc"; break;
                        case 'cloudy': return ($night ? "n" : "")."ovc".$precipProbability; break;
                        case 'partly-cloudy-day':
                            if ($cloudCover >= 0.75)
                                return "ovc".$precipProbability;
                            else if ($cloudCover >= 0.4)
                                return "bkn".$precipProbability;
				else if ($cloudCover >= 0.1)
                                return "sct".$precipProbability;
                            else
                                return "few".$precipProbability; 
                            break;
                        case 'partly-cloudy-night': 
                            if ($cloudCover >= 0.75)
                                return "novc".$precipProbability;
                            else if ($cloudCover >= 0.4)
                                return "nbkn".$precipProbability;
				else if ($cloudCover >= 0.1)
                                return "nsct".$precipProbability;
                            else
                                return "nfew".$precipProbability;
                            break;
        }
    }
    
    private function getWindDirection($bearing) {
        $directions = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSO", "SO", "OSO", "O", "ONO", "NO", "NNO");
        
        for($i=0; $i<16; $i++) {
            if ($bearing <= ($i+1)*22.5)
                return $directions[$i];
        }        
    }
}
