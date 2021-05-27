<?php

    class Welcome extends Controller {

        public function index() {
            $this->view('welcome/index');
        }

        public function about(){
            $this->view('welcome/about');
        }
    
        
    }

?>