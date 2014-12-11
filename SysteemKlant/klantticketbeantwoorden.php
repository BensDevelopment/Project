<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Jeffrey Hamberg, Bart Holsappel, Sander van der Stelt -->
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
                <!--BEGIN MENU-->
                <div id="menu">
                    <?php
                    include 'menubackend.php';
                    ?>
                </div>
                <!--EINDE MENU-->
            </header>
            <!--BEGIN CONTENT-->
            <div id="content">
                <h1>Ticket</h1>
                <?php
                if (isset($_POST["submit"]))
                {
                    $ticketidarray = $_POST["ticketid"]; //Deze foreach is nodig om de ticketid uit de array te halen die wordt meegegeven vanaf de vorige pagina.
                    foreach ($ticketidarray as $ticketid => $notused)
                    {
                        $ticket_id = $ticketid;
                    }
                    $username = $_SESSION['username'];
                    $password = $_SESSION['password'];

                    include "link.php"; // Met deze query wordt de naam en userid van de ingelogde klant opgehaald.
                    $userinfo = mysqli_prepare($link, "SELECT user_id, first_name, last_name FROM User WHERE mail='$username'");
                    mysqli_stmt_execute($userinfo);
                    mysqli_stmt_bind_result($userinfo, $login, $fname, $lname);
                    while (mysqli_stmt_fetch($userinfo))
                    {
                        $login;
                        $fname;
                        $lname;
                    }
                    mysqli_close($link);

                    include "link.php"; //Met deze query wordt de nieuwe reactie in de tabel gezet.
                    $description = $_POST["beschrijving"];
                    $reactionquery = mysqli_prepare($link, "INSERT INTO Reaction SET ticket_id=$ticket_id, text='$description', time=NOW(), user_id=$login");
                    mysqli_stmt_execute($reactionquery);
                    mysqli_stmt_fetch($reactionquery);
                    header("klantticketbeantwoorden.php");
                }
                else
                {
                    $ticketidarray = $_POST["ticketid"];//Deze foreach is nodig om de ticketid uit de array te halen die wordt meegegeven vanaf de vorige pagina.
                    foreach ($ticketidarray AS $ticketid => $notused)
                    {
                        $ticket_id = $ticketid;
                    }
                    $username = $_SESSION['username'];
                    $password = $_SESSION['password'];
                    include "link.php"; //Deze query bepaalt de userid van de ingelogde klant.
                    $loginQuery = mysqli_prepare($link, "SELECT user_id FROM User WHERE mail='$username'");
                    mysqli_stmt_execute($loginQuery);
                    mysqli_stmt_bind_result($loginQuery, $login);
                    while (mysqli_stmt_fetch($loginQuery))
                    {
                        $login;
                    }
                    mysqli_close($link);
                    include "link.php";
                    //De if loop is hieronder nodig om te true/false status van de ticket om te zetten naar text.
                    $stmt1 = mysqli_prepare($link, "SELECT C.company_name, T.category, T.description, T.completed_status, C.customer_id, T.creation_date FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticket_id");
                    mysqli_stmt_bind_result($stmt1, $compname, $cat, $desc, $completed, $CID, $creation);
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
                        echo "</label><br><label>Klant ID:$CID</label><br><label>Description:<br>$desc</label> <label>$creation</label>";
                    }
                    $stmt2 = mysqli_prepare($link, "SELECT text, time, U.mail FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticket_id");
                    mysqli_stmt_bind_result($stmt2, $text, $time, $mail);
                    mysqli_stmt_execute($stmt2);
                    echo "<br><label>Reactions:</label>";
                    while (mysqli_stmt_fetch($stmt2))
                    {
                        echo "<br><label><br>$text</label> <label>$time</label>";
                    }
                }
                ?>
                <br>
                <br>
                <form method="POST" action="klantticketbeantwoorden.php">
                    Uw antwoord:<br>
                    <textarea name="beschrijving"></textarea>
                    <br>
                    <input type="submit" name="submit" value="Beantwoorden">
                    <input type="hidden" name="ticketid['<?php echo "$ticketid"; ?>']">
                </form>
                <form method="POST" action='klantticketoverzicht.php'>
                    <input type='submit' name='terug' value='terug'>
                    <input type='hidden' name="" value="">
                </form>
            </div>
            <!--EINDE CONTENT-->
        </div>
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>

