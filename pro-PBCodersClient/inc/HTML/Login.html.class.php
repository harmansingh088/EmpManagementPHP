<?php

class Login  {
    static function showForm() { ?>
        <html>
            <head>
                <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <link rel="stylesheet" href="css/Login.css">
                <title>Sign in</title>
            </head>

            <body>
                <div class="main">
                    <p class="sign" align="center">Sign in</p>
                    <form class="form1" ACTION="" METHOD="POST">
                        <input class="un " type="text" name="userName" align="center" placeholder="Username" required>
                        <input class="pass" type="password" name="password" align="center" placeholder="Password" required>
                        <input class="submit" type="submit" value="Sign in">
                    </form>
                </div>
            </body>
        </html>
    <?php }
}