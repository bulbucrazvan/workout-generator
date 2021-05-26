<?php

    class DatabaseConnector {
        private static $instance = null;
        private $CONNECTION = null;
        private $CONFIG;

        private function __construct() {
            $this->CONFIG = json_decode(file_get_contents("../dbconfig.json"), true);
            $this->CONNECTION = new mysqli($this->CONFIG["servername"], $this->CONFIG["username"], $this->CONFIG["password"], $this->CONFIG["database"]);
        }

        public static function getInstance() {
            if (self::$instance == null) {
                self::$instance = new DatabaseConnector();
            }
            return self::$instance;
        }

        public function getConnection() {
            return $this->CONNECTION;
        }

        public function checkConnection() {
            return $this->CONNECTION->connect_error;
        }
    }

?>