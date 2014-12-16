<!DOCTYPE html>
<!--Léyon Courtz -->
<?php
session_start();
if ($_SESSION["login"] != 1)
{
    echo 'U moet ingelogd zijn om deze pagina te bekijken';
    session_unset();
    session_destroy();
}
else
{
    ?>
<html>
        <head>
            <meta charset="UTF-8">
            <title>Admin factuuroverzicht</title>
            <link href="stijl.css" rel="stylesheet" type="text/css">
        </head>
        <body>
            <div id='bovenbalk'>
                <div id='logo'>
                    <img src="img/logo-bens.png" alt=""/>
                </div>
                <?php
                include 'menu.php';
                ?>
            </div>
            <div id='content'>
                <h1>Facturen</h1>
       <br>
                    <table>
                        <tr>
                            <th>
                                <?php
                                // Met de volgende rijen code wordt bepaald welke sorteerknop we willen hebben. Of we een DESC of een ASC knop hebben.
                                if (isset($_POST["sortfac"])) {
                                    echo "<form class='table_hdr' method='POST' action='Adminfactuuroverzicht.php'><input type='submit' name='sortfacDESC' value='Factuurnummer'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='Adminfactuuroverzicht.php'><input type='submit' name='sortfac' value='Factuurnummer'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortkl"])) {
                                    echo "<form class='table_hdr' method='POST' action='Adminfactuuroverzicht.php'><input type='submit' name='sortklDESC' value='Klant'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='Adminfactuuroverzicht.php'><input type='submit' name='sortkl' value='Klant'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortanmd"])) {
                                    echo "<form class='table_hdr' method='POST' action='Adminfactuuroverzicht.php'><input type='submit' name='sortanmdDESC' value='Aanmaak datum'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='Adminfactuuroverzicht.php'><input type='submit' name='sortanmd' value='Aanmaak datum'></form>";
                                }
                                ?>
                            </th>
                            <th>
                                <?php
                                if (isset($_POST["sortstat"])) {
                                    echo "<form class='table_hdr' method='POST' action='Adminfactuuroverzicht.php'><input type='submit' name='sortstatDESC' value='Status'></form>";
                                } else {
                                    echo "<form class='table_hdr' method='POST' action='Adminfactuuroverzicht.php'><input type='submit' name='sortstat' value='Status'></form>";
                                }
                                ?>
                            </th>
                            
                            <th>Bekijken</th>
                        </tr>
                        <form method="POST" action="#">
                        <?php 
                        include "link.php";
                        if (isset($_POST["sortfac"])) {
                             $stmt12 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice ORDER BY invoice_number");
                             mysqli_stmt_execute($stmt12);
                             mysqli_stmt_bind_result($stmt12, $invoice_number, $customer_id , $date , $payment_completed);
                             while (mysqli_stmt_fetch($stmt12)) {
                                    if ($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ; 
                        }
                        }elseif (isset($_POST["sortfacDESC"])) {
                            $stmt13 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice ORDER BY invoice_number DESC");
                             mysqli_stmt_execute($stmt13);
                             mysqli_stmt_bind_result($stmt13, $invoice_number, $customer_id , $date , $payment_completed);
                             while (mysqli_stmt_fetch($stmt13)) {
                                    if ($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ; 
                        }
                            
                        }elseif (isset($_POST["sortkl"])) {
                            $stmt14 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice ORDER BY customer_id");
                             mysqli_stmt_execute($stmt14);
                             mysqli_stmt_bind_result($stmt14, $invoice_number, $customer_id , $date , $payment_completed);
                             while (mysqli_stmt_fetch($stmt14)) {
                                    if ($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ;
                                    
                        } 
                        } elseif (isset ($_POST["sortklDESC"])) {
                            $stmt15 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice ORDER BY customer_id DESC");
                             mysqli_stmt_execute($stmt15);
                             mysqli_stmt_bind_result($stmt15, $invoice_number, $customer_id , $date , $payment_completed);
                             while (mysqli_stmt_fetch($stmt15)) {
                                    if ($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ;
                        }
                        }elseif (isset($_POST["sortanmd"])) {
                            $stmt16 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice ORDER BY date");
                             mysqli_stmt_execute($stmt16);
                             mysqli_stmt_bind_result($stmt16, $invoice_number, $customer_id , $date , $payment_completed);
                             while (mysqli_stmt_fetch($stmt16)) {
                                    if ($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ;
                                    
                        } 
                        } elseif (isset($_POST["sortanmdDESC"])) {
                            $stmt17 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice ORDER BY date DESC");
                             mysqli_stmt_execute($stmt17);
                             mysqli_stmt_bind_result($stmt17, $invoice_number, $customer_id , $date , $payment_completed);
                             while (mysqli_stmt_fetch($stmt17)) {
                                    if ($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ;
                                    
                        } 
                        }elseif (isset($_POST["sortstat"])) {
                            $stmt18 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice ORDER BY payment_completed");
                             mysqli_stmt_execute($stmt18);
                             mysqli_stmt_bind_result($stmt18, $invoice_number, $customer_id , $date , $payment_completed);
                             while (mysqli_stmt_fetch($stmt18)) {
                                    if ($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ;
                                    
                        } 
                        }elseif (isset($_POST["sortstatDESC"])) {
                            $stmt19 = mysqli_prepare($link, "SELECT invoice_number, customer_id , date , payment_completed FROM Invoice ORDER BY payment_completed DESC");
                             mysqli_stmt_execute($stmt19);
                             mysqli_stmt_bind_result($stmt19, $invoice_number, $customer_id , $date , $payment_completed);
                             while (mysqli_stmt_fetch($stmt19)) {
                                    if ($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ;
                                    
                        } 
                        } else{
                            $stmt20 = mysqli_prepare($link,"SELECT invoice_number, customer_id , date , payment_completed FROM Invoice " );
                            mysqli_stmt_execute($stmt20);
                            mysqli_stmt_bind_result($stmt20, $invoice_number, $customer_id , $date , $payment_completed);
                            while (mysqli_stmt_fetch($stmt20)) {
                                if($payment_completed == 1) {
                                        $payment_completed = "Betaald";
                                    } else {
                                        $payment_completed = "Niet betaald";
                                    }
                                    echo "<tr><td>$invoice_number</td><td>$customer_id </td> <td> $date</td> <td> $payment_completed </td><td><input type='checkbox' name='close/wijzig[]'></td><td><input type='submit' name='ticket_id[]' value='Bekijken'></td><td><input type='submit' name='Beantwoorden[]' Value='Beantwoorden' formaction='#'></td></tr>" ;
                                    
                            }
                        }
                        
                        
                        
                        ?>
                        
                    </table>
<input type="submit" name="back" value="Terug" formaction="AdminOverzicht.php">
            <div class='push'></div>
            <div id='footer'>
                <div id='footerleft'>Admin Systeem</div>
                <div id='footerright'>&copy;Bens Development 2013 - 2014</div>
            </div>
        </body>       
    </html>
                        <?php }?>
