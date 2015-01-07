<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg -->
<?php
session_start();
if ($_SESSION["login"] != 1) {
    echo 'YOU DONT BELONG HERE';
    session_unset();
    session_destroy();
} else {
    if (isset($_POST["Sluiten"]) && isset($_POST["close/wijzig"])) {
        foreach ($_POST["close/wijzig"] AS $ticketid => $notused) {
            include "link.php";
            $ticket_id = $ticketid;
            $change = mysqli_prepare($link, "UPDATE ticket SET completed_status = 1 WHERE ticket_id = $ticket_id ");
            mysqli_execute($change);
            mysqli_close($link);
        }
    } elseif (isset($_POST["Openen"]) && isset($_POST["close/wijzig"])) {
        foreach ($_POST["close/wijzig"] AS $ticketid => $notused) {
            include "link.php";
            $ticket_id = $ticketid;
            $change = mysqli_prepare($link, "UPDATE ticket SET completed_status = 0 WHERE ticket_id = $ticket_id ");
            mysqli_execute($change);
            mysqli_close($link);
        }
    }
    ?>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Admin Systeem</title>
            <link href="stijl.css" rel="stylesheet" type="text/css"/>
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
                <div id="ticket">
                    <h1>Tickets</h1>
                    <br>
                    <table>
                        <tr>
                            <th>
                                <?php
                                if (isset($_POST["sorttit"])) {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sorttitDESC' value='Titel'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sorttit' value='Titel'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                // Met de volgende rijen code wordt bepaald welke sorteerknop we willen hebben. Of we een DESC of een ASC knop hebben.
                                if (isset($_POST["sortcomp"])) {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortcompDESC' value='Klant'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortcomp' value='Klant'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortcat"])) {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortcatDESC' value='Categorie'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortcat' value='Categorie'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortct"])) {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortctDESC' value='Aanmaak Daytime'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortct' value='Aanmaak Daytime'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortstat"])) {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortstatDESC' value='Status'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortstat' value='Status'></form>";
                                }
                                ?>
                            </th>
                            <th></th>
                            <th>Bekijken</th>
                            <th>Beantwoorden</th>
                        </tr>
                        <form method="POST" action="AdminTicketSelecteren.php">
                            <?php
                            include "link.php";
                            if (isset($_POST["sortcat"])) { // Elke if en elseif die hier volgen zijn verschillende clausules voor omhoog en omlaag gesorteerde categorien.
                                $stmt4 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY category");
                                mysqli_stmt_execute($stmt4);
                                mysqli_stmt_bind_result($stmt4, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt4)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sortcatDESC"])) {
                                $stmt5 = mysqli_prepare($link, "SELECT C.company_name ,category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY category DESC");
                                mysqli_stmt_execute($stmt5);
                                mysqli_stmt_bind_result($stmt5, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt5)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sortct"])) {
                                $stmt6 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY creation_date ");
                                mysqli_stmt_execute($stmt6);
                                mysqli_stmt_bind_result($stmt6, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt6)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sortctDESC"])) {
                                $stmt7 = mysqli_prepare($link, "SELECT C.company_name ,category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY creation_date DESC ");
                                mysqli_stmt_execute($stmt7);
                                mysqli_stmt_bind_result($stmt7, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt7)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sortcomp"])) {
                                $stmt8 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY company_name ");
                                mysqli_stmt_execute($stmt8);
                                mysqli_stmt_bind_result($stmt8, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt8)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sortcompDESC"])) {
                                $stmt9 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY company_name DESC ");
                                mysqli_stmt_execute($stmt9);
                                mysqli_stmt_bind_result($stmt9, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt9)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sortstat"])) {
                                $stmt8 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY completed_status ");
                                mysqli_stmt_execute($stmt8);
                                mysqli_stmt_bind_result($stmt8, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt8)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sortstatDESC"])) {
                                $stmt9 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY completed_status DESC");
                                mysqli_stmt_execute($stmt9);
                                mysqli_stmt_bind_result($stmt9, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt9)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sorttitDESC"])) {
                                $stmt9 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY title DESC");
                                mysqli_stmt_execute($stmt9);
                                mysqli_stmt_bind_result($stmt9, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt9)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } elseif (isset($_POST["sorttit"])) {
                                $stmt9 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id ORDER BY title DESC");
                                mysqli_stmt_execute($stmt9);
                                mysqli_stmt_bind_result($stmt9, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt9)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
                                    echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            } else {
                                $stmt10 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, titel FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id");
                                mysqli_stmt_execute($stmt10);
                                mysqli_stmt_bind_result($stmt10, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                                while (mysqli_stmt_fetch($stmt10)) {
                                    if ($completed == 1) {
                                        $completed = "Gesloten";
                                    } else {
                                        $completed = "Open";
                                    }
echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><form method='POST' action= 'AdminTicketSelecteren.php'><input type='image' src='afbeeldingen/bekijken.png' name='ticket_id'></form></td><td><input type='submit' name='Beantwoorden' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'></td><input type='hidden' name='ticket_id' value=$ticket_ID></tr>";
                                }
                            }
                            ?>
                    </table>
                </div>
                <input type="submit" name="WijzigenTO" Value="Wijzigen" formaction="AdminTicketWijzigen.php">
                <input type ="submit" name="Sluiten" Value="Sluiten" formaction="">
                <input type="submit" name="Openen" Value="Open" formaction="">
                <br><br>
                <form>
                <input type="submit" name="back" value="Terug" formaction="AdminOverzicht.php">
                </form>
                <!--
                <br><br><br>
                <h1>Gesloten Tickets:<br></h1>
                <table>
                    <tr><th>Klant</th><th>Catagorie</th><th>Aanmaak datum</th><th>Status</th><th></th><th>Bekijken</th></tr>
                <?php /*
                  include "link.php";
                  $stmt11 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 1");
                  mysqli_stmt_execute($stmt11);
                  mysqli_stmt_bind_result($stmt11, $company_name, $category, $creation, $completed, $ticket_ID);
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
                  echo "<form method='POST' action='AdminTicketSelecteren'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='Open[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                  } */
                ?>
                    <input type ="submit" name="Openen" Value="Openen" formaction="">
                    <input type="submit" name="Wijzigen" Value="Wijzigen" formaction="AdminTicketWijzigen.php">
                </table> -->
                </form>
            </div>
            <?php
            if (isset($_POST["Openen"]) || isset($_POST["Sluiten"])) {
                if (empty($_POST["close/wijzig"])) {
                    echo'<p class="foutmelding"> U heeft geen ticket geselecteerd.</p>';
                }
            }
            include 'footeradmin.php';
            ?>
        </body>
    </html>
    <?php
}
?>
