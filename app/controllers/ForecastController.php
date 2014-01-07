<?php

class ForecastController extends BaseController {
        protected $layout = 'layouts.archive';

        public function main() 
	{
		$f = Cache::get("forecast");
		$this->layout->content = View::make('forecast')->with('forecast', $f);
        }

	public function day($day) {
		$f = new Forecast(Cache::get("forecast"));
		
		return Response::json($f->getHourlyForecast($day));
	/*foreach($forecast->hourly->data as $d) {
	
        <tr>
                <td>{{ date("Y-m-d H:i:s", $d->time) }}</td>
                <td>{{ $d->icon }}</td>
                <td>{{ $d->precipIntensity }} </td>
                <td>{{ $d->precipProbability }}</td>
                <td>{{ $d->cloudCover }}</td>
                <td><img src="/assets/images/forecast/<?php echo $f->getForecastIcon($d->icon, $d->cloudCover, $d->precipIntensity, $d->precipProbability) ?>.jpg"></td>
        </tr>
	*/
	}
}
