<?php

class Home extends Controller {
    
    public function __construct() {
        SessionUtils::checkAuthorized();
    }

    public function index() {    
        $curlHandle = curl_init("http://92.115.143.213:3000/project/api/users/" . $_SESSION["SESSION_USER"]);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, ["Authorization: " . $_SESSION["LOGIN_KEY"]]);
        $curlResponse = json_decode(curl_exec($curlHandle), true);
        if ($curlResponse["statusCode"]) {
            Redirect::errorPage($curlResponse["description"]);
        }
        $response = $curlResponse["description"];

        $userHomepage = $this->model("UserHomePage");
        foreach ($userHomepage as $key => $value) {
            if (isset($response[$key])) {
                $userHomepage->setInfo($key, $response[$key]);
            }
        }

        $uri = "http://92.115.143.213:3000/project/api/users/" . $_SESSION["SESSION_USER"] . "/workouts/history?limit=1";
        curl_setopt($curlHandle, CURLOPT_URL, $uri);
        $curlResponse = json_decode(curl_exec($curlHandle), true);
        if ($curlResponse["statusCode"]) {
            Redirect::errorPage($curlResponse["description"]);
        }
        $response = $curlResponse["description"];
        
        if (count($response)) {
            $userHomepage->setInfo("lastWorkout", $response[0]);
        }
        else {
            $userHomepage->setInfo("lastWorkout", null);
        }
        $this->view('home/home', $userHomepage);
    }

    public function globalStatistics(){
        $this->view('home/globalStatistics');
    }

    public function workoutHistory(){
        $this->view('home/workoutHistory');
    }
}

?>
