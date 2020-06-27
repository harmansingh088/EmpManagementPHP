<?php

class SalesHTML  {

    static function showHeader(){ ?>
        <html lang="en">
            <head>
                <meta charset="UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                <meta http-equiv="X-UA-Compatible" content="ie=edge" />
                <link rel="stylesheet" href="css/Navigation.css">
                <link rel="stylesheet" href="css/Users.css">
                <link rel="stylesheet" href="css/UserForm.css">
                
            </head>
            <body>
    <?php }

    static function showFooter(){ ?>
            </body>
        </html>
    <?php }

    static function showAdminNavigation(){ ?>
        <div class="topnav">
            <a href="?action=users">Home</a>
            <a class="active">Sales</a>
            <a href="?action=hours">Hours</a>
            <div class="topnav-right">
                <a href="?action=logout"><?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'].'(Logout)'?> </a>
            </div>
        </div>
    <?php }

    static function showNavigation(){ ?>
        <div class="topnav">
            <a class="active">Sales</a>
            <a href="?action=hours">Hours</a>
            <div class="topnav-right">
                <a href="?action=logout"><?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'].'(Logout)'?> </a>
            </div>
        </div>
    <?php }

    static function showSales($sales) { 
        $totalSales = 0.00;
        for($i=0; $i<count($sales); $i++){
            $totalSales += $sales[$i]->getAmount();
        }

        ?>
        <div class="container">
        <h1 id="balance"><?php echo $_SESSION['selectedUserFirstName'].' '.$_SESSION['selectedUserLastName'] . ' - Total Sales: $' . $totalSales ?> </h1>
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col">Item</div>
                <div class="col">Amount</div>
                <div class="col">Date</div>
                <div class="col">Actions</div>
            </li>

            <?php 
                for($i=0; $i<count($sales); $i++){
                    ?>
                    <li class="table-row">
                        <div class="col"><a> <?php echo $sales[$i]->getText()?> </a></div>
                        <div class="col"><?php echo '$'.$sales[$i]->getAmount() ?></div>
                        <div class="col"><?php 
                            $date=date_create($sales[$i]->getDate());
                            echo (date_format($date,"F d, Y")) ?>
                        </div>
                        <div class="col">
                            <a class="buttonEdit" href="?action=edit&id=<?php echo $sales[$i]->getSaleId() ?> ">Edit</a>
                            <a class="buttonDelete" href="?action=delete&id=<?php echo $sales[$i]->getSaleId() ?> ">Delete</a>
                        </div>
                    </li>
                    <?php 
                }
            ?>
        </ul>

        </div>
    <?php }

    
    static function addSale($items){ 
        //var_dump($items);
        $itemArray = array();
        $amountArray = array();
        for($i=0; $i<count($items); $i++){
            $itemArray[] = $items[$i]->getText();
            $amountArray[] = $items[$i]->getAmount();
        }
    ?>
        <div class="form">

            <h3>Add Sale</h3>

            <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <label for="text">Item</label>
                <select id="text" name="text">
                    <?php 
                        for($i=0; $i<count($itemArray); $i++){
                            echo '<option value="'.$itemArray[$i].'" >'.$itemArray[$i].'</option>';
                        }
                    ?>  
                </select>
                
                <label for="amount">Amount</label>
                <input type="number" step="0.01" id="amount" name="amount" required placeholder="Amount">

                <label for="date">Date</label>
                <input type="date" id="date" name="date" required value="<?php echo date("Y-m-d") ?>">

                <input type="submit" name="action" value="Add">
            </form>
        </div>

    <?php }

    static function editSale($items, $sale){ 
        //var_dump($items);
        $itemArray = array();
        $amountArray = array();
        for($i=0; $i<count($items); $i++){
            $itemArray[] = $items[$i]->getText();
            $amountArray[] = $items[$i]->getAmount();
        }
    ?>
        <div class="form">

            <h3>Edit Sale</h3>

            <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <label for="text">Item</label>
                <select id="text" name="text">
                    <?php 
                        for($i=0; $i<count($itemArray); $i++){
                            if($sale->getText() == $itemArray[$i]){
                                echo '<option value="'.$itemArray[$i].'" selected>'.$itemArray[$i].'</option>';
                            }
                            else{
                                echo '<option value="'.$itemArray[$i].'" >'.$itemArray[$i].'</option>';
                            }
                            
                        }
                    ?>  
                </select>
                
                <label for="amount">Amount</label>
                <input type="number" step="0.01" id="amount" name="amount" required placeholder="Amount"  value="<?php echo $sale->getAmount()?>">

                <label for="date">Date</label>
                <input type="date" id="date" name="date"  required value="<?php echo $sale->getDate()?>">

                <input type="text" name="id" hidden value="<?php echo $sale->getSaleId()?>">
                <input type="submit" name="action" value="Edit">
            </form>
        </div>

    <?php }
}