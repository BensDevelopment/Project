<!DOCTYPE html>
<!--Joshua van Gelder, Jeffrey Hamberg, , Sander van der Stelt-->
<?php
session_start();
if ($_SESSION["login"] != 1)
{
    echo 'U moet ingelogd zijn om deze pagina te bekijken';
    session_unset();
    session_destroy();
}
else
{
    if (isset($_POST["submit"]))
    {
        $ticketid = $_POST['ticket_id'];
        include "link.php"; //Met deze query wordt de nieuwe reactie in de tabel gezet.
        $description = $_POST["beschrijving"];
        $login = $_SESSION['username'];
        $query1 = mysqli_prepare($link, "SELECT user_id FROM user WHERE mail ='$login'");
        mysqli_stmt_execute($query1);
        mysqli_stmt_bind_result($query1, $loginid);
        while(mysqli_stmt_fetch($query1)){
            $user_id = $loginid;
        }
        $reactionquery = mysqli_prepare($link, "INSERT INTO Reaction SET ticket_id=$ticketid, text='$description', time=NOW(), user_id=$user_id");
        mysqli_stmt_execute($reactionquery);
    }
    else
    {
        
    }
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
                <h1>Ticket beantwoorden</h1>
                <div id="ticket">                   
                    <?php
                    include "link.php";
                    $ticketid = $_POST["ticket_id"];
                    //De if loop is hieronder nodig om te true/false status van de ticket om te zetten naar text.
                    $description = mysqli_prepare($link, "SELECT T.category, T.description, T.completed_status, T.creation_date, T.title FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticketid");
                    mysqli_stmt_bind_result($description, $cat, $desc, $completed, $creation, $titel);
                    mysqli_stmt_execute($description);
                    while (mysqli_stmt_fetch($description))
                    {

                        echo "<label>Titel: </label>$titel<br><label>Categorie:</label> $cat<br><label>Status:</label> ";
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
                    $reactions = mysqli_prepare($link, "SELECT text, time, U.mail, U.first_name FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticketid ORDER BY time");
                    mysqli_stmt_bind_result($reactions, $text, $time, $mail, $first_name);
                    mysqli_stmt_execute($reactions); // Deze query wordt gebruikt om alle reacties uit de reaction tabel te halen.
                    echo "<br><label>Reactie:</label>";
                    while (mysqli_stmt_fetch($reactions))
                    {
                        echo "<br><table class='table_admin'><td class='table_reactie'>$first_name<br><span class='datum'>$time</span><br>$text</td></table>";
                    }
                    ?>
                    <br>
                    <form method="POST">
                        Uw antwoord:<br>
                        <textarea name="beschrijving"></textarea><br>
                        <input type='submit' name='terug' value='Terug' formaction='AdminTicketOverzicht.php'>
                        <input type="submit" name="submit" value="Beantwoorden" formaction="AdminTicketBeantwoorden.php">
                        <input type="hidden" name="ticket_id" value='<?php echo $ticketid ?>'>
                        
                    </form>
                </div>
            </div>
            <?php
                include 'include/php/footeradmin.php';
            ?>
        </body>
    </html>
<?php } ?>
