<?php

    class SessionUtils {

        public static function startSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }

        public static function isLoggedIn() {
            return isset($_SESSION["SESSION_USER"]);
        }

        public static function login($userID, $loginKey) {
            $_SESSION["SESSION_USER"] = $userID;
            $_SESSION["LOGIN_KEY"] = $loginKey;
        }

        public static function logout() {
            session_unset();
            session_destroy();
        }

    }

?>