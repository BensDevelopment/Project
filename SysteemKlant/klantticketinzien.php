<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Jeffrey Hamberg, Sander van der Stelt -->
<html>    
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="stijl.css" rel="stylesheet" type="text/css"/>
        <script src="include/functionGoBack.js" type="text/javascript"></script>
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
                <h1>Ticket inzien</h1><br>
                <?php
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

                $ticketidarray = $_POST["ticketid"]; //Deze foreach is nodig om de ticketid uit de array te halen die wordt meegegeven vanaf de vorige pagina.
                foreach ($ticketidarray as $ticket => $notused)
                {
                    $ticketid = $ticket;
                }
                ?>
                <form method="POST" action="klantticketaanmaken.php">
                    <p> <label>Naam:</label> <?php echo "$fname $lname";
                ?>
                        <br>
                        <label>E-mail:</label> <?php echo $username; ?> 
                    </p>                                                                                                
                    <?php
                    $status = mysqli_prepare($link, "SELECT COUNT(reaction_id) FROM Reaction WHERE ticket_id=$ticketid");
                    mysqli_stmt_bind_result($status, $count);
                    mysqli_stmt_execute($status);
                    mysqli_stmt_fetch($status);
                    mysqli_close($link);
                    if ($count == 0)
                    {
                        include "link.php";
                        $description = mysqli_prepare($link, "SELECT T.category, T.description, T.completed_status, T.creation_date FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticketid");
                        mysqli_stmt_bind_result($description, $cat, $desc, $completed, $creation);
                        mysqli_stmt_execute($description);
                        while (mysqli_stmt_fetch($description))
                        {
                            echo "<label>Categorie:</label> $cat<br><label>Status:</label> ";
                            if ($completed == 1)
                            {
                                echo "Gesloten";
                            }
                            else
                            {
                                echo "Open";
                            }
                            echo "<br><label>Omschrijving:</label><br><table><td class='table_reactie'><span class='datum'>$creation</span><br>$desc</td></table>";
                            mysqli_close($link);
                        }
                    }
                    //De if loop is hieronder nodig om te true/false status van de ticket om te zetten naar text.                        
                    else
                    {
                        include "link.php";
                        $description = mysqli_prepare($link, "SELECT T.category, T.description, T.completed_status, T.creation_date FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticketid");
                        mysqli_stmt_bind_result($description, $cat, $desc, $completed, $creation);
                        mysqli_stmt_execute($description);
                        while (mysqli_stmt_fetch($description))
                        {
                            echo "<label>Categorie:</label> $cat<br><label>Status:</label> ";
                            if ($completed == 1)
                            {
                                echo "Gesloten";
                            }
                            else
                            {
                                echo "Open";
                            }
                            echo "<br><label>Omschrijving:</label><br><table><td class='table_reactie'><span class='datum'>$creation</span><br>$desc</td></table>";
                        }
                        mysqli_close($link);
                        include "link.php";
                        $reactions = mysqli_prepare($link, "SELECT text, time, U.mail FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticketid");
                        mysqli_stmt_bind_result($reactions, $text, $time, $mail);
                        mysqli_stmt_execute($reactions); // Deze query wordt gebruikt om alle reacties uit de reaction tabel te halen.
                        echo "<br><label>Reactie:</label>";
                        while (mysqli_stmt_fetch($reactions))
                        {
                            echo "<br><table><td class='table_reactie'><span class='datum'>Datum: $time </span><br> $text</td></table>";
                        }
                    }
                    ?>                                               

                </form>
                <form method="POST" action="klantticketoverzicht.php">
                    <submit onclick="goBack()">Terug</submit>  
                    <input type="submit" name="Back" value="Terug">
                </form><!-- text field and button to send text field and cancel button to go back -->                            
            </div>
            <?php 
            
            ?>
            <!--EINDE CONTENT-->
        </div>
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>

