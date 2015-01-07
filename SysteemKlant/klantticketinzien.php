<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Jeffrey Hamberg, Sander van der Stelt -->
<html>    
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="include/css/stijl.css" rel="stylesheet" type="text/css"/>
        <script src="include/functionGoBack.js" type="text/javascript"></script>
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
                <h1>Ticket inzien</h1><br>
                <?php
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                $ticketid = $_POST['ticketid'];

                include "link.php";
                $userinfo = mysqli_prepare($link, "SELECT user_id, first_name, last_name FROM User WHERE mail='$username'");
                mysqli_stmt_execute($userinfo);
                mysqli_stmt_bind_result($userinfo, $login, $fname, $lname);
                while (mysqli_stmt_fetch($userinfo))
                {
                    $login;
                    $fname;
                    $lname;
                }
                ?>                
                <p> 
                    <label>Naam:</label> <?php echo "$fname $lname"; ?>
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
                    $description = mysqli_prepare($link, "SELECT T.title,T.category, T.description, T.completed_status, T.creation_date FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticketid");
                    mysqli_stmt_bind_result($description, $titel, $cat, $desc, $completed, $creation);
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
                else
                {
                    include "link.php";
                    $description = mysqli_prepare($link, "SELECT T.title,T.category, T.description, T.completed_status, T.creation_date FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticketid");
                    mysqli_stmt_bind_result($description, $titel, $cat, $desc, $completed, $creation);
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
                        echo "<br><label>Tickettitel:</label> $titel";
                        echo "<br><br><label>Omschrijving:</label><br><table><td class='table_reactie'><span class='datum'>Datum: $creation</span><br>$desc</td></table>";
                    }
                    mysqli_close($link);
                    include "link.php";
                    $reactions = mysqli_prepare($link, "SELECT text, time, U.mail FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticketid");
                    mysqli_stmt_bind_result($reactions, $text, $time, $mail);
                    mysqli_stmt_execute($reactions);
                    echo "<br><label>Reactie:</label>";
                    while (mysqli_stmt_fetch($reactions))
                    {
                        echo "<br><table><td class='table_reactie'><span class='datum'>Datum: $time </span><br> $text</td></table>";
                    }
                }
                ?>                                                               
                <form method="POST" action="klantticketoverzicht.php">                    
                    <input type="submit" name="Back" value="Terug">
                </form>
            </div>           
        </div>
        <footer>
            <?php 
                include 'include/php/footer.php'; 
            ?>
        </footer>
    </body>
</html>

