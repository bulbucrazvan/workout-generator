<?php
    require_once("../controllers/Controller.php");

    class ControllerRouter {

        private $routesJSON;
        private $requestParams;
        private $headers;
        private $requestUriTokens;
        private $requestMethod;
        private $requestBody;
        private $queryParams;
        private $errorMessage;

        function __construct($headers, $requestBody, $requestUri, $requestMethod, $queryString) {
            $this->routesJSON = json_decode(file_get_contents("routes.json"));
            $this->headers = $headers;
            $this->requestUriTokens = array_slice(explode('/', rtrim(parse_url($requestUri, PHP_URL_PATH), '/')), 3);
            $this->requestMethod = $requestMethod;
            $this->requestParams = array();
            parse_str($queryString, $this->queryParams);
            $this->requestBody = json_decode($requestBody, true);
        }

        public function parseURI() {
            $currentRoute = $this->routesJSON->routes;
            $subroutes = $currentRoute;

            for ($currentDepth = 0; $currentDepth < count($this->requestUriTokens); $currentDepth++) {
                $currentRoute = $this->checkCurrentDepth($subroutes, $this->requestUriTokens[$currentDepth]);
                if (!isset($currentRoute)) {
                    return $this->getErrorController(404, "Endpoint not found");
                }
                $subroutes = $currentRoute->subroutes;
            }

            return $this->getController($currentRoute, $this->requestUriTokens[0]);
        }

        private function checkCurrentDepth($currentDepthRoutes, $currentDepthToken) {
            foreach ($currentDepthRoutes as $route) {
                if ($route->isParameter) {
                    $this->requestParams[$route->name] = $currentDepthToken;
                    return $route;  
                }
                else {
                    if ($route->name == $currentDepthToken) {
                        return $route;
                    }
                }
            }
            return null;
        }

        private function getErrorController($statusCode, $errorDescription) {
            require_once("../controllers/ErrorController.php");
            return new ErrorController(array($statusCode, $errorDescription));
        }

        private function getController($endpoint, $topMostRouteName) {
            $controllerType = $this->getControllerType($topMostRouteName);

            $requestMethodIndex = array_search($this->requestMethod, $endpoint->acceptedMethods);
            if ($requestMethodIndex === false) {
                return $this->getErrorController(500, "Method not allowed.");
            }
            $controllerHandler = $endpoint->methodHandlers[$requestMethodIndex];
            
            $requestBodyModelObject = $this->getRequestBodyModel($endpoint, $requestMethodIndex);
            if (isset($this->errorMessage)) {
                return $this->errorMessage;
            }
            
            if ($this->checkQueryParams($endpoint, $requestMethodIndex) === false) {
                return $this->errorMessage;
            }

            require_once("../controllers/" . $controllerType . ".php");
            return new $controllerType($controllerHandler, $this->requestParams, $this->queryParams, $requestBodyModelObject);
        }


        private function getControllerType($topMostRouteName) {
            foreach ($this->routesJSON->routes as $topMostRoute) {
                if ($topMostRoute->name == $topMostRouteName) {
                    return $topMostRoute->controller;
                }
            }
        }

        private function getRequestBodyModel($endpoint, $requestMethodIndex) {
            $requestBodyModelType = $endpoint->requestBodyModel[$requestMethodIndex];
            if ($requestBodyModelType == null) {
                if (!empty($this->requestBody)) {
                    $this->errorMessage = $this->getErrorController(400, "Method doesn't accept request bodies.");
                }
                return null;
            }
            else {
                return $this->constructRequestBodyModelObject($requestBodyModelType);
            }
        }

        private function constructRequestBodyModelObject($requestBodyModelType) {
            if (file_exists(__DIR__."/../models/". $requestBodyModelType . ".php")) {
                require_once(__DIR__."/../models/" . $requestBodyModelType . ".php");
            }
            else {
                require_once(__DIR__."/../models/DTO/" . $requestBodyModelType . ".php");
            }

            $requestBodyModelObject = new $requestBodyModelType();
            foreach ($requestBodyModelObject as $key => $value) {
                if (isset($this->requestBody[$key])) {
                    $requestBodyModelObject->setInfo($key, $this->requestBody[$key]);
                }
                else {
                    $this->errorMessage = $this->getErrorController(400, "Invalid request body.");
                    break;
                }
            }
            return $requestBodyModelObject;
        }

        private function checkQueryParams($endpoint, $requestMethodIndex) {
            $stringQueries = $endpoint->stringQueries[$requestMethodIndex];
            $stringQueryDefaults = $endpoint->stringQueryDefaults[$requestMethodIndex];

            if (count(array_diff(array_flip($this->queryParams), $stringQueries))) {
                $this->errorMessage = $this->getErrorController(400, "Unrecognized string query parameters.");
                return false;
            }

            for ($i = 0; $i < count($stringQueries); $i++) {
                if (!isset($this->queryParams[$stringQueries[$i]])) {
                    if ($stringQueryDefaults[$i] === null) {
                        $this->errorMessage = $this->getErrorController(400, "Query parameter '". $stringQueries[$i] . "' must be filled.");
                        return false;
                    }
                    else {
                        $this->queryParams[$stringQueries[$i]] = $stringQueryDefaults[$i];
                    }
                }
            }
            return true;
        }

    }

?>