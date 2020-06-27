<?php
session_start();

//Require
require_once("inc\config.inc.php");

require_once("inc\Entity\Item.class.php");

require_once("inc\Utility\RestClient.class.php");

require_once("inc\HTML\Items.html.class.php");

if (!empty($_SESSION)) {
    $eItem = new Item();
    if(!empty($_GET)){
        if($_GET["action"] == "users"){
            header("Location: pro-PBCoders-userlist.php");
        }
        else if($_GET["action"] == "logout"){
            session_destroy();
            header("Location: pro-PBCoders-login.php");
        }
        else if($_GET["action"] == "delete"){
            $api = API_Base_URL."/api/items/delete/".$_GET['id'];
            $response = RestClient::call("DELETE",$api);
        }
        else if($_GET["action"] == "hoursChart"){
            header("Location: pro-PBCoders-hourschart.php");
        }
        else if($_GET["action"] == "salesChart"){
            header("Location: pro-PBCoders-saleschart.php");
        }
        else if($_GET["action"] == "edit"){
            $apiURL = API_Base_URL."/api/items/itemId/".$_GET['id'];
            $jItem = RestClient::call("GET",$apiURL);
            if(is_object($jItem)){
                $eItem->setItemId($jItem->itemId);
                $eItem->setText($jItem->text);
                $eItem->setAmount($jItem->amount);
            }
            else{
                $eItem = null;
            }
        }
    }

    if(!empty($_POST)){
        if(!empty($_POST["text"]) && !empty($_POST["amount"])){
            if(isset($_POST["action"]) && $_POST["action"] =="Add"){
                $alreadyAdded = false;
                $apiURL = API_Base_URL."/api/items";
                $jItems = RestClient::call("GET",$apiURL);
                $items = array();
                if(!empty($jItems)){
                    foreach($jItems as $jItem)   {
                        if($jItem->text == $_POST["text"]){
                            $alreadyAdded = true;
                        }
                    }
                }
                if(!$alreadyAdded){
                    $item = array(
                        "text"=>$_POST["text"],
                        "amount"=>$_POST["amount"]
                    );
                    $api = API_Base_URL."/api/items/add";
                    
                    $response = RestClient::call("POST",$api,$item);
                }
                else{
                    echo "<script type='text/javascript'>alert('This item name already exists, enter some other name!');</script>";
                }
            }

            else if(isset($_POST["action"]) && $_POST["action"] == "Edit"){
                if(true){
                    $item = array(
                        "text"=>$_POST["text"],
                        "amount"=>$_POST["amount"]
                    );
                    $api = API_Base_URL."/api/items/update/".$_POST['id'];
                    $response = RestClient::call("PUT",$api,$item);
                } 
            }
        }
        else{
            echo "<script type='text/javascript'>alert('Please enter all the details!');</script>";
        }
    }


    $apiURL = API_Base_URL."/api/items";
    $jItems = RestClient::call("GET",$apiURL);
    $items = array();
    foreach($jItems as $jItem)   {
        $ni = new Item();
        $ni->setItemId($jItem->itemId);
        $ni->setAmount($jItem->amount);
        $ni->setText($jItem->text);

        $items[] = $ni;
    }
    ItemsHTML::showHeader();
    ItemsHTML::showNavigation();
    ItemsHTML::showItems($items);
    if(!empty($_GET) && ($_GET["action"] == "edit")){
        ItemsHTML::editItem($eItem);
    }
    else{
        ItemsHTML::addItem();
    }
    
    ItemsHTML::showFooter();
}
else{
    header("Location: pro-PBCoders-login.php");
}


?>