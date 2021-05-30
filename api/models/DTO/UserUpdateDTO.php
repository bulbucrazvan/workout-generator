<?php

    require_once(__DIR__."/../Model.php");

    class UserUpdateDTO extends Model {

        public $gender;
        public $dateOfBirth;
        public $height;
        public $weight;
        public $email;
        public $oldPassword;
        public $newPassword;
        public $type;

    }

?>