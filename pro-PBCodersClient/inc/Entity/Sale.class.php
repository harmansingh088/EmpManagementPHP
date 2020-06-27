<?php

class Sale  {

//Attributes for our POPO
private $saleId;
private $date;
private $text;
private $amount;
private $userId;

//Getters
public function getSaleId() : int {
    return $this->saleId;
}

public function getDate() : string {
    return $this->date;
}
public function getText() : string {
    return $this->text;
}
public function getAmount(){
    return $this->amount;
}
public function getUserId() : int {
    return $this->userId;
}


//Setters
public function setSaleId(int $saleId) { 
    $this->saleId = $saleId; 
}
public function setDate(string $date) { 
    $this->date = $date; 
}
public function setText(string $text) { 
    $this->text = $text; 
}
public function setAmount($amount) { 
    $this->amount = $amount; 
}
public function setUserId(int $userId) { 
    $this->userId = $userId; 
}

}

?>