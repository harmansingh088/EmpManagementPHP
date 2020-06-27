<?php

//Require Files
require_once("inc\config.inc.php");

require_once("inc\Entity\User.class.php");

require_once("inc\Utility\RestClient.class.php");

require_once("inc\HTML\Login.html.class.php");


if (!empty($_POST)) {

    $eUser = new User();

    //Get the   user 
    $apiURL = API_Base_URL."/api/users/userName/".$_POST["userName"];
    $jUser = RestClient::call("GET",$apiURL);

    if(is_object($jUser)){
        $eUser->setUserId($jUser->userId);
        $eUser->setUserName($jUser->userName);
        $eUser->setFirstName($jUser->firstName);
        $eUser->setLastName($jUser->lastName);
        $eUser->setUserType($jUser->userType);
        $eUser->setPassword($jUser->password);
    }
    else{
        $eUser = null;
    }

    if($eUser != null){
        //Check the password
        if ($eUser->verifyPassword($_POST["password"]))  { 
            //Start the session
            session_start();
            //Set the user to logged in
            $_SESSION["login"] = "true";
            $_SESSION["userId"] = $eUser->getUserId();
            $_SESSION["userName"] = $eUser->getUserName();
            $_SESSION["firstName"] = $eUser->getFirstName();
            $_SESSION["lastName"] = $eUser->getLastName();
            $_SESSION["userType"] = $eUser->getUserType();

            if($eUser->getUserType() == 'Employee'){
                $_SESSION["selectedUserId"] = $eUser->getUserId();
                $_SESSION["selectedUserFirstName"] = $eUser->getFirstName();
                $_SESSION["selectedUserLastName"] = $eUser->getLastName();
                header("Location: pro-PBCoders-sales.php");
            }
            else{
                header("Location: pro-PBCoders-userlist.php");
            }            

        }
        else{
            echo "<script type='text/javascript'>alert('Password is incorrect');</script>";
        }
    }
    else{
        echo "<script type='text/javascript'>alert('There is no user with this username');</script>";
    }

}
Login::showForm();


?>