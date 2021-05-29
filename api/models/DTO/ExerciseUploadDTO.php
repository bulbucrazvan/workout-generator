<?php
    require_once(__DIR__."/../Model.php");

    class ExerciseUploadDTO extends Model {

        public $name;
        public $instructions;
        public $videoURL;
        public $duration;
        public $locations;
        public $muscles;

    }

?>