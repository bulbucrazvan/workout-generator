<?php

    class Model {
        public function setInfo($key, $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        public function getInfo($requestedInfo) {
            return $this->$requestedInfo;
        }
    }

?>