<?php

    class Admin extends Controller {

        public function index() {
            $requestURI = "http://92.115.143.213:3000/project/api/exercises/";

            $curlHandle = curl_init($requestURI . "locationTypes");
            curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
            $curlResponse = json_decode(curl_exec($curlHandle), true);
            $response["locations"] = $curlResponse["description"];
            
            curl_setopt($curlHandle, CURLOPT_URL, $requestURI . "muscleTypes");
            $curlResponse = json_decode(curl_exec($curlHandle), true);
            $response["muscles"] = $curlResponse["description"];
            curl_close($curlHandle);
            
            
            $this->view('admin/admin', $response);
        }
    }

?>