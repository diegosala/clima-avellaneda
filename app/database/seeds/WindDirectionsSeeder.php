<?php
class WindDirectionsSeeder extends Seeder {
	public function run()
	{
		WindDirection::create(array('id'=>1, 'code'=>'N'));
		WindDirection::create(array('id'=>2, 'code'=>'NNE'));
		WindDirection::create(array('id'=>3, 'code'=>'NE'));
		WindDirection::create(array('id'=>4, 'code'=>'ENE'));
		WindDirection::create(array('id'=>5, 'code'=>'E'));
		WindDirection::create(array('id'=>6, 'code'=>'ESE'));
		WindDirection::create(array('id'=>7, 'code'=>'SE'));
		WindDirection::create(array('id'=>8, 'code'=>'SSE'));
		WindDirection::create(array('id'=>9, 'code'=>'S'));
		WindDirection::create(array('id'=>10, 'code'=>'SSO'));
		WindDirection::create(array('id'=>11, 'code'=>'SO'));
		WindDirection::create(array('id'=>12, 'code'=>'OSO'));
		WindDirection::create(array('id'=>13, 'code'=>'O'));
		WindDirection::create(array('id'=>14, 'code'=>'ONO'));
		WindDirection::create(array('id'=>15, 'code'=>'NO'));
		WindDirection::create(array('id'=>16, 'code'=>'NNO'));
	}
}
