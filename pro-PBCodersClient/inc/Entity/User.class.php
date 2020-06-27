<?php

class User  {

//Attributes for our POPO
private $userId;
private $firstName;
private $lastName;
private $userName;
private $email;
private $phone;
private $gender;
private $age;
private $userType;
private $password;

//Getters
public function getUserId() : int {
    return $this->userId;
}

public function getFirstName() : string {
    return $this->firstName;
}

public function getLastName() : string {
    return $this->lastName;
}

public function getUserName() : string {
    return $this->userName;
}


public function getEmail() : string {
    return $this->email;
}

public function getPhone() : string {
    return $this->phone;
}


public function getGender() : string {
    return $this->gender;
}

public function getAge() : string {
    return $this->age;
}

public function getUserType() : string {
    return $this->userType;
}

public function getEncryptedPassword() : string {
    return password_hash($this->password, PASSWORD_DEFAULT);
}

//Verify the password
function verifyPassword(string $passwordToVerify) {
    //Return a boolean based on verifying if the password given is correct for the current user
    return password_verify($passwordToVerify, $this->password);
}


//Setters
public function setUserId(int $id) { 
    $this->userId = $id; 
}
public function setFirstName(string $firstName) { 
    $this->firstName = $firstName; 
}
public function setLastName(string $lastName) { 
    $this->lastName = $lastName; 
}
public function setUserName(string $userName) { 
    $this->userName = $userName; 
}
public function setEmail(string $email) { 
    $this->email = $email; 
}
public function setPhone(string $phone) { 
    $this->phone = $phone; 
}
public function setGender(string $gender) { 
    $this->gender = $gender; 
}
public function setAge(string $age) { 
    $this->age = $age; 
}
public function setUserType(string $userType) { 
    $this->userType = $userType; 
}
public function setPassword(string $password) { 
    $this->password = $password; 
}

//Serialize the object to JSON.
public function jsonSerialize()
{
    //You can do this but then EVERYTHING gets returned

    //$vars = get_object_vars($this);
    //return $vars;
    

    //Or you can specify a new object of stdClass and add the attributes you want to return.
    $obj = new stdClass;

    //Add all the attributes you want.
    $obj->userId = $this->userId;
    $obj->firstName = $this->firstName;
    $obj->lastName = $this->lastName;
    $obj->userName = $this->userName;
    $obj->email = $this->email;
    $obj->phone = $this->phone;
    $obj->gender = $this->gender;
    $obj->age = $this->age;
    $obj->userType = $this->userType;
    
    return $obj;
}
}

?>