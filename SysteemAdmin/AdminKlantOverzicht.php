<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg, Bart Holsappel -->
<?php session_start(); //start sessie ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Admin Systeem</title>
        <link href="include/css/stijl.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div id='bovenbalk'>
            <div id='logo'>
                <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
            </div>
            <?php
            include 'include/php/menu.php';
            ?>
        </div>

        <div id='content'>
            <h1>Klanten</h1>
            <br>
            <p><?php
                include "link.php";
                $username = $_SESSION["username"];
                $password = $_SESSION["password"];

                $stat = mysqli_prepare($link, "SELECT company_name, emailadress, customer_id FROM Customer ORDER BY customer_id");
                mysqli_stmt_execute($stat);
                mysqli_stmt_bind_result($stat, $comname, $mail, $CID);
                print("<table><tr><th>Bedrijfsnaam</th><th>E-mail</th><th></th></tr>");
                while (mysqli_stmt_fetch($stat))
                {
                    print("<form method='POST' action='AdminKlantInzien.php' ><tr><td>$comname</td><td>$mail</td><td><input type='hidden' name='CID' value='$CID'><input type='submit' name='submit' value='Bekijken'></form></td></tr>");
                } // Door de name te veranderen naar CID[$CID] kan je hem aanvragen op andere pagina's
                print ("</table>");
                ?>
            <form class="knop_link" method="post" action="AdminOverzicht.php">
                <input type="submit" name="back" value="Terug">
            </form>
        </div>
        <?php
        include 'include/php/footeradmin.php';
        ?>       
    </body>
</html>