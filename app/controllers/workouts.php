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
            $curlHandle = curl_init("http://92.115.143.213:3000/project/api/exercises/locationTypes");
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $response["locations"] = json_decode(curl_exec($curlHandle), true);

            curl_setopt($curlHandle, CURLOPT_URL, "http://92.115.143.213:3000/project/api/exercises/muscleTypes");
            $response["muscles"] = json_decode(curl_exec($curlHandle), true);

            $this->view('workouts/generateWorkout', $response);
        }

        public function generatedWorkout() {

            $this->view('workouts/generatedWorkout');
        }

        public function edit($workout = '') {

            $this->view('workouts/workoutViewer', $workout);
        }

        public function run($workout = '') {

            $curlHandle = curl_init("http://92.115.143.213:3000/project/api/users/" . $_SESSION["SESSION_USER"] . "/workouts/" . $workout);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($curlHandle), true);
            curl_close($curlHandle);

            $this->view('workouts/startWorkout', $response);
        }

    }

?>