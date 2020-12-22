<?php

    class Utilisateur {

        private $login;
        private $email;

        public function getlogin(){
            return $this->login;
        }

        public function getemail(){
            return $this->email;
        }

        public function setlogin($newlogin){
            $this->login = $newlogin;
        }

        public function setemail($newemail){
            $this->email = $newemail;
        }
    }

?>