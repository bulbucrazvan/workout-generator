<?php

class Home extends Controller {
    

    public function index(){
        $this->view('home/home');
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
