<!DOCTYPE html>
<!--Bart Holsappel -->

    <html>
        <head>
            <meta charset="UTF-8">
            <title>Admin Systeem</title>
            <link href="stijl.css" rel="stylesheet" type="text/css"/>
        </head>
        <body>
            <div id='bovenbalk'>
                <div id='logo'>
                    <img src="img/logo-bens.png" alt=""/>
                </div>
                <?php
                include 'menu.php';
                ?>
            </div>
            <div id='content'>
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
                    $userid;
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
                <p><?php
                    include "link.php";
                    $factuurarray = $_POST["CID"];
                    foreach ($factuurarray as $invoice => $notused)
                    {
                        $invoiceID = $invoice;
                    }
                    echo "<label>Factuur nummer:</label><label>" . $invoiceID . "</label>";
                    echo "$date";

                    mysqli_close($link);
                    ?>
                </p>
                
                <p>Factuur:
                <?php
                include"link.php";
                $stmt2 = mysqli_prepare($link, "SELECT * FROM line WHERE invoice_number = $invoiceID");
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_bind_result($stmt2, $lineID, $IN, $D1, $D2, $amount, $price, $BTW);
                echo "<table><th>Beschrijving</th><th>Aantal</th><th>prijs</th>";
                while (mysqli_stmt_fetch($stmt2)){
                   echo "<tr><td>$D1</td><td>$amount</td><td>$price</td></tr>" ;
                   
                }
                echo "</table>";
                ?>
                </p>
                <form class="knop_link" method="post" action="Klantfactuurverzicht.php">
                <input type="submit" name="back" value="Terug">
            </form>
                    <br>
        </div>

        <div class='push'></div>
        <div id='footer'>
            <div id='footerleft'>Klant systeem</div>

            <div id='footerright'>&copy;Bens Development 2013 - 2014</div>
        </div>
                
            </div>
    </body>
</html>
