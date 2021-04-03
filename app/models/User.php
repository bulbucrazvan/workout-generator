<?php

class User {
    private $name;

    public function setName($name = 'default'){
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }
}

?>