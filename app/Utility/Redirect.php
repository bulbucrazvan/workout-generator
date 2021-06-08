<?php

    class Redirect {

        public static function to($path) {
            header("Location: " . $path);
        }

        public static function errorPage($errorMessage) {
            setcookie("errorMessage", $errorMessage, time() + 10);
            header("Location: /project/public/errorMessage");
            die();
        }

    }

?>