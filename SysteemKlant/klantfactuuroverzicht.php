<!DOCTYPE html>
<?php session_start(); ?>
<!-- Bart Holsappel, Joshua van Gelder-->
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
                    include 'include/php/menubackend.php';
                    ?>
                </div>                
            </header>
            <div id="content">
                <h1>Factuur Overzicht</h1><br>                
                <?php
                if (isset($_POST["betaald"]))
                {
                    //send email
                }
                include "link.php";
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];

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

                include "link.php";
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
                        <?php
                        include "link.php";

                        $count = mysqli_prepare($link, "SELECT COUNT(C.company_name) FROM Customer C JOIN Customer_User U ON U.user_id=C.customer_id WHERE U.user_id=$user");
                        mysqli_stmt_execute($count);
                        mysqli_stmt_bind_result($count, $ammount);
                        mysqli_stmt_fetch($count);
                        if ($ammount == 1)
                        {
                            echo "Bedrijfsnaam: $name";
                        }
                        else
                        {
                            echo "Bedrijsnamen:";
                            include "link.php";
                            $company_name = mysqli_prepare($link, "SELECT C.company_name, C.customer_id FROM Customer C JOIN Customer_User U ON U.customer_id=C.customer_id WHERE U.user_id=$user");
                            mysqli_stmt_execute($company_name);
                            mysqli_stmt_bind_result($company_name, $companyname, $customerid);
                            while (mysqli_stmt_fetch($company_name))
                            {
                                echo " $companyname ";
                            }
                        }
                        ?>
                        <br>
                    <p>Facturen: <?php
                        include"link.php";
                        $stat = mysqli_prepare($link, "SELECT invoice_number, date, payment_completed, customer_id FROM invoice WHERE user_id = $user");
                        mysqli_stmt_execute($stat);
                        mysqli_stmt_bind_result($stat, $invoice_number, $date, $pc, $cid);
                        echo "<table><tr><th>Factuur nummer</th><th>Datum</th><th>Status</th><th>Bekijken</th></tr>";
                        while (mysqli_stmt_fetch($stat))
                        {
                            if ($pc == 0)
                            {
                                $ps = "Niet betaald";
                            }
                            else
                            {
                                $ps = "Betaald";
                            }
                            echo "<tr><td>$invoice_number</td><td>$date</td><td>$ps</td><td><form method='POST'><input type='hidden' name='invoice_number' value='$invoice_number'>"
                            . "<input type='image' src='afbeeldingen/bekijken.png' name='submit' formaction='klantfactuurinzien.php'>"
                            . "<input type=hidden name='cid' value='$cid'></form></td></tr>";
                        }
                        print ("</table>");
                        ?>
                        <br>
                    <form method="POST">
                        <input type="submit" name="back" value="Terug" formaction="KlantOverzicht.php">
                    </form>
                    <br>
                </div>
            </div>
        </div>
        <footer>
            <?php
            include 'include/php/footer.php';
            ?>
        </footer>
    </body>
</html>
