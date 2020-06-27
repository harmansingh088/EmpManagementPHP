<?php
session_start();

//Require
require_once("inc\config.inc.php");

require_once("inc\Utility\RestClient.class.php");

require_once("inc\HTML\Chart.html.class.php");

if (!empty($_SESSION) && $_SESSION['userType']=='Admin') {
    if(!empty($_GET)){
        if($_GET["action"] == "users"){
            header("Location: pro-PBCoders-userlist.php");
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
    }
    
    ChartHtml::showHeader();
    ChartHtml::showNavigation('Sale');
    ChartHtml::showChart('Sale', API_Base_URL."/api/sales/saleschart");
    ChartHtml::showFooter();
}
else{
    header("Location: pro-PBCoders-login.php");
}


?>