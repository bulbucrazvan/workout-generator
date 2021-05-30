<?php

    class Workouts extends Controller {

        public function index() {

            $curlHandle = curl_init("http://92.115.143.213:3000/project/api/users/" . $_SESSION["SESSION_USER"] . "/workouts");
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curlHandle), true);
            curl_close($curlHandle);

            $this->view('workouts/userworkouts', $response);
        }

        public function create() {

            $this->view('workouts/manualWorkout');
        }

        public function generate() {

            $this->view('workouts/generateWorkout');
        }

        public function edit($workout = '') {

            $this->view('workouts/workoutViewer', $workout);
        }

    }

?>