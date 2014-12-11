<!DOCTYPE html>
<!-- Sander van der Stelt, Léyon Courtz-->
<html>
<head>
    <meta charset="UTF-8">
    <title>Bens Developement</title>
    <link href="stijl.css" rel="stylesheet" type="text/css"/>
</head>
<body>
    <div id='bovenbalk'>

        <div id='logo'>
            <img src="img/logo-bens.png" alt=""/>
        </div>
        <div id='gebruiker'></div><div id='menu'><p class="adminsysteem">Bens Administratie Systeem</p></div>
    </div>
    <div id='content'>
        <h1>Wachtwoord vergeten</h1>
        <form action="" method="post">
            E-mailadres: <input type="text" name="E-mailadres" ><br>
            <input type="submit" name="send" value="Verzenden"><br>
        </form> 



        <?php
        include "link.php"; //Hier include hij de link zodat er verbinding kan worden gemaakt met de database.

        if (isset($_POST['send'])) {

            $emailadres = $_POST['E-mailadres']; //Hier wordt het e-mailadres ingevuld.

            $stmt11 = mysqli_prepare($link, "SELECT first_name, mail FROM user WHERE mail = ? "); //Hier wordt er gecontroleerd of de mail in de database staat.

            mysqli_stmt_bind_param($stmt11, "s", $emailadres);
            mysqli_stmt_execute($stmt11);
            mysqli_stmt_bind_result($stmt11, $emailadres , $first_name);
            mysqli_stmt_store_result($stmt11);

            $find = mysqli_stmt_num_rows($stmt11);
            if ($find) { include 'functieRandomPassword.php'; //Hier wordt een random wachtwoord gegeneerd uit de functie functieRandomPassword.
                print("E-mail verzonden!");
                $final_result = mysqli_query($link, "UPDATE user SET password ='$random_password' WHERE mail = '$emailadres' "); //Hier wordt het random wachtwoord in de database geplaatst bij het ingevulde e-mailadres.
                        if ($final_result)
                        {
                            while (mysqli_stmt_fetch($stmt11)) {
                                 $naam = $first_name;
                             }
                              
        $to = $emailadres;
        $subject = "Wachtwoord opvragen";
        $message = '
<html>
<head>
  <title>Wachtwoord opvragen</title>
</head>
<body>
  <p>Beste ' .$naam .', hierbij uw nieuwe wachtwoord: '. $random_password . ' .</p>
  <p>Met vriendelijke groet,<br> Bens Development</p>
</body>
</html>
';

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'To: ' . $naam . $emailadres . "\r\n";
$headers .= 'From: Bensdevolopment <bensdevolopment@hotmail.com>' . "\r\n";

        mail($to, $subject, $message, $headers); //Hier wordt het mailtje gestuurd naar de afzender.
                        }
            } elseif ($_POST['E-mailadres'] == "") { //hier wordt gechecked of het e-mailadres niet leeg is.
                print("E-mailadres moet worden ingevuld!"); // Hier wordt een foutmelding gegeven als het e-mailadres leeg is.
            } else {
                echo "<p>Uw e-mail is niet bekend.</p>";
                mysqli_stmt_free_result($stmt11); // resultset opschonen
                mysqli_stmt_close($stmt11); // statement opruimen
                mysqli_close($link); // verbinding verbreken 
            }
        }







        
        ?>
    <form action="AdminLogin.php" method="post">
        <input type="submit" name="back" value="Terug">  
    </form>
    </div>
    <div class='push'></div>
    <div id='footer'>
        <div id='footerleft'>Admin Systeem</div>

        <div id='footerright'>&copy;Bens Development 2013 - 2014</div>
    </div>
</body>
</html>
