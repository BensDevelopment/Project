<!DOCTYPE html>
<!-- Bart Holsappel-->
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
                <!--BEGIN MENU-->
                <div id="menu">
                    <?php
                    include 'menubackend.php';
                    ?>
                </div>
                <!--EINDE MENU-->
            </header>
            <!--BEGIN CONTENT-->
            <div id="content">
                <h1>Factuur Overzicht</h1>
                <!-- NIEUW GEPLAATSTE CODE-->
                <?php
                include "link.php";
                session_start();
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                $userid   = mysqli_prepare($link, "SELECT user_id FROM User WHERE mail='$username'");
                mysqli_stmt_execute($userid);
                mysqli_stmt_bind_result($userid, $user);
                while (mysqli_stmt_fetch($userid))
                {
                    $user;
                }
                mysqli_close($link);
                ?> <!-- Dit maakt connectie met de database en zorgt voor de start van de inlogsessie -->
                <div id="factuur">
                    <p>Naam: <?php
                        include"link.php";
                        $stmt1 = mysqli_prepare($link, "SELECT first_name, last_name FROM User WHERE mail='$username'");
                        mysqli_stmt_execute($stmt1);
                        mysqli_stmt_bind_result($stmt1, $fname, $lname);
                        while (mysqli_stmt_fetch($stmt1))
                        {
                            echo "$fname $lname <br>";
                            //echo "$user";
                        }
                        mysqli_close($link);
                        ?>
                    </p>
                        <br>
                    <p>Facaturen: <?php
                    include"link.php";
                     $stat = mysqli_prepare($link, "SELECT invoice_number, date, payment_completed FROM invoice WHERE user_id = $user");
                mysqli_stmt_execute($stat);
                mysqli_stmt_bind_result($stat, $CID, $date, $pc);
                echo "<table><tr><th>Factuur nummer</th><th>Datum</th><th>Status</th></tr>";
                while (mysqli_stmt_fetch($stat))
                {
                    if($pc=0){
                     $ps = "Niet betaald";   
                    }else {
                        $ps = "Betaald";
                    }
                    echo "<form method='POST' action='klantfactuurinzien.php' ><tr><td>$CID</td><td>$date</td><td>$ps</td><td><input type='hidden' name=CID[$CID] ><input type='submit' name='submit' value='Bekijken'></form></td></tr>";
                } // Door de name te veranderen naar CID[$CID] kan je hem aanvragen op andere pagina's
                print ("</table>");
                ?>
                    </p>
                    <form class="knop_link" method="post" action="KlantOverzicht.php">
                <input type="submit" name="back" value="Terug">
            </form>
                    <br>
        </div>
        </div>
        </div>
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>
