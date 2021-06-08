<?php

    class SessionUtils {

        public static function startSession() {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
        }

        public static function checkAuthorized() {
            if (!SessionUtils::isLoggedIn()) {
                Redirect::errorPage("You need to be logged in to access this page.");
            }
        }

        public static function checkAdminAuthorized() {
            SessionUtils::checkAuthorized();
            if (!SessionUtils::isAdmin()) {
                Redirect::errorPage("You need to be an administrator to access this page.");
            }
        }

        public static function isLoggedIn() {
            return (isset($_SESSION["SESSION_USER"]) );
        }

        public static function isAdmin() {
            return $_SESSION["USER_ROLE"];
        }

        public static function login($loginInfo, $loginKey) {
            $_SESSION["SESSION_USER"] = $loginInfo["userID"];
            $_SESSION["USER_ROLE"] = $loginInfo["userRole"];
            $_SESSION["LOGIN_KEY"] = $loginKey;
        }

        public static function logout() {
            session_unset();
            session_destroy();
        }

    }

?>