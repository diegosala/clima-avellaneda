<?php

class ContactController extends BaseController {
	protected $layout = 'layouts.master';
	
	public function main()
    	{          	
		$this->layout->content = View::make('contact.form');
 	}
	
	public function send() {
		Mail::send('contact.mail', $_POST, function($message)
		{
			$message->to('diego45@gmail.com', 'Diego Sala')->subject('Contacto');
		});
	}
	
}
