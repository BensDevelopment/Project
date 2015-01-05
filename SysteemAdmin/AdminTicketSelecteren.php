<!DOCTYPE html>
<!--Joshua van Gelder, Jeffrey Hamberg, , Sander van der Stelt-->
<?php
session_start();
if ($_SESSION["login"] != 1) {
    echo 'YOU DONT BELONG HERE';
    session_unset();
    session_destroy();
} else {
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Admin Systeem</title>
            <link href="stijl.css" rel="stylesheet" type="text/css">
        </head>
        <body>
            <div id='bovenbalk'>
                <div id='logo'>
                    <img src="img/logo-bens.png" alt="">
                </div>
                <?php
                include 'menu.php';
                ?>
            </div>
            <div id='content'>
                <h1>Admin ticket selecteren</h1>
                <div id="ticket">

                    <?php
                    include "link.php";
                    //De Ticked_iD wordt hieronder uit de form gehaald omdat het in array form wordt opgeslagen.
                    foreach ($_POST["ticket_id"] AS $ticketid => $notused) {
                        $ticket_id = $ticketid;
                    }
                    $status = mysqli_prepare($link, "SELECT COUNT(reaction_id) FROM Reaction WHERE ticket_id=$ticket_id");
                    mysqli_stmt_bind_result($status, $count);
                    mysqli_stmt_execute($status);
                    mysqli_stmt_fetch($status);
                    mysqli_close($link);
                    if ($count == 0) {
                        include "link.php";
                        $description = mysqli_prepare($link, "SELECT T.category, T.description, T.completed_status, T.creation_date, T.titel, C.company_name FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticket_id");
                        mysqli_stmt_bind_result($description, $cat, $desc, $completed, $creation, $titel, $compname);
                        mysqli_stmt_execute($description);
                        while (mysqli_stmt_fetch($description)) {
                            echo "<label>Titel: </label>$titel <br><label>Bedrijfsnaam: </label> $compname<br><label>Categorie:</label> $cat<br><label>Status:</label> ";
                            if ($completed == 1) {
                                echo "Gesloten";
                            } else {
                                echo "Open";
                            }
                            echo "<br><label>Omschrijving:</label><br><table class='table_admin'><td class='table_reactie'><span class='datum'>$creation</span><br>$desc</td></table>";
                            mysqli_close($link);
                        }
                    } else {
                        include "link.php";
                        $description = mysqli_prepare($link, "SELECT T.category, T.description, T.completed_status, T.creation_date, T.titel, C.company_name FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticket_id");
                        mysqli_stmt_bind_result($description, $cat, $desc, $completed, $creation, $titel, $compname);
                        mysqli_stmt_execute($description);
                        while (mysqli_stmt_fetch($description)) {
                            echo "<label>Titel: </label>$titel <br><label>Bedrijfsnaam: </label> $compname<br><label>Categorie:</label> $cat<br><label>Status:</label> ";
                            if ($completed == 1) {
                                echo "Gesloten";
                            } else {
                                echo "Open";
                            }
                            echo "<br><br><label>Omschrijving:</label><br><table class='table_admin'><td class='table_reactie'><span class='datum'>$creation</span><br>$desc</td></table>";
                        }
                        mysqli_close($link);
                        include "link.php";
                        $reactions = mysqli_prepare($link, "SELECT text, time, U.mail FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticket_id");
                        mysqli_stmt_bind_result($reactions, $text, $time, $mail);
                        mysqli_stmt_execute($reactions); // Deze query wordt gebruikt om alle reacties uit de reaction tabel te halen.
                        echo "<br><label>Reactie:</label>";
                        while (mysqli_stmt_fetch($reactions)) {
                            echo "<br><table class='table_admin'><td class='table_reactie'><span class='datum'>$time</span><br>$text</td></table>";
                        }
                    }
                    ?><br>
                    <form method="POST" action=''>
                        <input type='submit' name='terug' value='Terug' formaction="AdminTicketOverzicht.php">
                        <input type='submit' name='Wijzigen' value='Doorsturen' formaction='#'>
                    </form>
                    <form method="POST" action="AdminTicketBeantwoorden.php">
                        <input type="submit" name="antwoord" value="Ticket beantwoorden">
                    </form>
                </div>
            </div>
            <?php
            include 'footeradmin.php';
            ?>
        </body>
    </html>
<?php } ?>
