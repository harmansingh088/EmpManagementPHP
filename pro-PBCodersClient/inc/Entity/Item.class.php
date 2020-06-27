<?php

class Item  {

    //Attributes for our POPO
    private $itemId;
    private $text;
    private $amount;

    //Getters
    public function getItemId() : int {
        return $this->itemId;
    }

    public function getText() : string {
        return $this->text;
    }
    public function getAmount(){
        return $this->amount;
    }


    //Setters
    public function setItemId(int $itemId) { 
        $this->itemId = $itemId; 
    }
    public function setText(string $text) { 
        $this->text = $text; 
    }
    public function setAmount($amount) { 
        $this->amount = $amount; 
    }

}

?>