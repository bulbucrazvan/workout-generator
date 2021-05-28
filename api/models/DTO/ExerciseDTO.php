<?php

    class ExerciseDTO extends Model {

        public $name;
        public $wasDeleted;

        public function __construct($name, $wasDeleted) {
            $this->name = $name;
            $this->wasDeleted = $wasDeleted;
        }

    }

?>