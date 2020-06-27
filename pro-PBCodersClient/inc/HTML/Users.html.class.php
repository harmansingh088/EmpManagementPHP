<?php
class UsersHtml  {

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
            <a class="active">Users</a>
            <a href="?action=items">Items</a>
            <a href="?action=hoursChart">Hours Chart</a>
            <a href="?action=salesChart">Sales Chart</a>
            <div class="topnav-right">
                <a href="?action=logout"><?php echo $_SESSION['firstName'].' '.$_SESSION['lastName'].'(Logout)'?> </a>
            </div>
        </div>
    <?php }

    static function showUserList($users) { ?>
        
            <div class="container">
                <ul class="responsive-table">
                    <li class="table-header">
                        <div class="col">Name</div>
                        <div class="col">User Type</div>
                        <div class="col">Email</div>
                        <div class="col">Phone</div>
                        <div class="col">Actions</div>
                    </li>

                    <?php 
                        for($i=0; $i<count($users); $i++){
                            ?>
                            <li class="table-row">
                                <div class="col" data-label="Name"><a> <?php echo $users[$i]->getFirstName() . ' ' . $users[$i]->getLastName()?> </a></div>
                                <div class="col" data-label="User Type"><?php echo $users[$i]->getUserType() ?></div>
                                <div class="col" data-label="Email"><?php echo $users[$i]->getEmail() ?></div>
                                <div class="col" data-label="Phone"><?php echo $users[$i]->getPhone() ?></div>
                                <div class="col">
                                    <a class="buttonView" href="?action=view&id=<?php echo $users[$i]->getUserId() ?> ">View</a>
                                    <a class="buttonEdit" href="?action=edit&id=<?php echo $users[$i]->getUserId() ?> ">Edit</a>
                                    <?php
                                    if($users[$i]->getUserId() != $_SESSION['userId']){ ?>
                                        <a class="buttonDelete" href="?action=delete&id=<?php echo $users[$i]->getUserId() ?> ">Delete</a>
                                    <?php } ?>
                                </div>
                            </li>
                            <?php 
                        }
                    ?>
                </ul>
                </div>
           
    <?php }

    static function addUser()    { ?>
        <div class="form">

        <h3>Add User</h3>

        <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <h4> Login Information </h4>
            <label for="userType">User Type</label>
            <select id="userType" name="userType">
                <option value="Admin">Admin</option>
                <option value="Employee">Employee</option>
            </select>

            <label for="uname">User Name</label>
            <input type="text" id="uname" name="userName" placeholder="User Name.." required>

            <label for="password">Enter Password</label>
            <input type="password" id="Password" name="password" placeholder="Enter Password.." required>

            <label for="password">Confirm Password</label>
            <input type="password" id="cPassword" name="password" placeholder="Confirm Password.." required>

            <h4> Personal Information </h4>
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="firstName" placeholder="First Name.." required>

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lastName" placeholder="Last Name.." required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email.." required>

            <label for="phone">Phone (XXX-XXX-XXXX) </label>
            <input type="text" id="phone" name="phone" placeholder="Phone.." required pattern="^[1-9]\d{2}-\d{3}-\d{4}$">

            <label for="gender">Gender</label>
            <select id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="age">Age</label>
            <input type="number" id="age" name="age" placeholder="Age.. " required>

            <input type="submit" name="action" value="Add">
        </form>

    <?php }

    static function editUser($user)    { ?>
        <div class="form">

        <h3>Edit User - <?php echo $user->getFirstName() . ' ' . $user->getLastName()?></h3>

        <form method="POST" ACTION="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="firstName" placeholder="First Name.." required
            value="<?php echo $user->getFirstName()?>">

            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lastName" placeholder="Last Name.." required
            value="<?php echo $user->getLastName()?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email.." required
            value="<?php echo $user->getEmail()?>">

            <label for="phone">Phone (XXX-XXX-XXXX) </label>
            <input type="text" id="phone" name="phone" placeholder="Phone.. " required pattern="^[1-9]\d{2}-\d{3}-\d{4}$"
            value="<?php echo $user->getPhone()?>">

            <label for="gender">Gender</label>
            <select id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <label for="age">Age</label>
            <input type="number" id="age" name="age" placeholder="Age.. " required
            value="<?php echo $user->getAge()?>">

            <input type="text" name="id" hidden value="<?php echo $user->getUserId()?>">
            <input type="submit" name="action" value="Edit">
        </form>

    <?php }
}