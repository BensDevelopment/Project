<!DOCTYPE html>
<!-- Jeffrey Hamberg, Joshua van Gelder, Sander van der Stelt-->
<?php
session_start();
if ($_SESSION['login'] != 1) {
    echo 'U moet ingelogd zijn om deze pagina te bekijken';
    session_unset();
    session_destroy();
} else {
    ?>
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
                <?php
                include "link.php"; //Met deze query wordt
                $ticketammount = mysqli_prepare($link, "SELECT COUNT(ticket_id) FROM Ticket WHERE completed_status=0");
                mysqli_stmt_execute($ticketammount);
                mysqli_stmt_bind_result($ticketammount, $count);
                mysqli_stmt_fetch($ticketammount);
                mysqli_close($link);
                include "link.php";
                $factuurammount = mysqli_prepare($link, "SELECT COUNT(invoice_number) FROM Invoice WHERE payment_completed=0");
                mysqli_stmt_execute($factuurammount);
                mysqli_stmt_bind_result($factuurammount, $count2);
                mysqli_stmt_fetch($factuurammount);
                mysqli_close($link);
                ?>
                <div id="overzichtcontainer">
                    <div id="overzicht">
                        <p>Er zijn <?php
                            if ($count == 1) {
                                echo $count . " open ticket";
                            } else {
                                echo $count . " open tickets";
                            }
                            ?>
                        </p>
                        <table>
                            <tr>
                                <th>Titel</th>
                                <th>Categorie</th>
                                <th>Aanmaak Datum</th>
                            </tr>
                            <?php
                            include "link.php";
                            $tickets = mysqli_prepare($link, " SELECT category, creation_date, ticket_id, titel FROM Ticket WHERE completed_status=0 ORDER BY creation_date DESC");
                            mysqli_stmt_execute($tickets);
                            mysqli_stmt_bind_result($tickets, $category, $creation, $ticketid, $titel);
                            while (mysqli_stmt_fetch($tickets)) {
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td></tr>";
                            }
                            ?>
                        </table></div>
                    <div id="overzicht">
                        <p>Er zijn <?php
                            if ($count2 == 1) {
                                echo $count2 . " open factuur";
                            } else {
                                echo"$count2 open facturen";
                            }
                            ?>
                        </p>
                        <table>
                            <tr>
                                <th>Factuurnummer</th>
                                <th>Datum</th>
                            </tr>
                            <?php
                            include "link.php";
                            $facturen = mysqli_prepare($link, " SELECT invoice_number, date FROM Invoice WHERE payment_completed=0 ORDER BY date DESC");
                            mysqli_stmt_execute($facturen);
                            mysqli_stmt_bind_result($facturen, $number, $date);
                            while (mysqli_stmt_fetch($facturen)) {
                                echo "<tr><td>$number</td><td>$date</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div id="overzicht">
                        <form method="POST" action="AdminTicketAanmaken.php">
                            <input type="submit" name="Ticket aanmaken" value="Ticket aanmaken">
                        </form>
                        <form method="POST" action="AdminFactuurAanmaken.php">
                            <input type="submit" name="Factuur aanmaken" value="Factuur aanmaken">
                        </form>
                    </div>
                </div>
            </div>
            <?php
                include 'include/php/footeradmin.php';
            ?>
        </body>
    </html>
<?php } ?>
