<?php

    class ErrorMessage extends Controller {
        
        public function index($errorMessage = '') {
            $errorMessage = "Hello there.";
            $this->view('errorScreen', $errorMessage);
        }
    }

?>