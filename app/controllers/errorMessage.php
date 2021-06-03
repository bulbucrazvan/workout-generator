<?php

    class ErrorMessage extends Controller {
        
        public function index() {
            $this->view('errorScreen', $_COOKIE["errorMessage"]);
        }
    }

?>