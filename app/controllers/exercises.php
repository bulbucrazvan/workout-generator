<?php

    class Exercises extends Controller {

        public function index($exercise = '') {

            $curlHandle = curl_init("http://92.115.143.213:3000/project/api/exercises/" . $exercise);
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $curlResponse = json_decode(curl_exec($curlHandle), true);
            $response = $curlResponse["description"];

            $this->view('exercises/exerciseViewer', $response);
        }

    }

?>