<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg, Daan Hagemans, Sander van der Stelt -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="include/css/stijl.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="container">
            <header>
                <div id="logo">
                    <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
                </div>
                <div id="menu">
                    <?php
                    include 'include/php/menu.php';
                    ?>
                </div>
            </header>
            <div id="content">
                <h1>login</h1>            	
                <div class="login">                    	
                    <form action="klantlogin.php" method="POST">
                        <label>Gebruikersnaam:</label><br>
                        <input type="text" name="username">
                        <br>
                        <label>Wachtwoord:</label><br>
                        <input type="password" name="password">
                        <br>
                        <input type="submit" name="login" value="login">
                        <br><br>
                        <a href="klantwwvergeten.php">Wachtwoord vergeten?</a>
                    </form>
                </div> 	
                <?php

                function sha512($password, $unique_salt)
                {
                    return crypt($password, '$6$20$' . $unique_salt);
                }

                function unique_salt()
                {
                    return substr(sha1(mt_rand()), 0, 22);
                }

                session_start(); //start sessie
                include "link.php"; //Database connectie
                if (isset($_POST["login"]))
                { //Hier wordt gecontroleerd of de login knop ingedrukt is.
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $hash = sha512($password, $unique_salt); //Hiermee wordt het ingevoerde wachtwoord omgezet in een Hash
                    $login = $_POST["login"];
                    if (empty($username) || empty($password) || empty($username) && empty($password))
                    {// Deze if loop controleerd of alle velden zijn ingevuld
                        $error = "<p class='foutmelding'>Uw Gebruikersnaam en/of Wachtwoord is niet correct.</p>";
                        echo $error;
                    }
                    else
                    {
                        if (isset($login))
                        {//met de volgend if loop wordt bepaald of er goed is ingelogd.
                            $username = $_POST["username"];
                            $password = $_POST["password"];
                            $hash = sha512($password, $unique_salt);
                            $result = mysqli_query($link, "SELECT mail, password FROM User WHERE mail='$username' AND password='$hash'");
                            $rows = mysqli_num_rows($result);
                            if ($rows == 1)
                            {
                                $_SESSION['username'] = $_POST['username'];
                                $_SESSION['password'] = $_POST['password'];
                                $_SESSION['login'] = 1;
                                mysqli_close($link);
                                include "link.php"; //Deze query zet de status van de gebruiker op online.
                                $updatelogin = mysqli_prepare($link, "UPDATE User SET status='Online', laatste_inlog=NOW() WHERE mail='$username'");
                                mysqli_stmt_execute($updatelogin);
                                header("location: klantoverzicht.php");
                            }
                            else
                            {
                                $error = "<p class='foutmelding'>Uw Gebruikersnaam en/of Wachtwoord is niet correct.</p>";
                                echo $error;
                            }
                        }
                    }
                }
                if (isset($_GET["link"]))
                {
                    $username = $_SESSION['username'];
                    $password = $_SESSION['password'];
                    $loguit = mysqli_prepare($link, "UPDATE User SET status='Offline' WHERE mail='$username'");
                    mysqli_stmt_execute($loguit);
                    session_destroy();
                    header("location: klantlogin.php");
                }
                ?>

            </div>
        </div>
        <footer>
<?php include 'include/php/footer.php'; ?>
        </footer>
    </body>
</html>