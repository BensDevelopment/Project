<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Sander van der Stelt -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Bens Development</title>
        <link rel="stylesheet" href="stijl.css" type="text/css"/>
    </head>    
    <body>        
        <div id="container">
            <header>
                <div id="logo">
                    <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
                </div>
                <div id="menu">
                    <?php
                    include 'menubackend.php';
                    include 'link.php';
                    ?>
                </div>
            </header>
            <div id="content">
                <h1>Home</h1><br>
                <?php
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];

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
                $ticketammount = mysqli_prepare($link, "SELECT COUNT(ticket_id) FROM Ticket WHERE user_id=$login AND completed_status=0");
                mysqli_stmt_execute($ticketammount);
                mysqli_stmt_bind_result($ticketammount, $count);
                mysqli_stmt_fetch($ticketammount);
                mysqli_close($link);

                include "link.php";
                $factuurammount = mysqli_prepare($link, "SELECT COUNT(invoice_number) FROM Invoice WHERE user_id=$login AND payment_completed=0");
                mysqli_stmt_execute($factuurammount);
                mysqli_stmt_bind_result($factuurammount, $count2);
                mysqli_stmt_fetch($factuurammount);
                mysqli_close($link);
                ?>
                <div class='overzicht'>
                    <p>U heeft <?php
                        if ($count == 1)
                        {
                            echo $count . " open ticket";
                        }
                        else
                        {
                            echo $count . " open tickets";
                        }
                        ?></p>
                    <table>                    
                        <tr>
                            <th>Titel</th>
                            <th>Categorie</th>
                            <th>Aanmaak Datum</th>
                        </tr>                    
                        <?php
                        include "link.php";
                        $tickets = mysqli_prepare($link, " SELECT titel, category, creation_date, ticket_id FROM Ticket WHERE user_id=$login AND completed_status=0 ORDER BY creation_date DESC");
                        mysqli_stmt_execute($tickets);
                        mysqli_stmt_bind_result($tickets, $titel, $category, $creation, $ticketid);
                        while (mysqli_stmt_fetch($tickets))
                        {
                            echo "<tr><td>$titel</td><td>$category</td><td>$creation</td></tr>";
                        }
                        ?>
                    </table></div>
                <p>U heeft <?php
                    if ($count2 == 1)
                    {
                        echo $count2 . " open factuur";
                    }
                    else
                    {
                        echo"$count2 open facturen";
                    }
                    ?> </p>
                <div class='overzicht'>
                    <table class='overzicht'>
                        <tr>
                            <th>Factuurnummer</th>
                            <th>Datum</th>
                        </tr>
                        <?php
                        include "link.php";
                        $facturen = mysqli_prepare($link, " SELECT invoice_number, date FROM Invoice WHERE user_id=$login AND payment_completed=0 ORDER BY date DESC");
                        mysqli_stmt_execute($facturen);
                        mysqli_stmt_bind_result($facturen, $number, $date);
                        while (mysqli_stmt_fetch($facturen))
                        {
                            echo "<tr><td>$number</td><td>$date</td></tr>";
                        }
                        ?>
                    </table>
                </div>
                <div class="overzicht_btn">
                    <form method="POST" action="klantticketaanmaken.php">
                        <input type="submit" name="ticketmaken" value="Ticket aanmaken">
                    </form>
                    <form method="POST" action="klantticketoverzicht.php">
                        <input type="submit" name="ticketinzien" value="Tickets inzien">
                    </form>                     
                    <form method="POST" action="klantfactuuroverzicht.php">
                        <input type="submit" name="klantfactuuroverzicht" value="Factuur Overzicht">
                    </form>
                </div>
            </div>                        
        </div>
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>
