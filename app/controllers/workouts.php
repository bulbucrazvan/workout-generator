<?php

    class Workouts extends Controller {

        public function index() {

            $this->view('workouts/userworkouts');
        }

        public function create() {

            $this->view('workouts/manualWorkout');
        }

        public function generate() {

            $this->view('workouts/generateWorkout');
        }

    }

?>