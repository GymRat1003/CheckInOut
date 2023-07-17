<?php
    class History
    {
        private $datetime;
        private $area;
        private $accID;
        private $checkin;
        private $checkout;

        public function __construct($datetime, $area, $accID, $checkin, $checkout)
        {
            $this->datetime = $datetime;
            $this->area = $area;
            $this->accID = $accID;
            $this->checkin = $checkin;
            $this->checkout = $checkout;
        }

        public function getDateTime()
        {
            return $this->datetime;
        }

        public function getArea()
        {
            return $this->area;
        }

        public function getAccID()
        {
            return $this->accID;
        }

        public function getCheckIn()
        {
            return $this->checkin;
        }
        public function getCheckOut()
        {
            return $this->checkout;
        }
    }
?>