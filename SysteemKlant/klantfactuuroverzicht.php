<!DOCTYPE html>
<?php session_start(); ?>
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
                <h1>Factuur Overzicht</h1><br>
                <!-- NIEUW GEPLAATSTE CODE-->
                <?php
                if(isset($_POST["betaald"]))
                {
                    //send email
                }
                include "link.php";
                $username = $_SESSION['username'];
                $password = $_SESSION['password']; //Deze query haalt de user id en naam van de ingelogde klant uit de database.
                $userid = mysqli_prepare($link, "SELECT user_id, first_name, last_name FROM User WHERE mail='$username'");
                mysqli_stmt_execute($userid);
                mysqli_stmt_bind_result($userid, $user, $fname, $lname);
                while (mysqli_stmt_fetch($userid))
                {
                    $user;
                    $fname;
                    $lname;
                }
                mysqli_close($link);
                include "link.php"; // Met deze query wordt de company naam van de ingelogde klant opgehaald.
                $stmt2 = mysqli_prepare($link, "SELECT C.company_name FROM Customer C JOIN User U ON U.user_id=C.customer_id WHERE U.user_id=$user ");
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_bind_result($stmt2, $name);
                mysqli_stmt_fetch($stmt2);
                mysqli_close($link);
                ?>               
                <div id="factuur">
                    <p>Naam: <?php echo "$fname $lname"; ?>
                    </p>
                    <p>
                        Bedrijfsnaam: <?php
                        include "link.php";
                        $count = mysqli_prepare($link, "SELECT COUNT(C.company_name) FROM Customer C JOIN Customer_User U ON U.user_id=C.customer_id WHERE U.user_id=$user");
                        mysqli_stmt_execute($count);
                        mysqli_stmt_bind_result($count, $ammount);
                        mysqli_stmt_fetch($count);
                        mysqli_close($link);
                        if ($ammount == 1)
                        {
                            echo "$name";
                        }
                        else
                        {
                            echo "<select name=company_name>";
                            include "link.php";
                            $company_name = mysqli_prepare($link, "SELECT C.company_name FROM Customer C JOIN Customer_User U ON U.customer_id=C.customer_id WHERE U.user_id=$user");
                            mysqli_stmt_execute($company_name);
                            mysqli_stmt_bind_result($company_name, $companyname);
                            while (mysqli_stmt_fetch($company_name))
                            {
                                echo "<option value='$companyname'>$companyname</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                    <p>
                        <br>
                    <p>Facaturen: <?php
                        include"link.php";
                        $stat = mysqli_prepare($link, "SELECT invoice_number, date, payment_completed FROM invoice WHERE user_id = $user");
                        mysqli_stmt_execute($stat);
                        mysqli_stmt_bind_result($stat, $CID, $date, $pc);
                        echo "<table><tr><th>Factuur nummer</th><th>Datum</th><th>Status</th></tr>";
                        while (mysqli_stmt_fetch($stat))
                        {
                            if ($pc = 0)
                            {
                                $ps = "Niet betaald";
                            }
                            else
                            {
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
