<!DOCTYPE html>
<!-- Joshua van Gelder, Jeffrey Hamberg, Bart Holsappel, Sander van der Stelt -->
<?php
session_start();
if ($_SESSION["login"] != 1) {
    echo 'U moet ingelogd zijn om deze pagina te bekijken.';
    session_unset();
    session_destroy();
} else {
    ?>

    <html>
        <head>
            <meta charset="UTF-8">
            <title>Admin Systeem</title>
            <link href="include/css/stijl.css" rel="stylesheet" type="text/css"/>
        </head>
        <body>
            <div id='bovenbalk'>
                <div id='logo'>
                    <img src="afbeeldingen/logo-bens.png" alt="Bens Development"/>
                </div>
                <?php
                include 'include/php/menu.php';
                ?>
            </div>
            <div id='content'>
                <p><?php
                    include "link.php";
                    $customerIDarray = $_POST["CID"];
                    foreach ($customerIDarray as $customer => $notused) {
                        $customerID = $customer;
                    }
                    echo "<label>Klant ID:</label><label>" . $customerID . "</label>";
                    if ($customerID != "") {
                        $stat = mysqli_prepare($link, "SELECT company_name, street, house_number, postal_code, city, phone_number, fax_number, emailadress, kvk_number, btw_number FROM customer WHERE customer_id = $customerID ");
                        mysqli_stmt_execute($stat);
                        mysqli_stmt_bind_result($stat, $comname, $street, $house, $postal, $city, $phone, $fax, $email, $kvk, $btw);
                        while (mysqli_stmt_fetch($stat)) {
                            echo "<br><label>Bedrijfsnaam:</label><label>$comname</label><br><label>Adres:</label><label>" . $street . $house . "</label><br><label>Email:</label><label>$email</label><br><label>Woonplaats:</label><label>$city</label><br><label>Phone:</label><label>$phone</label><br><label>FAX nummer:</label><label>$fax</label><br><label>KVK nummer:</label><label>$kvk</label><br><label>BTW nummer:</label><label>$btw</label>";
                        }
                    } else {
                        echo "customer ID is niet geselecteerd";
                    }

                    mysqli_close($link);
                    ?>
                </p>
                <hr> 
                <h1>Tickets</h1>
                <br>
                <table>
                    <tr>
                        <th>
                            Titel
                        </th>
                        <th>
                            <?php
                            // Met de volgende rijen code wordt bepaald welke sorteerknop we willen hebben. Of we een DESC of een ASC knop hebben.
                            if (isset($_POST["sortcomp"])) {
                                echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortcompDESC' value='Klant'></form>";
                            } else {
                                echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortcomp' value='Klant'></form>";
                            }
                            ?>
                        </th>
                        <th>
                            <?php
                            if (isset($_POST["sortcat"])) {
                                echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortcatDESC' value='Categorie'></form>";
                            } else {
                                echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortcat' value='Categorie'></form>";
                            }
                            ?>
                        </th>
                        <th>
                            <?php
                            if (isset($_POST["sortct"])) {
                                echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortctDESC' value='Aanmaak Datum'></form>";
                            } else {
                                echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortct' value='Aanmaak Datum'></form>";
                            }
                            ?>
                        </th>
                        <th>
                            <?php
                            if (isset($_POST["sortstat"])) {
                                echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortstatDESC' value='Status'></form>";
                            } else {
                                echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortstat' value='Status'></form>";
                            }
                            ?>
                        </th>
                        <th></th>
                        <th>Bekijken</th>
                    </tr>
                    <form method="POST" action="AdminTicketSelecteren.php">
                        <?php
                        include "link.php";
                        if (isset($_POST["sortcat"])) { // Elke if en elseif die hier volgen zijn verschillende clausules voor omhoog en omlaag gesorteerde categorien.
                            $stmt4 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID ORDER BY category");
                            mysqli_stmt_execute($stmt4);
                            mysqli_stmt_bind_result($stmt4, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt4)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        } elseif (isset($_POST["sortcatDESC"])) {
                            $stmt5 = mysqli_prepare($link, "SELECT C.company_name ,category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID ORDER BY category DESC");
                            mysqli_stmt_execute($stmt5);
                            mysqli_stmt_bind_result($stmt5, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt5)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        } elseif (isset($_POST["sortct"])) {
                            $stmt6 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID ORDER BY creation_date ");
                            mysqli_stmt_execute($stmt6);
                            mysqli_stmt_bind_result($stmt6, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt6)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        } elseif (isset($_POST["sortctDESC"])) {
                            $stmt7 = mysqli_prepare($link, "SELECT C.company_name ,category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID ORDER BY creation_date DESC ");
                            mysqli_stmt_execute($stmt7);
                            mysqli_stmt_bind_result($stmt7, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt7)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        } elseif (isset($_POST["sortcomp"])) {
                            $stmt8 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID ORDER BY company_name ");
                            mysqli_stmt_execute($stmt8);
                            mysqli_stmt_bind_result($stmt8, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt8)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        } elseif (isset($_POST["sortcompDESC"])) {
                            $stmt9 = mysqli_prepare($link, " SELECT C.company_name ,category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID ORDER BY company_name DESC ");
                            mysqli_stmt_execute($stmt9);
                            mysqli_stmt_bind_result($stmt9, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt9)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        } elseif (isset($_POST["sortstat"])) {
                            $stmt8 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID ORDER BY completed_status ");
                            mysqli_stmt_execute($stmt8);
                            mysqli_stmt_bind_result($stmt8, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt8)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        } elseif (isset($_POST["sortstatDESC"])) {
                            $stmt9 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID ORDER BY completed_status DESC");
                            mysqli_stmt_execute($stmt9);
                            mysqli_stmt_bind_result($stmt9, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt9)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        } else {
                            $stmt10 = mysqli_prepare($link, "SELECT C.company_name, category, creation_date, completed_status, ticket_id, title FROM Ticket T JOIN Customer C ON T.customer_id = C.customer_id WHERE T.customer_id = $customerID");
                            mysqli_stmt_execute($stmt10);
                            mysqli_stmt_bind_result($stmt10, $company_name, $category, $creation, $completed, $ticket_ID, $titel);
                            while (mysqli_stmt_fetch($stmt10)) {
                                if ($completed == 1) {
                                    $completed = "Gesloten";
                                } else {
                                    $completed = "Open";
                                }
                                echo "<tr><td>$titel</td><td>$company_name</td><td>$category</td><td>$creation</td><td>$completed</td><td><input type='checkbox' name='close/wijzig[$ticket_ID]'></td><td><input type='submit' name='ticket_id[$ticket_ID]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[$ticket_ID]' Value='Beantwoorden' formaction='AdminTicketBeantwoorden.php'><input type='hidden' name='ticket_id' value=$ticket_ID></td></tr>";
                            }
                        }
                        ?>
                </table>

            <input type="submit" name="WijzigenTO" Value="Wijzigen" formaction="AdminTicketWijzigen.php">
            <input type ="submit" name="Sluiten" Value="Sluiten" formaction="">
            <input type="submit" name="Openen" Value="Open" formaction="">
            <input type="hidden" name="ticketid[<?php echo $ticketid; ?>]">

            <?php
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
        </form>
        <?php
        if (isset($_POST["betaald"]) && isset($_POST["close/wijzig"])) {
            foreach ($_POST["close/wijzig"] AS $invoicenumber => $notused) {
                include "link.php";
                $invoice_number = $invoicenumber;
                $change = mysqli_prepare($link, "UPDATE invoice SET payment_completed = 1 WHERE invoice_number = $invoice_number ");
                mysqli_execute($change);
                mysqli_close($link);
            }
        } elseif (isset($_POST["nietbetaald"]) && isset($_POST["close/wijzig"])) {
            foreach ($_POST["close/wijzig"] AS $invoicenumber => $notused) {
                include "link.php";
                $invoice_number = $invoicenumber;
                $change = mysqli_prepare($link, "UPDATE invoice SET payment_completed = 0 WHERE invoice_number = $invoice_number");
                mysqli_execute($change);
                mysqli_close($link);
            }
        }
        ?>
        <hr>            
        <h1>Facturen</h1>
        <br>
        <table>
            <tr>
                <th>
                    <?php
                    // Met de volgende rijen code wordt bepaald welke sorteerknop we willen hebben. Of we een DESC of een ASC knop hebben.
                    if (isset($_POST["sortfac"])) {
                        echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortfacDESC' value='Factuurnummer'></form>";
                    } else {
                        echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortfac' value='Factuurnummer'></form>";
                    }
                    ?>
                </th>
                <th>
                    <?php
                    if (isset($_POST["sortkl"])) {
                        echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortklDESC' value='Klant'></form>";
                    } else {
                        echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortkl' value='Klant'></form>";
                    }
                    ?>
                </th>
                <th>
                    <?php
                    if (isset($_POST["sortanmd"])) {
                        echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortanmdDESC' value='Aanmaak datum'></form>";
                    } else {
                        echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortanmd' value='Aanmaak datum'></form>";
                    }
                    ?>
                </th>
                <th>
                    <?php
                    if (isset($_POST["sortstat"])) {
                        echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortstatDESC' value='Status'></form>";
                    } else {
                        echo "<form class='table_hdr' method='POST' action='AdminKlantInzien.php'><input type='submit' name='sortstat' value='Status'></form>";
                    }
                    ?>
                </th>
                <th></th>
                <th>Bekijken</th>
            </tr>
            <form method='POST' action='AdminKlantInzien.php'>
                <?php
                include "link.php";
                if (isset($_POST["sortfac"])) {
                    $stmt12 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ORDER BY invoice_number");
                    mysqli_stmt_execute($stmt12);
                    mysqli_stmt_bind_result($stmt12, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt12)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit' name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                } elseif (isset($_POST["sortfacDESC"])) {
                    $stmt13 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ORDER BY invoice_number DESC");
                    mysqli_stmt_execute($stmt13);
                    mysqli_stmt_bind_result($stmt13, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt13)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit' name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                } elseif (isset($_POST["sortkl"])) {
                    $stmt14 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ORDER BY customer_id");
                    mysqli_stmt_execute($stmt14);
                    mysqli_stmt_bind_result($stmt14, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt14)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit' name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                } elseif (isset($_POST["sortklDESC"])) {
                    $stmt15 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ORDER BY customer_id DESC");
                    mysqli_stmt_execute($stmt15);
                    mysqli_stmt_bind_result($stmt15, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt15)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit' name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                } elseif (isset($_POST["sortanmd"])) {
                    $stmt16 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ORDER BY date");
                    mysqli_stmt_execute($stmt16);
                    mysqli_stmt_bind_result($stmt16, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt16)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit' name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                } elseif (isset($_POST["sortanmdDESC"])) {
                    $stmt17 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ORDER BY date DESC");
                    mysqli_stmt_execute($stmt17);
                    mysqli_stmt_bind_result($stmt17, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt17)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit' name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                } elseif (isset($_POST["sortstat"])) {
                    $stmt18 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ORDER BY payment_completed");
                    mysqli_stmt_execute($stmt18);
                    mysqli_stmt_bind_result($stmt18, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt18)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit' name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                } elseif (isset($_POST["sortstatDESC"])) {
                    $stmt19 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ORDER BY payment_completed DESC");
                    mysqli_stmt_execute($stmt19);
                    mysqli_stmt_bind_result($stmt19, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt19)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit' name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                } else {
                    $stmt20 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice WHERE customer_id = $customerID ");
                    mysqli_stmt_execute($stmt20);
                    mysqli_stmt_bind_result($stmt20, $invoice_number, $customer_id, $date, $payment_completed);
                    while (mysqli_stmt_fetch($stmt20)) {
                        if ($payment_completed == 1) {
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[$invoice_number]'></td><td><input type='submit'  name='invoice_number[$invoice_number]' value='Bekijken' formaction='AdminFactuurInzien.php'></td></tr>";
                    }
                }
                ?>
        </table>
        <input type="submit" name="betaald" Value="Betaald" formaction="">
        <input type="submit" name="nietbetaald" value="Niet betaald" formaction="">
        </form><br><br>
    <form>
    <input type="submit" name="Terug" value="Terug" formaction="AdminOverzicht.php">
    </form>
    </div>
    <?php
    if (isset($_POST["nietbetaald"]) || isset($_POST["betaald"])) {
        if (empty($_POST["close/wijzig"])) {
            echo'<p class="foutmelding"> U heeft geen factuur geselecteerd.</p>';
        }
    }
    include 'include/php/footeradmin.php';
    ?>
    </body>
    </html>
<?php }
?>