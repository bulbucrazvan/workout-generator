<?php

    abstract class Controller {
        private $handler;
        private $requestParams;

        public function __construct($handler, $requestParams = []) {
            $this->handler = $handler;
            $this->requestParams = $requestParams;
        }

        public function callHandler() {
            call_user_func_array(array($this, $this->handler), array($this->requestParams));
        }
    }

?>