<?php

class Agence{
    private $id;
    private $cityName;

    //id
    public function getId(){
        return $this ->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    //cityName
    public function getCityName(){
        return $this ->cityName;
    }

    public function setCityName($cityName){
        $this->cityName=$cityName;
    }
}
?>