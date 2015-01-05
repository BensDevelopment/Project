<!DOCTYPE html>
<!--Joshua van Gelder, Jeffrey Hamberg, , Sander van der Stelt-->
<?php
session_start();
if ($_SESSION["login"] != 1) {
    echo 'U moet ingelogd zijn om deze pagina te bekijken';
    session_unset();
    session_destroy();
} else {
    if (isset($_POST["submit"])) {
        $ticketidarray = $_POST["Beantwoorden"]; //Deze foreach is nodig om de ticketid uit de array te halen die wordt meegegeven vanaf de vorige pagina.
        foreach ($ticketidarray as $ticketid => $notused) {
            $ticket_id = $ticketid;
        }
        include "link.php"; //Met deze query wordt de nieuwe reactie in de tabel gezet.
        $description = $_POST["beschrijving"];
        $reactionquery = mysqli_prepare($link, "INSERT INTO Reaction SET ticket_id=$ticket_id, text='$description', time=NOW(), user_id=$login");
        mysqli_stmt_execute($reactionquery);
        mysqli_stmt_fetch($reactionquery);
        header("AdminTicketBeantwoorden.php");
    } else {

    }
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
                <h1>Ticket beantwoorden</h1>
                <div id="ticket">
                    <?php
                    $ticketidarray = $_POST["Beantwoorden"]; //Deze foreach is nodig om de ticketid uit de array te halen die wordt meegegeven vanaf de vorige pagina.
                    foreach ($ticketidarray as $ticket => $notused) {
                        $ticketid = $ticket;
                    }
                    ?>
                    <form method="POST" action="">
                        <?php
                        include "link.php";
                        //De if loop is hieronder nodig om te true/false status van de ticket om te zetten naar text.
                        $description = mysqli_prepare($link, "SELECT T.category, T.description, T.completed_status, T.creation_date, T.titel FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticketid");
                        mysqli_stmt_bind_result($description, $cat, $desc, $completed, $creation, $titel);
                        mysqli_stmt_execute($description);
                        while (mysqli_stmt_fetch($description)) {

                            echo "<label>Titel: </label>$titel<br><label>Categorie:</label> $cat<br><label>Status:</label> ";
                            if ($completed == 1) {
                                echo "Gesloten";
                            } else {
                                echo "Open";
                            }
                            echo "<br><br><label>Omschrijving:</label><br><table class='table_admin'><td class='table_reactie'><span class='datum'>$creation</span><br>$desc</td></table>";
                        }
                        mysqli_close($link);
                        include "link.php";
                        $reactions = mysqli_prepare($link, "SELECT text, time, U.mail FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticketid ORDER BY time");
                        mysqli_stmt_bind_result($reactions, $text, $time, $mail);
                        mysqli_stmt_execute($reactions); // Deze query wordt gebruikt om alle reacties uit de reaction tabel te halen.
                        echo "<br><br><label>Reactie:</label>";
                        while (mysqli_stmt_fetch($reactions)) {
                            echo "<br><table class='table_admin'><td class='table_reactie'><span class='datum'>$time</span><br>$text</td></table>";
                        }
                        ?>
                        <br>
                        <form method="POST" action="">
                            Uw antwoord:<br>
                            <textarea name="beschrijving"></textarea><br>
                            <input type="submit" name="submit" value="Beantwoorden">
                            <input type="hidden" name="Beantwoorden[<?php echo $ticketid; ?>]">
                        </form>
                        <form method="POST" action='AdminTicketOverzicht.php'>
                            <input type='submit' name='terug' value='Terug'>
                            <input type="hidden" name="ticketid[<?php echo $ticketid; ?>]">
                        </form>
                </div>
            </div>
            <?php
            include 'footeradmin.php';
            ?>
        </body>
    </html>
<?php } ?>
