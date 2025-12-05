<?php

class Trajet{
    private $id;
    private $startAgencyId;
    private $endAgencyId;
    private $departureDate;
    private $arrivalDate;
    private $totalSeat;
    private $availableSeat;
    private $personContactId;

    
    // id
    public function getId(){
        return $this ->id;
    }

    public function setId($id){
        $this->id=$id;
    }

    //startAgencyId
    public function getStartAgencyId() {
    return $this->startAgencyId;
    }

    public function setStartAgencyId($startAgencyId) {
    $this->startAgencyId = $startAgencyId;
    }

    // endAgencyId
    public function getEndAgencyId() {
        return $this->endAgencyId;
    }

    public function setEndAgencyId($endAgencyId) {
        $this->endAgencyId = $endAgencyId;
    }

    // departureDate
    public function getDepartureDate() {
        return $this->departureDate;
    }

    public function setDepartureDate($departureDate) {
        $this->departureDate = $departureDate;
    }

    // arrivalDate
    public function getArrivalDate() {
        return $this->arrivalDate;
    }

    public function setArrivalDate($arrivalDate) {
        $this->arrivalDate = $arrivalDate;
    }

    // totalSeat
    public function getTotalSeat() {
        return $this->totalSeat;
    }

    public function setTotalSeat($totalSeat) {
        $this->totalSeat = $totalSeat;
    }

    // availableSeat
    public function getAvailableSeat() {
        return $this->availableSeat;
    }

    public function setAvailableSeat($availableSeat) {
        $this->availableSeat = $availableSeat;
    }

    // personContactId
    public function getPersonContactId() {
        return $this->personContactId;
    }

    public function setPersonContactId($personContactId) {
        $this->personContactId = $personContactId;
    }

}


?>