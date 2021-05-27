<?php
    
    class Authorization extends Controller {

        public function login() {
            if (SessionUtils::isLoggedIn()) {
                Redirect::to(APP_PATH . "/home");
            }
            $this->view('auth/login');
        }

        public function register() {
            if (SessionUtils::isLoggedIn()) {
                Redirect::to(APP_PATH . "/home");
            }
            $this->view('auth/register');
        }

        public function beginSession($loginkey) {
            if (SessionUtils::isLoggedIn()) {
                Redirect::to(APP_PATH . '/home');
            }
            
            $requestURI = "http://92.115.143.213:3000/project/api/users/login/loginKeyUser?loginKey=" . $loginkey;

            $curlHandle = curl_init($requestURI);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curlHandle), true);
            curl_close($curlHandle);

            SessionUtils::login($response["description"], $loginkey);
            Redirect::to(APP_PATH);
        }

    }

?>