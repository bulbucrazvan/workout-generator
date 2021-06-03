<?php

    class Workouts extends Controller {

        public function __construct() {
            SessionUtils::checkAuthorized();
        }

        public function index() {

            $curlHandle = curl_init("http://92.115.143.213:3000/project/api/users/" . $_SESSION["SESSION_USER"] . "/workouts");
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, ["Authorization: " . $_SESSION["LOGIN_KEY"]]);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $curlResponse = json_decode(curl_exec($curlHandle), true);
            if ($curlResponse["statusCode"]) {
                Redirect::errorPage($curlResponse["description"]);
            }
            $response = $curlResponse["description"];
            curl_close($curlHandle);

            $this->view('workouts/userworkouts', $response);
        }

        public function create() {

            $this->view('workouts/manualWorkout');
        }

        public function generate() {
            $curlHandle = curl_init("http://92.115.143.213:3000/project/api/exercises/locationTypes");
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, ["Authorization: " . $_SESSION["LOGIN_KEY"]]);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $curlResponse = json_decode(curl_exec($curlHandle), true);
            if ($curlResponse["statusCode"]) {
                Redirect::errorPage($curlResponse["description"]);
            }
            $response["locations"] = $curlResponse["description"];

            curl_setopt($curlHandle, CURLOPT_URL, "http://92.115.143.213:3000/project/api/exercises/muscleTypes");
            $curlResponse = json_decode(curl_exec($curlHandle), true);
            if ($curlResponse["statusCode"]) {
                Redirect::errorPage($curlResponse["description"]);
            }
            $response["muscles"] = $curlResponse["description"];

            $this->view('workouts/generateWorkout', $response);
        }

        public function generatedWorkout($workout = '') {

            $this->view('workouts/generatedWorkout', $workout);
        }

        public function edit($workout = '') {

            $this->view('workouts/workoutViewer', $workout);
        }

        public function run($workout = '') {

            $curlHandle = curl_init("http://92.115.143.213:3000/project/api/users/" . $_SESSION["SESSION_USER"] . "/workouts/" . $workout);
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, ["Authorization: " . $_SESSION["LOGIN_KEY"]]);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $curlResponse = json_decode(curl_exec($curlHandle), true);
            if ($curlResponse["statusCode"]) {
                Redirect::errorPage($curlResponse["description"]);
            }
            $response = $curlResponse["description"];
            curl_close($curlHandle);

            $this->view('workouts/startWorkout', $response);
        }

    }

?>