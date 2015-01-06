<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg, Daan Hagemans, Sander van der Stelt -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="stijl.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id="container">
            <header>
                <div id="logo">
                    <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
                </div>
                <div id="menu">
                    <?php
                    include 'menu.php';
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
                session_start(); //start sessie
                include "link.php"; //Database connectie
                if (isset($_POST["login"])) //Hier wordt gecontroleerd of de login knop ingedrukt is.
                {
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $login = $_POST["login"];
                    if (empty($username) || empty($password) || empty($username) && empty($password))// Deze if loop controleerd of alle velden zijn ingevuld
                    {
                        $error = "<p class='foutmelding'>Uw Gebruikersnaam en/of Wachtwoord is niet correct.</p>";
                        echo $error;
                    }
                    else
                    {
                        if (isset($login)) //met de volgend if loop wordt bepaald of er goed is ingelogd.
                        {
                            $username = $_POST["username"];
                            $password = $_POST["password"];
                            $result = mysqli_query($link, "SELECT mail, password FROM User WHERE mail='$username' AND password='$password'");
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
                if (isset($_GET["link"])) //Deze if loop bekijkt of de gebruiker van een uitlogknop komt, en zet de status van de gebruikker dan op offline
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
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>