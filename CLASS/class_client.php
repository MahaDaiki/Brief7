<?php
class client{
    private $id ;
    private $fullname ;
    private $username ;
    private $email ;
    private $phonenumber ;
    private $adresse ;
    private $passw;
    private $valide ;

    public function __construct($id , $fullname ,$username , $email ,$phonenumber , $adresse , $passw , $valide )
    {
        $this ->id = $id;
        $this ->username = $username ;
        $this ->email = $email ;
        $this ->phonenumber = $phonenumber;;
        $this ->adresse = $adresse ;
        $this ->passw = $passw;
        $this ->valide = $valide ;
    }
    public function getId()
    {
        return $this ->id;
    }
    public function getUsername()
    {
        return $this ->username;
    }
    public function getEmail()
    {
        return $this ->email;
    }
    public function getPhonenumber()
    {
        return $this ->phonenumber;
    }
    public function getAdresse ()
    {
        return $this ->adresse ;
    }
    public function getPassw()
    {
        return $this ->passw;
    }
    public function getValide()
    {
        return $this ->valide;
    }

     

}


 