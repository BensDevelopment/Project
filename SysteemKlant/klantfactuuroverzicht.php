<!DOCTYPE html>
<?php session_start(); ?>
<!-- Bart Holsappel-->
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
                    <form id="customerid">
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
                            $company_name = mysqli_prepare($link, "SELECT C.company_name, C.customer_id FROM Customer C JOIN Customer_User U ON U.customer_id=C.customer_id WHERE U.user_id=$user");
                            mysqli_stmt_execute($company_name);
                            mysqli_stmt_bind_result($company_name, $companyname, $customerid);
                            while (mysqli_stmt_fetch($company_name))
                            {
                                echo "<option value='$customerid'>$companyname</option>";
                            }
                            echo "</select>";
                        }
                        ?>
                        <br>
                        <p>Facturen: <?php
                            include"link.php";
                            $stat = mysqli_prepare($link, "SELECT invoice_number, date, payment_completed FROM invoice WHERE user_id = $user");
                            mysqli_stmt_execute($stat);
                            mysqli_stmt_bind_result($stat, $invoice_number, $date, $pc);
                            echo "<table><tr><th>Factuur nummer</th><th>Datum</th><th>Status</th></tr>";
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
                                echo "<form method='POST'><tr><td>$invoice_number</td><td>$date</td><td>$ps</td><td><input type='hidden' name='invoice_number' value='$invoice_number'><input type='image' src='afbeeldingen/bekijken.png'name='submit'  formaction='klantfactuurinzien.php'></form></td></tr>";
                            }
                            print ("</table>");
                            ?>
                    </form>
                    <br>
                    <form method="post" action="KlantOverzicht.php">
                        <input type="submit" name="back" value="Terug">
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
