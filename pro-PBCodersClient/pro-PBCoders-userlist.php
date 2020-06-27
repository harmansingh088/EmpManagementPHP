<?php
session_start();
//Require Files
require_once("inc\config.inc.php");

require_once("inc\Entity\User.class.php");

require_once("inc\Utility\RestClient.class.php");

require_once("inc\HTML\Users.html.class.php");

if (!empty($_SESSION)) {

    $eUser = new User();
    if(!empty($_GET)){
        $apiURL = API_Base_URL."/api/users/userId/".$_GET['id'];
        $jUser = RestClient::call("GET",$apiURL);
        if(is_object($jUser)){
            $eUser->setUserId($jUser->userId);
            $eUser->setUserName($jUser->userName);
            $eUser->setFirstName($jUser->firstName);
            $eUser->setLastName($jUser->lastName);
            $eUser->setUserType($jUser->userType);
            $eUser->setEmail($jUser->email);
            $eUser->setAge($jUser->age);
            $eUser->setGender($jUser->gender);
            $eUser->setPhone($jUser->phone);
        }
        else{
            $eUser = null;
        }

        if ($_GET["action"] == "view")  {
            $_SESSION["selectedUserId"] = $eUser->getUserId();
            $_SESSION["selectedUserFirstName"] = $eUser->getFirstName();
            $_SESSION["selectedUserLastName"] = $eUser->getLastName();
            header("Location: pro-PBCoders-sales.php");
        }
        else if($_GET["action"] == "items"){
            header("Location: pro-PBCoders-items.php");
        }
        else if($_GET["action"] == "logout"){
            session_destroy();
            header("Location: pro-PBCoders-login.php");
        }
        else if($_GET["action"] == "hoursChart"){
            header("Location: pro-PBCoders-hourschart.php");
        }
        else if($_GET["action"] == "salesChart"){
            header("Location: pro-PBCoders-saleschart.php");
        }
        else if($_GET["action"] == "delete"){
            $api = API_Base_URL."/api/users/delete/".$_GET['id'];
            $response = RestClient::call("DELETE",$api);
        }
    }
    
    if(!empty($_POST)){
        if($_POST["action"]=="Add"){
            if(!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["userName"]) 
            && !empty($_POST["email"]) && !empty($_POST["phone"]) && !empty($_POST["gender"]) && !empty($_POST["age"])
            && !empty($_POST["userType"])
            ){
                $user = array(
                    "firstName"=>$_POST["firstName"],
                    "lastName"=>$_POST["lastName"],
                    "userName"=>$_POST["userName"],
                    "email"=>$_POST["email"],
                    "phone"=>$_POST["phone"],
                    "age"=>$_POST["age"],
                    "gender"=>$_POST["gender"],
                    "userType"=>$_POST["userType"],
                    "password"=>password_hash($_POST["password"], PASSWORD_DEFAULT)
                );
                $api = API_Base_URL."/api/users/add";
                $response = RestClient::call("POST",$api,$user);
            }
            else{
                echo "<script type='text/javascript'>alert('Please enter all the details!');</script>";

            }
        }

        else if($_POST["action"]=="Edit"){
            if(!empty($_POST["firstName"]) && !empty($_POST["lastName"]) && !empty($_POST["email"]) 
            && !empty($_POST["phone"]) && !empty($_POST["gender"]) && !empty($_POST["age"])){
                $user = array(
                    "firstName"=>$_POST["firstName"],
                    "lastName"=>$_POST["lastName"],
                    "email"=>$_POST["email"],
                    "phone"=>$_POST["phone"],
                    "age"=>$_POST["age"],
                    "gender"=>$_POST["gender"]
                );
                $api = API_Base_URL."/api/users/update/".$_POST['id'];
                $response = RestClient::call("PUT",$api,$user);
            }
            else{
                echo "<script type='text/javascript'>alert('Please enter all the details!');</script>";
            }
        }

    }

    $apiURL = API_Base_URL."/api/users";
    $jUsers = RestClient::call("GET",$apiURL);


    $users = array();

    foreach($jUsers as $jUser)   {
        $nu = new User();
        $nu->setUserId($jUser->userId);
        $nu->setUserName($jUser->userName);
        $nu->setFirstName($jUser->firstName);
        $nu->setLastName($jUser->lastName);
        $nu->setUserType($jUser->userType);
        $nu->setEmail($jUser->email);
        $nu->setPhone($jUser->phone);
        $users[] = $nu;
    }
    UsersHtml::showHeader();
    UsersHtml::showNavigation();
    if(count($users) > 0){
        UsersHtml::showUserList($users);
    }

    if(!empty($_GET) && $_GET['action'] == 'edit'){
        UsersHtml::editUser($eUser);
    }
    else{
        UsersHtml::addUser();
    }
    UsersHtml::showFooter();
}
else{
    header("Location: pro-PBCoders-login.php");
}
    
?>