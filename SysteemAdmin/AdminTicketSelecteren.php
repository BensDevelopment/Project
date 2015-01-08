<!DOCTYPE html>
<!--Joshua van Gelder, Jeffrey Hamberg, , Sander van der Stelt-->
<?php
session_start();
if ($_SESSION["login"] != 1)
{
    echo 'YOU DONT BELONG HERE';
    session_unset();
    session_destroy();
}
else
{
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
                <h1>Admin ticket selecteren</h1>
                <div id="ticket">

                    <?php
                    include "link.php";
                    //De Ticked_iD wordt hieronder uit de form gehaald omdat het in array form wordt opgeslagen.
                    $ticket_id = $_POST["ticket_id"];
                    $status = mysqli_prepare($link, "SELECT COUNT(reaction_id) FROM Reaction WHERE ticket_id=$ticket_id");
                    mysqli_stmt_bind_result($status, $count);
                    mysqli_stmt_execute($status);
                    mysqli_stmt_fetch($status);
                    mysqli_close($link);

                    if ($count == 0)
                    {
                        include "link.php";
                        $description = mysqli_prepare($link, "SELECT T.category, T.description, T.completed_status, T.creation_date, T.title, C.company_name FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticket_id");
                        mysqli_stmt_bind_result($description, $cat, $desc, $completed, $creation, $titel, $compname);
                        mysqli_stmt_execute($description);
                        while (mysqli_stmt_fetch($description))
                        {
                            echo "<label>Titel: </label>$titel <br><label>Bedrijfsnaam: </label> $compname<br><label>Categorie:</label> $cat<br><label>Status:</label> ";
                            if ($completed == 1)
                            {
                                echo "Gesloten";
                            }
                            else
                            {
                                echo "Open";
                            }
                            echo "<br><label>Omschrijving:</label><br><table class='table_admin'><td class='table_reactie'><span class='datum'>$creation</span><br>$desc</td></table>";
                            mysqli_close($link);
                        }
                    }
                    else
                    {
                        include "link.php";
                        $description = mysqli_prepare($link, "SELECT T.category, T.description, T.completed_status, T.creation_date, T.title, C.company_name FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticket_id");
                        mysqli_stmt_bind_result($description, $cat, $desc, $completed, $creation, $titel, $compname);
                        mysqli_stmt_execute($description);
                        while (mysqli_stmt_fetch($description))
                        {
                            echo "<label>Titel: </label>$titel <br><label>Bedrijfsnaam: </label> $compname<br><label>Categorie:</label> $cat<br><label>Status:</label> ";
                            if ($completed == 1)
                            {
                                echo "Gesloten";
                            }
                            else
                            {
                                echo "Open";
                            }
                            echo "<br><br><label>Omschrijving:</label><br><table class='table_admin'><td class='table_reactie'><span class='datum'>$creation</span><br>$desc</td></table>";
                        }
                        mysqli_close($link);
                        include "link.php";
                        $reactions = mysqli_prepare($link, "SELECT text, time, U.mail, U.first_name FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticket_id");
                        mysqli_stmt_bind_result($reactions, $text, $time, $mail, $firstname);
                        mysqli_stmt_execute($reactions); // Deze query wordt gebruikt om alle reacties uit de reaction tabel te halen.
                        echo "<br><label>Reactie:</label>";
                        while (mysqli_stmt_fetch($reactions))
                        {
                            echo "<br><table class='table_admin'><td class='table_reactie'>$firstname<br><span class='datum'>$time</span><br>$text<br></td></table>";
                        }
                    }
                    ?>
                    <br>
                    <form method="POST">
                        <input type="submit" name="Beantwoorden" value="Ticket beantwoorden" formaction="AdminTicketBeantwoorden.php">
                        <?php
                        $ticketid = $_POST["ticket_id"];
                        $openorclosed = mysqli_prepare($link, "SELECT completed_status FROM Ticket WHERE ticket_id=$ticketid");
                        mysqli_stmt_bind_result($openorclosed, $cs);
                        mysqli_stmt_execute($openorclosed);
                        if ($cs == 1)
                        {
                            ?>
                            <input type="submit" name="Close" value="Sluiten" formaction="AdminTicketSelecteren.php">
                            <?php
                        }
                        if ($cs == 0)
                        {
                            ?>
                            <!-- Knop voor Optie ticket status wijzigen.
                            <input type="submit" name="Open" value="Openen" formaction="AdminTicketSelecteren.php">-->
                            <?php
                        }
                        ?>
                        <input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
                    </form>
                    <?php
                    if (isset($_POST["Close"]))
                    {
                        $update1 = mysqli_prepare($link, "UPDATE Ticket SET completed_status=1 WHERE ticket_id=$ticket_id");
                        mysqli_stmt_execute($update1);
                    }
                    if (isset($_POST["Open"]))
                    {
                        $update2 = mysqli_prepare($link, "UPDATE Ticket SET completed_status=0 WHERE ticket_id=$ticket_id");
                        mysqli_stmt_execute($update2);
                    }
                    ?>
                    <form method="POST">
                        <input type='submit' name='terug' value='Terug' formaction="AdminTicketOverzicht.php">
                        <!--
                        Optie voor ticket doorsturen naar 3e partijen, Bens Development zal dit zelf invullen
                        <input type='submit' name='Wijzigen' value='Doorsturen' formaction='#'>
                        -->
                    </form>
                </div>
            </div>
            <?php
            include 'include/php/footeradmin.php';
            ?>
        </body>
    </html>
<?php } ?>
