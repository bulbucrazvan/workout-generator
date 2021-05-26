<?php

    class Response {
        public $statusCode;
        public $description;

        public function __construct($statusCode, $description) {
            $this->statusCode = $statusCode;
            $this->description = $description;
        }
    }

?>