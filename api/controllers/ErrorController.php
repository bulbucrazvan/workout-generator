<?php

    class ErrorController extends Controller {
        
        public function __construct($requestParams) {
            $this->requestParams = $requestParams;
        }

        public function callHandler() {
            $this->printError($this->requestParams);
        }

        public function printError($errorParams) {
            http_response_code($errorParams[0]);

            $errorMessage = [
                "statusCode" => $errorParams[0],
                "description" => $errorParams[1]
            ];

            echo json_encode($errorMessage);
        }
    }

?>