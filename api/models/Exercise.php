<?php
    require_once("Model.php");

    class Exercise extends Model {

        public $id;
        public $name;
        public $instructions;
        public $videoURL;
        public $duration;
        public $locations;
        public $muscles;

    }

?>