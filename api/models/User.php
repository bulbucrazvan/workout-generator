<?php 
    require_once("Model.php");

    class User extends Model {
        
        public $id;
        public $username;
        public $password;
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