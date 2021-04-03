<?php

class Home extends Controller {
    
    public function index($name = 'default'){
        $user = $this->model('User');
        $user->setName($name);

        $this->view('index', ['name' => $user->getName()]);
    }
}

?>
