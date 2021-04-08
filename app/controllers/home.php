<?php

class Home extends Controller {
    
    public function index($name = 'default'){
        $this->view('home/index');
    }

    public function about(){
        $this->view('home/about');
    }

    public function login(){
        $this->view('home/login');
    }

    public function register(){
        $this->view('home/register');
    }

    public function home(){
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

}

?>
