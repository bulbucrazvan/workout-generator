<?php

    class Admin extends Controller {

        public function index() {
            $requestURI = "http://92.115.143.213:3000/project/api/exercises/";

            $curlHandle = curl_init($requestURI . "locationTypes");
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $response["locations"] = json_decode(curl_exec($curlHandle), true);
            curl_setopt($curlHandle, CURLOPT_URL, $requestURI . "muscleTypes");
            $response["muscles"] = json_decode(curl_exec($curlHandle), true);
            curl_close($curlHandle);
            
            $this->view('admin/admin', $response);
        }
    }

?>