<!DOCTYPE html>
<!--Jeffrey Hamberg, Joshua van Gelder, Daan Hagemans-->

<html>
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="include/css/stijl.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id='bovenbalk'>

            <div id='logo'>
                <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
            </div>
            <div id='gebruiker'></div><div id='menu'><p class="adminsysteem">Bens Administratie Systeem</p></div>
            <?php

            function sha512($password, $unique_salt)
            {
                return crypt($password, '$6$20$' . $unique_salt);
            }

            function unique_salt()
            {
                return substr(sha1(mt_rand()), 0, 22);
            }

            include 'link.php';
            if (isset($_POST["login"]))
            {
                $username = $_POST["username"];
                $password = $_POST["password"];
                $hash = sha512($password, $unique_salt);
                $login = $_POST["login"];
                if (empty($username) || empty($password) || empty($username) && empty($password))
                {
                    $error = "Gebruikersnaam of Wachtwoord verkeerd.";
                    print($error);
                }
                else
                {
                    if (isset($login))
                    {
                        $username = $_POST["username"];
                        $password = $_POST["password"];
                        $hash = sha512($password, $unique_salt);
                        if ($username != 'admin@bensdevelopment.nl')
                        {
                            echo "Gebruikersnaam of Wachtwoord verkeerd.";
                        }
                        else
                        {
                            $username = $_POST["username"];
                            $password = $_POST["password"];
                            //$login1 = mysqli_prepare($link, "SELECT mail, password FROM User WHERE mail='$username' AND password='$password'");
                            //mysqli_stmt_execute($login1);
                            $result = mysqli_query($link, "SELECT mail, password FROM User WHERE mail='$username' AND password='$hash'");
                            $rows = mysqli_num_rows($result);
                            mysqli_close($link);
                            if ($rows == 1)
                            {
                                include "link.php";
                                session_start();
                                $_SESSION['username'] = $_POST['username'];
                                $_SESSION['password'] = $_POST['password'];
                                $_SESSION['login'] = 1;
                                $updatelogin = mysqli_prepare($link, "UPDATE User SET status='Online', laatste_inlog=NOW() WHERE mail='$username'");
                                mysqli_stmt_execute($updatelogin);
                                header("location: AdminOverzicht.php");
                            }
                            else
                            {
                                $error = "Gebruikersnaam of Wachtwoord verkeerd.";
                                print($error);
                            }
                        }
                    }
                }
            }
            ?>
        </div>
        <div id='content'>
            <h1>login</h1>
            <div class="login">
                <form action="AdminLogin.php" method="POST">
                    <label>Gebruikersnaam:</label><br>
                    <input type="text" name="username">
                    <br>
                    <label>Wachtwoord:</label><br>
                    <input type="password" name="password">
                    <br>
                    <input type="submit" name="login" value="login">
                    <br><br>
                    <a href="adminwachtwoordvergeten.php">Wachtwoord vergeten?</a>
                </form>
            </div>
        </div>
<?php
include 'include/php/footeradmin.php';
?>
    </body>
</html>
</body>
</html>
