<?php

    require_once("ControllerRouter.php");
    require_once("../controllers/Controller.php");
    require_once("../DatabaseConnector.php");
    require_once("../models/Response.php");

    header('Content-type: application/json');

    $databaseStatus = DatabaseConnector::getInstance()->checkConnection();
    if ($databaseStatus) {
        require_once("../controllers/ErrorController.php");
        echo new ErrorController(500, $databaseStatus);
        die($databaseStatus);
    }
    
    $requestHeaders = getallheaders();
    $requestBody = file_get_contents("php://input");

    $requestRouter = new ControllerRouter($requestHeaders, $requestBody, $_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"], $_SERVER["QUERY_STRING"]);
    $controller = $requestRouter->parseURI();
    $controller->callHandler();

?>