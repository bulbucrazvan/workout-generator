<?php

    require_once(__DIR__."/../Model.php");

    class WorkoutDTO extends Model {

        public $workoutName;
        public $workoutID;

        public function __construct($name, $id) {
            $this->workoutName = $name;
            $this->workoutID = $id;
        }

    }


?>