<?php
class admin{
    
        private $id ;
        private $username ;
        private $email ;
        private $passw ;
        public function __construct($id , $username , $email , $passw )
        {
            $this->id = $id ;
            $this ->username = $username ;
            $this ->email = $email ;
            $this ->passw = $passw ;
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
        public function getPassw()
        {
            return $this ->passw;
        }
        
    }



