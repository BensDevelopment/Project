<!DOCTYPE html>
<!--Bart Holsappel, Joshua van Gelder-->
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
                <h1>Factuur inzien</h1><br>
                <?php
                include "link.php";
                session_start();
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                $userid = mysqli_prepare($link, "SELECT user_id,first_name, last_name FROM User WHERE mail='$username'");
                mysqli_stmt_execute($userid);
                mysqli_stmt_bind_result($userid,$user,$fname,$lname);
                while (mysqli_stmt_fetch($userid)){
                   echo "<label>Naam:</label>$fname $lname";
                }
                mysqli_close($link);
                ?>
                <div id="factuur">
                    <p><?php
                    /*
                        include"link.php";
                        $stmt0 = mysqli_prepare($link, "SELECT first_name, last_name FROM User WHERE userid= $userid");
                        mysqli_stmt_execute($stmt0);
                        mysqli_stmt_bind_result($stmt0, $fname, $lname);
                        while (mysqli_stmt_fetch($stmt0))
                        {
                            echo "<label>Naam:</label>$fname $lname";
                        }
                        mysqli_close($link);
                        echo "<label>Naam:</label>$fname $lname";*/
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
                        $invoiceID = $_POST["invoice_number"];
                        include "link.php";
                        $stat2 = mysqli_prepare($link, "SELECT date, payment_completed FROM invoice WHERE user_id = $user");
                        mysqli_stmt_execute($stat2);
                        mysqli_stmt_bind_result($stat2, $date, $payment_completed);
                        while (mysqli_stmt_fetch($stat2))
                        {
                            echo "<label>Factuurnummer:</label>$invoiceID";
                            echo "<br>";
                            echo "<label>Datum:</label>$date";
                        }
                        mysqli_close($link);
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
                    <?php
                    if ($payment_completed == 0)
                    {
                        echo '<p>Gelieve deze factuur binnen 14 dagen naar IBAN: NL 83 RABO 0344 4625 36 <br>t.n.v. D. van Beek o.v.v. factuurnummer en datum over te maken.</p>
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
                        /* Mail word verzonden als deze online staat
                            $to = 'financial@bensdevelopment.nl';
                            $subject = "Factuur: $invoiceID is betaald";
                            $message = "
                            <html>
                            <head>
                              <title>Deze factuur is betaald</title>
                            </head>
                            <body>
                              <p>
                              Goedendag,<br>
                              Factuur: $invoiceID is betaald
                                  
                              Met vriendelijke groet,
                              $company_name<br>
                              <br>
                              $fname $lname
                              </p>
                            </body>
                            </html>
                            ";
                            $headers  = 'MIME-Version: 1.0' . "\r\n";
                            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                            $headers .= 'From: <financial@bensdevelopment>' . "\r\n"; //support is de juiste mail van Bens Development.

                            mail($to, $subject, $message, $headers); 
                         */
                    }
                    ?>
                    <br>
                </div>
            </div></div>
        <footer>
            <?php 
                include 'include/php/footer.php'; 
            ?>
        </footer>
    </body>
</html>
