<!DOCTYPE html>
<!--Bart Holsappel, Léyon Courtz, Sander van der Stelt-->
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
            	<?php
                session_start();
            	if ($_SESSION["login"] != 1) {
                    echo 'U moet ingelogd zijn om deze pagina te bekijken.';
                    session_unset();
                    session_destroy();
                } else {
            	?> <!-- Dit maakt connectie met de database en zorgt voor de start van de inlogsessie -->
            	<div id="factuur">
                    <?php 
                    include "link.php";
                    $invoiceIDarray = $_POST["invoice_number"]; // Deze foreach gaat factuurnummers door
                    foreach ($invoiceIDarray as $invoice => $notused) {
                        $invoiceID = $invoice;
                    }
                    echo '<h1>Factuur nummer: '.$invoiceID.'</h1>';
                    if ($invoiceID != ""){ //customer (gebruiker) wordt gezocht die correspondeert met de juiste factuurnummer.
                    $stat = mysqli_prepare($link, "SELECT customer_id, company_name, street, house_number, city, kvk_number, btw_number FROM customer where customer_id IN (SELECT customer_id FROM Invoice WHERE invoice_number = $invoiceID )");
                    mysqli_stmt_execute($stat);
                    mysqli_stmt_bind_result($stat, $customer_id,$company_name,$street, $housen, $city, $kvk, $btw);
                    while (mysqli_stmt_fetch($stat))
                    {
                        echo "<label>Bedrijfsnaam:</label>$company_name<br>";
                        echo "<label>Adres:</label>$street $housen<br>";
                        echo "<label>Woonplaats:</label>$city";
                        mysqli_close($link);
                    }
                    }
                    ?>
                        <p><?php 
                    	include "link.php"; //Factuurgegevens worden opgezocht aan de hand an de gebruiker en het factuurnummer.
                    	$stat2 = mysqli_prepare($link, "SELECT date, invoice_number, payment_completed FROM invoice WHERE customer_id = $customer_id AND invoice_number = $invoiceID ");
                    	mysqli_stmt_execute($stat2);
                    	mysqli_stmt_bind_result($stat2, $date, $invoiceID, $payment_completed);
                    	while (mysqli_stmt_fetch($stat2)){
                        if ($payment_completed == 1) { //Status staat als integer in de database, hier wordt het omgezet naar tekst.
                            $payment_completed = "Betaald";
                        } else {
                            $payment_completed = "Niet betaald";
                        }
                        echo "<label>Factuur status:</label> $payment_completed";
                        echo "<br><label>Factuurnummer:</label>$invoiceID";
                    	echo "<br><label>Datum:</label>$date";                      
                    	mysqli_close($link);
                        }
                    	?>
                	</p>
                	<p>Factuur:
                    	<?php 
                    	$subtotaal = 0;
                    	include"link.php"; //Artikelen worden opgehaald met aantal, bedrag en omschrijvingen.
                    	$stmt3 = mysqli_prepare($link, "SELECT line_id, invoice_number, description, description2, amount, price, btw FROM line WHERE invoice_number = $invoiceID");
                    	mysqli_stmt_execute($stmt3);
                    	mysqli_stmt_bind_result($stmt3,$lineID, $IN, $D1, $D2, $amount, $price, $BTW);
                    	echo "<table><th>Beschrijving</th><th>Aantal</th><th>Prijs</th>";
                    	while ($rij=mysqli_stmt_fetch($stmt3)) {
                        	echo "<tr><td>$D1</td><td>$amount</td><td>€ $price</td></tr>";
                                $subtotaal = $amount * $price;
                    	}

                    	$btwbedrag = ($subtotaal /100)* $BTW; //Berekening van het btwbedrag
                        $totaal = $subtotaal + $btwbedrag; //Totaal berekenen
                        
                    	echo "</table><br>";
                    	echo "<label class='factuur'>Subtotaal</label>€ $subtotaal<br>";
                    	echo "<label class='factuur'>BTW 21 %</label>€ $btwbedrag<br>";
                    	echo "<label class='factuur'><strong>Totaal</label>€ $totaal </strong>"; 

                    	if ($payment_completed == "Niet betaald") { //melding wordt getoond a.d.h.v. de betreffende status
                        	echo '<p class="foutmelding">Deze factuur is nog niet betaald.</p>';
                    	} else {
                        	echo '<p class="succesmelding">Deze factuur is betaald.</p>';
                    	}
                    	?>
                        </p>
                        <form class="knop_link" method="post" action="AdminFactuuroverzicht.php">
                    	<input type="submit" name="back" value="Terug">
                    	<?php
                        }
                    	?>
                	</form>
                	<br>
            	</div>
        	</div></div>
        <?php 
            include 'include/php/footeradmin.php'; 
        ?>
	</body>
</html>

