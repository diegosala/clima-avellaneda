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
				'email.email' => 'Ingrese una direcci&oacute;n de correo electr&oacute;nico v&aacute;lida',
				'comment.required' => 'Ingrese un comentario'
			)
		);

		if ($v->fails()) {
			$this->layout->content = View::make('contact.form')->withErrors($v)->withInput($_POST);
		} else {
			$view = View::make('contact.sent')->withSuccess(true);
			try {
				Mail::send('contact.mail', $_POST, function($message)
	                	{
	                        	$message->to('diego45@gmail.com', 'Diego Sala')->subject('Contacto')->setReplyTo($_POST["email"], $_POST["name"]);
	                	});
			} catch (Exception $e) {
				$view->withSuccess(false);
			}
			$this->layout->content = $view;
		}
	}	
}
