<?php

class Wunder extends BaseController {
    public function Main() {
        $request = Requests::get('http://climasurgba.com.ar/');
        
        return $request->body;
    }
    
}

?>