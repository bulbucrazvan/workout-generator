<?php
    require_once("ControllerRouter.php");
    require_once("../controllers/Controller.php");

    header('Content-type: application/json');

    $requestHeaders = getallheaders();

    $payloadString = file_get_contents("php://input");

    $requestUriTokens = array_slice(explode('/', rtrim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), '/')), 3);

    // test($requestUriTokens);
    $requestRouter = new ControllerRouter($requestHeaders, $payloadString, $_SERVER["REQUEST_URI"], $_SERVER["REQUEST_METHOD"], $_SERVER["QUERY_STRING"]);
    $controller = $requestRouter->parseURI();
    $controller->callHandler();

    function test($requestUriTokens) {
        http_response_code(404);
        global $getArr;
        $response = [
            "status" => 404,
            "reason" => $requestUriTokens,
            "test" => json_decode(file_get_contents("php://input")),
            "test2" => $_SERVER["REQUEST_METHOD"],
            "srvname" => $_SERVER["SERVER_NAME"],
            "querystr" => $_SERVER["QUERY_STRING"],
            "qurst" => $getArr,
            "dcmtroot" => $_SERVER["DOCUMENT_ROOT"],
            "httpaccept" => $_SERVER["HTTP_ACCEPT"],
            "json" => json_decode(file_get_contents("routes.json"))
        ];

        echo json_encode($response);
    }

?>