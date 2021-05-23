<?php
    class UsersController extends Controller {

        public function test($params) {
            echo $params[0];
        }

        public function getUsers($params) {
            echo 'hi';
        }

        public function addUser($params) {
            if (isset($params)) {
                echo 'setpost';
            }
            else {
                echo 'unsetpost';
            }
            foreach ($params as $param) {
                echo $param;
            }
        }

    }

?>