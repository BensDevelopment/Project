<!DOCTYPE html>
<?php session_start(); ?>
<!-- Joshua van Gelder, Jeffrey Hamberg, Sander van der Stelt -->
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
                <h1>Ticket Overzicht</h1><br>                
                <?php
                include "link.php";
                $username = $_SESSION['username'];
                $password = $_SESSION['password'];
                $userid = mysqli_prepare($link, "SELECT user_id, first_name, last_name FROM User WHERE mail='$username'");
                mysqli_stmt_execute($userid);
                mysqli_stmt_bind_result($userid, $user, $fname, $lname);
                mysqli_stmt_fetch($userid);
                mysqli_close($link);
                include "link.php";
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
                            <th>
                                <?php                                
                                if (isset($_POST["sorttit"]))
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sorttitDESC' value='Titel'></form>";
                                }
                                else
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sorttit' value='Titel'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php                                
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
                                if (isset($_POST["sortscn"]))
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sortcnDESC' value='Bedrijf'></form>";
                                }
                                else
                                {
                                    echo "<form class='table_hdr' method='POST' action='klantticketoverzicht.php'><input type='submit' name='sortcn' value='Bedrijf'></form>";
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
                        {
                            $stmt4 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY T.category");
                            mysqli_stmt_execute($stmt4);
                            mysqli_stmt_bind_result($stmt4, $titel, $category, $creation, $completed, $ticketid, $companyname);
                            while (mysqli_stmt_fetch($stmt4))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sortcatDESC"]))
                        {
                            $stmt5 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user  ORDER BY T.category DESC");
                            mysqli_stmt_execute($stmt5);
                            mysqli_stmt_bind_result($stmt5, $titel, $category, $creation, $completed, $ticketid, $companyname);
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
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sortct"]))
                        {
                            $stmt6 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY T.creation_date ");
                            mysqli_stmt_execute($stmt6);
                            mysqli_stmt_bind_result($stmt6, $titel, $category, $creation, $completed, $ticketid, $companyname);
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
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sortctDESC"]))
                        {
                            $stmt7 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY T.creation_date DESC ");
                            mysqli_stmt_execute($stmt7);
                            mysqli_stmt_bind_result($stmt7, $titel, $category, $creation, $completed, $ticketid, $companyname);
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
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sortstat"]))
                        {
                            $stmt8 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY T.completed_status");
                            mysqli_stmt_execute($stmt8);
                            mysqli_stmt_bind_result($stmt8, $titel, $category, $creation, $completed, $ticketid, $companyname);
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
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sortstatDESC"]))
                        {
                            $stmt9 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY T.completed_status DESC ");
                            mysqli_stmt_execute($stmt9);
                            mysqli_stmt_bind_result($stmt9, $titel, $category, $creation, $completed, $ticketid, $companyname);
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
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sorttitDESC"]))
                        {
                            $stmt10 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY T.title DESC ");
                            mysqli_stmt_execute($stmt10);
                            mysqli_stmt_bind_result($stmt10, $titel, $category, $creation, $completed, $ticketid, $companyname);
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
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sorttit"]))
                        {
                            $stmt11 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY T.title ");
                            mysqli_stmt_execute($stmt11);
                            mysqli_stmt_bind_result($stmt11, $titel, $category, $creation, $completed, $ticketid, $companyname);
                            while (mysqli_stmt_fetch($stmt11))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sortcnDESC"]))
                        {
                            $stmt12 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY C.company_name DESC ");
                            mysqli_stmt_execute($stmt12);
                            mysqli_stmt_bind_result($stmt12, $titel, $category, $creation, $completed, $ticketid, $companyname);
                            while (mysqli_stmt_fetch($stmt12))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        elseif (isset($_POST["sortcn"]))
                        {
                            $stmt13 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY C.company_name ");
                            mysqli_stmt_execute($stmt13);
                            mysqli_stmt_bind_result($stmt13, $titel, $category, $creation, $completed, $ticketid, $companyname);
                            while (mysqli_stmt_fetch($stmt13))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        else
                        {
                            $stmt14 = mysqli_prepare($link, "SELECT T.title, T.category, T.creation_date, T.completed_status, T.ticket_id, C.company_name FROM Ticket T JOIN Customer C ON C.customer_id=T.customer_id WHERE T.user_id=$user ORDER BY completed_status");
                            mysqli_stmt_execute($stmt14);
                            mysqli_stmt_bind_result($stmt14, $titel, $category, $creation, $completed, $ticketid, $companyname);
                            while (mysqli_stmt_fetch($stmt14))
                            {
                                if ($completed == 1)
                                {
                                    $completed = "Gesloten";
                                }
                                else
                                {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$category</td><td>$creation</td><td>$companyname</td><td>$completed</td><td><form method = 'POST'><input type='image' src='afbeeldingen/bekijken.png'formaction='klantticketinzien.php' ></td>"
                                . "<td><input type='image' src='afbeeldingen/wijzigen.png' formaction='klantticketwijzigen.php'></td><td><input type='image' src='afbeeldingen/toevoegen.png' formaction='klantticketbeantwoorden.php'></td>"
                                . "<input type='hidden' name='ticketid' value='$ticketid'></form></tr>";
                            }
                        }
                        ?>
                    </table>
                    <br>
                    <form class="knop_link" method="POST">
                        <input type="submit" name="back" value="Terug" formaction="klantoverzicht.php">
                    </form>
                </div>                
            </div>            
        </div>
        <footer>
            <?php 
                include 'include/php/footer.php'; 
            ?>
        </footer>
    </body>
</html>

