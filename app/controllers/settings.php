<?php

    class Settings extends Controller {

        public function __construct() {
            SessionUtils::checkAuthorized();
        }

        public function index() {
           
            $this->view('settings/settings');
        }
    }

?>