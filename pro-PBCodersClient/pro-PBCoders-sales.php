<?php
session_start();

//Require
require_once("inc\config.inc.php");

require_once("inc\Entity\User.class.php");
require_once("inc\Entity\Sale.class.php");
require_once("inc\Entity\Item.class.php");

require_once("inc\Utility\RestClient.class.php");

require_once("inc\HTML\Sales.html.class.php");

if (!empty($_SESSION)) {
    $eSale = new Sale();
    if(!empty($_GET)){
        if($_GET["action"] == "users"){
            header("Location: pro-PBCoders-userlist.php");
        }
        else if($_GET["action"] == "hours"){
            header("Location: pro-PBCoders-hours.php");
        }
        else if($_GET["action"] == "logout"){
            session_destroy();
            header("Location: pro-PBCoders-login.php");
        }
        else if($_GET["action"] == "delete"){
            $api = API_Base_URL."/api/sales/delete/".$_GET['id'];
            $response = RestClient::call("DELETE",$api);
        }
        else if($_GET["action"] == "edit"){
            $apiURL = API_Base_URL."/api/sales/saleId/".$_GET['id'];
            $jSale = RestClient::call("GET",$apiURL);
            if(is_object($jSale)){
                $eSale->setSaleId($jSale->saleId);
                $eSale->setText($jSale->text);
                $eSale->setAmount($jSale->amount);
                $eSale->setDate($jSale->date);
            }
            else{
                $eSale = null;
            }
        }
    }

    if(!empty($_POST)){
        if(!empty($_POST["text"])&& !empty($_POST["amount"]) && !empty($_POST["date"])){
            if($_POST["action"]=="Add"){
                $sale = array(
                    "text"=>$_POST["text"],
                    "amount"=>$_POST["amount"],
                    "date"=>$_POST["date"],
                    "userId"=>$_SESSION["selectedUserId"]
                );
                $api = API_Base_URL."/api/sales/add";
                
                $response = RestClient::call("POST",$api,$sale);
            }

            else if($_POST["action"]=="Edit"){
                if(true){
                    $sale = array(
                        "text"=>$_POST["text"],
                        "amount"=>$_POST["amount"],
                        "date"=>$_POST["date"],
                    );
                    $api = API_Base_URL."/api/sales/update/".$_POST['id'];
                    $response = RestClient::call("PUT",$api,$sale);
                }
                

            }
        }
        else{
            echo "<script type='text/javascript'>alert('Please enter all the details!');</script>";
        }
    }

    $apiURLItems = API_Base_URL."/api/items";
    $jItems = RestClient::call("GET",$apiURLItems);
    $items = array();
    foreach($jItems as $jItem)   {
        $ni = new Item();
        $ni->setItemId($jItem->itemId);
        $ni->setAmount($jItem->amount);
        $ni->setText($jItem->text);
        $items[] = $ni;
    }

    $apiURL = API_Base_URL."/api/sales/userId/".$_SESSION["selectedUserId"];
    $jSales = RestClient::call("GET",$apiURL);
    $sales = array();
    foreach($jSales as $jSale)   {
        $ns = new Sale();
        $ns->setSaleId($jSale->saleId);
        $ns->setDate($jSale->date);
        $ns->setAmount($jSale->amount);
        $ns->setText($jSale->text);
        $ns->setUserId($jSale->userId);

        $sales[] = $ns;
    }
    SalesHTML::showHeader();
    if($_SESSION["userType"] == 'Admin'){
        SalesHTML::showAdminNavigation();
    }
    else{
        SalesHTML::showNavigation();
    }
    SalesHTML::showSales($sales);
    if(!empty($_GET) && ($_GET["action"] == "edit")){
        SalesHTML::editSale($items, $eSale);
    }
    else{
        SalesHTML::addSale($items);
    }
    
    SalesHTML::showFooter();
}
else{
    header("Location: pro-PBCoders-login.php");
}


?>