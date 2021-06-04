<?php

    require_once(__DIR__."/../Model.php");

    class WorkoutDTO extends Model {

        public $workoutName;
        public $workoutID;
        public $dateCompleted;

        public function __construct($name, $id, $date) {
            $this->workoutName = $name;
            $this->workoutID = $id;
            $this->dateCompleted = $date;
        }

    }


?>