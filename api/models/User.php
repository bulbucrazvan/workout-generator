<?php 
    require_once("Model.php");

    class User extends Model {
        
        public $username;
        public $email;
        public $gender;
        public $dateOfBirth;
        public $height;
        public $weight;
        public $currentStreak;
        public $longestStreak;
        public $workoutsCompleted;
        public $canCreate;

    }

?>