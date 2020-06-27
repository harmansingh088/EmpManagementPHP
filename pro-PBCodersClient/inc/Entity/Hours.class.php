<?php

class Hours  {

//Attributes for our POPO
private $hoursId;
private $date;
private $hoursWorked;
private $userId;

//Getters
public function getHoursId() : int {
    return $this->hoursId;
}
public function getDate() : string {
    return $this->date;
}
public function getHoursWorked() : int {
    return $this->hoursWorked;
}
public function getUserId() : int {
    return $this->userId;
}


//Setters
public function setHoursId(int $hoursId) { 
    $this->hoursId = $hoursId; 
}
public function setDate(string $date) { 
    $this->date = $date; 
}
public function setHoursWorked(int $hoursWorked) { 
    $this->hoursWorked = $hoursWorked; 
}
public function setUserId(int $userId) { 
    $this->userId = $userId; 
}

}

?>