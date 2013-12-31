<?php

class ContactController extends BaseController {
	protected $layout = 'layouts.master';
	
	public function main()
	{          	
		$this->layout->content = View::make('contact.form')->withInput(array('name'=>null,'email'=>null,'comment'=>null));
 	}
	
	public function send() {
		$v = Validator::make(
			$_POST,
			array(
				'name' => 'required',
				'email' => 'required|email',
				'comment' => 'required'
			),
			array(
				'name.required' => 'Ingrese su nombre',
				'email.required' => 'Ingrese su direcci&oacute;n de correo electr&oacute;nico',
				'email.email' => 'La direcci&oacute;n de correo electr&oacute;nico ingresada no es v&aacute;lida',
				'comment' => 'Ingrese un comentario'
			)
		);

		if ($v->fails()) {
			$this->layout->content = View::make('contact.form')->withErrors($v)->withInput($_POST);
		} else {
			 Mail::send('contact.mail', $_POST, function($message)
                	{
                        	$message->to('diego45@gmail.com', 'Diego Sala')->subject('Contacto')->setReplyTo($_POST["email"], $_POST["name"]);
                	});
		}
	}	
}
