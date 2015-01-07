<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Jeffrey Hamberg, Bart Holsappel, Sander van der Stelt -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bens Developement</title>
        <link href="include/css/stijl.css" rel="stylesheet" type="text/css"/>
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
                <h1>Ticket beantwoorden</h1><br>
                <?php
                $ticketid = $_POST["ticketid"];
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];

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
                $stmt1 = mysqli_prepare($link, "SELECT C.company_name, T.category, T.description, T.completed_status, C.customer_id, T.creation_date FROM customer C JOIN ticket T ON C.customer_id = T.customer_id WHERE T.ticket_id=$ticketid");
                mysqli_stmt_bind_result($stmt1, $compname, $cat, $desc, $completed, $CID, $creation);
                mysqli_stmt_execute($stmt1);
                while (mysqli_stmt_fetch($stmt1))
                {
                    echo "<label>Ticket ID:</label> $ticketid<br><label>Klant ID:</label> $compname<br><label>Category:</label> $cat<br><label>Status:</label> ";
                    if ($completed == 1)
                    {
                        echo "Gesloten";
                    }
                    else
                    {
                        echo "Open";
                    }
                    echo "<br><br><label>Omschrijving:</label><br><table><td class='table_reactie'><span class='datum'>Datum: $creation</span><br>$desc</td></table>";
                }

                $stmt2 = mysqli_prepare($link, "SELECT text, time, U.mail FROM reaction R JOIN User U ON R.user_id = U.user_id WHERE R.ticket_id = $ticketid");
                mysqli_stmt_bind_result($stmt2, $text, $time, $mail);
                mysqli_stmt_execute($stmt2);
                echo "<br><label>Reactie:</label>";
                while (mysqli_stmt_fetch($stmt2))
                {
                    echo "<br><table><td class='table_reactie'><span class='datum'>Datum: $time</span><br>$text</table>";
                }
                ?>
                <br>
                <br>
                <?php
                include "link.php";
                $openorclosed = mysqli_prepare($link, "SELECT completed_status FROM Ticket WHERE ticket_id=$ticketid");
                mysqli_stmt_bind_result($openorclosed, $status);
                mysqli_stmt_execute($openorclosed);
                mysqli_stmt_fetch($openorclosed);
                if ($status == 0)
                {
                    ?>
                    <form method="POST">
                        Uw antwoord:<br>
                        <textarea name="beschrijving"></textarea>
                        <br>
                        <input type="submit" name="submit" value="Beantwoorden" formaction="klantticketbeantwoorden.php">
                        <input type="hidden" name="ticketid" value="<?php echo "$ticketid"; ?>">                    
                        <?php
                    }
                    else
                    {
                        echo "Deze ticket is gesloten en u kan er niet meer op reageren.<br>Als dit niet zo hoort te zijn neem dan contact op met de administrator.";
                    }
                    if (isset($_POST["submit"]))
                    {

                        $ticketid = $_POST["ticketid"];
                        $username = $_SESSION['username'];
                        $password = $_SESSION['password'];

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
                        mysqli_close($link);

                        include "link.php";
                        $description = $_POST["beschrijving"];
                        $reactionquery = mysqli_prepare($link, "INSERT INTO Reaction SET ticket_id=$ticketid, text='$description', time=NOW(), user_id=$login");
                        mysqli_stmt_execute($reactionquery);
                    }
                    ?>               
                    <input type='submit' name='terug' value='terug' formaction="klantticketoverzicht.php">
                </form>
            </div>
            <!--EINDE CONTENT-->
        </div>
        <footer>
            <?php
            include 'include/php/footer.php';
            ?>
        </footer>
    </body>
</html>

