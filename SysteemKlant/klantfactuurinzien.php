<!DOCTYPE html>
<!--Bart Holsappel -->
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
                    include 'menubackend.php';
                    ?>
                </div>
            </header>            
            <div id="content">
                <h1>Factuur inzien</h1><br>
                <?php
                include "link.php";
                session_start();
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                $userid = mysqli_prepare($link, "SELECT user_id FROM User WHERE mail='$username'");
                mysqli_stmt_execute($userid);
                mysqli_stmt_bind_result($userid, $user);
                while (mysqli_stmt_fetch($userid))
                {
                    $userid;
                }
                mysqli_close($link);
                ?>
                <div id="factuur">
                    <p><?php
                        include"link.php";
                        $stmt = mysqli_prepare($link, "SELECT first_name, last_name FROM User WHERE mail='$username'");
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_bind_result($stmt, $fname, $lname);
                        while (mysqli_stmt_fetch($stmt))
                        {
                            echo "<label>Naam:</label>$fname $lname";
                        }
                        mysqli_close($link);
                        ?>
                    </p>

                    <p><?php
                        include "link.php";
                        $stat1 = mysqli_prepare($link, "SELECT company_name, street, house_number, city, kvk_number, btw_number FROM Customer WHERE customer_id = $user");
                        mysqli_stmt_execute($stat1);
                        mysqli_stmt_bind_result($stat1, $company_name, $street, $housen, $city, $kvk, $btw);
                        while (mysqli_stmt_fetch($stat1))
                        {
                            echo "<label>Bedrijfsnaam:</label>$company_name<br>";
                            echo "<label>Adres:</label>$street $housen<br>";
                            echo "<label>Woonplaats:</label>$city";
                        }

                        mysqli_close($link);
                        ?>
                    <p><?php
                        include "link.php";
                        $stat2 = mysqli_prepare($link, "SELECT date, payment_completed FROM invoice WHERE user_id = $user");
                        mysqli_stmt_execute($stat2);
                        mysqli_stmt_bind_result($stat2, $date, $payment_completed);
                        while (mysqli_stmt_fetch($stat2))
                        {
                            
                        }
                        mysqli_close($link);

                        $invoice = $_POST["CID"];

                        echo "<label>Factuurnummer:</label>$invoiceID";
                        echo "<br>";
                        echo "<label>Datum:</label>$date";
                        ?>
                    </p>
                    <p>
                        Factuur:
                        <?php
                        $total = 0;
                        include"link.php";
                        $stmt3 = mysqli_prepare($link, "SELECT line_id, invoice_number, description, description2, amount, price, btw FROM line WHERE invoice_number = $invoiceID");
                        mysqli_stmt_execute($stmt3);
                        mysqli_stmt_bind_result($stmt3, $lineID, $IN, $D1, $D2, $amount, $price, $BTW);
                        echo "<table><th>Beschrijving</th><th>Aantal</th><th>Prijs</th>";
                        while (mysqli_stmt_fetch($stmt3))
                        {
                            $total = $total + ($amount * $price);
                            echo "<tr><td>$D1</td><td>$amount</td><td>€ $price</td></tr>";
                        }
                        $BTWsub = ($BTW / 100) + 1;
                        $totalincbtw = $total * $BTWsub;
                        $BTWtotal = $totalincbtw - $total;

                        echo "</table><br>";
                        echo "<label class='factuur'>Subtotaal</label>€ $total<br>";
                        echo "<label class='factuur'>BTW 21 %</label>€ $BTWtotal<br>";
                        echo "<label class='factuur'><strong>Totaal</strong></label>€ $totalincbtw";
                        ?>
                    </p>
                    <p>
                        IBAN: NL 83 RABO 0344 4625 36
                    </p>
                    <?php
                    if ($payment_completed == 1)
                    {
                        echo '<p>Gelieve deze factuur binnen 14 dagen op bovenstaande rekeningnummer t.n.v. D. van Beek<br> o.v.v. factuurnummer en datum overmaken.</p>
                        <p class="foutmelding">Deze factuur is nog niet voldaan.</p>';
                    }
                    else
                    {
                        echo '<p class="succesmelding">Deze factuur is voldaan.</p>';
                    }
                    ?>
                    <form class="knop_link" method="POST" action="klantfactuuroverzicht.php">
                        <input type="submit" name="betaald" value="Ik heb betaald"> 
                    </form>
                    <form class="knop_link" method="post" action="klantfactuuroverzicht.php">
                        <input type="submit" name="back" value="Terug">
                    </form>
                    <?php
                    if (isset($_POST["betaald"]))
                    {
                        
                    }
                    ?>
                    <br>
                </div>
            </div></div>
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>
