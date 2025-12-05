<?php

class User{
    private $id;
    private $firstName;
    private $lastName;
    private $phone;
    private $email;
    private $password;
    private $role;

    //id
    public function getId(){
        return $this ->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    //firstName
    public function getFirstName(){
        return $this ->firstName;
    }

    public function setFirstName($firstName){
        $this->firstName=$firstName;
    }

    //lastName
    public function getLastName(){
        return $this ->lastName;
    }

    public function setLastName($lastName){
        $this->lastName=$lastName;
    }

    //phone
    public function getPhone(){
        return $this ->phone;
    }

    public function setPhone($phone){
        $this->phone=$phone;
    }

    //email
    public function getEmail(){
        return $this ->email;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    //password
    public function getPassword(){
        return $this ->password;
    }

    public function setPassword($password){
        $this->password=$password;
    }

    //role
    public function getRole(){
        return $this ->role;
    }

    public function setRole($role){
        $this->role=$role;
    }

}

?>