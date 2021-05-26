<?php

    abstract class Controller {
        private $handler;
        private $requestParams;
        private $requestBody;
        private $queryParams;
        protected $databaseConnection;

        public function __construct($handler, $requestParams = [], $queryParams, $requestBody = null) {
            $this->handler = $handler;
            $this->requestParams = $requestParams;
            $this->requestBody = $requestBody;
            $this->queryParams = $queryParams;
            $this->databaseConnection = DatabaseConnector::getInstance()->getConnection();
        }

        public function callHandler() {
            call_user_func(array($this, $this->handler), $this->requestParams, $this->queryParams, $this->requestBody);
        }
    }

?>