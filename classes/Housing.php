<?php

    class Housing
    {
        private $accID;
        private $area;
        private $house_address;

        public function __construct($accID, $area, $house_address)
        {
            $this->accID = $accID;
            $this->area = $area;
            $this->house_address = $house_address;
        }

        public function getAccID()
        {
            return $this->accID;
        }

        public function getArea()
        {
            return $this->area;
        }

        public function getHouseAddress()
        {
            return $this->house_address;
        }
    }
?>
