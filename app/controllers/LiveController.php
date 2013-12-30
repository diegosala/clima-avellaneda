<?php

class LiveController extends BaseController {
	protected $layout = 'layouts.master';
	
	public function showLive()
    {
            $rawForecast = Cache::get("forecast");
            $finalForecast = array();
                
            $offset = 0;
            if (date("H") > 18) {
                $now = new DateTime();
                $tomorrow = new DateTime();
                $tomorrow->add(new DateInterval("P1D"));
                $tomorrow->setTime(3, 0);
                $threeAM = $now->diff($tomorrow);                                
                $d = $threeAM->h;
                
                $finalForecast[] = array(
                    "date" => "Esta noche", //date("d/m H:i:s", $rawForecast->hourly->data[$d]->time),
                    "icon" => "/assets/images/forecast/{$this->getForecastIcon($rawForecast->hourly->data[$d]->icon, $rawForecast->hourly->data[$d]->cloudCover, $rawForecast->hourly->data[$d]->precipIntensity, true)}.jpg",                    
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
                    "date" => date("d/m", $dailyData->time),
                    "icon" => "/assets/images/forecast/{$this->getForecastIcon($dailyData->icon, $dailyData->cloudCover, $dailyData->precipIntensity)}.jpg",
                    "cover" => $dailyData->cloudCover,
                    "max" => round($dailyData->temperatureMax),
                    "min" => round($dailyData->temperatureMin),
                    "windDir" => $this->getWindDirection($dailyData->windBearing),
                    "windSpeed" => round($dailyData->windSpeed*(3600 / 1000))
                );                
            }
            
            $this->layout->content = View::make('live')->with("forecast", $finalForecast);
    }
    
    private function getForecastIcon($icon, $cloudCover = "", $precipIntensity = "", $night = false) {
        switch ($icon) {
                        case 'clear-day': return "skc"; break;
                        case 'clear-night': return "nskc"; break;
                        case 'rain': 
                            if ($precipIntensity >= 1)
                                return ($night ? "n" : "")."tsra";
                            elseif ($precipIntensity >= 0.25)
                                return ($night ? "n" : "")."ra";
                            else
                                return ($night ? "n" : "")."shra"; 
                            break;
                        case 'snow': return "skc"; break;
                        case 'sleet': return "skc"; break;
                        case 'wind': return "skc"; break;
                        case 'fog': return "skc"; break;
                        case 'cloudy': return ($night ? "n" : "")."clody"; break;
                        case 'partly-cloudy-day':
                            if ($cloudCover >= 0.75)
                                return "ovc";
                            else if ($cloudCover >= 0.4)
                                return "sct";
                            else
                                return "bkn"; 
                            break;
                        case 'partly-cloudy-night': 
                            if ($cloudCover >= 0.75)
                                return "novc";
                            else if ($cloudCover >= 0.4)
                                return "nsct";
                            else
                                return "nbkn"; 
                            break;
                            break;
        }
    }
    
    private function getWindDirection($bearing) {
        $directions = array("N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSO", "SO", "OSO", "O", "ONO", "NO", "NNO");
        
        for($i=0; $i<16; $i++) {
            if ($bearing < $i*22.5)
                return $directions[$i];
        }        
    }

	public function LastData($span)
	{	        		
		return Response::json(DB::table('live')->select('timestamp', 'temperature', 'humidity', 'wind_speed', 'wind_gust', 'wind_direction', 'rain')->orderBy('id', 'desc')->take($span*12)->get());
	}

	public function LiveData($span = 5, $unit = 'minutes') {	
		$this->layout->content = View::make('graficos')->with('span', $span);		
	}
}
