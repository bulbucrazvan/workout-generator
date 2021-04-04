<?php

class Home extends Controller {
    
    public function index($name = 'default'){
        $this->view('home/index');
    }

    public function about(){
        $this->view('home/about');
    }

    public function login(){
        $this->view('home/login');
    }

    public function register(){
        $this->view('home/register');
    }
}

?>
