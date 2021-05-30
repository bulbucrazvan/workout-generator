<?php
    require_once("Model.php");

    class Workout extends Model {

        public $id;
        public $name;
        public $wasDeleted;
        public $duration;
        public $exercises;
    }

?>
