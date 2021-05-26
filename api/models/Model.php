<?php

    class Model {
        public function setInfo($key, $value) {
            $this->$key = $value;
        }

        public function getInfo($requestedInfo) {
            return $this->$requestedInfo;
        }
    }

?>