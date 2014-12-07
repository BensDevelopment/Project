<!DOCTYPE html>
<?php
session_start();
if ($_SESSION["login"] != 1)
{
    echo 'YOU DONT BELONG HERE';
    session_unset();
    session_destroy();
}
else
{
    if (isset($_POST["Sluiten"]))
    {
        foreach ($_POST["close/wijzig"] AS $ticketid => $notused)
        {
            include "link.php";
            $ticket_id = $ticketid;
            $change    = mysqli_prepare($link, "UPDATE ticket SET archived_status = 1 WHERE ticket_id = $ticket_id ");
            mysqli_execute($change);
            mysqli_close($link);
        }
    }
    elseif (isset($_POST["Openen"]))
    {
        foreach ($_POST["Open"] AS $ticketid => $notused)
        {
            include "link.php";
            $ticket_id = $ticketid;
            $change    = mysqli_prepare($link, "UPDATE ticket SET archived_status = 0 WHERE ticket_id = $ticket_id ");
            mysqli_execute($change);
            mysqli_close($link);
        }
    }
    ?>
    <html>
        <!-- Joshua van Gelder, Jeffrey Hamberg-->
        <head>
            <meta charset="UTF-8">
            <title>Admin Systeem</title>
            <link href="stijl.css" rel="stylesheet" type="text/css"/>
        </head>
        <body>
            <form method="POST">
                <div id='bovenbalk'>
                    <div id='logo'>
                        <img src="img/logo-bens.png" alt="">
                    </div>
                    <?php
                    include 'menu.php';
                    ?>
                </div>                           
                <div id="ticket">
                    <h1>Open tickets:</h1>
                    <br>
                    <table>
                        <tr>
                            <th>
                                <?php
                                // Met de volgende rijen code wordt bepaald welke sorteerknop we willen hebben. Of we een DESC of een ASC knop hebben.
                                if (isset($_POST["sortcomp"]))
                                {
                                    print ("<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortcompDESC' value='Klant'></form>");
                                }
                                else
                                {
                                    print ("<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortcomp' value='Klant'></form>");
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortcat"]))
                                {
                                    print ("<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortcatDESC' value='Categorie'></form>");
                                }
                                else
                                {
                                    print ("<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortcat' value='Categorie'></form>");
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortct"]))
                                {
                                    print("<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortctDESC' value='Aanmaak Datum'></form>");
                                }
                                else
                                {
                                    print("<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortct' value='Aanmaak Datum'></form>");
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortstat"]))
                                {
                                    print("<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortstatDESC' value='Status'></form>");
                                }
                                else
                                {
                                    print("<form class='table_hdr' method='POST' action='AdminTicketOverzicht.php'><input type='submit' name='sortstat' value='Status'></form>");
                                }
                                ?>
                            </th>
                            <th></th>
                            <th>Bekijken</th>
                        </tr>
                        <?php
                        include "link.php";
                        if (isset($_POST["sortcat"]))
                        { // Elke if en elseif die hier volgen zijn verschillende clausules voor omhoog en omlaag gesorteerde categorien.
                            $stmt4 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0 ORDER BY category");
                            mysqli_stmt_execute($stmt4);
                            mysqli_stmt_bind_result($stmt4, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortcatDESC"]))
                        {
                            $stmt5 = mysqli_prepare($link, "SELECT C.company_name ,category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0 ORDER BY category DESC");
                            mysqli_stmt_execute($stmt5);
                            mysqli_stmt_bind_result($stmt5, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortct"]))
                        {
                            $stmt6 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0 ORDER BY creation_date ");
                            mysqli_stmt_execute($stmt6);
                            mysqli_stmt_bind_result($stmt6, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortctDESC"]))
                        {
                            $stmt7 = mysqli_prepare($link, "SELECT C.company_name ,category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0 ORDER BY creation_date DESC ");
                            mysqli_stmt_execute($stmt7);
                            mysqli_stmt_bind_result($stmt7, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortcomp"]))
                        {
                            $stmt8 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0 ORDER BY company_name ");
                            mysqli_stmt_execute($stmt8);
                            mysqli_stmt_bind_result($stmt8, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortcompDESC"]))
                        {
                            $stmt9 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0 ORDER BY company_name DESC ");
                            mysqli_stmt_execute($stmt9);
                            mysqli_stmt_bind_result($stmt9, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortstat"]))
                        {
                            $stmt8 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0 ORDER BY completed_status ");
                            mysqli_stmt_execute($stmt8);
                            mysqli_stmt_bind_result($stmt8, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        elseif (isset($_POST["sortstatDESC"]))
                        {
                            $stmt9 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0 ORDER BY completed_status DESC");
                            mysqli_stmt_execute($stmt9);
                            mysqli_stmt_bind_result($stmt9, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        else
                        {
                            $stmt10 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.archived_status = 0");
                            mysqli_stmt_execute($stmt10);
                            mysqli_stmt_bind_result($stmt10, $company_name, $category, $creation, $completed, $ticket_ID);
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
                                echo "<form method='POST' action='AdminTicketSelecteren.php'><tr><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td></tr>";
                            }
                        }
                        ?>
                    </table>
                </div>

                <input type ="submit" name="Sluiten" Value="Sluiten" formaction="">
                <input type="submit" name="Wijzigen" Value="Wijzigen" formaction="AdminTicketWijzigen.php">                        

                <br><br><br>
                <h1>Gesloten Tickets:<br></h1>
                <table>
                    <tr><th>Klant</th><th>Catagorie</th><th>Aanmaak datum</th><th>Status</th><th></th><th>Bekijken</th></tr>
                    <?php
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
                    }
                    ?>
                    <input type ="submit" name="Openen" Value="Openen" formaction="">
                    <input type="submit" name="Wijzigen" Value="Wijzigen" formaction="AdminTicketWijzigen.php">                        
                </table>
            </form>            
            <div id='footer'>
                <div id='footerleft'>Admin Systeem</div>
                <div id='footerright'>&copy;Bens Development 2013 - 2014</div>
            </div>
        </body>
    </html>
    <?php
}
?>
