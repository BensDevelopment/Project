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
                        <a href="klantwwvergeten.php">wachtwoord vergeten</a>
                    </form>
                </div>     
                <?php
                session_start(); //start sessie
                include "link.php"; //Database connectie
                if (isset($_POST["login"]))
                {
                    $username = $_POST["username"];
                    $password = $_POST["password"];
                    $login = $_POST["login"];
                    if (empty($username) || empty($password) || empty($username) && empty($password))
                    {
                        $error = "<p class='foutmelding'>Uw Gebruikersnaam en/of Wachtwoord is niet correct.</p>";
                        echo $error;
                    }
                    else
                    {
                        if (isset($login))
                        {
                            $username = $_POST["username"];
                            $password = $_POST["password"];
                            //$login1 = mysqli_prepare($link, "SELECT mail, password FROM User WHERE mail='$username' AND password='$password'");
                            //mysqli_stmt_execute($login1);
                            $result = mysqli_query($link, "SELECT mail, password FROM User WHERE mail='$username' AND password='$password'");
                            $rows = mysqli_num_rows($result);
                            if ($rows == 1)
                            {
                                $_SESSION['username'] = $_POST['username'];
                                $_SESSION['password'] = $_POST['password'];
                                $_SESSION['login'] = 1;
                                mysqli_close($link);
                                include "link.php";
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
                ?>
            </div>
        </div>
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>

