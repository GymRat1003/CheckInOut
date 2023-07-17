<?php

    class UserAccount
    {
        private $accID;
        private $name;
        private $hashedPassword;
        private $role;

        public function __construct($accID, $name, $hashedPassword, $role)
        {
            $this->accID = $accID;
            $this->name = $name;
            $this->hashedPassword = $hashedPassword;
            $this->role = $role;
        }

        public function getAccID()
        {
            return $this->accID;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getHashedPassword()
        {
            return $this->hashedPassword;
        }

        public function getRole()
        {
            return $this->role;
        }
    }
?>
