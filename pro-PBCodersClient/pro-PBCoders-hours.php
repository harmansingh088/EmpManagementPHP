<?php
session_start();

require_once("inc\config.inc.php");

require_once("inc\Entity\User.class.php");
require_once("inc\Entity\Sale.class.php");
require_once("inc\Entity\Item.class.php");
require_once("inc\Entity\Hours.class.php");

require_once("inc\Utility\RestClient.class.php");

require_once("inc\HTML\Hours.html.class.php");

if (!empty($_SESSION)) {
    $eHours = new Hours();
    if(!empty($_GET)){
        if($_GET["action"] == "users"){
            header("Location: pro-PBCoders-userlist.php");
        }
        if($_GET["action"] == "sales"){
            header("Location: pro-PBCoders-sales.php");
        }
        else if($_GET["action"] == "logout"){
            session_destroy();
            header("Location: pro-PBCoders-login.php");
        }
        else if($_GET["action"] == "delete"){
            $api = API_Base_URL."/api/hours/delete/".$_GET['id'];
            $response = RestClient::call("DELETE",$api);
        }
        else if($_GET["action"] == "edit"){
            $apiURL = API_Base_URL."/api/hours/hoursId/".$_GET['id'];
            $jHours = RestClient::call("GET",$apiURL);
            if(is_object($jHours)){
                $eHours->setHoursId($jHours->hoursId);
                $eHours->setHoursWorked($jHours->hoursWorked);
                $eHours->setDate($jHours->date);
            }
            else{
                $eHours = null;
            }
        }
    }


    if(!empty($_POST)){
        if(!empty($_POST["hoursWorked"]) && !empty($_POST["date"])){
            if($_POST["action"]=="Add"){
                $alreadyAdded = false;
                $apiURL = API_Base_URL."/api/hours/userId/".$_SESSION["selectedUserId"];
                $jHoursList = RestClient::call("GET",$apiURL);
                if(!empty($jHoursList)){
                    foreach($jHoursList as $jHours)   {
                        if($jHours->date == $_POST["date"]){
                            $alreadyAdded = true;
                        }
                        
                    }
                }
                if(!$alreadyAdded){
                        $hours = array(
                            "hoursWorked"=>$_POST["hoursWorked"],
                            "date"=>$_POST["date"],
                            "userId"=>$_SESSION["selectedUserId"]
                        );
                        $api = API_Base_URL."/api/hours/add";
                        
                        $response = RestClient::call("POST",$api,$hours);
                }
                else{
                    echo "<script type='text/javascript'>alert('Hours for this date already exists!');</script>";
                }
            }
            else if($_POST["action"]=="Edit"){
                if(true){
                    $sale = array(
                        "hoursWorked"=>$_POST["hoursWorked"],
                        "date"=>$_POST["date"]
                    );
                    $api = API_Base_URL."/api/hours/update/".$_POST['id'];
                    $response = RestClient::call("PUT",$api,$sale);
                }
                
    
            }
        }
        else{
            echo "<script type='text/javascript'>alert('Please enter all the details!');</script>";
        }
    }

    $apiURL = API_Base_URL."/api/hours/userId/".$_SESSION["selectedUserId"];
    $jHoursList = RestClient::call("GET",$apiURL);
    $hoursList = array();
    foreach($jHoursList as $jHours)   {
        $ns = new Hours();
        $ns->setHoursId($jHours->hoursId);
        $ns->setDate($jHours->date);
        $ns->setHoursWorked($jHours->hoursWorked);
        $ns->setUserId($jHours->userId);

        $hoursList[] = $ns;
    }

    HoursHTML::showHeader();
    if($_SESSION["userType"] == 'Admin'){
        HoursHTML::showAdminNavigation();
    }
    else{
        HoursHTML::showNavigation();
    }
    HoursHTML::showHoursList($hoursList);
    if(!empty($_GET) && ($_GET["action"] == "edit")){
        HoursHTML::editHours($eHours);
    }
    else{
        HoursHTML::addHours();
    }
    
    HoursHTML::showFooter();
}
else{
    header("Location: pro-PBCoders-login.php");
}


?>