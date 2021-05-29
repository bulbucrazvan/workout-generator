<?php

class Home extends Controller {
    
    public function index() {
        if (!SessionUtils::isLoggedIn()) {
            Redirect::to(APP_PATH . '/welcome');
        }
        
        $curlHandle = curl_init("http://92.115.143.213:3000/project/api/users/" . $_SESSION["SESSION_USER"]);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($curlHandle), true);
        curl_close($curlHandle);

        require_once(APP_MODELS . "UserHomePage.php");
        $userHomepage = new UserHomePage();
        foreach ($userHomepage as $key => $value) {
            if (isset($response[$key])) {
                $userHomepage->setInfo($key, $response[$key]);
            }
        }

        $this->view('home/home', $userHomepage);
    }

    public function globalStatistics(){
        $this->view('home/globalStatistics');
    }

    public function workoutHistory(){
        $this->view('home/workoutHistory');
    }

    public function userWorkouts(){
        $this->view('home/userworkouts');
    }

    public function workoutViewer(){
        $this->view('home/workoutViewer');
    }

    public function exerciseViewer(){
        $this->view('home/exerciseViewer');
    }

    public function generateWorkout(){
        $this->view('home/generateWorkout');
    }

    public function generatedWorkout() {
        $this->view('home/generatedWorkout');
    }

    public function manualWorkout() {
        $this->view('home/manualWorkout');
    }

    public function startWorkout() {
        $this->view('home/startWorkout');
    }

    public function settings() {
        $this->view('home/settings');
    }
}

?>
