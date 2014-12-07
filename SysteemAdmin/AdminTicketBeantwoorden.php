<!DOCTYPE html>
<!--Joshua van Gelder, Jeffrey Hamberg-->
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
                    $username   = $_SESSION['username'];
                    $password   = $_SESSION['password'];
                    include "link.php";
                    $loginQuery = mysqli_prepare($link, "SELECT user_id FROM User WHERE mail='$username'");
                    mysqli_stmt_execute($loginQuery);
                    mysqli_stmt_bind_result($loginQuery, $login);
                    while (mysqli_stmt_fetch($loginQuery))
                    {
                        $login;
                    }
                    mysqli_close($link);
                    include "link.php";
                    //De Ticked_iD wordt hieronder uit de form gehaald omdat het in array form wordt opgeslagen.
                    foreach ($_POST["ticket_id"] AS $ticketid => $notused)
                    {
                        $ticket_id = $ticketid;
                    }
                    //De if loop is hieronder nodig om te true/false status van de ticket om te zetten naar text.
                    $stmt1 = mysqli_prepare($link, "SELECT C.company_name, T.category, T.description, T.completed_status, C.customer_id, T.creation_date, R.text, R.time FROM customer C JOIN ticket T ON C.customer_id = T.customer_id JOIN Reaction R ON R.ticket_id = T.ticket_id WHERE T.ticket_id=$ticket_id ORDER BY R.time ASC");
                    mysqli_stmt_bind_result($stmt1, $compname, $cat, $desc, $completed, $CID, $creation, $text, $time);
                    mysqli_stmt_execute($stmt1);
                    while (mysqli_stmt_fetch($stmt1))
                    {
                        echo "<label>Ticket ID: $ticket_id</label><br><label>Klant ID:$compname</label><br><label>Category: $cat</label><br><label>Status:";
                        if ($completed == 1)
                        {
                            echo "Gesloten";
                        }
                        else
                        {
                            echo "Open";
                        }
                        echo "</label><br><label>Klant ID:$CID</label><br><label>Description:<br>$desc</label><label>$creation</label><br><label>Reactions:<br>$text</label><label>$time</label>";
                    }
                    ?>
                    <form method="POST" action="AdmintTicketBeantwoorden.php">
                        <textarea name="beschrijving">                        
                        </textarea>
                        <?php
                        $description = $_POST["beschrijving"];
                        $reactionquery    = mysqli_prepare($link, "INSERT INTO Reaction SET text='$description', time=NOW(), user_id=$login");
                        mysqli_stmt_bind_result($reactionquery, $reaction);
                        mysqli_stmt_execute($reactionquery);     
                        while(mysqli_stmt_fetch($reactionquery))
                        {
                            $reaction;
                        }
                        ?>
                    </form>
                    <form method="POST" action='AdminTicketOverzicht.php'>
                        <input type='submit' name='terug' value='terug'>
                        <input type='hidden' name='' value=''>
                    </form>
                </div>
            </div>
            <div class='push'></div>
            <div id='footer'>
                <div id='footerleft'>Admin Systeem</div>
                <div id='footerright'>&copy;Bens Development 2013 - 2014</div>
            </div>
        </body>
    </html>
<?php } ?>