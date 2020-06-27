<?php

class HoursHTML  {

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
            <a href="?action=sales">Sales</a>
            <a class="active">Hours</a>
            <div class="topnav-right">
                <a href="?action=logout"><?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'].'(Logout)'?> </a>
            </div>
        </div>
    <?php }

    static function showNavigation(){ ?>
        <div class="topnav">
            <a href="?action=sales">Sales</a>
            <a class="active">Hours</a>
            <div class="topnav-right">
                <a href="?action=logout"><?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'].'(Logout)'?> </a>
            </div>
        </div>
    <?php }

    static function showHoursList($hoursList) { 
        $totalHours = 0.00;
        for($i=0; $i<count($hoursList); $i++){
            $totalHours += $hoursList[$i]->getHoursWorked();
        }

        ?>
        <div class="container">
        <h1 id="balance"><?php echo $_SESSION['selectedUserFirstName'].' '.$_SESSION['selectedUserLastName'] . ' - Total Hours: ' . $totalHours ?> </h1>
        <ul class="responsive-table">
            <li class="table-header">
                <div class="col">Date</div>
                <div class="col">Hours Worked</div>
                <div class="col">Actions</div>
            </li>

            <?php 
                for($i=0; $i<count($hoursList); $i++){
                    ?>
                    <li class="table-row">
                        <div class="col"><?php 
                            $date=date_create($hoursList[$i]->getDate());
                            echo (date_format($date,"F d, Y")) ?>
                        </div>
                        <div class="col"><?php echo $hoursList[$i]->getHoursWorked() ?></div>
                        <div class="col">
                            <a class="buttonEdit" href="?action=edit&id=<?php echo $hoursList[$i]->getHoursId() ?> ">Edit</a>
                            <a class="buttonDelete" href="?action=delete&id=<?php echo $hoursList[$i]->getHoursId() ?> ">Delete</a>
                        </div>
                    </li>
                    <?php 
                }
            ?>
        </ul>

        </div>
    <?php }

    
    static function addHours(){ 
    ?>
        <div class="form">

            <h3>Add Hours</h3>

            <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">

                <label for="date">Date</label>
                <input type="date" id="date" required name="date"  value="<?php echo date("Y-m-d") ?>">

                <label for="hoursWorked">Hours Worked</label>
                <input type="number" id="hoursWorked" required name="hoursWorked" placeholder="Hours Worked..">

                <input type="submit" name="action" value="Add">
            </form>
        </div>

    <?php }

    static function editHours($hours){ ?>
        <div class="form">

            <h3>Edit Hours</h3>

            <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="date">Date</label>
                <input type="date" id="date" name="date" required value="<?php echo $hours->getDate()?>">

                <label for="hoursWorked">Hours Worked</label>
                <input type="number" id="hoursWorked" name="hoursWorked" required placeholder="Hours Worked.." value="<?php echo $hours->getHoursWorked()?>">
                
                <input type="text" name="id" hidden value="<?php echo $hours->getHoursId()?>">
                <input type="submit" name="action" value="Edit">
            </form>
        </div>

    <?php }
}