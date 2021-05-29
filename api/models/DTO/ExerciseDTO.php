<?php

    class ExerciseDTO extends Model {

        public $id;
        public $name;
        public $wasDeleted;

        public function __construct($id, $name, $wasDeleted) {
            $this->id = $id;
            $this->name = $name;
            $this->wasDeleted = $wasDeleted;
        }

    }

?>