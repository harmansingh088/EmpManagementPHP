<?php

class ItemsHTML  {

    static function showHeader(){ ?>
        <html>
            <head>
                <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
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

     static function showNavigation(){ ?>
        <div class="topnav">
            <a href="?action=users">Users</a>
            <a class="active">Items</a>
            <a href="?action=hoursChart">Hours Chart</a>
            <a href="?action=salesChart">Sales Chart</a>
            <div class="topnav-right">
                <a href="?action=logout"><?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'].'(Logout)'?> </a>
            </div>
        </div>
    <?php }

    static function showItems($items) { ?>
        
            <div class="container">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col col-1">Item</div>
                        <div class="col col-2">Amount</div>
                        <div class="col col-3">Actions</div>
                    </li>

                    <?php 
                        for($i=0; $i<count($items); $i++){
                            ?>
                            <li class="table-row">
                                <div class="col col-1"><a> <?php echo $items[$i]->getText()?> </a></div>
                                <div class="col col-2"><?php echo '$'.$items[$i]->getAmount() ?></div>
                                <div class="col col-3">
                                    <a class="buttonEdit" href="?action=edit&id=<?php echo $items[$i]->getItemId() ?> ">Edit</a>
                                    <a class="buttonDelete" href="?action=delete&id=<?php echo $items[$i]->getItemId() ?> ">Delete</a>
                                </div>
                            </li>
                            <?php 
                        }
                    ?>
                </ul>
                </div>
           
    <?php }

    static function addItem()    { ?>
        <div class="form">

        <h3>Add Item</h3>

        <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="text">Item</label>
            <input type="text" id="text" name="text" required placeholder="Item">

            <label for="amount">Amount</label>
            <input type="number" step="0.01" id="amount" name="amount" required placeholder="Amount">

            <input type="submit" name="action" value="Add">
        </form>

    <?php }

static function editItem($item)    { ?>
    <div class="form">

    <h3>Edit Item</h3>

    <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="text">Item</label>
        <input type="text" id="text" name="text" placeholder="Item" required value="<?php echo $item->getText()?>">

        <label for="amount">Amount</label>
        <input type="text" step="0.01" id="amount" name="amount" required placeholder="Amount" value="<?php echo $item->getAmount()?>">

        <input type="text" name="id" hidden value="<?php echo $item->getItemId()?>">
        <input type="submit" name="action" value="Edit">
    </form>

<?php }
}