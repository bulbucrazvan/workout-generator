<?php
    require_once("../controllers/Controller.php");
    require_once("../controllers/UsersController.php");
    require_once("../controllers/ErrorController.php");

    class ControllerRouter {

        private $routesJSON;
        private $requestParams;
        private $headers;
        private $requestUriTokens;
        private $requestMethod;
        private $queryParams;
        private $payloadJSON;

        function __construct($headers, $payloadString, $requestUri, $requestMethod, $queryString) {
            $this->routesJSON = json_decode(file_get_contents("routes.json"));
            $this->headers = $headers;
            $this->requestUriTokens = array_slice(explode('/', rtrim(parse_url($requestUri, PHP_URL_PATH), '/')), 3);
            $this->requestMethod = $requestMethod;
            $this->requestParams = array();
            parse_str($queryString, $this->queryParams);
            $this->payloadJSON = json_decode($payloadString);
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

        private function checkCurrentDepth($currentDepthRoute, $currentDepthToken) {
            foreach ($currentDepthRoute as $route) {
                if ($route->isParameter) {
                    if (is_numeric($currentDepthToken)) {
                        array_push($this->requestParams, $currentDepthToken);
                        return $route;
                    }
                    else {
                        return null;
                    }
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
            return new ErrorController(array($statusCode, $errorDescription));
        }

        private function getController($endpoint, $topMostRouteName) {
            $controllerType = $this->getControllerType($topMostRouteName);
            $controllerHandler = $this->getControllerHandler($endpoint, $this->requestMethod);
            return new $controllerType($controllerHandler, $this->requestParams);
        }


        private function getControllerType($topMostRouteName) {
            foreach ($this->routesJSON->routes as $topMostRoute) {
                if ($topMostRoute->name == $topMostRouteName) {
                    return $topMostRoute->controller;
                }
            }
        }

        private function getControllerHandler($endpoint, $requestMethod) {
            $handlerIndex = array_search($requestMethod, $endpoint->acceptedMethods);
            return $endpoint->methodHandlers[$handlerIndex];
        }

    }

?>