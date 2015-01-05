<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Jeffrey Hamberg, Sander van der Stelt -->
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
                <h1>Ticket Overzicht</h1><br>
                <!-- NIEUW GEPLAATSTE CODE-->
                <?php
                include "link.php";
                $username = $_SESSION['username'];
                $password = $_SESSION['password']; //Deze query haalt de user id en naam van de ingelogde klant uit de database.
                $userid = mysqli_prepare($link, "SELECT user_id, first_name, last_name FROM User WHERE mail='$username'");
                mysqli_stmt_execute($userid);
                mysqli_stmt_bind_result($userid, $user, $fname, $lname);
                mysqli_stmt_fetch($userid);
                mysqli_close($link);
                include "link.php"; // Met deze query wordt de company naam van de ingelogde klant opgehaald.
                $stmt2 = mysqli_prepare($link, "SELECT COUNT(C.company_name) FROM Customer C JOIN Customer_User U ON U.user_id=C.customer_id WHERE U.user_id=$user");
                mysqli_stmt_execute($stmt2);
                mysqli_stmt_bind_result($stmt2, $name);
                mysqli_stmt_fetch($stmt2);
                mysqli_close($link);
                ?>
                <div id="ticket">
                    <p>
                        Naam: <?php echo "$fname $lname"; ?>
                    </p>                    
                    <p>
                        <?php
                        include "link.php";
                        $count = mysqli_prepare($link, "SELECT COUNT(C.company_name) FROM Customer C JOIN Customer_User U ON U.user_id=C.customer_id WHERE U.user_id=$user");
                        mysqli_stmt_execute($count);
                        mysqli_stmt_bind_result($count, $ammount);
                        mysqli_stmt_fetch($count);
                        mysqli_close($link);
                        if ($ammount == 1)
                        {
                            echo "Bedrijfsnaam: $name";
                        }
                        else
                        {
                            include "link.php";
                            echo "Bedrijfsnamen: ";
                            $company_name = mysqli_prepare($link, "SELECT C.company_name FROM Customer C JOIN Customer_User U ON U.customer_id=C.customer_id WHERE U.user_id=$user");
                            mysqli_stmt_execute($company_name);
                            mysqli_stmt_bind_result($company_name, $companyname);
                            while (mysqli_stmt_fetch($company_name))
                            {
                                echo "$companyname ";
                            }
                            echo "</select>";
                        }
                        ?>
                    </p>                    
                    <br>                                       
                    <table>
                        <tr>
                            <th>Titel</th>
                            <th>
                                <?php
                                // Met de volgende rijen code wordt bepaald welke sorteerknop we willen hebben. Of we een DESC of een ASC knop hebben.
                                if (isset($_POST["sortcat"]))
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sortcatDESC' value='Categorie'></form>";
                                }
                                else
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sortcat' value='Categorie'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortct"]))
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sortctDESC' value='Aanmaak Datum'></form>";
                                }
                                else
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sortct' value='Aanmaak Datum'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortstat"]))
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sortstatDESC' value='Status'></form>";
                                }
                                else
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sortstat' value='Status'></form>";
                                }
                                ?>
                            </th>                            
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <?php
                        include'link.php';
                        if (isset($_POST["sortcat"]))
                        { // Elke if en elseif die hier volgen zijn verschillende clausules voor omhoog en omlaag gesorteerde categorien.
                            $stmt4 = mysqli_prepare($link, " SELECT titel, category, creation_date, completed_status, ticket_id FROM Ticket WHERE user_id=$user ORDER BY category");
                            mysqli_stmt_execute($stmt4);
                            mysqli_stmt_bind_result($stmt4, $titel, $category, $creation, $completed, $ticketid);
                            while (mysqli_stmt_fetch($stmt4))
                            {
                                if ($completed == 1) //Deze if en else zijn nodig om de completed status om te zetten in woorden.
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$completed</td><td><form method='POST' action='klantticketwijzigen.php'><input type='submit' name='ticketid[$ticketid]' value='Wijzigen'></form></td><td><form method='POST' action=klantticketinzien.php><input type='submit' name='ticketid[$ticketid]' value='Bekijken'></form></td><td><form method='POST' action='klantticketbeantwoorden.php'><input type='submit' name='ticketid[$ticketid]' value='Beantwoorden'></form></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortcatDESC"]))
                        {
                            $stmt5 = mysqli_prepare($link, " SELECT titel, category, creation_date, completed_status, ticket_id FROM Ticket WHERE user_id=$user  ORDER BY category DESC");
                            mysqli_stmt_execute($stmt5);
                            mysqli_stmt_bind_result($stmt5, $titel, $category, $creation, $completed, $ticketid);
                            while (mysqli_stmt_fetch($stmt5))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$completed</td><td><form method='POST' action='klantticketwijzigen.php'><input type='submit' name='ticketid[$ticketid]' value='Wijzigen'></form></td><td><form method='POST' action=klantticketinzien.php><input type='submit' name='ticketid[$ticketid]' value='Bekijken'></form></td><td><form method='POST' action='klantticketbeantwoorden.php'><input type='submit' name='ticketid[$ticketid]' value='Beantwoorden'></form></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortct"]))
                        {
                            $stmt6 = mysqli_prepare($link, " SELECT titel, category, creation_date, completed_status, ticket_id FROM Ticket WHERE user_id=$user ORDER BY creation_date ");
                            mysqli_stmt_execute($stmt6);
                            mysqli_stmt_bind_result($stmt6, $titel, $category, $creation, $completed, $ticketid);
                            while (mysqli_stmt_fetch($stmt6))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$completed</td><td><form method='POST' action='klantticketwijzigen.php'><input type='submit' name='ticketid[$ticketid]' value='Wijzigen'></form></td><td><form method='POST' action=klantticketinzien.php><input type='submit' name='ticketid[$ticketid]' value='Bekijken'></form></td><td><form method='POST' action='klantticketbeantwoorden.php'><input type='submit' name='ticketid[$ticketid]' value='Beantwoorden'></form></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortctDESC"]))
                        {
                            $stmt7 = mysqli_prepare($link, " SELECT titel, category, creation_date, completed_status, ticket_id FROM ticket WHERE user_id=$user ORDER BY creation_date DESC ");
                            mysqli_stmt_execute($stmt7);
                            mysqli_stmt_bind_result($stmt7, $titel, $category, $creation, $completed, $ticketid);
                            while (mysqli_stmt_fetch($stmt7))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$completed</td><td><form method='POST' action='klantticketwijzigen.php'><input type='submit' name='ticketid[$ticketid]' value='Wijzigen'></form></td><td><form method='POST' action=klantticketinzien.php><input type='submit' name='ticketid[$ticketid]' value='Bekijken'></form></td><td><form method='POST' action='klantticketbeantwoorden.php'><input type='submit' name='ticketid[$ticketid]' value='Beantwoorden'></form></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortstat"]))
                        {
                            $stmt8 = mysqli_prepare($link, " SELECT titel, category, creation_date, completed_status, ticket_id FROM ticket WHERE user_id=$user ORDER BY completed_status");
                            mysqli_stmt_execute($stmt8);
                            mysqli_stmt_bind_result($stmt8, $titel, $category, $creation, $completed, $ticketid);
                            while (mysqli_stmt_fetch($stmt8))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$completed</td><td><form method='POST' action='klantticketwijzigen.php'><input type='submit' name='ticketid[$ticketid]' value='Wijzigen'></form></td><td><form method='POST' action=klantticketinzien.php><input type='submit' name='ticketid[$ticketid]' value='Bekijken'></form></td><td><form method='POST' action='klantticketbeantwoorden.php'><input type='submit' name='ticketid[$ticketid]' value='Beantwoorden'></form></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortstatDESC"]))
                        {
                            $stmt9 = mysqli_prepare($link, " SELECT titel, category, creation_date, completed_status, ticket_id FROM ticket WHERE user_id=$user ORDER BY completed_status DESC ");
                            mysqli_stmt_execute($stmt9);
                            mysqli_stmt_bind_result($stmt9, $titel, $category, $creation, $completed, $ticketid);
                            while (mysqli_stmt_fetch($stmt9))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$completed</td><td><form method='POST' action='klantticketwijzigen.php'><input type='submit' name='ticketid[$ticketid]' value='Wijzigen'></form></td><td><form method='POST' action=klantticketinzien.php><input type='submit' name='ticketid[$ticketid]' value='Bekijken'></form></td><td><form method='POST' action='klantticketbeantwoorden.php'><input type='submit' name='ticketid[$ticketid]' value='Beantwoorden'></form></td></tr>";
                            }
                        }
                        else
                        {
                            $stmt10 = mysqli_prepare($link, "SELECT titel, category, creation_date, completed_status, ticket_id FROM Ticket WHERE user_id=$user ORDER BY completed_status");
                            mysqli_stmt_execute($stmt10);
                            mysqli_stmt_bind_result($stmt10, $titel, $category, $creation, $completed, $ticketid);
                            while (mysqli_stmt_fetch($stmt10))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$completed</td><td><form method='POST' action='klantticketwijzigen.php'><input type='submit' name='ticketid[$ticketid]' value='Wijzigen'></form></td><td><form method='POST' action=klantticketinzien.php><input type='submit' name=ticketid[$ticketid] value='Bekijken'></form></td><td><form method='POST' action='klantticketbeantwoorden.php'><input type='submit' name='ticketid[$ticketid]' value='Beantwoorden'></form></td></tr>";
                            }
                        }
                        ?>
                    </table>
                    <br>
                    <form class="knop_link" method="post" action="klantoverzicht.php">
                        <input type="submit" name="back" value="Terug">
                    </form>
                </div>
                <!-- EINDE NIEUW GEPLAATSTE CODE -->
            </div>
            <!--EINDE CONTENT-->
        </div>
        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>

