<?php

    abstract class Controller {
        private $handler;
        private $requestParams;
        private $requestBody;
        private $queryParams;
        protected $databaseConnection;

        public function __construct($handler, $requestParams = [], $queryParams, $requestBody = null, $requestHeaders) {
            $this->handler = $handler;
            $this->requestParams = $requestParams;
            $this->requestBody = $requestBody;
            $this->queryParams = $queryParams;
            $this->requestHeaders = $requestHeaders;
            $this->databaseConnection = DatabaseConnector::getInstance()->getConnection();
        }

        public function callHandler() {
            call_user_func(array($this, $this->handler), $this->requestParams, $this->queryParams, $this->requestBody);
        }

        public function checkAuthorized($userID, $adminAuth) {
            if (!is_numeric($userID)) {
                echo json_encode(new Response(40, "Bad userID."));
                die();
            }
            $result = $this->databaseConnection->query("SELECT id, role FROM users WHERE id = $userID");
            $row = $result->fetch_row();
            if (!$row) {
                echo json_encode(new Response(41, "User doesn't exist."));
                die();
            }
            if ($adminAuth) {
                if (!$row[1]) {
                    echo json_encode(new Response(44, "UserID not an admin."));
                    die();
                } 
            }
            if (!isset($this->requestHeaders["Authorization"])) {
                echo json_encode(new Response(42, "Authorization header not set."));
                die();
            }
            $result = $this->databaseConnection->query("SELECT EXISTS(SELECT * FROM user_login_keys 
                                                        WHERE userID = $userID AND loginKey = \"" . $this->requestHeaders["Authorization"] . "\")");
            $row = $result->fetch_row();
            if (!$row[0]) {
                echo json_encode(new Response(43, "UserID not logged in."));
                die();
            }

        }
    }

?>